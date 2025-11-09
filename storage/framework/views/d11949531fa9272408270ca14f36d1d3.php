

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
<style>
    /* Judul besar elegan */
    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(90deg, #2563eb, #1e40af);
        color: white;
        text-align: center;
        padding: 1rem 0;
        border-radius: 0.75rem 0.75rem 0 0;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
    }

    /* Card utama */
    .card-modern {
        background: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border-top: 6px solid #2563eb;
        padding: 2.5rem;
    }

    /* Label */
    label {
        font-weight: 600;
        color: #374151;
    }

    /* Input & Select cantik */
    input[type="text"],
    input[type="number"],
    input[type="date"],
    select {
        border: 1.8px solid #d1d5db;
        border-radius: 0.6rem;
        padding: 0.65rem 0.8rem;
        transition: all 0.25s ease;
        width: 100%;
        background: #f9fafb;
    }

    input:focus,
    select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2);
        background: #ffffff;
    }

    /* Select warna tipe */
    #type option[value="income"] {
        color: #16a34a;
        font-weight: 600;
    }

    #type option[value="expense"] {
        color: #dc2626;
        font-weight: 600;
    }

    /* Tombol utama */
    .btn-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.9rem 2.2rem;
        font-weight: 800;
        font-size: 1.1rem;
        border-radius: 0.75rem;
        color: white;
        background: linear-gradient(90deg, #2563eb, #1e3a8a);
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
    }

    .btn-submit:hover {
        transform: scale(1.05);
        background: linear-gradient(90deg, #1e40af, #1d4ed8);
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.5);
    }

    /* Tombol batal */
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.8rem 1.8rem;
        border-radius: 0.75rem;
        font-weight: 600;
        color: #4b5563;
        border: 2px solid #d1d5db;
        background: #f9fafb;
        transition: all 0.25s ease;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
        transform: scale(1.05);
    }

    /* Trix editor styling */
    trix-editor {
        border: 1.8px solid #d1d5db;
        border-radius: 0.6rem;
        padding: 0.75rem;
        background: #f9fafb;
        transition: all 0.25s;
    }

    trix-editor:focus {
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2);
    }

    /* Gambar preview */
    #preview-img {
        border-radius: 0.75rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        transition: 0.3s;
    }

    #preview-img:hover {
        transform: scale(1.03);
    }

    .form-required::after {
        content: " *";
        color: #ef4444;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="py-10 bg-blue-50">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="card-modern">
            <div class="page-title">✏️ Tambah Transaksi Baru</div>

            <form action="<?php echo e(route('transactions.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6 mt-6">
                <?php echo csrf_field(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="form-required">Judul</label>
                        <input id="title" name="title" type="text" value="<?php echo e(old('title')); ?>" required />
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="amount" class="form-required">Jumlah (Rp)</label>
                        <input id="amount" name="amount" type="number" value="<?php echo e(old('amount')); ?>" required min="0" step="1" />
                        <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div>
                    <label for="description">Deskripsi</label>
                    <input id="description" type="hidden" name="description" value="<?php echo e(old('description')); ?>">
                    <trix-editor input="description"></trix-editor>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="type" class="form-required">Tipe</label>
                        <select id="type" name="type" required>
                            <option value="">Pilih Tipe</option>
                            <option value="income" <?php echo e(old('type') === 'income' ? 'selected' : ''); ?>>🟢 Pemasukan</option>
                            <option value="expense" <?php echo e(old('type') === 'expense' ? 'selected' : ''); ?>>🔴 Pengeluaran</option>
                        </select>
                        <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="transaction_date" class="form-required">Tanggal</label>
                        <input id="transaction_date" name="transaction_date" type="date" value="<?php echo e(old('transaction_date', date('Y-m-d'))); ?>" required />
                        <?php $__errorArgs = ['transaction_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="category">Kategori</label>
                        <input id="category" name="category" type="text" value="<?php echo e(old('category')); ?>" placeholder="Contoh: Gaji / Belanja" />
                        <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div>
                    <label for="cover">Lampiran Gambar (opsional)</label>
                    <input id="cover" name="cover" type="file" accept="image/*" onchange="previewImage(this)" class="w-full text-sm text-gray-600" />
                    <p class="mt-1 text-sm text-gray-500">PNG, JPG, GIF hingga 2MB.</p>
                    <div id="image-preview" class="mt-2 hidden">
                        <img id="preview-img" src="#" alt="Preview" class="max-w-xs">
                    </div>
                    <?php $__errorArgs = ['cover'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="border-t border-gray-200 pt-6 flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        <span class="text-red-500">*</span> Wajib diisi
                    </div>
                    <div class="flex space-x-4">
                        <a href="<?php echo e(route('transactions.index')); ?>" class="btn-cancel">
                            ❌ Batal
                        </a>
                        <button type="submit" class="btn-submit">
                            💾 Simpan Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
<script>
function previewImage(input) {
    const previewWrap = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    if (input.files && input.files[0]) {
        const file = input.files[0];
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({ icon: 'error', title: 'File terlalu besar', text: 'Ukuran file maksimal 2MB' });
            input.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            previewWrap.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        previewWrap.classList.add('hidden');
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEM 5\PABWE\catatan-keuangan\resources\views/transactions/create.blade.php ENDPATH**/ ?>