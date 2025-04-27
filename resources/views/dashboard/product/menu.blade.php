@php
    use App\Models\Product;

    $searchQuery = request('search');
    $categoryFilter = request('category');
    $sizeFilter = request('size');
    $query = Product::latest();

    if ($searchQuery) {
        $query->where('name', 'like', '%' . $searchQuery . '%');
    }

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
    <title>Popular Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('input.css') }}">
    <style>
        .product-card {
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
        }
        .quantity-btn {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #f3f4f6;
            cursor: pointer;
            font-weight: bold;
            user-select: none;
        }
        .quantity-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .quantity-input {
            width: 40px;
            text-align: center;
            border: none;
            font-size: 16px;
            font-weight: 500;
        }
        .add-to-cart {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #22c55e;
            color: white;
            cursor: pointer;
            margin-left: 10px;
        }
        .add-to-cart.disabled {
            background-color: #9ca3af;
            cursor: not-allowed;
        }
        .stock-info {
            text-align: center;
            font-size: 14px;
            color: #4b5563;
            margin-top: 8px;
        }
        .fade-in {
            opacity: 0;
            transform: translateY(10px);
            animation: fadeIn 0.5s ease-in-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .search-container {
            position: relative;
            width: 100%;
        }
        .search-container .search-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: #9ca3af;
        }
        .search-input {
            width: 100%;
            padding: 10px 12px 10px 40px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
            transition: all 0.3s ease;
        }
        .search-input:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
            background-color: white;
        }
        .search-btn {
            background-color: #4f46e5;
            color: white;
            border-radius: 8px;
            padding: 10px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .search-btn:hover {
            background-color: #4338ca;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('layouts.sidebar')
    @include('layouts.navbar') 

    <!-- Main container with responsive margins -->
    <div class="ml-0 md:ml-16 lg:ml-60 p-3 md:p-6 transition-all duration-300">
        <div class="container mx-auto">
            <!-- Header section with search and filters -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 fade-in bg-white p-4 md:p-6 rounded-lg shadow-md" style="animation-delay: 0.2s;">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-gray-800">Product</h2>
                
             
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">
                       <!-- Search Form -->
                <form method="GET" action="" class="w-full sm:w-64">
                    <div class="search-container">
                        <i class="search-icon" data-feather="search"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="search-input">
                    </div>
                </form>
                
                    <form method="GET" action="" class="w-full sm:w-auto" id="categoryForm">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <select name="category" onchange="this.form.submit()" class="w-full p-2 md:p-3 border rounded-lg shadow bg-gray-50 text-gray-700 focus:ring-2 focus:ring-indigo-500 transition">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category }}" {{ request('category') == $category->category ? 'selected' : '' }}>
                                    {{ ucfirst($category->category) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    <form method="GET" action="" class="w-full sm:w-auto" id="sizeForm">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <select name="size" onchange="this.form.submit()" class="w-full p-2 md:p-3 border rounded-lg shadow bg-gray-50 text-gray-700 focus:ring-2 focus:ring-indigo-500 transition">
                            <option value="">Semua Ukuran</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size->size }}" {{ request('size') == $size->size ? 'selected' : '' }}>
                                    {{ ucfirst($size->size) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <!-- Products not found message -->
            @if($products->isEmpty())
            <div class="my-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No products found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
                <div class="mt-6">
                    <a href="{{ url()->current() }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Clear all filters
                    </a>
                </div>
            </div>
            @endif

            <!-- Product grid with responsive columns -->
            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6">
                @foreach($products as $index => $product)
                <div class="product-card bg-white p-3 md:p-6 rounded-xl shadow-sm fade-in" 
                     style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;"
                     x-data="{ 
                        quantity: 1, 
                        stock: {{ $product->stock }},
                        productId: {{ $product->id }},
                        productName: '{{ $product->name }}',
                        productPrice: {{ $product->price }},
                        decrementQuantity() {
                            if (this.quantity > 1) this.quantity--;
                        },
                        incrementQuantity() {
                            if (this.quantity < this.stock) this.quantity++;
                        },
                        addToCart() {
                            if (this.stock <= 0) {
                                showSweetAlert('warning', 'Peringatan!', `${this.productName} sudah habis. Silakan tambahkan stok terlebih dahulu.`);
                                return;
                            }
                            
                            let cart = JSON.parse(localStorage.getItem('cart')) || [];
                            let existingProduct = cart.find(item => item.id === this.productId);
                            
                            if (existingProduct) {
                                if (existingProduct.quantity + this.quantity <= this.stock) {
                                    existingProduct.quantity += this.quantity;
                                } else {
                                    showSweetAlert('warning', 'Peringatan!', `Jumlah ${this.productName} di keranjang akan melebihi stok maksimal (${this.stock}).`);
                                    return;
                                }
                            } else {
                                cart.push({ 
                                    id: this.productId, 
                                    name: this.productName, 
                                    price: this.productPrice, 
                                    quantity: this.quantity, 
                                    stock: this.stock 
                                });
                            }
                            
                            localStorage.setItem('cart', JSON.stringify(cart));
                            this.stock -= this.quantity;
                            
                            if (this.quantity > this.stock) {
                                this.quantity = this.stock > 0 ? this.stock : 1;
                            }
                            
                            showSweetAlert('success', 'Berhasil!', `${this.quantity} ${this.productName} telah ditambahkan ke keranjang.`);
                        }
                     }">
                    <div class="flex justify-center mb-3 md:mb-4">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-16 md:h-20 lg:h-24 w-16 md:w-20 lg:w-24 object-contain">
                    </div>
                    <h3 class="text-center font-medium text-gray-800 text-sm md:text-base">{{ $product->name }}</h3>
                    <p class="text-center text-gray-500 text-xs md:text-sm">{{ $product->size }}</p>
                    <p class="text-center font-bold text-gray-900 mt-1 md:mt-2 text-sm md:text-base">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="stock-info text-xs md:text-sm" x-text="'Stock: ' + stock"></p>
                    
                    <div class="flex justify-between items-center mt-3 md:mt-4">
                        <div class="quantity-control">
                            <div class="quantity-btn" 
                                 :class="{ 'disabled': quantity <= 1 }"
                                 x-on:click="decrementQuantity()">-</div>
                            <input type="text" class="quantity-input text-sm md:text-base" x-model="quantity" readonly>
                            <div class="quantity-btn" 
                                 :class="{ 'disabled': quantity >= stock }"
                                 x-on:click="incrementQuantity()">+</div>
                        </div>
                        <div class="add-to-cart w-8 h-8 md:w-10 md:h-10"
                             :class="{ 'disabled': stock <= 0 }"
                             x-on:click="addToCart()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6 md:mt-8 flex justify-center fade-in" style="animation-delay: 0.5s;">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

<script>  
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace();
        
        // Handle sidebar toggle for mobile
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('block');
            });
        }
        
        // Save products to localStorage
        const products = [
            @foreach($products as $product)
            {
                id: {{ $product->id }},
                name: "{{ $product->name }}",
                price: {{ $product->price }},
                stock: {{ $product->stock }}
            },
            @endforeach
        ];
        localStorage.setItem('products', JSON.stringify(products));
        
        // Preserve search parameter when changing category or size
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (form.id === 'categoryForm' || form.id === 'sizeForm') {
                    const searchParam = new URLSearchParams(window.location.search).get('search');
                    if (searchParam) {
                        const searchInput = form.querySelector('input[name="search"]');
                        if (searchInput) {
                            searchInput.value = searchParam;
                        }
                    }
                }
            });
        });
    });

    // Global SweetAlert function
    function showSweetAlert(icon, title, text) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
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
                .swal2-title {
                    font-size: 1.25rem !important;
                }
                .swal2-text {
                    font-size: 0.9rem !important;
                }
                .swal2-confirm {
                    font-size: 0.9rem !important;
                    padding: 0.5rem 1rem !important;
                }
            }
        </style>
    `);
</script>
</body>
</html>