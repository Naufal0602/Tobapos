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
  
</head>
<body class="" style="background:#F5E6F0;">

    @include('layouts.sidebar')
    @include('layouts.navbar')

    <div class="ml-60 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Pengeluaran</h2>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
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
                    <input type="number" name="amount" class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Unggah Bukti Pembayaran</label>
                    <input type="file" name="receipt_image" class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('dashboard.expenses.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg">Batal</a>
                    <button type="button" onclick="confirmCreate()" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
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
    </script>

</body>
</html>
