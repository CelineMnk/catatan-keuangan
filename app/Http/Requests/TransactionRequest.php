<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'transaction_date' => 'nullable|date',
            'cover' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul transaksi wajib diisi',
            'title.max' => 'Judul transaksi maksimal 255 karakter',
            'amount.required' => 'Jumlah transaksi wajib diisi',
            'amount.numeric' => 'Jumlah transaksi harus berupa angka',
            'amount.min' => 'Jumlah transaksi tidak boleh negatif',
            'type.required' => 'Tipe transaksi wajib dipilih',
            'type.in' => 'Tipe transaksi tidak valid',
            'transaction_date.date' => 'Format tanggal tidak valid',
            'cover.image' => 'File harus berupa gambar',
            'cover.max' => 'Ukuran gambar maksimal 2MB',
            'cover.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg, gif',
        ];
    }
}