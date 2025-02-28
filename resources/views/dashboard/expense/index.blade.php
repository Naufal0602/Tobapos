<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengeluaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('input.css') }}">
    <style>
        @media print {
            body {
                visibility: hidden;
            }
            #printArea {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
           table {
                font-size: 16px; /* Atau lebih besar sesuai kebutuhan */
            }
            th, td {
                padding: 10px;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body class="font-sans" style="background:#F5E6F0;">
    @include('layouts.sidebar')
    @include('layouts.navbar')

    <div class="lg:ml-60 p-6">
        <div class="mb-4 p-4 shadow-md flex flex-col lg:flex-row justify-between bg-white rounded-lg">
            <h2 class="text-2xl lg:text-4xl font-semibold">Pengeluaran</h2>
            <div class="space-x-0 lg:space-x-5 mt-4 lg:mt-0">
                <a href="{{ route('dashboard.expenses.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg block lg:inline-block">Buat Pengeluaran</a>
                <button onclick="printTable()" class="bg-blue-500 text-white px-4 py-2 rounded-lg block lg:inline-block mt-2 lg:mt-0">Cetak PDF</button>
            </div>
        </div>

        <div class="mb-4 flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4">
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
            <button onclick="filterData()" class="bg-purple-500 text-white px-4 py-2 rounded-lg">Filter</button>
        </div>

        <div class="bg-white px-3 py-2 rounded-lg shadow-md">
            <div class="overflow-x-auto" id="printArea">
                <div class="p-3">
                    <h2 class="text-xl lg:text-2xl font-semibold font-mono">List Data Pengeluaran</h2>
                </div>
                <table id="expenseTable" class="w-full border-collapse border border-gray-300">
                    <thead class="bg-gradient-to-b from-[#D5A4CF] to-[#B689B0] text-center text-black font-bold">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">Nama</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Kategori</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Pengeluaran</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Tanggal</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Bukti</th>
                            <th class="border border-gray-300 px-4 py-2 text-left no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="expenseBody">
                        @forelse ($expenses as $expense)
                            <tr class="expense-row" data-date="{{ $expense->created_at->format('Y-m') }}" data-day="{{ $expense->created_at->format('l') }}">
                                <td class="border border-gray-300 px-4 py-2">{{ $expense->name }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $expense->category }}</td>
                                <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $expense->created_at->format('d M Y') }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    @if ($expense->receipt_image)
                                    <img src="{{ asset('storage/' . $expense->receipt_image) }}" 
                                    class="w-16 h-16 object-cover rounded-lg mx-auto cursor-pointer"
                                    x-on:click="console.log('Clicked!'); showModal = true; modalImage = '{{ asset('storage/' . $expense->receipt_image) }}'">
                                    @else
                                    
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center no-print">
                                    <a href="{{ route('dashboard.expenses.edit', $expense->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg">Edit</a>
                                    <form action="{{ route('dashboard.expenses.destroy', $expense->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg mt-2 lg:mt-0">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                        <tr id="noDataRow">
                            <td colspan="6" class="border border-gray-300 px-4 py-2 text-center">Tidak ada pengeluaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

    {{-- modal --}}
    <div x-data="{ showModal: false, modalImage: '' }">
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-4 rounded-lg shadow-lg relative">
                <button x-on:click="showModal = false" class="absolute top-2 right-2 text-xl">&times;</button>
                <img :src="modalImage" class="max-w-full h-auto rounded-lg">
            </div>
        </div>
    </div>
 </body>
</html>

<script>
    function filterData() {
        let selectedDay = document.getElementById("filterHari").value;
        let selectedMonth = document.getElementById("filterBulan").value;
        let rows = document.querySelectorAll(".expense-row");
        let visibleRows = 0;

        rows.forEach(row => {
            let rowDate = row.getAttribute("data-date");
            let rowDay = row.getAttribute("data-day");
            let showRow = true;

            if (selectedMonth && rowDate !== selectedMonth) {
                showRow = false;
            }
            if (selectedDay && rowDay !== selectedDay) {
                showRow = false;
            }

            row.style.display = showRow ? "table-row" : "none";
            if (showRow) visibleRows++;
        });

        document.getElementById("noDataRow").style.display = visibleRows ? "none" : "table-row";
    }
    
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date();
            const currentMonth = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0'); // Format YYYY-MM

            const rows = document.querySelectorAll(".expense-row");
            let hasData = false;

            rows.forEach(row => {
                if (row.getAttribute("data-date") === currentMonth) {
                    row.style.display = "table-row";
                    hasData = true;
                } else {
                    row.style.display = "none";
                }
            });

            // Jika tidak ada data yang sesuai, tampilkan pesan "Tidak ada pengeluaran"
            const noDataRow = document.getElementById("noDataRow");
            if (noDataRow) {
                noDataRow.style.display = hasData ? "none" : "table-row";
            }
        });

        document.addEventListener('alpine:init', () => {
        Alpine.plugin(collapse);
    });

    function printTable() {
        window.print();
    }
</script>
