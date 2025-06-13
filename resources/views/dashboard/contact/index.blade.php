<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kontak</title>
    
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    
    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Print Styles */
        @media print {
            body * {
                visibility: hidden;
            }
            
            #printArea,
            #printArea * {
                visibility: visible;
            }
            
            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            
            .no-print,
            .no-print * {
                display: none !important;
            }
            
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate,
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                display: none !important;
            }
            
            .dataTable tbody tr {
                display: table-row !important;
            }
        }

        /* DataTables Custom Styling */
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

        /* DataTables Sorting Icons */
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

        /* Filter Button Styling */
        .filter-btn {
            transition: all 0.3s ease;
        }

        .filter-btn.active {
            background: #B689B0 !important;
            color: white !important;
            transform: scale(1.05);
        }

        .filter-btn:hover {
            background: #D5A4CF !important;
            color: white !important;
        }

        @media (max-width: 320px) {
            .action-buttons {
               justify-content: center;
            }
        }
    </style>
</head>

<body style="background:#F5E6F0;">

    @include('layouts.sidebar')
    @include('layouts.navbar')

    <div class="ml-0 sm:ml-60 p-3 md:p-6">
        <div class="bg-white p-3 md:p-6 rounded-lg shadow-md">
            
            <!-- Header -->
            <h2 class="text-2xl md:text-4xl font-bold mb-4">Kontak</h2>

            <!-- Filter Section -->
            <div class="mb-4 no-print">
                
                <!-- Quick Filter Buttons -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <button onclick="setQuickFilter('today')" id="btn-today" 
                            class="filter-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
                        Hari Ini
                    </button>
                    <button onclick="setQuickFilter('month')" id="btn-month" 
                            class="filter-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
                        Bulan Ini
                    </button>
                    <button onclick="setQuickFilter('all')" id="btn-all" 
                            class="filter-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-lg active">
                        Semua Data
                    </button>
                </div>

                <!-- Advanced Filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                    <input type="date" id="filterTanggal" 
                           class="px-4 py-2 border rounded-lg shadow-md" 
                           placeholder="Pilih Tanggal">
                    
                    <input type="text" id="searchName" 
                           placeholder="Cari nama..." 
                           class="px-4 py-2 border rounded-lg shadow-md">
                    
                    <input type="text" id="searchEmail" 
                           placeholder="Cari email..." 
                           class="px-4 py-2 border rounded-lg shadow-md">
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap justify-evenly gap-2 md:justify-start">
                    <button onclick="applyFilters()" 
                            class="bg-gray-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg">
                        <i class='bx bx-filter'></i> Filter
                    </button>
                    <button onclick="resetFilters()" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                        <i class='bx bx-refresh'></i> Reset
                    </button>
                    <button onclick="printTable()" 
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                        <i class='bx bx-printer'></i> Print
                    </button>
                    <button onclick="exportData()" 
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                        <i class='bx bx-download'></i> Export
                    </button>
                </div>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto" id="printArea">
                
                <!-- Print Header (Hidden by default) -->
                <div id="printHeader" class="mb-4 hidden">
                    <h3 class="text-xl font-bold text-center">Laporan Data Kontak</h3>
                    <p class="text-center mb-4" id="printPeriod"></p>
                </div>

                <!-- Contact Table -->
                <table class="w-full border-collapse border border-gray-300" id="contacts-table">
                    <thead class="bg-[#34495E] text-white">
                        <tr>
                            <th class="border px-2 py-1 md:px-3 md:py-2 text-xs md:text-sm">No</th>
                            <th class="border px-2 py-1 md:px-3 md:py-2 text-xs md:text-sm">Nama</th>
                            <th class="border px-2 py-1 md:px-3 md:py-2 text-xs md:text-sm">Email</th>
                            <th class="border px-2 py-1 md:px-3 md:py-2 text-xs md:text-sm">Pesan</th>
                            <th class="border px-2 py-1 md:px-3 md:py-2 text-xs md:text-sm">Tanggal</th>
                            <th class="border px-2 py-1 md:px-3 md:py-2 text-xs md:text-sm no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $index => $contact)
                        <tr class="contact-row"
                            data-date="{{ $contact->created_at->format('Y-m-d') }}"
                            data-month="{{ $contact->created_at->format('Y-m') }}"
                            data-year="{{ $contact->created_at->format('Y') }}"
                            data-day="{{ $contact->created_at->format('l') }}"
                            data-name="{{ strtolower($contact->name) }}"
                            data-email="{{ strtolower($contact->email) }}">
                            
                            <td class="border px-2 py-1 md:px-3 md:py-2 text-xs md:text-sm">
                                {{ $index + 1 }}
                            </td>
                            
                            <td class="border px-2 py-1 md:px-3 md:py-2 text-xs md:text-sm">
                                {{ $contact->name }}
                            </td>
                            
                            <td class="border px-2 py-1 md:px-3 md:py-2 text-xs md:text-sm">
                                {{ $contact->email }}
                            </td>
                            
                            <td class="border px-2 py-1 md:px-3 md:py-2 text-xs md:text-sm">
                                <div class="max-w-xs">
                                    <span class="message-short">{{ Str::limit($contact->message, 30) }}</span>
                                    @if(strlen($contact->message) > 30)
                                    <button class="text-blue-500 hover:underline text-xs ml-1"
                                            onclick="showFullMessage('{{ addslashes($contact->message) }}')">
                                        Selengkapnya
                                    </button>
                                    @endif
                                </div>
                            </td>
                            
                            <td class="border px-2 py-1 md:px-3 md:py-2 text-xs md:text-sm"
                                data-sort="{{ $contact->created_at->format('Ymd') }}">
                                {{ $contact->created_at->format('d-m-Y H:i') }}
                            </td>
                            
                            <td class="border px-2 py-1 md:px-3 md:py-2 text-xs md:text-sm no-print">
                                <div class="flex justify-center space-x-1">
                                    <!-- View Message Button -->
                                    <button onclick="showFullMessage('{{ addslashes($contact->message) }}')"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded-lg text-xs"
                                            title="Lihat Pesan Lengkap">
                                        <i class='bx bx-show'></i>
                                    </button>
                                    
                                    <!-- Reply Button -->
                                    <button onclick="replyToContact('{{ $contact->email }}', '{{ addslashes($contact->name) }}')"
                                            class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded-lg text-xs"
                                            title="Balas Email">
                                        <i class='bx bx-reply'></i>
                                    </button>
                                    
                                    <!-- Delete Button -->
                                    <form action="{{ route('dashboard.contact.destroy', $contact->id) }}" 
                                          method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-lg text-xs"
                                                title="Hapus">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Statistics Cards -->
                <div class="mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-black">Total Kontak</h4>
                            <p class="text-2xl font-bold text-black" id="totalContacts">{{ count($contacts) }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-black">Kontak Hari Ini</h4>
                            <p class="text-2xl font-bold text-black" id="todayContacts">0</p>
                        </div>
                        <div class="bg-purple-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-black">Kontak Bulan Ini</h4>
                            <p class="text-2xl font-bold text-black" id="monthContacts">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global Variables
        let dataTable;
        let originalData = [];
        let currentFilters = {
            date: '',
            name: '',
            email: '',
            quick: 'all'
        };

        // Initialize on page load
        document.addEventListener("DOMContentLoaded", function() {
            initializeData();
            initializeDataTable();
            updateStatistics();
            setupEventListeners();
        });

        // Setup event listeners
        function setupEventListeners() {
            $('#searchName').on('keyup', function() {
                dataTable.columns(1).search(this.value).draw();
            });

            $('#searchEmail').on('keyup', function() {
                dataTable.columns(2).search(this.value).draw();
            });

            attachDeleteListeners();
        }

        // Initialize original data for filtering
        function initializeData() {
            document.querySelectorAll('.contact-row').forEach((row, index) => {
                originalData.push({
                    element: row,
                    date: row.getAttribute('data-date'),
                    month: row.getAttribute('data-month'),
                    year: row.getAttribute('data-year'),
                    day: row.getAttribute('data-day'),
                    name: row.getAttribute('data-name'),
                    email: row.getAttribute('data-email'),
                    index: index + 1
                });
            });
        }

        // Initialize DataTable
        function initializeDataTable() {
            dataTable = $('#contacts-table').DataTable({
                language: {
                    search: "Pencarian:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Tidak ada kontak yang ditemukan",
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
                columnDefs: [
                    { type: "num", targets: 0 },
                    { type: "string", targets: [1, 2, 3] },
                    { type: "date", targets: 4 }
                ],
                order: [[4, 'desc']], // Sort by date descending
                drawCallback: function() {
                    updateStatistics();
                    renumberRows();
                }
            });
        }

        // Quick filter functions
        function setQuickFilter(type) {
            // Update button states
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById(`btn-${type}`).classList.add('active');

            currentFilters.quick = type;

            // Clear other filters when using quick filter
            if (type !== 'all') {
                clearAdvancedFilters();
            }

            const today = new Date();
            const currentMonth = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0');
            const currentDate = today.toISOString().split('T')[0];

            switch (type) {
                case 'today':
                    currentFilters.date = currentDate;
                    break;
                case 'month':
                    currentFilters.month = currentMonth;
                    break;
                case 'all':
                default:
                    resetFilters(false);
                    break;
            }

            applyFilters();
        }

        function clearAdvancedFilters() {
            document.getElementById('filterTanggal').value = '';
        }

        // Apply filters to table
        function applyFilters() {
            // Get current filter values
            currentFilters.date = document.getElementById('filterTanggal').value;
            currentFilters.name = document.getElementById('searchName').value.toLowerCase();
            currentFilters.email = document.getElementById('searchEmail').value.toLowerCase();

            // If advanced filters are used, clear quick filter
            if (currentFilters.date) {
                currentFilters.quick = '';
                document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            }

            dataTable.destroy();

            let tableBody = document.querySelector("#contacts-table tbody");
            tableBody.innerHTML = '';

            // Filter data
            let filteredData = originalData.filter(item => {
                let show = true;

                // Quick filters
                if (currentFilters.quick === 'today') {
                    const today = new Date().toISOString().split('T')[0];
                    show = item.date === today;
                } else if (currentFilters.quick === 'month') {
                    const currentMonth = new Date().getFullYear() + '-' + String(new Date().getMonth() + 1).padStart(2, '0');
                    show = item.month === currentMonth;
                }

                // Advanced filters
                if (currentFilters.date && item.date !== currentFilters.date) show = false;
                if (currentFilters.name && !item.name.includes(currentFilters.name)) show = false;
                if (currentFilters.email && !item.email.includes(currentFilters.email)) show = false;

                return show;
            });

            // Add filtered rows back to table
            filteredData.forEach(item => {
                tableBody.appendChild(item.element.cloneNode(true));
            });

            // Reinitialize DataTable
            initializeDataTable();
            attachDeleteListeners();
        }

        // Reset all filters
        function resetFilters(updateButtons = true) {
            // Clear all filters
            currentFilters = {
                date: '',
                name: '',
                email: '',
                quick: 'all'
            };

            // Clear form inputs
            document.getElementById('filterTanggal').value = '';
            document.getElementById('searchName').value = '';
            document.getElementById('searchEmail').value = '';

            if (updateButtons) {
                // Update button states
                document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                document.getElementById('btn-all').classList.add('active');
            }

            // Reset table
            dataTable.destroy();
            let tableBody = document.querySelector("#contacts-table tbody");
            tableBody.innerHTML = '';

            originalData.forEach(item => {
                tableBody.appendChild(item.element.cloneNode(true));
            });

            initializeDataTable();
            attachDeleteListeners();
        }

        // Update statistics display
        function updateStatistics() {
            const today = new Date().toISOString().split('T')[0];
            const currentMonth = new Date().getFullYear() + '-' + String(new Date().getMonth() + 1).padStart(2, '0');

            // Count total displayed contacts
            const displayedRows = document.querySelectorAll('#contacts-table tbody tr').length;
            document.getElementById('totalContacts').textContent = displayedRows;

            // Count today's contacts
            const todayCount = originalData.filter(item => item.date === today).length;
            document.getElementById('todayContacts').textContent = todayCount;

            // Count this month's contacts
            const monthCount = originalData.filter(item => item.month === currentMonth).length;
            document.getElementById('monthContacts').textContent = monthCount;
        }

        // Renumber table rows
        function renumberRows() {
            const rows = document.querySelectorAll('#contacts-table tbody tr');
            rows.forEach((row, index) => {
                row.cells[0].textContent = index + 1;
            });
        }

        // Print table functionality
        function printTable() {
            // Show all data for printing
            dataTable.page.len(-1).draw();

            // Set print period
            let periodeText = getPeriodText();
            document.getElementById("printPeriod").textContent = periodeText;
            document.getElementById("printHeader").classList.remove("hidden");

            setTimeout(() => {
                window.print();
                document.getElementById("printHeader").classList.add("hidden");
                dataTable.page.len(10).draw();
            }, 500);
        }

        // Get period text for printing/exporting
        function getPeriodText() {
            let parts = [];

            if (currentFilters.quick === 'today') return 'Hari Ini';
            if (currentFilters.quick === 'month') return 'Bulan Ini';
            if (currentFilters.quick === 'all' && !currentFilters.date) return 'Semua Periode';

            if (currentFilters.date) parts.push(`Tanggal ${currentFilters.date}`);

            return parts.length ? parts.join(', ') : 'Periode Terfilter';
        }

        // Export data to CSV
        function exportData() {
            // Simple CSV export
            let csv = 'No,Nama,Email,Pesan,Tanggal\n';
            const rows = document.querySelectorAll('#contacts-table tbody tr');

            rows.forEach((row, index) => {
                const cells = row.querySelectorAll('td');
                const rowData = [
                    index + 1,
                    `"${cells[1].textContent.trim()}"`,
                    `"${cells[2].textContent.trim()}"`,
                    `"${cells[3].textContent.trim().replace(/Selengkapnya/, '')}"`,
                    `"${cells[4].textContent.trim()}"`
                ];
                csv += rowData.join(',') + '\n';
            });

            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `kontak_${getPeriodText().replace(/\s+/g, '_')}_${new Date().toISOString().split('T')[0]}.csv`;
            a.click();
            window.URL.revokeObjectURL(url);
        }

        // Show full message in modal
        function showFullMessage(message) {
            Swal.fire({
                title: 'Pesan Lengkap',
                text: message,
                icon: 'info',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#16C47F',
                customClass: {
                    popup: 'text-left'
                }
            });
        }

        // Reply to contact via email
        function replyToContact(email, name) {
            const subject = `Re: Pesan dari ${name}`;
            const body = `Halo ${name},\n\nTerima kasih atas pesan Anda. \n\nSalam,\nTim Customer Service`;

            const mailtoLink = `mailto:${email}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
            window.location.href = mailtoLink;
        }

        // Attach delete confirmation listeners
        function attachDeleteListeners() {
            document.querySelectorAll('form.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Pesan ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        }

        // Show success message if available
        @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#16C47F'
        });
        @endif
    </script>
</body>

</html>