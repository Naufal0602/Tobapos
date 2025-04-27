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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<body class="font-sans" style="background:#F5E6F0;" x-data="{ showModal: false, modalImage: '', modalExpense: null }">
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
                <select id="filterKategori" class="px-4 py-2 border rounded-lg shadow-md">
                    <option value="">Semua Kategori</option>
                    <option value="Pribadi">Pribadi</option>
                    <option value="Toko">Toko</option>
                    
                </select>
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
                            <tr class="expense-row" data-date="{{ $expense->created_at->format('Y-m') }}" data-day="{{ $expense->created_at->format('l') }}" data-amount="{{ $expense->amount }}">
                                <td class="border border-gray-300 px-4 py-2">{{ $expense->name }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $expense->category }}</td>
                                <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $expense->created_at->format('d M Y') }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    @if ($expense->receipt_image)
                                    <img src="{{ asset('storage/' . $expense->receipt_image) }}" 
                                    class="w-16 h-16 object-cover rounded-lg mx-auto cursor-pointer"
                                    onclick="openDetailedModal('{{ asset('storage/' . $expense->receipt_image) }}', '{{ $expense->name }}', '{{ $expense->category }}', '{{ number_format($expense->amount, 0, ',', '.') }}', '{{ $expense->created_at->format('d M Y') }}')">
                                    @else
                                    
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center no-print">
                                    <a href="{{ route('dashboard.expenses.edit', $expense->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg">Edit</a>
                                    <button onclick="confirmDelete('{{ route('dashboard.expenses.destroy', $expense->id) }}')" class="bg-red-500 text-white px-4 py-2 rounded-lg mt-2 lg:mt-0">Hapus</button>
                                    <form id="delete-form-{{ $expense->id }}" action="{{ route('dashboard.expenses.destroy', $expense->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                        <tr id="noDataRow">
                            <td colspan="6" class="border border-gray-300 px-4 py-2 text-center">Tidak ada pengeluaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <!-- Baris untuk total pengeluaran -->
                        <tr id="totalRow" class="bg-gray-100 font-bold">
                            <td class="border border-gray-300 px-4 py-2" colspan="2">Total Pengeluaran</td>
                            <td id="totalAmount" class="border justify-center border-gray-300 px-4 py-2" colspan="4">Rp 0</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modal gambar yang ditingkatkan dengan informasi lengkap -->
    <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg relative max-w-2xl w-full">
            <button @click="showModal = false" class="absolute top-3 right-3 text-2xl font-bold">&times;</button>
            <div class="flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-1/2">
                    <img :src="modalImage" class="max-w-full h-auto rounded-lg mx-auto">
                </div>
                <div class="w-full md:w-1/2 mt-4 md:mt-0">
                    <h3 class="text-xl font-bold mb-4">Detail Pengeluaran</h3>
                    <table class="w-full border-collapse">
                        <tr>
                            <td class="py-2 font-semibold">Nama:</td>
                            <td class="py-2" x-text="modalExpense?.name"></td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Kategori:</td>
                            <td class="py-2" x-text="modalExpense?.category"></td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Jumlah:</td>
                            <td class="py-2">Rp <span x-text="modalExpense?.amount"></span></td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold">Tanggal:</td>
                            <td class="py-2" x-text="modalExpense?.date"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    // Modal handler untuk menampilkan gambar dan informasi
    function openDetailedModal(imageSrc, name, category, amount, date) {
        // Alpine.js data access
        const alpineData = document.querySelector('body').__x.$data;
        alpineData.modalImage = imageSrc;
        alpineData.modalExpense = {
            name: name,
            category: category,
            amount: amount,
            date: date
        };
        alpineData.showModal = true;
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
                // Extract the ID from the URL
                const id = deleteUrl.split('/').pop();
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }

    function calculateTotal() {
        let total = 0;
        let visibleRows = 0;
        const rows = document.querySelectorAll('.expense-row');
        
        rows.forEach(row => {
            if (row.style.display !== 'none') {
                // Ambil nilai amount dari atribut data-amount
                const amount = parseInt(row.getAttribute('data-amount'));
                if (!isNaN(amount)) {
                    total += amount;
                    visibleRows++;
                }
            }
        });
        
        // Format total dengan pemisah ribuan
        const formattedTotal = new Intl.NumberFormat('id-ID', { 
            minimumFractionDigits: 0, 
            maximumFractionDigits: 0 
        }).format(total);
        
        document.getElementById('totalAmount').textContent = 'Rp ' + formattedTotal;
        
        // Tampilkan atau sembunyikan baris total berdasarkan apakah ada data atau tidak
        const totalRow = document.getElementById('totalRow');
        if (totalRow) {
            totalRow.style.display = visibleRows > 0 ? 'table-row' : 'none';
        }
        
        const noDataRow = document.getElementById('noDataRow');
        if (noDataRow) {
            noDataRow.style.display = visibleRows > 0 ? 'none' : 'table-row';
        }
    }

    function filterData() {
    let selectedDay = document.getElementById("filterHari").value;
    let selectedMonth = document.getElementById("filterBulan").value;
    let selectedCategory = document.getElementById("filterKategori").value;
    let rows = document.querySelectorAll(".expense-row");
    let visibleRows = 0;

    rows.forEach(row => {
        let rowDate = row.getAttribute("data-date");
        let rowDay = row.getAttribute("data-day");
        let rowCategory = row.querySelector("td:nth-child(2)").textContent.trim();
        let showRow = true;

        if (selectedMonth && rowDate !== selectedMonth) {
            showRow = false;
        }
        if (selectedDay && rowDay !== selectedDay) {
            showRow = false;
        }
        if (selectedCategory && rowCategory !== selectedCategory) {
            showRow = false;
        }

        row.style.display = showRow ? "table-row" : "none";
        if (showRow) visibleRows++;
    });

    const noDataRow = document.getElementById("noDataRow");
    if (noDataRow) {
        noDataRow.style.display = visibleRows > 0 ? "none" : "table-row";
    }
    
    // Hitung ulang total setelah filter
    calculateTotal();
}
    
    document.addEventListener("DOMContentLoaded", function() {
        const today = new Date();
        const currentMonth = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0'); // Format YYYY-MM
        
        // Set nilai default untuk filter bulan
        document.getElementById("filterBulan").value = currentMonth;

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
        
        // Hitung total pada saat halaman dimuat
        calculateTotal();
    });

    function printTable() {
        window.print();
    }
</script>