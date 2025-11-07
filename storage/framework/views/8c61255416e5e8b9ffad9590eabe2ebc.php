

<?php $__env->startSection('content'); ?>
<div class="min-h-screen py-12 bg-gradient-to-b from-pink-50 via-pink-100 to-pink-200 flex items-center justify-center">
    <div class="w-full max-w-3xl px-6">

        
        <div class="mb-10 text-center">
            <h1 class="text-5xl font-extrabold text-pink-700 drop-shadow-lg animate-pulse">✏️ Edit Transaksi</h1>
            <p class="text-pink-500 mt-2 text-lg font-medium">Perbarui detail transaksi kamu dengan cepat dan jelas</p>
        </div>

        
        <div class="bg-white rounded-3xl shadow-2xl p-10 border border-pink-200">
            <?php if($errors->any()): ?>
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('transactions.update', $transaction->id ?? '')); ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-pink-700 mb-2">Judul</label>
                        <input type="text" name="title" value="<?php echo e(old('title', $transaction->title ?? '')); ?>" required
                               class="w-full rounded-2xl border-2 border-pink-400 px-5 py-4 placeholder-pink-300 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-500 transition duration-300 text-pink-800 font-semibold">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-pink-700 mb-2">Jumlah (Rp)</label>
                        <input type="number" name="amount" value="<?php echo e(old('amount', $transaction->amount ?? 0)); ?>" required min="0" step="1"
                               class="w-full rounded-2xl border-2 border-pink-400 px-5 py-4 placeholder-pink-300 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-500 transition duration-300 text-pink-800 font-semibold">
                    </div>
                </div>

                
                <div>
                    <label class="block text-sm font-semibold text-pink-700 mb-2">Deskripsi</label>
                    <input id="description" type="hidden" name="description" value="<?php echo e(old('description', $transaction->description ?? '')); ?>">
                    <trix-editor input="description" class="w-full rounded-2xl border-2 border-pink-400 px-5 py-4 focus:ring-2 focus:ring-pink-400 focus:border-pink-500 transition duration-300 bg-white text-pink-800 font-semibold min-h-[14rem]"></trix-editor>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-pink-700 mb-2">Tipe</label>
                        <select name="type" required
                                class="w-full rounded-2xl border-2 border-pink-400 px-5 py-4 bg-white text-pink-800 font-semibold focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-500 transition duration-300">
                            <option value="">Pilih tipe</option>
                            <option value="income" <?php echo e(old('type', $transaction->type ?? '') === 'income' ? 'selected' : ''); ?>>Pemasukan</option>
                            <option value="expense" <?php echo e(old('type', $transaction->type ?? '') === 'expense' ? 'selected' : ''); ?>>Pengeluaran</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-pink-700 mb-2">Tanggal</label>
                        <input type="date" name="transaction_date" value="<?php echo e(old('transaction_date', optional($transaction->transaction_date)->format('Y-m-d'))); ?>" required
                               class="w-full rounded-2xl border-2 border-pink-400 px-5 py-4 bg-white text-pink-800 font-semibold focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-500 transition duration-300">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-pink-700 mb-2">Kategori</label>
                        <input type="text" name="category" value="<?php echo e(old('category', $transaction->category ?? '')); ?>"
                               class="w-full rounded-2xl border-2 border-pink-400 px-5 py-4 placeholder-pink-300 bg-white text-pink-800 font-semibold focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-500 transition duration-300" placeholder="Contoh: Gaji / Belanja">
                    </div>
                </div>

                
                <div>
                    <label class="block text-sm font-semibold text-pink-700 mb-2">Lampiran Gambar (opsional)</label>
                    <input type="file" name="cover" accept="image/*" onchange="previewImage(this)"
                           class="w-full text-sm text-pink-700 rounded-lg cursor-pointer">
                    <p class="text-sm text-pink-500 mt-1">PNG, JPG, GIF hingga 2MB</p>

                    <div id="image-preview" class="mt-4 <?php echo e(!empty($transaction->cover) ? '' : 'hidden'); ?>">
                        <img id="preview-img" src="<?php echo e(!empty($transaction->cover) ? Storage::url($transaction->cover) : ''); ?>" alt="Preview" class="max-w-xs rounded-2xl border-2 border-pink-400 shadow-xl">
                    </div>
                </div>

                
                <div class="flex justify-end space-x-6 mt-10">
                    <!-- Tombol Batal -->
                    <a href="<?php echo e(route('transactions.index')); ?>"
                       class="relative px-8 py-4 rounded-2xl bg-pink-500 text-black font-bold shadow-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-[0_15px_40px_rgba(219,39,119,0.7)] active:scale-95 active:shadow-inner before:absolute before:-inset-0.5 before:rounded-2xl before:bg-gradient-to-r before:from-pink-300 before:via-pink-500 before:to-fuchsia-500 before:opacity-60 before:blur-xl before:animate-animate-glow">
                        Batal
                    </a>

                    <!-- Tombol Simpan Perubahan -->
                    <button type="submit"
                            class="relative px-8 py-4 rounded-2xl bg-gradient-to-r from-pink-500 via-fuchsia-500 to-pink-500 text-black font-bold shadow-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-[0_15px_40px_rgba(219,39,119,0.7)] active:scale-95 active:shadow-inner before:absolute before:-inset-0.5 before:rounded-2xl before:bg-gradient-to-r before:from-pink-300 before:via-pink-500 before:to-fuchsia-500 before:opacity-60 before:blur-xl before:animate-animate-glow">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">

<style>
/* Animasi glow untuk tombol */
@keyframes animate-glow {
    0%, 100% { filter: blur(8px); opacity: 0.6; transform: scale(1); }
    50% { filter: blur(16px); opacity: 0.8; transform: scale(1.05); }
}
.before\\:animate-animate-glow {
    animation: animate-glow 1.5s infinite ease-in-out;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const image = document.getElementById('preview-img');
    if(input.files && input.files[0]){
        const reader = new FileReader();
        reader.onload = e => {
            image.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        image.src = '';
        preview.classList.add('hidden');
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEM 5\PABWE\catatan-keuangan\resources\views/transactions/edit.blade.php ENDPATH**/ ?>