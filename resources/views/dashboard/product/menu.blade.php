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
    </style>
</head>
<body class="bg-gray-50">
    @include('layouts.sidebar')
    @include('layouts.navbar') 

    <!-- Main container with responsive margins -->
    <div class="ml-0 md:ml-16 lg:ml-60 p-3 md:p-6 transition-all duration-300">
        <div class="container mx-auto">
            <!-- Header section with filters -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 fade-in bg-white p-4 md:p-6 rounded-lg shadow-md" style="animation-delay: 0.2s;">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-gray-800">Product</h2>
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">
                    <form method="GET" action="" class="w-full sm:w-auto">
                        <select name="category" onchange="this.form.submit()" class="w-full p-2 md:p-3 border rounded-lg shadow bg-gray-50 text-gray-700 focus:ring-2 focus:ring-indigo-500 transition">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category }}" {{ request('category') == $category->category ? 'selected' : '' }}>
                                    {{ ucfirst($category->category) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    <form method="GET" action="" class="w-full sm:w-auto">
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

            <!-- Product grid with responsive columns -->
            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6">
                @foreach($products as $index => $product)
                <div x-data="{ 
                    quantity: 1, 
                    stock: {{ $product->stock }},
                    decrementQuantity() {
                        if (this.quantity > 1) this.quantity--;
                    },
                    incrementQuantity() {
                        if (this.quantity < this.stock) this.quantity++;
                    }
                }" class="product-card bg-white p-3 md:p-6 rounded-xl shadow-sm fade-in" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
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
                             x-on:click="stock > 0 ? addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, stock, quantity) : null">
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
                {{ $products->links() }}
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
    });

    function addToCart(productId, productName, productPrice, productStock, quantity) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let existingProduct = cart.find(item => item.id === productId);
        
        if (existingProduct) {
            // Check if adding the quantity would exceed stock
            if (existingProduct.quantity + quantity <= productStock) {
                existingProduct.quantity += quantity;
            } else {
                Swal.fire({
                    title: 'Peringatan!',
                    text: `Jumlah ${productName} di keranjang akan melebihi stok maksimal (${productStock}).`,
                    icon: 'warning',
                    confirmButtonColor: '#4F46E5',
                    customClass: {
                        popup: 'swal2-responsive'
                    }
                });
                return;
            }
        } else {
            if (productStock > 0) {
                cart.push({ id: productId, name: productName, price: productPrice, quantity: quantity, stock: productStock });
            } else {
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
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        
        // Update product stock in the UI
        const productCard = document.querySelector(`[x-data*="quantity"][x-data*="${productId}"]`);
        if (productCard) {
            const stockComponent = productCard.__x.$data;
            stockComponent.stock -= quantity;
            if (stockComponent.quantity > stockComponent.stock) {
                stockComponent.quantity = stockComponent.stock > 0 ? stockComponent.stock : 1;
            }
        }

        Swal.fire({
            title: 'Berhasil!',
            text: `${quantity} ${productName} telah ditambahkan ke keranjang.`,
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
                .swal2-title {
                    font-size: 1.25rem !important;
                }
                .swal2-text {
                    font-size: 0.9rem !important;
                }
            }
        </style>
    `);

    function saveProducts(products) {
        localStorage.setItem('products', JSON.stringify(products));
    }

    document.addEventListener('DOMContentLoaded', function() {
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
        saveProducts(products);
    });
</script>
</body>
</html>