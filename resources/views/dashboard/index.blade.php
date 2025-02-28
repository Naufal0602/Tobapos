@php
    use App\Models\Product;
    use App\Models\transaction; // Assuming you have an Order model
    use App\Models\Expense;

    $products = Product::latest()->get();
    $totalProducts = Product::count();

    
    $expenses = Expense::latest()->get();
    $totalExpenses = Expense::sum('amount'); // Menghitung total amount dari expenses

    $expenseData = Expense::selectRaw('DATE(created_at) as date, SUM(amount) as total')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    // Format data untuk chart.js
    $expenseLabels = $expenseData->pluck('date')->toArray(); // Ambil tanggal
    $expenseValues = $expenseData->pluck('total')->toArray();

    // Get the number of orders for the current month
    $currentMonth = now()->format('Y-m');
    $monthlyOrders = transaction::where('created_at', 'like', "$currentMonth%")->count();
    $orderData = transaction::selectRaw('DATE(created_at) as date, COUNT(*) as total')
    ->groupBy('date')
    ->orderBy('date')
    ->get();

// Format data untuk Chart.js
$orderLabels = $orderData->pluck('date')->toArray();
$orderValues = $orderData->pluck('total')->toArray();
$monthlyIncome = Transaction::where('created_at', 'like', "$currentMonth%")->sum('total');

@endphp
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
    <div class="print-section">
        <!-- Cards Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 sm:gap-6 animate__animated animate__fadeInUp">
            <!-- Pemasukan -->
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

  <!-- Chart Script -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
         const ctx = document.getElementById('financeChart').getContext('2d');

         // Data asli dari Blade (diambil dari backend)
         const rawExpenseLabels = @json($expenseLabels); // Format tanggal dari backend
         const rawExpenseValues = @json($expenseValues); // Jumlah pengeluaran sesuai tanggal

         // Fungsi untuk mengelompokkan data berdasarkan periode waktu
         function groupDataByTime(period) {
             const groupedLabels = [];
             const groupedValues = {};
             
             rawExpenseLabels.forEach((date, index) => {
                 let key;
                 const dateObj = new Date(date);

                 if (period === "weekly") {
                     key = `Minggu ${getWeekNumber(dateObj)}`;
                 } else if (period === "monthly") {
                     key = `${dateObj.getFullYear()}-${String(dateObj.getMonth() + 1).padStart(2, '0')}`;
                 } else if (period === "yearly") {
                     key = `${dateObj.getFullYear()}`;
                 } else {
                     key = date; // Harian (default)
                 }

                 if (!groupedValues[key]) {
                     groupedValues[key] = 0;
                     groupedLabels.push(key);
                 }
                 groupedValues[key] += rawExpenseValues[index];
             });

             return {
                 labels: groupedLabels,
                 values: groupedLabels.map(label => groupedValues[label])
             };
         }

         function getWeekNumber(d) {
             const oneJan = new Date(d.getFullYear(), 0, 1);
             const numberOfDays = Math.floor((d - oneJan) / (24 * 60 * 60 * 1000));
             return Math.ceil((numberOfDays + oneJan.getDay() + 1) / 7);
         }

         let chartData = groupDataByTime("daily");

         let financeChart = new Chart(ctx, {
             type: 'line',
             data: {
                 labels: chartData.labels,
                 datasets: [{
                     label: 'Pengeluaran',
                     data: chartData.values,
                     borderColor: '#9333ea',
                     backgroundColor: 'rgba(147, 51, 234, 0.1)',
                     borderWidth: 2,
                     pointRadius: 4,
                     pointBackgroundColor: '#9333ea',
                     pointHoverRadius: 6,
                     pointHoverBackgroundColor: '#7e22ce',
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
                                 return 'Pengeluaran: Rp. ' + context.parsed.y.toLocaleString('id-ID');
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
             chartData = groupDataByTime(selectedPeriod);

             financeChart.data.labels = chartData.labels;
             financeChart.data.datasets[0].data = chartData.values;
             financeChart.update();
         });
     });

     document.addEventListener("DOMContentLoaded", function() {
        const ctxOrder = document.getElementById('orderChart').getContext('2d');

        // Data asli dari Blade (diambil dari backend)
        const rawOrderLabels = @json($orderLabels); // Format tanggal dari backend
        const rawOrderValues = @json($orderValues); // Jumlah order sesuai tanggal

        // Fungsi untuk mengelompokkan data berdasarkan periode waktu
        function groupOrderData(period) {
            const groupedLabels = [];
            const groupedValues = {};

            rawOrderLabels.forEach((date, index) => {
                let key;
                const dateObj = new Date(date);

                if (period === "weekly") {
                    key = `Minggu ${getWeekNumber(dateObj)}`;
                } else if (period === "monthly") {
                    key = `${dateObj.getFullYear()}-${String(dateObj.getMonth() + 1).padStart(2, '0')}`;
                } else if (period === "yearly") {
                    key = `${dateObj.getFullYear()}`;
                } else {
                    key = date; // Harian (default)
                }

                if (!groupedValues[key]) {
                    groupedValues[key] = 0;
                    groupedLabels.push(key);
                }
                groupedValues[key] += rawOrderValues[index];
            });

            return {
                labels: groupedLabels,
                values: groupedLabels.map(label => groupedValues[label])
            };
        }

        function getWeekNumber(d) {
            const oneJan = new Date(d.getFullYear(), 0, 1);
            const numberOfDays = Math.floor((d - oneJan) / (24 * 60 * 60 * 1000));
            return Math.ceil((numberOfDays + oneJan.getDay() + 1) / 7);
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
        
        // Print
        window.print();
        
        // Hide print-only elements again
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
 </script>
</body>
</html>