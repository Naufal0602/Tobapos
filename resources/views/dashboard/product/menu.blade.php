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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }
        
        .search-container {
            position: relative;
            width: 100%;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
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
            border-radius: 12px;
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
        }
        .search-input::placeholder {
            color: #9ca3af;
        }
        
        .category-tab {
            transition: all 0.2s ease;
            border: 1px solid #e2e8f0;
        }
        .category-tab.active {
            background: #22c55e;
            color: white;
            border-color: #22c55e;
        }
        
        .cart-notification {
            position: fixed;
            top: 20px;
            right: 10px;
            left: 10px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 12px 16px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
            transform: translateY(-100px);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: 1000;
            font-size: 14px;
        }
        
        .cart-notification.show {
            transform: translateY(0);
        }
        
        .cart-badge {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .stock-badge-low {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }
        
        .stock-badge-good {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        
        .stock-badge-empty {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
        
        /* Mobile Small (320px) optimizations */
        @media (max-width: 375px) {
            .mobile-header {
                position: sticky;
                top: 0;
                z-index: 40;
                background: white;
                border-bottom: 1px solid #e5e7eb;
            }
            
            .mobile-product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }
            
            .mobile-product-card {
                border-radius: 8px;
                overflow: hidden;
            }
            
            .mobile-product-image {
                aspect-ratio: 1;
                object-fit: cover;
            }
            
            .search-container .search-icon {
                left: 10px;
            }
            
            .search-input {
                padding: 8px 10px 8px 36px;
                font-size: 13px;
            }
            
            .category-tab {
                font-size: 12px;
                padding: 6px 12px;
            }
            
            .mobile-bottom-nav {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: white;
                border-top: 1px solid #e5e7eb;
                z-index: 50;
            }
        }
        
        /* Ultra small mobile (280px-320px) */
        @media (max-width: 320px) {
            .mobile-product-grid {
                gap: 6px;
            }
            
            .search-input {
                font-size: 12px;
                padding: 8px 8px 8px 32px;
            }
            
            .category-tab {
                font-size: 11px;
                padding: 5px 10px;
            }
        }

        /* Scrollbar hide utility */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Line clamp utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    @include('layouts.sidebar')
    @include('layouts.navbar') 

    <!-- Cart Notification Container -->
    <div id="cart-notification" class="cart-notification">
        <div class="flex items-center gap-2">
            <div class="bg-white bg-opacity-20 rounded-full p-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <div class="font-semibold text-sm">Berhasil ditambahkan!</div>
                <div class="text-xs opacity-90" id="notification-message"></div>
            </div>
        </div>
    </div>

    <!-- Main container with responsive design -->
    <div class="ml-0 md:ml-16 lg:ml-60 transition-all duration-300">
        
        <!-- Mobile Header -->
        <div class="mobile-header md:hidden">
            <div class="px-2 sm:px-4 py-2 sm:py-3">
                <!-- Search Bar and Cart -->
                <div class="flex items-center gap-2 sm:gap-3 mb-2 sm:mb-3">
                    <form method="GET" action="" class="flex-1">
                        <div class="search-container">
                            <i class="search-icon" data-feather="search"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="search-input">
                            <input type="hidden" name="category" value="{{ request('category') }}">
                            <input type="hidden" name="size" value="{{ request('size') }}">
                        </div>
                    </form>
                    
                    <div class="relative flex-shrink-0">
                     <a href="{{ route('dashboard.transactions.index') }}">
                        <button class="bg-white p-2 sm:p-3 rounded-xl border border-gray-200 relative shadow-sm">
                            <i data-feather="shopping-cart" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600"></i>
                            <span id="mobile-cart-count" class="cart-badge absolute -top-1 -right-1 text-white text-xs rounded-full w-4 h-4 sm:w-5 sm:h-5 flex items-center justify-center font-medium hidden"></span>
                        </button>
                      </a>
                    </div>
                </div>
                
                <!-- Category Filter Tabs -->
                <div class="flex gap-1 sm:gap-2 overflow-x-auto pb-1 scrollbar-hide">
                    <form method="GET" action="" class="flex gap-1 sm:gap-2">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="size" value="{{ request('size') }}">
                        
                        <button type="submit" name="category" value="" class="category-tab px-3 sm:px-4 py-1.5 sm:py-2 rounded-full whitespace-nowrap text-xs sm:text-sm font-medium {{ !request('category') ? 'active' : 'bg-white text-gray-600' }}">
                            Semua
                        </button>
                        
                        @foreach($categories as $category)
                        <button type="submit" name="category" value="{{ $category->category }}" class="category-tab px-3 sm:px-4 py-1.5 sm:py-2 rounded-full whitespace-nowrap text-xs sm:text-sm font-medium {{ request('category') == $category->category ? 'active' : 'bg-white text-gray-600' }}">
                            {{ ucfirst($category->category) }}
                        </button>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>

        <!-- Desktop Header (existing) -->
        <div class="hidden md:block p-6">
            <div class="container mx-auto">
                <div class="mb-6 flex justify-between items-center bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-3xl font-bold text-gray-800">Products</h2>
                    
                    <div class="flex items-center gap-3">
                        <form method="GET" action="" class="w-64">
                            <div class="search-container">
                                <i class="search-icon" data-feather="search"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="search-input">
                            </div>
                        </form>
                        
                        <form method="GET" action="" id="categoryForm">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <select name="category" onchange="this.form.submit()" class="p-3 border rounded-lg shadow bg-gray-50 text-gray-700 focus:ring-2 focus:ring-green-500 transition">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category }}" {{ request('category') == $category->category ? 'selected' : '' }}>
                                        {{ ucfirst($category->category) }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                        
                        <form method="GET" action="" id="sizeForm">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <select name="size" onchange="this.form.submit()" class="p-3 border rounded-lg shadow bg-gray-50 text-gray-700 focus:ring-2 focus:ring-green-500 transition">
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
            </div>
        </div>

        <!-- Products not found message -->
        @if($products->isEmpty())
        <div class="p-4 sm:p-6 text-center">
            <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-base sm:text-lg font-medium text-gray-900">Produk tidak ditemukan</h3>
            <p class="mt-1 text-sm text-gray-500">Coba ubah filter pencarian Anda</p>
            <div class="mt-4 sm:mt-6">
                <a href="{{ url()->current() }}" class="inline-flex items-center px-3 py-2 sm:px-4 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                    Reset Filter
                </a>
            </div>
        </div>
        @endif

        <!-- Product grid -->
        <div class="px-2 pb-4 sm:px-4 sm:pb-6 md:px-6">
            <div class="grid grid-cols-2 gap-2 sm:gap-4 md:grid-cols-3 lg:grid-cols-4 md:gap-6">
                @foreach($products as $index => $product)
                <div class="product-card bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden"
                x-data="{ 
                   quantity: 1, 
                   stock: {{ $product->stock }},
                   originalStock: {{ $product->stock }},
                   productId: {{ $product->id }},
                   productName: '{{ addslashes($product->name) }}',
                   productPrice: {{ $product->price }},
                   productSize: '{{ addslashes($product->size) }}',
                   productCategory: '{{ addslashes($product->category) }}',
                   
                   init() {
                       // Calculate current available stock based on cart
                       this.updateAvailableStock();
                   },
                   
                   updateAvailableStock() {
                       let cart = JSON.parse(localStorage.getItem('cart')) || [];
                       let cartItem = cart.find(item => item.id === this.productId);
                       let usedStock = cartItem ? cartItem.quantity : 0;
                       this.stock = Math.max(0, this.originalStock - usedStock);
                   },
                   
                   addToCart() {
                       // Update available stock first
                       this.updateAvailableStock();
                       
                       if (this.stock <= 0) {
                           showSweetAlert('warning', 'Peringatan!', 'Stok sudah habis!');
                           return;
                       }
                       
                       if (this.quantity > this.stock) {
                           showSweetAlert('warning', 'Peringatan!', `Stok tidak mencukupi. Tersisa ${this.stock} unit.`);
                           return;
                       }
           
                       let cart = JSON.parse(localStorage.getItem('cart')) || [];
                       let existingProduct = cart.find(item => item.id === this.productId);
           
                       if (existingProduct) {
                           // Check if adding quantity exceeds available stock
                           let totalAfterAdd = existingProduct.quantity + this.quantity;
                           if (totalAfterAdd > this.originalStock) {
                               let availableToAdd = this.originalStock - existingProduct.quantity;
                               if (availableToAdd <= 0) {
                                   showSweetAlert('warning', 'Peringatan!', 'Anda sudah menambahkan semua stok produk ini ke keranjang.');
                                   return;
                               }
                               showSweetAlert('warning', 'Peringatan!', `Hanya bisa menambah ${availableToAdd} unit lagi.`);
                               return;
                           }
                           existingProduct.quantity += this.quantity;
                       } else {
                           cart.push({
                               id: this.productId,
                               name: this.productName,
                               price: this.productPrice,
                               quantity: this.quantity,
                               stock: this.originalStock,
                               size: this.productSize,
                               category: this.productCategory
                           });
                       }
           
                       localStorage.setItem('cart', JSON.stringify(cart));
                       
                       // Update available stock display
                       this.updateAvailableStock();
                       
                       updateCartCounter();
                       showCartNotification(this.quantity, this.productName, this.productSize);
                       this.quantity = 1;
                   }
                }">
                   <!-- Product Image Container -->
                   <div class="relative bg-gradient-to-br from-gray-50 to-gray-100 p-2 sm:p-4 md:p-6">
                       <div class="aspect-square flex items-center justify-center">
                           <img src="{{ asset('storage/' . $product->image) }}" 
                                alt="{{ $product->name }}" 
                                class="max-h-16 max-w-16 sm:max-h-20 sm:max-w-20 md:max-h-32 md:max-w-32 object-contain transition-transform duration-300 hover:scale-105">
                       </div>
                       
                       <!-- Stock Badge -->
                       <div class="absolute top-1 right-1 sm:top-2 sm:right-2">
                           <span class="px-1.5 py-0.5 sm:px-2 sm:py-1 text-xs font-medium text-white rounded-full" 
                                 :class="{
                                     'stock-badge-good': stock > 10,
                                     'stock-badge-low': stock > 0 && stock <= 10,
                                     'stock-badge-empty': stock <= 0
                                 }">
                               <span x-text="stock > 0 ? 'Sisa ' + stock : 'Habis'" class="text-xs"></span>
                           </span>
                       </div>
                   </div>
                   
                   <!-- Product Info -->
                   <div class="p-2 sm:p-3 md:p-4 space-y-1.5 sm:space-y-2 md:space-y-3">
                       <!-- Product Name -->
                       <h3 class="font-semibold text-gray-900 text-xs sm:text-sm md:text-base leading-tight line-clamp-2">{{ $product->name }}</h3>
                       
                       <!-- Size & Category -->
                       <div class="flex gap-1 sm:gap-2">
                           <span class="text-xs text-gray-500 bg-gray-100 px-1.5 py-0.5 sm:px-2 sm:py-1 rounded-full">{{ $product->size }}</span>
                           <span class="text-xs text-gray-500 bg-gray-100 px-1.5 py-0.5 sm:px-2 sm:py-1 rounded-full">{{ $product->category }}</span>
                       </div>
                       
                       <!-- Price -->
                       <div class="text-left">
                           <p class="text-sm sm:text-lg md:text-xl font-bold text-black">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                       </div>
                       
                       <!-- Quantity Selector -->
                       <div class="flex items-center gap-1.5 sm:gap-2 mb-1.5 sm:mb-2" x-show="stock > 0">
                           <span class="text-xs sm:text-sm text-gray-600">Qty:</span>
                           <div class="flex items-center border rounded-lg">
                               <button type="button" class="px-1.5 py-0.5 sm:px-2 sm:py-1 text-gray-600 hover:bg-gray-100 text-xs sm:text-sm" 
                                       @click="quantity = Math.max(1, quantity - 1)">-</button>
                               <input type="number" x-model="quantity" min="1" :max="stock" 
                                      class="w-8 sm:w-12 text-center border-0 text-xs sm:text-sm py-0.5 sm:py-1 focus:ring-0">
                               <button type="button" class="px-1.5 py-0.5 sm:px-2 sm:py-1 text-gray-600 hover:bg-gray-100 text-xs sm:text-sm" 
                                       @click="quantity = Math.min(stock, quantity + 1)">+</button>
                           </div>
                       </div>
                       
                       <!-- Add to Cart Button -->
                       <button class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-2 py-1.5 sm:px-4 sm:py-2.5 md:py-3 rounded-lg text-xs sm:text-sm font-medium transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed shadow-md disabled:transform-none" 
                               :disabled="stock <= 0"
                               x-on:click="addToCart()">
                           <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13l2.5 2.5"></path>
                           </svg>
                           <span x-text="stock > 0 ? '+ Keranjang' : 'Habis'"></span>
                       </button>
                   </div>
               </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4 sm:mt-6 flex justify-center">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

