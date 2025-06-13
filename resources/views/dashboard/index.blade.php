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

    $netIncome = $monthlyIncome - $totalExpenses;
    
    // Data untuk chart gabungan pemasukan vs pengeluaran
    $combinedData = [];
    
    // Gabungkan data pemasukan dan pengeluaran berdasarkan tanggal
    $allDates = collect($incomeLabels)->merge(collect($expenseLabels))->unique()->sort()->values();
    
    foreach ($allDates as $date) {
        $incomeIndex = array_search($date, $incomeLabels);
        $expenseIndex = array_search($date, $expenseLabels);
        
        $combinedData[] = [
            'date' => $date,
            'income' => $incomeIndex !== false ? $incomeValues[$incomeIndex] : 0,
            'expense' => $expenseIndex !== false ? $expenseValues[$expenseIndex] : 0,
            'net' => ($incomeIndex !== false ? $incomeValues[$incomeIndex] : 0) - 
                    ($expenseIndex !== false ? $expenseValues[$expenseIndex] : 0)
        ];
    }
    
    // Format untuk JavaScript
    $chartLabels = collect($combinedData)->pluck('date')->toArray();
    $chartIncomeValues = collect($combinedData)->pluck('income')->toArray();
    $chartExpenseValues = collect($combinedData)->pluck('expense')->toArray();
    $chartNetValues = collect($combinedData)->pluck('net')->toArray();
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

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
                 font-family: 'Inter', sans-serif;
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
<body class="bg-[#F9FAFB] font-inter">

    <!-- Include the Sidebar and Header Components -->
    @include('layouts.sidebar')
    @include('layouts.navbar') 

    <div class="p-4 md:ml-60 md:p-6"> 
        <!-- Main Content Here -->
        <div class="mb-4 p-4 w-full shadow-md rounded-lg text-center hover:shadow-lg bg-white welcome-card animate__animated animate__fadeInDown">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold">Welcome Dashboard</h1>
            <h4 class="text-xl sm:text-2xl font-bold text-[#34495E]">{{ Auth::user()->name }}</h4>
        </div>  
         <!-- Print Button -->
         <div class="flex justify-end mb-4 no-print">
            <button onclick="printDashboard()" class="px-4 py-2 bg-[#34495E] text-white rounded-lg shadow-md hover:bg-purple-700 transition-colors duration-300 flex items-center animate__animated animate__fadeIn">
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
<!-- Dashboard Cards Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 animate__animated animate__fadeInUp">
    <!-- Position 8: Pemasukan Bersih - Spans 2 columns on larger screens -->
    <div class="lg:col-span-2 bg-[#34495E] p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-white bg-opacity-20 p-3 rounded-lg mr-4">
                    <i class="bx bx-trending-up text-3xl text-white"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-white opacity-90">Pemasukan Bersih</h2>
                    <p class="text-2xl font-bold text-white">
                        Rp. {{ number_format(($monthlyIncome - $totalExpenses), 0, ',', '.') }}
                    </p>
                    <div class="flex items-center mt-1">
                        @php
                            $netIncomePercent = $monthlyIncome > 0 ? (($monthlyIncome - $totalExpenses) / $monthlyIncome) * 100 : 0;
                        @endphp
                        <span class="text-sm text-white opacity-75">
                            {{ number_format($netIncomePercent, 1) }}% dari pemasukan
                        </span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-xs text-white opacity-75 mb-1">Bulan Ini</div>
                <div class="bg-white bg-opacity-20 px-3 py-1 text-center rounded-full">
                    <span class="text-xs font-medium text-white">{{ date('M Y') }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Position 2: Pemasukan -->
    <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border-l-4 group">
        <div class="flex items-center mt-4 justify-between">
            <div class="flex items-center">
                <div class="bg-transparant p-3 rounded-lg mr-4 group-hover:bg-green-200 transition-colors duration-300">
                    <i class="bx bx-wallet text-2xl text-black"></i>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Pemasukan</h2>
                    <p class="text-xl font-bold text-black">Rp. {{ number_format($monthlyIncome, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="text-right">
                <div class="bg-green-50 px-2 py-1 rounded-full">
                    <span class="text-xs text-black font-medium">+100%</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Position 3: Pengeluaran -->
    <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border-l-4 group">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-transparant p-3 rounded-lg mr-4 group-hover:bg-red-200 transition-colors duration-300">
                    <i class="bx bx-cart text-2xl text-black"></i>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Pengeluaran</h2>
                    <p class="text-xl font-bold text-black">Rp. {{ number_format($totalExpenses, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="text-right">
                @php
                    $expensePercent = $monthlyIncome > 0 ? ($totalExpenses / $monthlyIncome) * 100 : 0;
                @endphp
                <div class="bg-red-50 px-2 py-1 rounded-full">
                    <span class="text-xs text-red-600 font-medium">-{{ number_format($expensePercent, 1) }}%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Position 4: Order -->
    <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border-l-4 group">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-transparant p-3 rounded-lg mr-4 group-hover:bg-blue-200 transition-colors duration-300">
                    <i class="bx bx-shopping-bag text-2xl text-black"></i>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Order</h2>
                    <p class="text-xl font-bold text-black">{{ $monthlyOrders }}</p>
                </div>
            </div>
            <div class="text-right">
                <div class="bg-blue-50 px-2 py-1 rounded-full">
                    <span class="text-xs text-black font-medium">Transaksi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Position 5: Total Barang -->
    <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border-l-4 group">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-transparant p-3 rounded-lg mr-4 group-hover:bg-purple-200 transition-colors duration-300">
                    <i class="bx bx-package text-2xl text-black"></i>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Barang</h2>
                    <p class="text-xl font-bold text-balck">{{ $totalProducts }}</p>
                </div>
            </div>
            <div class="text-right">
                <div class="bg-purple-50 px-2 py-1 rounded-full">
                    <span class="text-xs text-balckfont-medium">Items</span>
                </div>
            </div>
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
    
    // Get current month and year
    const now = new Date();
    const currentMonth = now.getMonth() + 1; // JavaScript months are 0-indexed
    const currentYear = now.getFullYear();
    const daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
    
    // Function to group data by time period
    function groupFinancialData(period) {
        const expenseMap = new Map();
        const incomeMap = new Map();
        
        // Initialize all possible date keys for the current month (for daily view)
        if (period === "daily") {
            for (let day = 1; day <= daysInMonth; day++) {
                const dateKey = `${currentYear}-${String(currentMonth).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                expenseMap.set(dateKey, 0);
                incomeMap.set(dateKey, 0);
            }
        }
        
        // Process expenses
        allExpenses.forEach(expense => {
            const date = new Date(expense.created_at);
            // Skip if not from current month and year for daily and weekly views
            if ((period === "daily" || period === "weekly") && 
                (date.getMonth() + 1 !== currentMonth || date.getFullYear() !== currentYear)) {
                return;
            }
            
            let key;
            
            if (period === "daily") {
                key = date.toISOString().split('T')[0]; // YYYY-MM-DD
            } else if (period === "weekly") {
                const weekNum = getWeekNumber(date);
                key = `${currentYear}-W${weekNum.toString().padStart(2, '0')}`;
                
                // Initialize week keys if they don't exist
                if (!expenseMap.has(key)) {
                    expenseMap.set(key, 0);
                    incomeMap.set(key, 0);
                }
            } else if (period === "monthly") {
                const month = date.getMonth() + 1;
                key = `${date.getFullYear()}-${month.toString().padStart(2, '0')}`;
                
                // Initialize month keys if they don't exist
                if (!expenseMap.has(key)) {
                    expenseMap.set(key, 0);
                    incomeMap.set(key, 0);
                }
            } else { // yearly
                key = date.getFullYear().toString();
                
                // Initialize year keys if they don't exist
                if (!expenseMap.has(key)) {
                    expenseMap.set(key, 0);
                    incomeMap.set(key, 0);
                }
            }
            
            if (expenseMap.has(key)) {
                expenseMap.set(key, expenseMap.get(key) + parseFloat(expense.amount));
            } else {
                expenseMap.set(key, parseFloat(expense.amount));
            }
        });
        
        // Process income (transactions)
        allTransactions.forEach(transaction => {
            const date = new Date(transaction.created_at);
            // Skip if not from current month and year for daily and weekly views
            if ((period === "daily" || period === "weekly") && 
                (date.getMonth() + 1 !== currentMonth || date.getFullYear() !== currentYear)) {
                return;
            }
            
            let key;
            
            if (period === "daily") {
                key = date.toISOString().split('T')[0]; // YYYY-MM-DD
            } else if (period === "weekly") {
                const weekNum = getWeekNumber(date);
                key = `${currentYear}-W${weekNum.toString().padStart(2, '0')}`;
            } else if (period === "monthly") {
                const month = date.getMonth() + 1;
                key = `${date.getFullYear()}-${month.toString().padStart(2, '0')}`;
            } else { // yearly
                key = date.getFullYear().toString();
            }
            
            if (incomeMap.has(key)) {
                incomeMap.set(key, incomeMap.get(key) + parseFloat(transaction.total));
            } else {
                incomeMap.set(key, parseFloat(transaction.total));
            }
        });
        
        // Get all keys based on the period
        let allKeys = [];
        
        if (period === "daily") {
            // For daily, use all days in the current month
            allKeys = Array.from(expenseMap.keys());
        } else if (period === "weekly") {
            // For weekly, get weeks in the current month
            const weeksInMonth = getWeeksInMonth(currentYear, currentMonth);
            allKeys = weeksInMonth.map(weekNum => `${currentYear}-W${weekNum.toString().padStart(2, '0')}`);
        } else if (period === "monthly") {
            // For monthly, get all months in current year
            allKeys = [];
            for (let month = 1; month <= 12; month++) {
                allKeys.push(`${currentYear}-${month.toString().padStart(2, '0')}`);
            }
        } else { // yearly
            // Get last 5 years
            allKeys = [];
            for (let year = currentYear - 4; year <= currentYear; year++) {
                allKeys.push(year.toString());
            }
        }
        
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
                return `Minggu ${week}`;
            } else if (period === "monthly") {
                const [year, month] = key.split('-');
                return new Date(`${year}-${month}-01`).toLocaleDateString('id-ID', { month: 'long' });
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
    
    // Helper function to get week number
    function getWeekNumber(d) {
        d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
        d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay() || 7));
        const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
        const weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
        return weekNo;
    }
    
    // Helper function to get all week numbers in a month
    function getWeeksInMonth(year, month) {
        const weeks = new Set();
        const firstDay = new Date(year, month - 1, 1);
        const lastDay = new Date(year, month, 0);
        
        let currentDate = new Date(firstDay);
        while (currentDate <= lastDay) {
            weeks.add(getWeekNumber(currentDate));
            currentDate.setDate(currentDate.getDate() + 1);
        }
        
        return Array.from(weeks).sort((a, b) => a - b);
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
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp. ' + value.toLocaleString('id-ID');
                        }
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

    // Order Chart
    const ctxOrder = document.getElementById('orderChart').getContext('2d');
    
    function groupOrderData(period) {
        const orderMap = new Map();
        
        // Initialize all possible date keys for the current month (for daily view)
        if (period === "daily") {
            for (let day = 1; day <= daysInMonth; day++) {
                const dateKey = `${currentYear}-${String(currentMonth).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                orderMap.set(dateKey, 0);
            }
        }
        
        allTransactions.forEach(transaction => {
            const date = new Date(transaction.created_at);
            // Skip if not from current month and year for daily and weekly views
            if ((period === "daily" || period === "weekly") && 
                (date.getMonth() + 1 !== currentMonth || date.getFullYear() !== currentYear)) {
                return;
            }
            
            let key;
            
            if (period === "daily") {
                key = date.toISOString().split('T')[0]; // YYYY-MM-DD
            } else if (period === "weekly") {
                const weekNum = getWeekNumber(date);
                key = `${currentYear}-W${weekNum.toString().padStart(2, '0')}`;
                
                // Initialize week keys if they don't exist
                if (!orderMap.has(key)) {
                    orderMap.set(key, 0);
                }
            } else if (period === "monthly") {
                const month = date.getMonth() + 1;
                key = `${date.getFullYear()}-${month.toString().padStart(2, '0')}`;
                
                // Initialize month keys if they don't exist
                if (!orderMap.has(key)) {
                    orderMap.set(key, 0);
                }
            } else { // yearly
                key = date.getFullYear().toString();
                
                // Initialize year keys if they don't exist
                if (!orderMap.has(key)) {
                    orderMap.set(key, 0);
                }
            }
            
            if (orderMap.has(key)) {
                orderMap.set(key, orderMap.get(key) + 1);
            } else {
                orderMap.set(key, 1);
            }
        });
        
        // Get all keys based on the period
        let allKeys = [];
        
        if (period === "daily") {
            // For daily, use all days in the current month
            allKeys = Array.from(orderMap.keys());
        } else if (period === "weekly") {
            // For weekly, get weeks in the current month
            const weeksInMonth = getWeeksInMonth(currentYear, currentMonth);
            allKeys = weeksInMonth.map(weekNum => `${currentYear}-W${weekNum.toString().padStart(2, '0')}`);
        } else if (period === "monthly") {
            // For monthly, get all months in current year
            allKeys = [];
            for (let month = 1; month <= 12; month++) {
                allKeys.push(`${currentYear}-${month.toString().padStart(2, '0')}`);
            }
        } else { // yearly
            // Get last 5 years
            allKeys = [];
            for (let year = currentYear - 4; year <= currentYear; year++) {
                allKeys.push(year.toString());
            }
        }
        
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
        
        // Format labels for display
        const labels = allKeys.map(key => {
            if (period === "daily") {
                return new Date(key).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            } else if (period === "weekly") {
                const [year, week] = key.split('-W');
                return `Minggu ${week}`;
            } else if (period === "monthly") {
                const [year, month] = key.split('-');
                return new Date(`${year}-${month}-01`).toLocaleDateString('id-ID', { month: 'long' });
            } else { // yearly
                return key;
            }
        });
        
        return {
            labels,
            values: allKeys.map(key => orderMap.get(key) || 0)
        };
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
                        precision: 0 // Ensure whole numbers
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