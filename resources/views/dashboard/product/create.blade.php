<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create-Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('input.css') }}">
    <style>
        /* Responsive styles for mobile */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0 !important;
                padding: 1rem !important;
            }
            
            .form-container {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
            }
            
            .button-group {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .button-group a, 
            .button-group button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body class="" style="background:#F5E6F0;">

    @include('layouts.sidebar')
    @include('layouts.navbar') 

    <div class="ml-60 p-6 main-content">
        <div class="max-w-lg mx-auto bg-white p-6 rounded shadow form-container">
            <h2 class="text-xl font-extrabold mb-4">Tambah Produk</h2>
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form id="productForm" action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label class="block mb-2">Nama Produk</label>
                <input type="text" name="name" class="w-full border px-3 py-2 mb-2 rounded" required>
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                
                <label class="block mb-2">Kategori</label>
                <select name="category" class="w-full border px-3 py-2 mb-2 rounded" required>
                    <option value="menthol">Menthol</option>
                    <option value="herbal">Herbal</option>
                    <option value="ice">Ice</option>
                    <option value="bussa_mild">Bussa Mild</option>
                    <option value="bussa_esse">Bussa esse</option>
                    <option value="vapir">Vapir</option>
                    <option value="bussa_medium">Bussa Mdium</option>

                </select>
                @error('category') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                <label class="block mb-2">Size</label>
                <select name="size" class="w-full border px-3 py-2 mb-2 rounded">
                    <option value="50 gram">50 gram</option>
                    <option value="1 kg">1 kg</option>
                    <option value="100 gram">100 gram</option>
                    <option value="200 gram">200 gram</option>
                    <option value="500 gram">500 gram</option>
                </select>
                
                <label class="block mb-2">Harga</label>
                <input type="number" name="price" class="w-full border px-3 py-2 mb-2 rounded" required>
                @error('price') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                
                <label class="block mb-2">Stok</label>
                <input type="number" name="stock" class="w-full border px-3 py-2 mb-2 rounded" required>
                @error('stock') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                
                <label class="block mb-2">Gambar</label>
                <input type="file" name="image" class="w-full border px-3 py-2 mb-2 rounded">
                @error('image') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                
                <label class="block mb-2">Deskripsi</label>
                <textarea name="description" class="w-full border px-3 py-2 mb-2 rounded" required></textarea>
                @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                
                <div class="flex justify-between button-group">
                    <a href="{{ route('dashboard.products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                    <button type="button" onclick="confirmSubmission()" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Add JS for mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            // This assumes you have a toggle button in your sidebar component
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar'); // Update with your actual sidebar class
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('hidden');
                    
                    // Toggle margin of main content
                    const mainContent = document.querySelector('.main-content');
                    if (mainContent) {
                        mainContent.classList.toggle('ml-0');
                        mainContent.classList.toggle('ml-60');
                    }
                });
            }
            
            // Auto-hide sidebar on small screens initially
            function handleResize() {
                if (window.innerWidth < 768 && sidebar) {
                    sidebar.classList.add('hidden');
                    const mainContent = document.querySelector('.main-content');
                    if (mainContent) {
                        mainContent.classList.remove('ml-60');
                        mainContent.classList.add('ml-0');
                    }
                } else if (sidebar) {
                    sidebar.classList.remove('hidden');
                    const mainContent = document.querySelector('.main-content');
                    if (mainContent) {
                        mainContent.classList.add('ml-60');
                        mainContent.classList.remove('ml-0');
                    }
                }
            }
            
            window.addEventListener('resize', handleResize);
            handleResize(); // Call on initial load
        });

        function confirmSubmission() {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin ingin menyimpan produk ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('productForm').submit();
                }
            });
        }
    </script>
</body>
</html>