

<?php $__env->startSection('content'); ?>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-semibold">📊 Statistik Transaksi</h1>
                <a href="<?php echo e(route('transactions.index')); ?>" class="px-3 py-2 bg-blue-600 text-black rounded hover:bg-pink-700">Kembali</a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Tren Bulanan (Area)</h3>
                    <div id="areaChart"></div>
                </div>

                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Perbandingan Bulanan (Bar)</h3>
                    <div id="barChart"></div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <h3 class="text-lg font-semibold mb-4">Distribusi Pemasukan / Pengeluaran (Pie)</h3>
                <div id="pieChart"></div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Ringkasan Bulanan</h3>
                <div id="statsTable" class="overflow-x-auto"></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.css" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.min.js"></script>
    <script>
        // Fetch stats data using the correct named route
        fetch('<?php echo e(route('transactions.stats.data')); ?>')
            .then(r => r.json())
            .then(data => {
                // data: [{ date: '2025-01', income: 1000, expense: 500, balance: 500 }, ...]
                const labels = data.map(d => d.date);
                const income = data.map(d => Number(d.income));
                const expense = data.map(d => Number(d.expense));
                const balance = data.map(d => Number(d.balance));

                // Area chart (income/expense + line balance)
                new ApexCharts(document.querySelector('#areaChart'), {
                    chart: { type: 'area', height: 360 },
                    series: [
                        { name: 'Pemasukan', data: income },
                        { name: 'Pengeluaran', data: expense },
                        { name: 'Saldo', data: balance }
                    ],
                    xaxis: { categories: labels },
                    colors: ['#22c55e', '#ef4444', '#3b82f6']
                }).render();

                // Bar chart (compare income vs expense)
                new ApexCharts(document.querySelector('#barChart'), {
                    chart: { type: 'bar', height: 360 },
                    series: [
                        { name: 'Pemasukan', data: income },
                        { name: 'Pengeluaran', data: expense }
                    ],
                    xaxis: { categories: labels },
                    colors: ['#22c55e', '#ef4444']
                }).render();

                // Pie chart (total income vs total expense)
                const totalIncome = income.reduce((a,b) => a + b, 0);
                const totalExpense = expense.reduce((a,b) => a + b, 0);
                new ApexCharts(document.querySelector('#pieChart'), {
                    chart: { type: 'donut', height: 320 },
                    series: [totalIncome, totalExpense],
                    labels: ['Pemasukan', 'Pengeluaran'],
                    colors: ['#22c55e', '#ef4444']
                }).render();

                // Build simple summary table
                const table = document.createElement('table');
                table.className = 'min-w-full divide-y divide-gray-200';
                const thead = document.createElement('thead');
                thead.innerHTML = `
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bulan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemasukan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengeluaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Saldo</th>
                    </tr>`;
                table.appendChild(thead);
                const tbody = document.createElement('tbody');
                tbody.className = 'bg-white divide-y divide-gray-200';
                data.forEach(d => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${d.date}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">Rp ${Number(d.income).toLocaleString('id-ID')}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">Rp ${Number(d.expense).toLocaleString('id-ID')}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">Rp ${Number(d.balance).toLocaleString('id-ID')}</td>
                    `;
                    tbody.appendChild(tr);
                });
                table.appendChild(tbody);
                document.querySelector('#statsTable').appendChild(table);
            })
            .catch(err => {
                console.error('Error fetching stats data:', err);
                document.querySelector('#statsTable').innerText = 'Gagal memuat data statistik.';
            });
    </script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SEM 5\PABWE\catatan-keuangan\resources\views/transactions/stats.blade.php ENDPATH**/ ?>