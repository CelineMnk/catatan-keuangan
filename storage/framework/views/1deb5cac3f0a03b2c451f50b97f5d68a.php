

<?php $__env->startPush('styles'); ?>
<style>
    /* Warna utama pink lembut */
    .theme-bg {
        background: linear-gradient(135deg, #fde2e4 0%, #fbcfe8 100%);
    }

    /* Judul */
    .page-title {
        font-size: 2.3rem;
        font-weight: 800;
        text-align: center;
        color: #be185d;
        background: linear-gradient(90deg, #f472b6, #ec4899);
        color: white;
        padding: 1rem;
        border-radius: 1rem;
        box-shadow: 0 6px 16px rgba(244, 114, 182, 0.4);
        margin-bottom: 1.5rem;
    }

    /* Kartu ringkasan */
    .summary-card {
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 16px rgba(236, 72, 153, 0.3);
    }

    /* Variasi warna */
    .income-card { background: #f9f9f9; border-left: 6px solid #16a34a; }
    .expense-card { background: #fff0f3; border-left: 6px solid #dc2626; }
    .balance-card { background: #fdf2f8; border-left: 6px solid #db2777; }

    /* Tombol utama */
    .btn-fancy {
        padding: 0.75rem 1.6rem;
        font-weight: 700;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(244, 114, 182, 0.3);
    }

    .btn-fancy:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 18px rgba(236, 72, 153, 0.45);
    }

    .btn-pink { background: linear-gradient(90deg, #ec4899, #db2777); }
    .btn-purple { background: linear-gradient(90deg, #a78bfa, #9333ea); }

    /* Filter box */
    .filter-box {
        background: #fff0f7;
        border: 1px solid #fbcfe8;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 10px rgba(244, 114, 182, 0.15);
    }

    input, select {
        border: 1.8px solid #f9a8d4;
        border-radius: 0.6rem;
        padding: 0.6rem 0.8rem;
        background: #fff;
        transition: all 0.25s ease;
        width: 100%;
    }

    input:focus, select:focus {
        border-color: #db2777;
        box-shadow: 0 0 0 4px rgba(219, 39, 119, 0.2);
        outline: none;
    }

    /* Tabel */
    table th {
        background: #fce7f3;
        color: #9d174d;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    table tr:hover {
        background: #fff1f2;
    }

    /* Tombol kecil */
    .btn-reset {
        background: #e11d48;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.6rem;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-reset:hover {
        background: #be123c;
        transform: scale(1.05);
    }

    /* 🔽 Tambahan perbaikan ukuran foto */
    .transaction-img {
        height: 60px;
        width: 60px;
        object-fit: cover;
        border-radius: 50%;
        box-shadow: 0 0 6px rgba(236, 72, 153, 0.4);
        border: 2px solid #fbcfe8;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="py-10 theme-bg min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="page-title"> Catatan Keuangan</h1>

        
        <div class="flex items-center justify-end mb-6 space-x-3">
            <a href="<?php echo e(route('transactions.stats')); ?>" class="btn-fancy btn-purple">
                <span class="mr-2">📊</span> Statistik
            </a>
            <a href="<?php echo e(route('transactions.create')); ?>" class="btn-fancy btn-pink">
                <span class="mr-2">➕</span> Tambah Transaksi
            </a>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="summary-card income-card">
                <div class="text-sm font-semibold text-green-800">Total Pemasukan</div>
                <div class="text-3xl font-extrabold text-green-700 mt-1">
                    Rp <?php echo e(number_format($totalIncome ?? 0, 0, ',', '.')); ?>

                </div>
            </div>

            <div class="summary-card expense-card">
                <div class="text-sm font-semibold text-red-800">Total Pengeluaran</div>
                <div class="text-3xl font-extrabold text-red-700 mt-1">
                    Rp <?php echo e(number_format($totalExpense ?? 0, 0, ',', '.')); ?>

                </div>
            </div>

            <div class="summary-card balance-card">
                <div class="text-sm font-semibold text-pink-800">Saldo</div>
                <div class="text-3xl font-extrabold text-pink-700 mt-1">
                    Rp <?php echo e(number_format($balance ?? 0, 0, ',', '.')); ?>

                </div>
            </div>
        </div>

        
        <div class="filter-box mb-8">
            <form method="GET" action="<?php echo e(route('transactions.index')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="font-semibold text-gray-700">Cari</label>
                    <input id="search" name="search" type="text" value="<?php echo e(request('search')); ?>" placeholder="Judul atau deskripsi...">
                </div>

                <div>
                    <label for="type" class="font-semibold text-gray-700">Jenis</label>
                    <select id="type" name="type">
                        <option value="">Semua</option>
                        <option value="income" <?php echo e(request('type') === 'income' ? 'selected' : ''); ?>>Pemasukan</option>
                        <option value="expense" <?php echo e(request('type') === 'expense' ? 'selected' : ''); ?>>Pengeluaran</option>
                    </select>
                </div>

                <div>
                    <label for="start_date" class="font-semibold text-gray-700">Dari Tanggal</label>
                    <input id="start_date" name="start_date" type="date" value="<?php echo e(request('start_date')); ?>">
                </div>

                <div>
                    <label for="end_date" class="font-semibold text-gray-700">Sampai Tanggal</label>
                    <input id="end_date" name="end_date" type="date" value="<?php echo e(request('end_date')); ?>">
                </div>

                <div class="md:col-span-4 flex justify-end space-x-2 mt-4">
                    <button type="submit" class="btn-fancy btn-pink w-10 h-10">🔍</button>
                    <?php if(request()->hasAny(['search','type','start_date','end_date'])): ?>
                        <a href="<?php echo e(route('transactions.index')); ?>" class="btn-reset">Reset</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        
        <div class="bg-white rounded-2xl shadow-md overflow-x-auto border border-pink-100">
            <table class="min-w-full divide-y divide-pink-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs">Judul</th>
                        <th class="px-6 py-3 text-left text-xs">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pink-100">
                    <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-6 py-4 text-gray-700"><?php echo e($transaction->transaction_date ? date('d/m/Y', strtotime($transaction->transaction_date)) : '-'); ?></td>
                            <td class="px-6 py-4 text-gray-800">
                                <div class="flex items-center space-x-3">
                                    <?php if($transaction->cover): ?>
                                        
                                        <img src="<?php echo e(Storage::url($transaction->cover)); ?>" class="transaction-img">
                                    <?php else: ?>
                                        <div class="h-10 w-10 rounded-full bg-pink-100 flex items-center justify-center text-xs text-pink-700">No img</div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="font-bold text-pink-900"><?php echo e($transaction->title); ?></div>
                                        <div class="text-sm text-gray-600"><?php echo Str::limit(strip_tags($transaction->description), 60); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 <?php echo e($transaction->type === 'income' ? 'text-green-600' : 'text-red-600'); ?>">
                                <?php echo e($transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran'); ?>

                            </td>
                            <td class="px-6 py-4 <?php echo e($transaction->type === 'income' ? 'text-green-600' : 'text-red-600'); ?>">
                                Rp <?php echo e(number_format($transaction->amount, 0, ',', '.')); ?>

                            </td>
                            <td class="px-6 py-4 font-medium">
                                <a href="<?php echo e(route('transactions.edit', $transaction)); ?>" class="text-purple-600 hover:text-purple-800 font-bold mr-3">Edit</a>
                                <form action="<?php echo e(route('transactions.destroy', $transaction)); ?>" method="POST" class="inline" onsubmit="return false;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="button" onclick="confirmDelete(this.form)" class="text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-gray-600 py-4">Tidak ada transaksi</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <?php echo e($transactions->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(form) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#db2777',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEM 5\PABWE\catatan-keuangan\resources\views/transactions/index.blade.php ENDPATH**/ ?>