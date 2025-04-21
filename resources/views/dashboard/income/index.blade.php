<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pemasukan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
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
        }
    </style>
</head>
<body class="" style="background:#F5E6F0;"> 

    @include('layouts.sidebar')
    @include('layouts.navbar')

    <div class="ml-0 sm:ml-60 p-3 md:p-6">
        <h2 class="text-2xl md:text-4xl font-bold mb-4">Pemasukan</h2>

        <div class="bg-white p-3 md:p-6 rounded-lg shadow-md">
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
                <button onclick="printTable()" class="bg-blue-500 text-white px-4 py-2 rounded-lg justify-end">Print</button>
            </div>

            <div class="overflow-x-auto" id="printArea">
                <table class="w-full border-collapse border border-gray-300" id="transactions-table">
                    <thead class="bg-gradient-to-b from-[#D5A4CF] to-[#B689B0]">
                        <tr>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">ID Transaksi</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Total</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Metode Pembayaran</th>
                            <th class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $index => $transaction)
                            <tr class="expense-row" data-date="{{ $transaction->created_at->format('Y-m') }}" data-day="{{ $transaction->created_at->format('l') }}">
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $index + 1 }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">Rp {{ number_format($transaction->total, 2) }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $transaction->payment_method }}</td>
                                <td class="border px-2 py-1 md:px-4 md:py-2 text-xs md:text-base">{{ $transaction->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                        <tr id="noDataRow" class="hidden">
                            <td colspan="4" class="text-center py-4">Tidak ada pemasukan</td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="mt-4">
                    <h3 class="text-xl md:text-2xl font-bold">Total Pemasukan: <span class="total-income">Rp {{ number_format($totalIncome, 2) }}</span></h3>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterData() {
            let selectedDay = document.getElementById("filterHari").value;
            let selectedMonth = document.getElementById("filterBulan").value;
            let rows = document.querySelectorAll(".expense-row");
            let visibleRows = 0;
            let totalIncome = 0;

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
                if (showRow) {
                    visibleRows++;
                    totalIncome += parseFloat(row.querySelector("td:nth-child(2)").textContent.replace(/[^\d.-]/g, ""));
                }
            });

            document.getElementById("noDataRow").style.display = visibleRows ? "none" : "table-row";
            document.querySelector(".total-income").textContent = `Rp ${totalIncome.toLocaleString('id-ID', { minimumFractionDigits: 2 })}`;
        }

        function printTable() {
            window.print();
        }

        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date();
            const currentMonth = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0');
            const rows = document.querySelectorAll(".expense-row");
            let hasData = false;
            let totalIncome = 0;

            rows.forEach(row => {
                if (row.getAttribute("data-date") === currentMonth) {
                    row.style.display = "table-row";
                    hasData = true;
                    totalIncome += parseFloat(row.querySelector("td:nth-child(2)").textContent.replace(/[^\d.-]/g, ""));
                } else {
                    row.style.display = "none";
                }
            });

            const noDataRow = document.getElementById("noDataRow");
            if (noDataRow) {
                noDataRow.style.display = hasData ? "none" : "table-row";
            }

            document.querySelector(".total-income").textContent = `Rp ${totalIncome.toLocaleString('id-ID', { minimumFractionDigits: 2 })}`;
        });
    </script>
</body>
</html>
