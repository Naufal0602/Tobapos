@php
    use App\Models\Product;

    $categoryFilter = request('category');
    $sizeFilter = request('size');
    $query = Product::latest();

    if ($categoryFilter) {
        $query->where('category', $categoryFilter);
    }

    if ($sizeFilter) {
        $query->where('size', $sizeFilter);
    }

    $products = $query->paginate(8);
    $categories = Product::select('category')->distinct()->get();
    $sizes = Product::select('size')->distinct()->get();
@endphp
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('input.css') }}">
    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(10px);
            animation: fadeIn 0.5s ease-in-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .responsive-container {
                margin-left: 0 !important;
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
        }
        
        @media (max-width: 768px) {
            .responsive-header {
                flex-direction: column !important;
                align-items: stretch !important;
            }
            
            .responsive-category-select {
                width: 100% !important;
                margin-top: 1rem;
            }
            
            .product-image {
                height: 180px !important;
                width: 100% !important;
                object-fit: cover !important;
            }
            
            .product-card {
                margin-bottom: 1rem !important;
            }
        }
        
        @media (max-width: 480px) {
            .product-image {
                height: 150px !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('layouts.sidebar')
    @include('layouts.navbar') 

    <div class="ml-60 p-6 responsive-container">
        <div class="container mx-auto">
            <div class="mb-6 flex justify-between items-center fade-in bg-white p-6 rounded-lg shadow-md responsive-header" style="animation-delay: 0.2s;">
                <h2 class="text-2xl md:text-4xl font-extrabold text-gray-800">Daftar Produk</h2>
                <form method="GET" action="" class="responsive-category-select">
                    <select name="category" onchange="this.form.submit()" class="p-3 border rounded-lg shadow bg-gray-50 text-gray-700 focus:ring-2 focus:ring-indigo-500 transition">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category }}" {{ request('category') == $category->category ? 'selected' : '' }}>
                                {{ ucfirst($category->category) }}
                            </option>
                        @endforeach
                    </select>
                    <select name="size" onchange="this.form.submit()" class="p-3 border rounded-lg shadow bg-gray-50 text-gray-700 focus:ring-2 focus:ring-indigo-500 transition ml-4">
                        <option value="">Semua Ukuran</option>
                        @foreach($sizes as $size)
                            <option value="{{ $size->size }}" {{ request('size') == $size->size ? 'selected' : '' }}>
                                {{ ucfirst($size->size) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 lg:gap-8">
                @foreach($products as $index => $product)
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, {{ 200 + ($index * 100) }})" x-show="show"
                    x-transition.duration.500ms class="bg-white shadow-lg rounded-xl p-4 md:p-6 transform transition hover:scale-105 hover:shadow-2xl fade-in product-card" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
                    <div class="overflow-hidden rounded-lg">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-40 md:h-52 object-cover rounded-lg product-image">
                    </div>
                    <div class="mt-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h3>
                        <p class="text-gray-500 text-sm">Kategori: {{ ucfirst($product->category) }}</p>
                        <p class="text-green-600 font-bold text-xl mt-2">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-black text-sm mt-2">{{ Str::limit($product->description, 50) }}</p>
                        <div class="justify-between flex">
                            <p class="text-black text-sm mt-2">Ukuran: {{ $product->size }}</p>
                            <p class="text-black text-sm mt-2">Stock: {{ $product->stock }}</p>
                        </div>
                        <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->stock }})" 
                            class="mt-4 w-full bg-indigo-500 text-white px-4 py-3 rounded-lg hover:bg-indigo-600 transition font-semibold shadow-md">
                            Tambah ke Transaksi
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center fade-in" style="animation-delay: 0.5s;">
                {{ $products->links() }}
            </div>
        </div>
    </div>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace();
    });
    
    function addToCart(productId, productName, productPrice, productStock) {
        if (productStock <= 0) {
            Swal.fire({
                title: 'Peringatan!',
                text: `${productName} sudah habis. Silakan tambahkan stok terlebih dahulu.`,
                icon: 'warning',
                confirmButtonColor: '#4F46E5',
                customClass: {
                    popup: 'swal2-responsive'
                }
            });
            return;
        }

        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let existingProduct = cart.find(item => item.id === productId);

        if (existingProduct) {
            existingProduct.quantity += 1;
        } else {
            cart.push({ id: productId, name: productName, price: productPrice, quantity: 1 });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        Swal.fire({
            title: 'Berhasil!',
            text: `${productName} telah ditambahkan ke keranjang.`,
            icon: 'success',
            confirmButtonColor: '#4F46E5',
            customClass: {
                popup: 'swal2-responsive'
            }
        });
    }
    
    // Make SweetAlert responsive
    document.head.insertAdjacentHTML('beforeend', `
        <style>
            @media (max-width: 500px) {
                .swal2-responsive {
                    width: 90% !important;
                    padding: 1rem !important;
                }
            }
        </style>
    `);
</script>
</body>
</html>