<?php
    use App\Models\Product;
    use App\Models\Transaction;
    use App\Models\Expense;

    $products = Product::latest()->get();
    $totalProducts = Product::count();

    $currentMonth = now()->format('Y-m');
    $currentYear = now()->format('Y');

     // Get all expenses for current year (for monthly/yearly views)
    $allExpenses = Expense::whereYear('created_at', $currentYear)->get();
    $allTransactions = Transaction::whereYear('created_at', $currentYear)->get();

    $expenses = Expense::where('created_at', 'like', "$currentMonth%")->latest()->get();
    $totalExpenses = Expense::where('created_at', 'like', "$currentMonth%")->sum('amount');

    $expenseData = Expense::selectRaw('DATE(created_at) as date, SUM(amount) as total')
        ->where('created_at', 'like', "$currentMonth%")
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    // Format data untuk chart.js
    $expenseLabels = $expenseData->pluck('date')->map(function ($date) {
    return \Carbon\Carbon::parse($date)->format('Y-m-d');
})->toArray();
    $expenseValues = $expenseData->pluck('total')->toArray();

    // Get the number of orders for the current month
   
    // Get the number of orders for the current month
    $monthlyOrders = Transaction::where('created_at', 'like', "$currentMonth%")->count();
    $monthlyIncome = Transaction::where('created_at', 'like', "$currentMonth%")->sum('total');
    $orderData = Transaction::selectRaw('DATE(created_at) as date, COUNT(*) as total')
        ->where('created_at', 'like', "$currentMonth%")
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    // Format data untuk Chart.js
    $orderLabels = $orderData->pluck('date')->toArray();
    $orderValues = $orderData->pluck('total')->toArray();
    $monthlyIncome = Transaction::where('created_at', 'like', "$currentMonth%")->sum('total');

    // Data pemasukan
    $incomeData = Transaction::selectRaw('DATE(created_at) as date, SUM(total) as total')
        ->where('created_at', 'like', "$currentMonth%")
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    // Format data untuk Chart.js
    $incomeLabels = $incomeData->pluck('date')->toArray();
    $incomeValues = $incomeData->pluck('total')->toArray();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="{{ asset('img/logo_v2.png')}}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="{{ asset('input.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        #financeChart, #orderChart {
            max-width: 1440px;
            max-height: 300px;
            width: 100%;
            height: auto;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        .icon-bounce {
            transition: transform 0.3s ease;
        }
        
        .card-hover:hover .icon-bounce {
            transform: scale(1.2);
            color: #9333ea;
        }
        
        .welcome-card {
            transition: all 0.5s ease;
            background: linear-gradient(145deg, #ffffff, #f5f5f5);
        }
        
        .welcome-card:hover {
            background: linear-gradient(145deg, #f5f5f5, #ffffff);
            transform: scale(1.01);
        }
        
        .chart-container {
            transition: all 0.3s ease;
        }
        
        .chart-container:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        @media print {
            body * {
                visibility: hidden;
            }
            
            .print-section, .print-section * {
                visibility: visible;
            }
            
            .print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            
            .no-print {
                display: none;
            }
            
            .sidebar, .navbar {
                display: none;
            }
            
            canvas {
                max-height: 200px !important;
            }
        }
    </style>
</head>
<body class="font-sans" style="background:#F5E6F0;">

    <!-- Include the Sidebar and Header Components -->
    @include('layouts.sidebar')
    @include('layouts.navbar') 

    <div class="p-4 md:ml-60 md:p-6"> 
        <!-- Main Content Here -->
        <div class="mb-4 p-4 w-full shadow-md rounded-lg text-center hover:shadow-lg bg-white welcome-card animate__animated animate__fadeInDown" style="font-family: 'Nunito', sans-serif;">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold">Welcome Dashboard</h1>
            <h4 class="text-xl sm:text-2xl font-bold text-purple-600">{{ Auth::user()->name }}</h4>
        </div>  
         <!-- Print Button -->
         <div class="flex justify-end mb-4 no-print">
            <button onclick="printDashboard()" class="px-4 py-2 bg-purple-600 text-white rounded-lg shadow-md hover:bg-purple-700 transition-colors duration-300 flex items-center animate__animated animate__fadeIn">
                <i class="bx bx-printer mr-2"></i> Print Dashboard
            </button>
        </div>  
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-3 rounded" role="alert">
                <p>{{ session('error') }}</p>
            </div>
            @endif

            @if(session('success'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-3 rounded" role="alert">
                <p>{{ session('success') }}</p>
            </div>
            @endif
    <div class="print-section">
        <!-- Cards Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 sm:gap-6 animate__animated animate__fadeInUp">
            <!-- Pemasukan -->
            
            <div class="bg-white p-4 rounded-lg shadow-md flex items-center card-hover">
                <i class="bx bx-wallet text-3xl sm:text-4xl mr-2 sm:mr-4 icon-bounce"></i>
                <div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-700">Pemasukan</h2>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">Rp. {{ number_format($monthlyIncome, 0, ',', '.') }}</p>
                </div>
            </div>
            
            <!-- Pengeluaran -->
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md flex items-center card-hover">
                <i class="bx bx-cart text-3xl sm:text-4xl mr-2 sm:mr-4 icon-bounce"></i>
                <div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-700">Pengeluaran</h2>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">Rp. {{ number_format($totalExpenses, 0, ',', '.') }}</p>
                </div>
            </div>
    
            <!-- Order -->
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md flex items-center card-hover">
                <i class="bx bx-shopping-bag text-3xl sm:text-4xl mr-2 sm:mr-4 icon-bounce"></i>
                <div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-700">Order</h2>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $monthlyOrders }}</p>
                </div>
            </div>
    
            <!-- Total Penjualan -->
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md flex items-center card-hover">
                <i class="bx bx-package text-3xl sm:text-4xl mr-2 sm:mr-4 icon-bounce"></i>
                <div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-700">Total Barang</h2>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
    
        <!-- Chart Section -->
        <div class="mt-6 sm:mt-8 bg-white p-4 sm:p-6 rounded-lg shadow-md chart-container animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-base sm:text-lg font-semibold text-gray-700">Grafik Keuangan</h2>
                <select id="timeFilter" class="p-2 border rounded-md text-gray-700 no-print">
                    <option value="daily">Harian</option>
                    <option value="weekly">Mingguan</option>
                    <option value="monthly">Bulanan</option>
                    <option value="yearly">Tahunan</option>
                </select>
            </div>
            <canvas id="financeChart"></canvas>
        </div> 
        
        <!-- Chart Order Section -->
        <div class="mt-6 sm:mt-8 bg-white p-4 sm:p-6 rounded-lg shadow-md chart-container animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-base sm:text-lg font-semibold text-gray-700">Grafik Order</h2>
                <select id="orderFilter" class="p-2 border rounded-md text-gray-700 no-print">
                    <option value="daily">Harian</option>
                    <option value="weekly">Mingguan</option>
                    <option value="monthly">Bulanan</option>
                    <option value="yearly">Tahunan</option>
                </select>
            </div>
            <canvas id="orderChart"></canvas>
        </div>
    </div> 

    
        <!-- Print Date Footer -->
        <div class="mt-6 text-center text-gray-500 print-only" style="display: none;">
            <p>Printed on: <span id="print-date"></span></p>
        </div>
    </div>    

  
  
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('financeChart').getContext('2d');
    
    // Data from backend
    const allExpenses = @json($allExpenses);
    const allTransactions = @json($allTransactions);
    
    // Function to group data by time period
    function groupFinancialData(period) {
        const expenseMap = new Map();
        const incomeMap = new Map();
        
        // Process expenses
        allExpenses.forEach(expense => {
            const date = new Date(expense.created_at);
            let key;
            
            if (period === "daily") {
                key = date.toISOString().split('T')[0]; // YYYY-MM-DD
            } else if (period === "weekly") {
                const weekNum = getWeekNumber(date);
                const year = date.getFullYear();
                key = `${year}-W${weekNum.toString().padStart(2, '0')}`;
            } else if (period === "monthly") {
                const month = date.getMonth() + 1;
                key = `${date.getFullYear()}-${month.toString().padStart(2, '0')}`;
            } else { // yearly
                key = date.getFullYear().toString();
            }
            
            if (!expenseMap.has(key)) {
                expenseMap.set(key, 0);
            }
            expenseMap.set(key, expenseMap.get(key) + parseFloat(expense.amount));
        });
        
        // Process income (transactions)
        allTransactions.forEach(transaction => {
            const date = new Date(transaction.created_at);
            let key;
            
            if (period === "daily") {
                key = date.toISOString().split('T')[0]; // YYYY-MM-DD
            } else if (period === "weekly") {
                const weekNum = getWeekNumber(date);
                const year = date.getFullYear();
                key = `${year}-W${weekNum.toString().padStart(2, '0')}`;
            } else if (period === "monthly") {
                const month = date.getMonth() + 1;
                key = `${date.getFullYear()}-${month.toString().padStart(2, '0')}`;
            } else { // yearly
                key = date.getFullYear().toString();
            }
            
            if (!incomeMap.has(key)) {
                incomeMap.set(key, 0);
            }
            incomeMap.set(key, incomeMap.get(key) + parseFloat(transaction.total));
        });
        
        // Combine and sort keys
        const allKeys = Array.from(new Set([...expenseMap.keys(), ...incomeMap.keys()]));
        
        // Sort keys chronologically
        allKeys.sort((a, b) => {
            if (period === "daily") {
                return new Date(a) - new Date(b);
            } else if (period === "weekly") {
                const [yearA, weekA] = a.split('-W').map(Number);
                const [yearB, weekB] = b.split('-W').map(Number);
                return yearA === yearB ? weekA - weekB : yearA - yearB;
            } else if (period === "monthly") {
                return a.localeCompare(b);
            } else { // yearly
                return Number(a) - Number(b);
            }
        });
        
        // Format labels based on period
        const labels = allKeys.map(key => {
            if (period === "daily") {
                return new Date(key).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            } else if (period === "weekly") {
                const [year, week] = key.split('-W');
                return `Minggu ${week} ${year}`;
            } else if (period === "monthly") {
                const [year, month] = key.split('-');
                return new Date(`${year}-${month}-01`).toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
            } else { // yearly
                return key;
            }
        });
        
        return {
            labels,
            expenseValues: allKeys.map(key => expenseMap.get(key) || 0),
            incomeValues: allKeys.map(key => incomeMap.get(key) || 0)
        };
    }
    
    function getWeekNumber(d) {
        d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
        d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay() || 7));
        const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
        const weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
        return weekNo;
    }
    
    let chartData = groupFinancialData("daily");

         let financeChart = new Chart(ctx, {
             type: 'line',
                data: {
                labels: chartData.labels,
                datasets: [
                    {
                         label: 'Pengeluaran',
                         data: chartData.expenseValues,
                         borderColor: '#9333ea',
                         backgroundColor: 'rgba(147, 51, 234, 0.1)',
                         borderWidth: 2,
                         pointRadius: 4,
                         pointBackgroundColor: '#9333ea',
                         pointHoverRadius: 6,
                         pointHoverBackgroundColor: '#7e22ce',
                         fill: true,
                         tension: 0.2
                     },
                     {    
                         label: 'Pemasukan',
                         data: chartData.incomeValues,
                         borderColor: '#34d399',
                         backgroundColor: 'rgba(52, 211, 153, 0.1)',
                         borderWidth: 2,
                         pointRadius: 4,
                         pointBackgroundColor: '#34d399',
                         pointHoverRadius: 6,
                         pointHoverBackgroundColor: '#059669',
                         fill: true,
                         tension: 0.2
                     }
                 ]
             },
             options: {
                 responsive: true,
                 scales: {
                     y: {
                         beginAtZero: true,
                         grid: {
                             color: 'rgba(0, 0, 0, 0.05)'
                         }
                     },
                     x: {
                         grid: {
                             color: 'rgba(0, 0, 0, 0.05)'
                         }
                     }
                 },
                 animation: {
                     duration: 2000,
                     easing: 'easeOutQuart'
                 },
                 plugins: {
                     tooltip: {
                         backgroundColor: 'rgba(0, 0, 0, 0.7)',
                         padding: 10,
                         titleFont: {
                             size: 14
                         },
                         bodyFont: {
                             size: 14
                         },
                         callbacks: {
                             label: function(context) {
                                 return context.dataset.label + ': Rp. ' + context.parsed.y.toLocaleString('id-ID');
                             }
                         }
                     },
                     legend: {
                         labels: {
                             font: {
                                 size: 14
                             }
                         }
                     }
                 }
             }
         });

         document.getElementById('timeFilter').addEventListener('change', function() {
        const selectedPeriod = this.value;
        chartData = groupFinancialData(selectedPeriod);
        
        financeChart.data.labels = chartData.labels;
        financeChart.data.datasets[0].data = chartData.expenseValues;
        financeChart.data.datasets[1].data = chartData.incomeValues;
        financeChart.update();
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const ctxOrder = document.getElementById('orderChart').getContext('2d');
    const allTransactions = @json($allTransactions);
    
    function groupOrderData(period) {
        const orderMap = new Map();
        
        allTransactions.forEach(transaction => {
            const date = new Date(transaction.created_at);
            let key;
            
            if (period === "daily") {
                // Format: YYYY-MM-DD
                key = date.toISOString().split('T')[0];
            } else if (period === "weekly") {
                // Format: YYYY-Www (ISO week)
                const year = date.getFullYear();
                const weekNum = getISOWeekNumber(date);
                key = `${year}-W${weekNum.toString().padStart(2, '0')}`;
            } else if (period === "monthly") {
                // Format: YYYY-MM
                const month = date.getMonth() + 1;
                key = `${date.getFullYear()}-${month.toString().padStart(2, '0')}`;
            } else { // yearly
                // Format: YYYY
                key = date.getFullYear().toString();
            }
            
            if (!orderMap.has(key)) {
                orderMap.set(key, 0);
            }
            orderMap.set(key, orderMap.get(key) + 1);
        });
        
        const allKeys = Array.from(orderMap.keys());
        
        // Sort keys chronologically
        allKeys.sort((a, b) => {
            if (period === "daily") {
                return new Date(a) - new Date(b);
            } else if (period === "weekly") {
                // Parse ISO week format (YYYY-Www)
                const [yearA, weekA] = a.split('-W').map(Number);
                const [yearB, weekB] = b.split('-W').map(Number);
                return yearA === yearB ? weekA - weekB : yearA - yearB;
            } else if (period === "monthly") {
                return a.localeCompare(b);
            } else { // yearly
                return Number(a) - Number(b);
            }
        });
        
        // Format labels for display
        const labels = allKeys.map(key => {
            if (period === "daily") {
                // Format: DD MMM (e.g., 1 Jan)
                return new Date(key).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            } else if (period === "weekly") {
                // Format: Minggu ww YYYY (e.g., Minggu 05 2023)
                const [year, week] = key.split('-W');
                return `Minggu ${week} ${year}`;
            } else if (period === "monthly") {
                // Format: MMMM YYYY (e.g., Januari 2023)
                const [year, month] = key.split('-');
                return new Date(`${year}-${month}-01`).toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
            } else { // yearly
                // Format: YYYY
                return key;
            }
        });
        
        return {
            labels,
            values: allKeys.map(key => orderMap.get(key))
        };
    }
    
    // Fungsi untuk mendapatkan nomor minggu ISO (lebih akurat)
    function getISOWeekNumber(date) {
        const d = new Date(date);
        d.setHours(0, 0, 0, 0);
        // Thursday in current week decides the year
        d.setDate(d.getDate() + 3 - (d.getDay() + 6) % 7);
        // January 4 is always in week 1
        const week1 = new Date(d.getFullYear(), 0, 4);
        // Adjust to Thursday in week 1 and count number of weeks from date to week1
        return 1 + Math.round(((d - week1) / 86400000 - 3 + (week1.getDay() + 6) % 7) / 7);
    }
    
    let orderChartData = groupOrderData("daily");

    let orderChart = new Chart(ctxOrder, {
        type: 'line',
        data: {
            labels: orderChartData.labels,
            datasets: [{
                label: 'Jumlah Order',
                data: orderChartData.values,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: '#3b82f6',
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#2563eb',
                fill: true,
                tension: 0.2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        precision: 0 // Untuk memastikan angka bulat
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            },
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.7)',
                    padding: 10,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 14
                    },
                    callbacks: {
                        label: function(context) {
                            return `Order: ${context.parsed.y}`;
                        }
                    }
                },
                legend: {
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });

    document.getElementById('orderFilter').addEventListener('change', function() {
        const selectedPeriod = this.value;
        orderChartData = groupOrderData(selectedPeriod);
        
        orderChart.data.labels = orderChartData.labels;
        orderChart.data.datasets[0].data = orderChartData.values;
        orderChart.update();
    });
});

     

    
    // Print functionality
    function printDashboard() {
        // Set print date
        const now = new Date();
        const formattedDate = now.toLocaleString('id-ID', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric', 
            hour: '2-digit', 
            minute: '2-digit'
        });
        document.getElementById('print-date').textContent = formattedDate;
        
        // Show print-only elements
        document.querySelectorAll('.print-only').forEach(el => {
            el.style.display = 'block';
        });
        
       
        window.print();
        
        
        document.querySelectorAll('.print-only').forEach(el => {
            el.style.display = 'none';
        });
    }
    
    // Add animations to cards on scroll
    document.addEventListener('DOMContentLoaded', function() {
        // Initial load animations are handled by animate.css classes
        
        // Add event listener to card hover
        const cards = document.querySelectorAll('.card-hover');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                const icon = this.querySelector('.icon-bounce');
                icon.style.transform = 'scale(1.2)';
                icon.style.color = '#9333ea';
            });
            
            card.addEventListener('mouseleave', function() {
                const icon = this.querySelector('.icon-bounce');
                icon.style.transform = 'scale(1)';
                icon.style.color = '';
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const fadeElements = document.querySelectorAll('.welcome-card, .card-hover, .chart-container');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-10');
                } else {
                    entry.target.classList.add('opacity-0', 'translate-y-10');
                    entry.target.classList.remove('opacity-100', 'translate-y-0');
                }
            });
        }, {
            threshold: 0.1,
        });

        fadeElements.forEach((el) => {
            el.classList.add('opacity-0', 'translate-y-10', 'transition', 'duration-700', 'ease-in-out');
            observer.observe(el);
        });
    });
 </script>