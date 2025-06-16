<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pengeluaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @media (max-width: 768px) {
            .sidebar-hidden {
                transform: translateX(-100%);
            }
            .sidebar-visible {
                transform: translateX(0);
            }
        }
        
        @media (max-width: 320px) {
            button, input, select {
                min-height: 44px;
            }
        }
    </style>
</head>
<body class="font-bold font-inter" style="background:#F9FAFB;">

    @include('layouts.sidebar')
    @include('layouts.navbar')


    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

    <div class="md:ml-60 ml-0 p-4 md:p-6 pt-16 md:pt-6">
        
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-md">
            <h2 class="text-xl md:text-2xl font-semibold mb-4">Tambah Pengeluaran</h2>

            <form id="createExpenseForm" action="{{ route('dashboard.expenses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf                
                <div class="mb-4">
                    <label class="block text-gray-700">Nama</label>
                    <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Kategori</label>
                    <select name="category" class="w-full px-4 py-2 border rounded-lg">
                        <option value="Pribadi">Pribadi</option>
                        <option value="Toko">Toko</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700">Pengeluaran</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                        <input type="text" id="rupiah-display" class="w-full px-4 py-2 border rounded-lg pl-8" placeholder="0">
                        <input type="hidden" name="amount" id="amount-actual" value="">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Unggah Bukti Pembayaran</label>
                    <input type="file" name="receipt_image" class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2">
                    <a href="{{ route('dashboard.expenses.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg text-center">Batal</a>
                    <button type="button" onclick="confirmCreate()" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileOverlay = document.getElementById('mobile-overlay');
        
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                console.log('Toggle mobile menu');
            });
        }

        function confirmCreate() {
            Swal.fire({
                title: 'Yakin ingin menambahkan pengeluaran?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tambahkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('createExpenseForm').submit();
                }
            });
        }
        
        const rupiahDisplay = document.getElementById('rupiah-display');
        const amountActual = document.getElementById('amount-actual');
        
        rupiahDisplay.addEventListener('input', function() {
            let numericValue = this.value.replace(/\D/g, '');
            amountActual.value = numericValue;
            if (numericValue != '') {
                let formattedValue = parseInt(numericValue, 10).toLocaleString('id-ID');
                this.value = formattedValue;
            }
        });
        
        rupiahDisplay.addEventListener('focus', function() {
            if (this.value) {
                this.select();
            }
        });
    </script>

</body>
</html>