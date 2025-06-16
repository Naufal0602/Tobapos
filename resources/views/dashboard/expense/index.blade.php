<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengeluaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
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
            .no-print, .no-print * {
                display: none !important;
            }
            /* Menampilkan semua data saat print */
            .dataTables_wrapper .dataTables_info, 
            .dataTables_wrapper .dataTables_paginate,
            .dataTables_wrapper .dataTables_length, 
            .dataTables_wrapper .dataTables_filter {
                display: none !important;
            }
            /* Pastikan semua baris ditampilkan saat print */
            .dataTable tbody tr {
                display: table-row !important;
            }
        }
        
        /* DataTables Styling */
        .dataTables_wrapper .dataTables_length, 
        .dataTables_wrapper .dataTables_filter, 
        .dataTables_wrapper .dataTables_info, 
        .dataTables_wrapper .dataTables_processing, 
        .dataTables_wrapper .dataTables_paginate {
            margin-bottom: 10px;
            color: #555;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #D5A4CF !important;
            border-color: #B689B0 !important;
            color: white !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #B689B0 !important;
            border-color: #D5A4CF !important;
            color: white !important;
        }
        
        table.dataTable thead th {
            position: relative;
            background-image: none !important;
        }
        
        table.dataTable thead th.sorting:after,
        table.dataTable thead th.sorting_asc:after,
        table.dataTable thead th.sorting_desc:after {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            display: block;
            font-family: "Boxicons";
        }
        
        table.dataTable thead th.sorting:after {
            content: "\e9d5";
            opacity: 0.5;
            font-size: 0.8em;
        }
        
        table.dataTable thead th.sorting_asc:after {
            content: "\e9d8";
        }
        
        table.dataTable thead th.sorting_desc:after {
            content: "\e9db";
        }

    </style>
