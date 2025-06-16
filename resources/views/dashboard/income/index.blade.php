<?php

use App\Models\TransactionItem;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pemasukan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
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
<body class="font-inter" style="background:#F9FAFB;"> 

    @include('layouts.sidebar')
    @include('layouts.navbar')

    <div class="ml-0 sm:ml-60 p-3 md:p-6">
        <div class="bg-white p-3 md:p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl md:text-4xl font-bold mb-4">Pemasukan</h2>
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
                <button onclick="filterData()" class="bg-[#34495E] text-white px-4 py-2 rounded-lg">Filter</button>
                <button onclick="printTable()" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Print</button>
                <!-- Tombol Export CSV -->
               <button onclick="exportToCSV()" 
                    class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center justify-center mx-auto w-full sm:w-auto">
                    <i class="bx bx-download mr-2"></i>Export CSV
                </button>
            </div>

            <div class="overflow-x-auto" id="printArea">
                <div id="printHeader" class="mb-4 hidden">
                    <h3 class="text-xl font-bold text-center">Laporan Pemasukan</h3>
                    <p class="text-center mb-4" id="printPeriod"></p>
                </div>
                
                <table class="w-full border-collapse border border-gray-300" id="transactions-table">
                    <thead class="bg-[#34495E] text-white">
                        <tr>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">ID Transaksi</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Total</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Metode Pembayaran</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Tanggal</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $index => $transaction)
                            <tr class="expense-row" data-date="{{ $transaction->created_at->format('Y-m') }}" data-day="{{ $transaction->created_at->format('l') }}">
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $index + 1 }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base" data-sort="{{ $transaction->total }}">Rp {{ number_format($transaction->total, 2) }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $transaction->payment_method }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base" data-sort="{{ $transaction->created_at->format('Ymd') }}">{{ $transaction->created_at->format('d-m-Y') }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base no-print">
                                    <a href="{{ route('dashboard.transactions.show', $transaction->id) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs flex items-center justify-center w-8 h-8"
                                       title="Lihat Detail">
                                        <i class="bx bx-show text-sm"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="mt-4">
                    <h3 class="text-xl md:text-2xl font-bold">Total Pemasukan: <span class="total-income">Rp {{ number_format($totalIncome, 2) }}</span></h3>
                </div>
            </div>
        </div>
    </div>

    <script>
        let dataTable;
        let originalData = [];
        let currentFilterMonth = '';
        let currentFilterDay = '';
        
       // Bagian inisialisasi DataTables - ganti kode yang ada dengan ini
document.addEventListener("DOMContentLoaded", function() {
    // Store original data for filtering
    document.querySelectorAll('.expense-row').forEach(row => {
        originalData.push({
            element: row,
            date: row.getAttribute('data-date'),
            day: row.getAttribute('data-day'),
            total: parseFloat(row.querySelector('td:nth-child(2)').getAttribute('data-sort'))
        });
    });
    
    // Initialize DataTables with 10 items per page
    dataTable = $('#transactions-table').DataTable({
        language: {
            search: "Pencarian:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada pemasukan",
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
        // TAMBAHKAN BARIS INI UNTUK SORTING DEFAULT
        order: [[3, 'desc']], // Kolom tanggal (index 3) diurutkan descending (terbaru dulu)
        "columnDefs": [
            { "type": "num", "targets": 0 },
            { "type": "num", "targets": 1 },
            { "type": "string", "targets": 2 },
            { "type": "date", "targets": 3 },
            { "orderable": false, "targets": 4 }
        ],
        "drawCallback": function() {
            updateTotalIncome();
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
    let tableBody = document.querySelector("#transactions-table tbody");
    
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
        return showRow;
    });
    
    // Add filtered rows back to the table
    filteredData.forEach(item => {
        tableBody.appendChild(item.element.cloneNode(true));
    });
    
    // Reinitialize DataTables with pagination
    dataTable = $('#transactions-table').DataTable({
        language: {
            search: "Pencarian:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada pemasukan",
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
        // TAMBAHKAN BARIS INI JUGA DI SINI
        order: [[3, 'desc']], // Kolom tanggal (index 3) diurutkan descending (terbaru dulu)
        "columnDefs": [
            { "type": "num", "targets": 0 },
            { "type": "num", "targets": 1 },
            { "type": "string", "targets": 2 },
            { "type": "date", "targets": 3 },
            { "orderable": false, "targets": 4 }
        ],
        "drawCallback": function() {
            updateTotalIncome();
        }
    });
    
    updateTotalIncome();
}
        
        function updateTotalIncome() {
            let totalIncome = 0;
            
            // Untuk perhitungan total, gunakan semua row yang sesuai filter saat ini
            // bukan hanya yang ditampilkan di halaman saat ini
            let filteredRows = originalData.filter(item => {
                let include = true;
                if (currentFilterMonth && item.date !== currentFilterMonth) {
                    include = false;
                }
                if (currentFilterDay && item.day !== currentFilterDay) {
                    include = false;
                }
                return include;
            });
            
            // Hitung total dari semua data yang terfilter
            filteredRows.forEach(item => {
                totalIncome += item.total;
            });
            
            document.querySelector(".total-income").textContent = `Rp ${totalIncome.toLocaleString('id-ID', { minimumFractionDigits: 2 })}`;
        }

        function printTable() {
            // Sebelum print, enable semua data yang terfilter untuk ditampilkan
            dataTable.page.len(-1).draw(); // Tampilkan semua data
            
            // Set judul periode untuk print
            let periodeText = '';
            let bulanFilter = document.getElementById("filterBulan").value;
            let hariFilter = document.getElementById("filterHari").value;
            
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
                dataTable.page.len(10).draw(); // Kembali ke 10 data per halaman
            }, 500);
        }

        // Fungsi Export ke CSV
        function exportToCSV() {
            // Ambil data yang sudah difilter
            let filteredRows = originalData.filter(item => {
                let include = true;
                if (currentFilterMonth && item.date !== currentFilterMonth) {
                    include = false;
                }
                if (currentFilterDay && item.day !== currentFilterDay) {
                    include = false;
                }
                return include;
            });

            if (filteredRows.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak Ada Data',
                    text: 'Tidak ada data untuk diekspor!'
                });
                return;
            }

            // Buat header CSV
            let csvContent = "ID Transaksi,Total,Metode Pembayaran,Tanggal\n";
            
            // Tambahkan data ke CSV
            filteredRows.forEach((item, index) => {
                const cells = item.element.querySelectorAll('td');
                const idTransaksi = index + 1;
                const total = item.total;
                const metodePembayaran = cells[2].textContent.trim();
                const tanggal = cells[3].textContent.trim();
                
                // Format data untuk CSV (handle comma dalam data)
                csvContent += `"${idTransaksi}","${total}","${metodePembayaran}","${tanggal}"\n`;
            });

            // Tambahkan total pemasukan di akhir
            const totalIncome = filteredRows.reduce((sum, item) => sum + item.total, 0);
            csvContent += `\nTotal Pemasukan,"${totalIncome}",,\n`;

            // Buat nama file dengan periode
            let fileName = 'laporan_pemasukan';
            if (currentFilterMonth) {
                const [year, month] = currentFilterMonth.split('-');
                fileName += `_${month}-${year}`;
            }
            if (currentFilterDay) {
                const dayNames = {
                    "Monday": "senin",
                    "Tuesday": "selasa", 
                    "Wednesday": "rabu",
                    "Thursday": "kamis",
                    "Friday": "jumat",
                    "Saturday": "sabtu",
                    "Sunday": "minggu"
                };
                fileName += `_${dayNames[currentFilterDay]}`;
            }
            fileName += '.csv';

            // Download file CSV
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            
            if (link.download !== undefined) {
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', fileName);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                // Tampilkan notifikasi sukses
                Swal.fire({
                    icon: 'success',
                    title: 'Export Berhasil!',
                    text: `File ${fileName} telah didownload`,
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        }
    </script>
</body>
</html>