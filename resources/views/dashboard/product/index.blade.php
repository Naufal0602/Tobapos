<?php
  use App\Models\printers;
  
  // Mendapatkan data printer langsung di view
  $printers = printers::all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
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
                <h2 class="text-2xl md:text-3xl font-extrabold">Kelola Barang</h2>
                <div class="flex flex-wrap gap-2 md:space-x-5">
                    <a href="{{ route('dashboard.products.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg text-sm md:text-base flex items-center justify-center">
                        <i class="bx bx-plus mr-1"></i> Tambah Barang
                    </a>
                    <button type="button" onclick="printTable()" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm md:text-base flex items-center justify-center">
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
        <div class="bg-white p-3 md:p-6 rounded shadow mb-6">
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
                                    <form action="{{ route('dashboard.products.destroy', $product) }}" method="POST" class="w-full md:w-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                            onclick="confirmDelete(this.form, '{{ $product->name }}')"
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

        <!-- Printer Management Section - Flexbox Layout -->
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Pilih Printer Section -->
            <div class="bg-gray-100 rounded-2xl p-5 shadow-sm flex-1">
                <!-- Header -->
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-gray-700 font-medium text-lg">Pilih Printer</h3>
                    <a href="#" class="text-green-500 text-sm font-medium">Lihat bantuan</a>
                </div>
                
                <!-- Form content -->
                <form method="POST" action="{{ route('dashboard.products.setPrinter') }}">
                    @csrf
                    <div class="mb-5">
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                            </svg>
                            <span>Daftar printer yang tersedia</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="w-full">
                                <select name="printer_name" id="printer_name" class="w-full bg-white border border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Pilih printer</option>
                                    @foreach($printers as $printer)
                                        <option value="{{ $printer->nama_printer }}">{{ $printer->nama_printer }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg w-full transition duration-200" onclick="setPrinter(event, this.form)">
                        Simpan
                    </button>
                </form>
            </div>

            <!-- Kelola Printer Section -->
            <div class="bg-gray-100 rounded-2xl p-5 shadow-sm flex-1">
                <!-- Tambah Printer Baru -->
                <div class="mb-6">
                    <h4 class="text-gray-700 font-medium mb-3">Tambah Printer Baru</h4>
                    <form method="POST" action="{{ route('dashboard.printers.store') }}" class="flex gap-2">
                        @csrf
                        <input type="text" name="nama_printer" placeholder="Nama printer baru" 
                            class="flex-1 bg-white border border-gray-200 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 rounded-lg transition duration-200" onclick="addPrinter(event, this.form)">
                            Tambah
                        </button>
                    </form>
                </div>

                <!-- Daftar Printer -->
                <div class="border-t pt-4">
                    <h4 class="text-gray-700 font-medium mb-3">Kelola Printer</h4>
                    <div class="space-y-2">
                        @foreach($printers as $printer)
                            <div class="flex justify-between items-center bg-white p-3 rounded-lg border border-gray-200">
                                <span>{{ $printer->nama_printer }}</span>
                                <form method="POST" action="{{ route('dashboard.printers.destroy', $printer->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDeletePrinter(this.form, '{{ $printer->nama_printer }}')" class="text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
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

            // Check for flash messages from the server
            @if(session('success'))
                showSuccessAlert("{{ session('success') }}");
            @endif

            @if(session('error'))
                showErrorAlert("{{ session('error') }}");
            @endif
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

        // Sweet Alert helper functions
        function showSuccessAlert(message) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: message,
                timer: 3000,
                timerProgressBar: true
            });
        }

        function showErrorAlert(message) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: message
            });
        }

        // Confirm delete product with SweetAlert - FIXED VERSION
        function confirmDelete(form, productName) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus produk "${productName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Important: Submit the form directly
                    form.submit();
                }
            });
        }

        // Confirm delete printer with SweetAlert - FIXED VERSION
        function confirmDeletePrinter(form, printerName) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus printer "${printerName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Important: Submit the specific form directly
                    form.submit();
                }
            });
        }

        // Add printer with SweetAlert - FIXED VERSION
        function addPrinter(event, form) {
            event.preventDefault();
            const formData = new FormData(form);
            const printerName = formData.get('nama_printer');

            if (!printerName) {
                showErrorAlert('Nama printer tidak boleh kosong!');
                return;
            }

            // Regular form submission with SweetAlert on success
            Swal.fire({
                title: 'Menambahkan Printer...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                    
                    // Submit form through AJAX
                    $.ajax({
                        url: form.action,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: `Printer "${printerName}" berhasil ditambahkan`,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            let errorMessage = 'Terjadi kesalahan saat menambahkan printer';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            showErrorAlert(errorMessage);
                        }
                    });
                }
            });
        }

        // Set printer with SweetAlert - FIXED VERSION
        function setPrinter(event, form) {
            event.preventDefault();
            const formData = new FormData(form);
            const printerName = formData.get('printer_name');

            if (!printerName) {
                showErrorAlert('Silakan pilih printer terlebih dahulu');
                return;
            }

            // Regular form submission with SweetAlert on success
            Swal.fire({
                title: 'Menyimpan...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                    
                    // Submit form through AJAX
                    $.ajax({
                        url: form.action,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: `Printer "${printerName}" berhasil dipilih`,
                                timer: 1500
                            });
                        },
                        error: function(xhr) {
                            let errorMessage = 'Terjadi kesalahan saat memilih printer';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            showErrorAlert(errorMessage);
                        }
                    });
                }
            });
        }

        // Load printers from API
        document.addEventListener('DOMContentLoaded', function () {
            fetch('{{ route('dashboard.products.printers') }}')
                .then(response => response.json())
                .then(printers => {
                    console.log('Daftar printer:', printers); // Debug daftar printer
                    const printerSelect = document.getElementById('printer_name');
                    printerSelect.innerHTML = '<option value="">Pilih printer</option>'; // Reset dropdown

                    printers.forEach(printer => {
                        const option = document.createElement('option');
                        option.value = printer;
                        option.textContent = printer;
                        printerSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Gagal memuat daftar printer:', error);
                });
        });
    </script>
</body>
</html>