</head>
<body class="font-inter" style="background:#F9FAFB;" x-data="expenseApp()">
    @include('layouts.sidebar')
    @include('layouts.navbar')
    
    <div class="ml-0 sm:ml-60 p-3 md:p-6">
        <div class="bg-white p-3 md:p-6 rounded-lg shadow-md">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <h2 class="text-2xl md:text-4xl font-bold">Pengeluaran</h2>
               <div id="button_create" class="mt-4 md:mt-0 flex flex-col sm:flex-row sm:space-x-2 space-y-2">
                    <a href="{{ route('dashboard.expenses.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg text-center">
                        <i class='bx bx-plus'></i> Buat Pengeluaran
                    </a>
                    <button onclick="printTable()" class="bg-blue-500 text-white px-4 py-2 rounded-lg no-print text-center">
                        <i class='bx bx-printer'></i> Print
                    </button>
                </div>
            </div>

            <div class="mb-4 flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4 no-print">
                <select id="filterHari" class="px-4 py-2 border rounded-lg shadow-md">
                    <option value="">Semua Hari</option>
                    <option value="Monday">Senin</option>
                    <option value="Tuesday">Selasa</option>
                    <option value="Wednesday">Rabu</option>
                    <option value="Thursday">Kamis</option>
                    <option value="Friday">Jumat</option>
                    <option value="Saturday">Sabtu</option>
                    <option value="Sunday">Minggu</option>
                </select>
                <input type="month" id="filterBulan" class="px-4 py-2 border rounded-lg shadow-md">
                <select id="filterKategori" class="px-4 py-2 border rounded-lg shadow-md">
                    <option value="">Semua Kategori</option>
                    <option value="Pribadi">Pribadi</option>
                    <option value="Toko">Toko</option>
                </select>
                <button onclick="filterData()" class="bg-[#34495E] text-white px-4 py-2 rounded-lg">Filter</button>
            </div>

            <div class="overflow-x-auto" id="printArea">
                <div id="printHeader" class="mb-4 hidden">
                    <h3 class="text-xl font-bold text-center">Laporan Pengeluaran</h3>
                    <p class="text-center mb-4" id="printPeriod"></p>
                </div>
                
                <table class="w-full border-collapse border border-gray-300" id="expenses-table">
                    <thead class="bg-[#34495E] text-white">
                        <tr>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Id</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Nama</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Kategori</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Pengeluaran</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Tanggal</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Bukti</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($expenses as $index => $expense)
                            <tr class="expense-row" data-date="{{ $expense->created_at->format('Y-m') }}" 
                                data-day="{{ $expense->created_at->format('l') }}" 
                                data-category="{{ $expense->category }}"
                                data-amount="{{ $expense->amount }}">
                                 <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $index + 1 }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $expense->name }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $expense->category }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base" data-sort="{{ $expense->amount }}">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base" data-sort="{{ $expense->created_at->format('Ymd') }}">{{ $expense->created_at->format('d-m-Y') }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base text-center">
                                    @if ($expense->receipt_image)
                                        <img src="{{ asset('storage/' . $expense->receipt_image) }}" 
                                             class="w-12 h-12 md:w-16 md:h-16 object-cover rounded-lg mx-auto cursor-pointer"
                                             @click="openModal('{{ asset('storage/' . $expense->receipt_image) }}', '{{ $expense->name }}', '{{ $expense->category }}', '{{ number_format($expense->amount, 0, ',', '.') }}', '{{ $expense->created_at->format('d-m-Y') }}')">
                                    @else
                                        -
                                    @endif
                                </td>
                               <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base text-center no-print">
                                    <a href="{{ route('dashboard.expenses.edit', $expense->id) }}" 
                                    class="bg-yellow-500 text-white px-3 py-1 md:px-4 md:py-2 rounded-lg inline-block">
                                        <i class='bx bx-edit'></i> Edit
                                    </a>
                                    <button onclick="confirmDelete('{{ route('dashboard.expenses.destroy', $expense->id) }}')" 
                                            class="bg-red-500 text-white px-3 py-1 md:px-4 md:py-2 rounded-lg mt-1 md:mt-0 md:ml-2">
                                        <i class='bx bx-trash'></i> Hapus
                                    </button>
                                    <form id="delete-form-{{ $expense->id }}" action="{{ route('dashboard.expenses.destroy', $expense->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border px-4 py-2 text-center">Tidak ada pengeluaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="mt-4">
                    <h3 class="text-xl md:text-2xl font-bold">Total Pengeluaran: <span class="total-expense">Rp 0</span></h3>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal gambar yang ditingkatkan dengan informasi lengkap -->
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
         @click.self="closeModal()">
        <div class="bg-white p-6 rounded-lg shadow-lg relative max-w-2xl w-full mx-4">
            <button @click="closeModal()" class="absolute top-3 right-3 text-2xl font-bold hover:text-gray-600">&times;</button>
            <div class="flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-1/2">
                    <img :src="modalImage" class="max-w-full h-auto rounded-lg mx-auto" alt="Receipt Image">
                </div>
                <div class="w-full md:w-1/2 mt-4 md:mt-0">
                    <h3 class="text-xl font-bold mb-4">Detail Pengeluaran</h3>
                    <table class="w-full border-collapse">
                        <tr>
                            <td class="py-2 font-semibold">Nama:</td>
                            <td class="py-2" x-text="modalExpense.name"></td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Kategori:</td>
                            <td class="py-2" x-text="modalExpense.category"></td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Jumlah:</td>
                            <td class="py-2">Rp <span x-text="modalExpense.amount"></span></td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Tanggal:</td>
                            <td class="py-2" x-text="modalExpense.date"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Alpine.js component
        function expenseApp() {
            return {
                showModal: false,
                modalImage: '',
                modalExpense: {
                    name: '',
                    category: '',
                    amount: '',
                    date: ''
                },
                
                openModal(imageSrc, name, category, amount, date) {
                    this.modalImage = imageSrc;
                    this.modalExpense = {
                        name: name,
                        category: category,
                        amount: amount,
                        date: date
                    };
                    this.showModal = true;
                },
                
                closeModal() {
                    this.showModal = false;
                    // Reset data setelah modal ditutup
                    setTimeout(() => {
                        this.modalImage = '';
                        this.modalExpense = {
                            name: '',
                            category: '',
                            amount: '',
                            date: ''
                        };
                    }, 300);
                }
            }
        }

        let dataTable;
        let originalData = [];
        let currentFilterMonth = '';
        let currentFilterDay = '';
        let currentFilterCategory = '';
        
        document.addEventListener("DOMContentLoaded", function() {
            // Store original data for filtering
            document.querySelectorAll('.expense-row').forEach(row => {
                originalData.push({
                    element: row,
                    date: row.getAttribute('data-date'),
                    day: row.getAttribute('data-day'),
                    category: row.getAttribute('data-category'),
                    amount: parseFloat(row.getAttribute('data-amount'))
                });
            });
            
            // Initialize DataTables with 10 items per page
            dataTable = $('#expenses-table').DataTable({
                language: {
                    search: "Pencarian:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Tidak ada pengeluaran",
                    info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                    infoEmpty: "Tidak ada data tersedia",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                },
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                responsive: true,
                "columnDefs": [
                    { "type": "string", "targets": 0 },
                    { "type": "string", "targets": 1 },
                    { "type": "num", "targets": 2 },
                    { "type": "date", "targets": 3 },
                    { "orderable": false, "targets": [4, 5] }
                ],
                "drawCallback": function() {
                    updateTotalExpense();
                }
            });
            
            // Set default filter to current month
            const today = new Date();
            const currentMonth = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0');
            document.getElementById("filterBulan").value = currentMonth;
            filterData();
        });
        
        function filterData() {
            dataTable.destroy();
            
            currentFilterDay = document.getElementById("filterHari").value;
            currentFilterMonth = document.getElementById("filterBulan").value;
            currentFilterCategory = document.getElementById("filterKategori").value;
            let tableBody = document.querySelector("#expenses-table tbody");
            
            // Clear the table
            tableBody.innerHTML = '';
            
            // Filter and rebuild the table with filtered data
            let filteredData = originalData.filter(item => {
                let showRow = true;
                if (currentFilterMonth && item.date !== currentFilterMonth) {
                    showRow = false;
                }
                if (currentFilterDay && item.day !== currentFilterDay) {
                    showRow = false;
                }
                if (currentFilterCategory && item.category !== currentFilterCategory) {
                    showRow = false;
                }
                return showRow;
            });
            
            // Add filtered rows back to the table
            filteredData.forEach(item => {
                tableBody.appendChild(item.element.cloneNode(true));
            });
            
            // If no data, show message
            if (filteredData.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="6" class="border px-4 py-2 text-center">Tidak ada pengeluaran.</td></tr>';
            }
            
            // Reinitialize DataTables with pagination
            dataTable = $('#expenses-table').DataTable({
                language: {
                    search: "Pencarian:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Tidak ada pengeluaran",
                    info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                    infoEmpty: "Tidak ada data tersedia",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                },
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                responsive: true,
                "columnDefs": [
                    { "type": "string", "targets": 0 },
                    { "type": "string", "targets": 1 },
                    { "type": "num", "targets": 2 },
                    { "type": "date", "targets": 3 },
                    { "orderable": false, "targets": [4, 5] }
                ],
                "drawCallback": function() {
                    updateTotalExpense();
                }
            });
            
            updateTotalExpense();
        }
        
        function updateTotalExpense() {
            let totalExpense = 0;
            
            // Untuk perhitungan total, gunakan semua row yang sesuai filter saat ini
            let filteredRows = originalData.filter(item => {
                let include = true;
                if (currentFilterMonth && item.date !== currentFilterMonth) {
                    include = false;
                }
                if (currentFilterDay && item.day !== currentFilterDay) {
                    include = false;
                }
                if (currentFilterCategory && item.category !== currentFilterCategory) {
                    include = false;
                }
                return include;
            });
            
            // Hitung total dari semua data yang terfilter
            filteredRows.forEach(item => {
                totalExpense += item.amount;
            });
            
            document.querySelector(".total-expense").textContent = `Rp ${totalExpense.toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`;
        }

        function printTable() {
            // Sebelum print, enable semua data yang terfilter untuk ditampilkan
            dataTable.page.len(-1).draw();
            
            // Set judul periode untuk print
            let periodeText = '';
            let bulanFilter = document.getElementById("filterBulan").value;
            let hariFilter = document.getElementById("filterHari").value;
            let kategoriFilter = document.getElementById("filterKategori").value;
            
            if (bulanFilter) {
                const [year, month] = bulanFilter.split('-');
                const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                periodeText = `Bulan ${monthNames[parseInt(month)-1]} ${year}`;
            }
            
            if (hariFilter) {
                const dayNames = {
                    "Monday": "Senin",
                    "Tuesday": "Selasa",
                    "Wednesday": "Rabu",
                    "Thursday": "Kamis",
                    "Friday": "Jumat",
                    "Saturday": "Sabtu",
                    "Sunday": "Minggu"
                };
                periodeText += periodeText ? `, Hari ${dayNames[hariFilter]}` : `Hari ${dayNames[hariFilter]}`;
            }
            
            if (kategoriFilter) {
                periodeText += periodeText ? `, Kategori ${kategoriFilter}` : `Kategori ${kategoriFilter}`;
            }
            
            if (!periodeText) {
                periodeText = "Semua Periode";
            }
            
            document.getElementById("printPeriod").textContent = periodeText;
            document.getElementById("printHeader").classList.remove("hidden");
            
            // Print halaman
            setTimeout(() => {
                window.print();
                
                // Setelah print, kembalikan ke tampilan dengan paginasi
                document.getElementById("printHeader").classList.add("hidden");
                dataTable.page.len(10).draw();
            }, 500);
        }

        // Fungsi konfirmasi hapus dengan SweetAlert
        function confirmDelete(deleteUrl) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const id = deleteUrl.split('/').pop();
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
    </script>
</body>
</html>