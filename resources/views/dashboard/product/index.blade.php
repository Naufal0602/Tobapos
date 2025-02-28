<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Product</title>
    <link rel="icon" href="{{ asset('img/logo_v2.png')}}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
    <!-- DataTables with Responsive Extension -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  
    <link rel="stylesheet" href="{{ asset('input.css') }}">

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printArea, #printArea * {
                visibility: visible;
            }
            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print, 
            .dataTables_paginate, 
            .dataTables_info, 
            .dataTables_length, 
            .dataTables_filter,
            .dataTables_wrapper .dt-buttons,
            .sorting,
            .sorting_asc,
            .sorting_desc {
                display: none !important;
            }
            .table-responsive {
                overflow-x: visible !important;
            }
            /* Remove DataTables styling during print */
            table.dataTable {
                width: 100% !important;
                margin: 0 !important;
                clear: both;
                border-collapse: collapse !important;
                border-spacing: 0 !important;
            }
        }

        /* Responsive sidebar */
        @media (max-width: 768px) {
            .sidebar-container {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            .sidebar-container.open {
                transform: translateX(0);
            }
            .content-container {
                margin-left: 0;
            }
        }

        /* Better table handling on small screens */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>
<body class="bg-[#F5E6F0]">

    <!-- Include the Sidebar and Header Components -->
    @include('layouts.sidebar')
    @include('layouts.navbar') 


    <!-- Main Content Container - Responsive margin -->
    <div class="transition-all duration-300 content-container md:ml-60 p-4 md:p-6">
        <!-- Header Section - Responsive layout -->
        <div class="mb-4 p-3 md:p-4 shadow-md bg-white rounded-lg">
            <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                <h2 class="text-2xl md:text-3xl font-mono">Kelola Barang</h2>
                <div class="flex flex-wrap gap-2 md:space-x-5">
                    <a href="{{ route('dashboard.products.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg text-sm md:text-base flex items-center justify-center">
                        <i class="bx bx-plus mr-1"></i> Tambah Barang
                    </a>
                    <button onclick="printTable()" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm md:text-base flex items-center justify-center">
                        <i class="bx bx-printer mr-1"></i> Cetak PDF
                    </button>
                </div>
            </div>
        </div>

        <!-- Notifikasi Stok Menipis - Responsive padding -->
        @if($lowStockProducts->isNotEmpty())
            <div class="mb-4 p-3 md:p-4 bg-yellow-100 text-yellow-800 rounded-lg">
                <h3 class="text-lg font-semibold">Peringatan Stok Menipis</h3>
                <ul class="list-disc list-inside">
                    @foreach($lowStockProducts as $product)
                        <li>{{ $product->name }} - Stok: {{ $product->stock }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Table Section -->
        <div class="bg-white p-3 md:p-6 rounded shadow">
            <div class="mb-4">
                <h2 class="text-xl md:text-2xl font-mono">Data Barang</h2>
            </div>
            <div class="table-responsive">
                <table id="produkTable" class="w-full border-collapse border bg-gradient-to-b from-[#D5A4CF] to-[#B689B0] display responsive nowrap" style="width:100%">
                    <thead>
                        <tr class="bg-green-100">
                            <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Nama Produk</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Kategori</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Harga</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Stok</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Ukuran</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Gambar</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Deskripsi</th>
                            <th class="border border-gray-300 px-4 py-2 text-center no-print">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $product->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $product->category }}</td>
                            <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $product->stock }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $product->size }}</td>
                            <td class="border border-gray-300 px-2 py-1">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar {{ $product->name }}" class="w-12 h-12 md:w-16 md:h-16 object-cover">
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ Str::limit($product->description, 50) }}</td>
                            <td class="border border-gray-300 px-2 py-2 text-center no-print">
                                <div class="flex flex-col md:flex-row items-center justify-center gap-2">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('dashboard.products.edit', $product) }}" 
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 md:px-3 md:py-2 rounded-md text-xs md:text-sm flex items-center w-full md:w-auto justify-center">
                                        <i class="bx bxs-edit mr-1"></i> Edit
                                    </a>
                            
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('dashboard.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');" class="w-full md:w-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 md:px-3 md:py-2 rounded-md text-xs md:text-sm flex items-center w-full justify-center">
                                            <i class="bx bxs-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Hidden table for printing only -->
        <div id="printArea" class="hidden">
            <h1 class="text-center text-2xl font-bold mb-4">Data Barang</h1>
            <table class="w-full border-collapse border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Nama Produk</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Kategori</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Harga</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Stok</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Ukuran</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Gambar</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $index => $product)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $product->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $product->category }}</td>
                        <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $product->stock }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $product->size }}</td>
                        <td class="border border-gray-300 px-2 py-1">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar {{ $product->name }}" class="w-16 h-16 object-cover">
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ Str::limit($product->description, 50) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Initialize DataTable with responsive features
        $(document).ready(function () {
            $('#produkTable').DataTable({
                responsive: true,
                pageLength: 5,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                    paginate: {
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
            
            // Store products in local storage
            localStorage.setItem('products', @json($products));
            
            // Toggle sidebar on mobile
            $('#sidebarToggle').click(function() {
                $('.sidebar-container').toggleClass('open');
            });
        });
        
        // Completely separate print function that uses a hidden clean table
        function printTable() {
            // Open a new window for printing
            let printWindow = window.open('', '_blank', 'height=600,width=800');
            
            // Get the clean print table HTML
            let printContent = document.getElementById('printArea').innerHTML;
            
            // Write clean HTML to new window
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Data Barang</title>
                    <style>
                        body { 
                            font-family: Arial, sans-serif;
                            padding: 20px;
                        }
                        h1 {
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid #ddd;
                            padding: 8px;
                            text-align: left;
                        }
                        th {
                            background-color: #f2f2f2;
                        }
                        img {
                            width: 50px;
                            height: 50px;
                            object-fit: cover;
                        }
                        @media print {
                            @page {
                                margin: 0.5cm;
                            }
                        }
                    </style>
                </head>
                <body>
                    ${printContent}
                </body>
                </html>
            `);
            
            // Finalize and print
            printWindow.document.close();
            printWindow.focus();
            
            // Wait a moment for images to load, then print
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 500);
        }
    </script>
</body>
</html>