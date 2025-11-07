<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- SweetAlert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Trix Editor -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">

    <?php echo $__env->yieldPushContent('styles'); ?>

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <!-- SweetAlert & ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Trix -->
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff5f8;
        }

        /* Navbar pink gradasi */
        nav {
            background: linear-gradient(90deg, #ffd6e0, #ffb6c1, #ffe4ec);
            box-shadow: 0 2px 6px rgba(255, 182, 193, 0.4);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 50;
        }

        main {
            padding-top: 5rem; /* biar tidak ketimpa navbar */
        }

        /* Card hover lembut */
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(255, 182, 193, 0.4);
            transition: all 0.3s ease;
        }

        /* Tombol feminin */
        .btn-pink {
            background: linear-gradient(to right, #ff80aa, #ffb6c1);
            color: white;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-pink:hover {
            background: linear-gradient(to right, #ff5c8d, #ff9eb5);
            transform: scale(1.03);
            box-shadow: 0 4px 10px rgba(255, 120, 150, 0.4);
        }

        /* SweetAlert feminim */
        .swal2-popup {
            border-radius: 20px !important;
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-800">
    <div class="min-h-screen">
        <!-- Navbar -->
        <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Page Heading -->
        <?php if(isset($header)): ?>
            <header class="bg-white/70 backdrop-blur-md shadow-md mt-16">
                <div class="max-w-7xl mx-auto py-4 px-6 lg:px-8 text-pink-700 font-semibold">
                    <?php echo e($header); ?>

                </div>
            </header>
        <?php endif; ?>

        <!-- Page Content -->
        <main class="px-4 sm:px-6 lg:px-8">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <!-- Notifikasi Sukses -->
    <?php if(session('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses 💖',
                text: "<?php echo e(session('success')); ?>",
                timer: 2000,
                showConfirmButton: false,
                background: '#fff0f5',
                color: '#d63384'
            });
        </script>
    <?php endif; ?>

    <script>
        function showSuccess(message) {
            Swal.fire({
                icon: 'success',
                title: 'Sukses 💖',
                text: message,
                timer: 2000,
                showConfirmButton: false,
                background: '#fff0f5',
                color: '#d63384'
            });
        }

        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal 😢',
                text: message,
                background: '#fff0f5',
                color: '#c9184a'
            });
        }
    </script>
</body>
</html>
<?php /**PATH D:\SEM 5\PABWE\catatan-keuangan\resources\views/layouts/app.blade.php ENDPATH**/ ?>