<script>  
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace();
        updateCartCounter();
        
        // Listen for cart updates to refresh stock display
        window.addEventListener('storage', function(e) {
            if (e.key === 'cart') {
                // Refresh the page to update stock display
                location.reload();
            }
        });
        
        // Save products to localStorage
        const products = [
            @foreach($products as $product)
            {
                id: {{ $product->id }},
                name: "{{ addslashes($product->name) }}",
                price: {{ $product->price }},
                stock: {{ $product->stock }},
                size: "{{ addslashes($product->size) }}",
                category: "{{ addslashes($product->category) }}"
            }@if(!$loop->last),@endif
            @endforeach
        ];
        localStorage.setItem('products', JSON.stringify(products));
    });

    function showSweetAlert(icon, title, text) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            confirmButtonColor: '#22c55e',
            customClass: {
                popup: 'swal2-responsive'
            }
        });
    }
    
    function showCartNotification(quantity, productName, productSize) {
        const notification = document.getElementById('cart-notification');
        const message = document.getElementById('notification-message');
        
        if (!notification || !message) return;
        
        message.textContent = `${quantity} ${productName} (${productSize})`;
        
        notification.classList.remove('show');
        notification.offsetHeight;
        
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        setTimeout(() => {
            notification.classList.remove('show');
        }, 4000);
    }
    
    function updateCartCounter() {
        const cartCountElement = document.getElementById('cart-count');
        const mobileCartCountElement = document.getElementById('mobile-cart-count');
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
        
        [cartCountElement, mobileCartCountElement].forEach(element => {
            if (element) {
                if (totalItems > 0) {
                    element.textContent = totalItems;
                    element.classList.remove('hidden');
                } else {
                    element.classList.add('hidden');
                }
            }
        });
    }
    
    // Function to clear cart (you can call this when transaction is completed)
    function clearCart() {
        localStorage.removeItem('cart');
        updateCartCounter();
        location.reload(); // Refresh to update stock display
    }
</script>
</body>
</html>