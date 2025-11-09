<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', auth()->id());

        // 🔍 Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 🔁 Filter tipe transaksi
        if ($request->filled('type') && in_array($request->type, ['income', 'expense'])) {
            $query->where('type', $request->type);
        }

        // 📅 Filter tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        // ✅ Perbaikan utama: clone query agar tidak saling menimpa
        $incomeQuery = clone $query;
        $expenseQuery = clone $query;

        $transactions = $query->orderBy('transaction_date', 'desc')
            ->paginate(20)
            ->withQueryString();

        // ✅ Hitung total secara independen
        $totalIncome = $incomeQuery->where('type', 'income')->sum('amount');
        $totalExpense = $expenseQuery->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('transactions.index', compact('transactions', 'totalIncome', 'totalExpense', 'balance'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'transaction_date' => 'required|date',
            'cover' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->except('cover');
        $data['user_id'] = auth()->id();

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $image = $request->file('cover');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.\-]/', '_', $image->getClientOriginalName());
            $path = $image->storeAs('covers', $filename, 'public');
            $data['cover'] = $path;
        }

        Transaction::create($data);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'transaction_date' => 'required|date',
            'cover' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
        ]);

        $data = $request->except('cover');

        if ($request->hasFile('cover')) {
            if ($transaction->cover && Storage::disk('public')->exists($transaction->cover)) {
                Storage::disk('public')->delete($transaction->cover);
            }

            $image = $request->file('cover');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.\-]/', '_', $image->getClientOriginalName());
            $path = $image->storeAs('covers', $filename, 'public');
            $data['cover'] = $path;
        }

        $transaction->update($data);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        if ($transaction->cover && Storage::disk('public')->exists($transaction->cover)) {
            Storage::disk('public')->delete($transaction->cover);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    public function stats()
    {
        return view('transactions.stats');
    }

    public function statsData()
    {
        try {
            $userId = auth()->id();
            $driver = DB::getDriverName();

            // Format tanggal per DB
            if ($driver === 'pgsql') {
                $dateExpr = "to_char(transaction_date, 'YYYY-MM')";
            } elseif ($driver === 'sqlite') {
                $dateExpr = "strftime('%Y-%m', transaction_date)";
            } else {
                $dateExpr = "DATE_FORMAT(transaction_date, '%Y-%m')";
            }

            $monthlyStats = Transaction::where('user_id', $userId)
                ->whereDate('transaction_date', '>=', now()->subMonths(11)->startOfMonth())
                ->selectRaw("$dateExpr as date,
                    SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income,
                    SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expense")
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->map(function ($stat) {
                    return [
                        'date' => date('M Y', strtotime($stat->date)),
                        'income' => floatval($stat->income),
                        'expense' => floatval($stat->expense),
                        'balance' => floatval($stat->income - $stat->expense)
                    ];
                });

            return response()->json($monthlyStats);
        } catch (\Exception $e) {
            \Log::error('Error generating stats: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengambil data statistik'], 500);
        }
    }
}
