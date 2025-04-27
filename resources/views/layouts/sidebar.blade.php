<!-- Tambahkan Alpine.js di root container -->
<div x-data="{ openSidebar: false }">
    <!-- Toggle Button for Mobile -->
    <button @click="openSidebar = !openSidebar" class="fixed top-4 left-4 z-50  p-2 rounded-md md:hidden">
        <i class="bx bx-menu text-2xl"></i>
    </button>

    <!-- Sidebar -->
    <aside 
        :class="openSidebar ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 shadow-md w-60 z-50 bg-gradient-to-tr from-[#D5A4CF] to-[#B689B0] flex flex-col h-screen transition-transform duration-300 md:translate-x-0">
        <!-- Header Section -->
        <div class="px-4 py-4 flex justify-between items-center">
            <h1 class="font-bold w-32 h-auto xl:text bg-white rounded-full ml-6">
                <img src="{{ asset('img/logo-v3.png') }}" alt="Logo" class="mx-auto">
            </h1>
            <!-- Close Button in Mobile -->
            <button @click="openSidebar = false" class="md:hidden text-black text-2xl">
                <i class="bx bx-x"></i>
            </button>
        </div>

        <!-- Navigation Links Section -->
        <div class="flex-grow overflow-y-auto p-4">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('dashboard.index') }}" class="flex items-center py-3 px-4 rounded-xl font-semibold text-sm text-black hover:bg-white hover:text-yellow-900">
                        <i class="bx bxs-home text-3xl mr-3"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.products.menu') }}" class="flex items-center py-3 px-4 rounded-xl font-semibold text-sm text-black hover:bg-white hover:text-yellow-900">
                        <i class="bx bx-box text-3xl mr-3"></i> Product
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.products.index') }}" class="flex items-center py-3 px-4 rounded-xl font-semibold text-sm text-black hover:bg-white hover:text-yellow-900">
                        <i class="bx bxs-package text-3xl mr-3"></i> Kelola Stok
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.transactions.index') }}" class="flex items-center py-3 px-4 rounded-xl font-semibold text-sm text-black hover:bg-white hover:text-yellow-900 relative">
                        <i class="bx bx-transfer-alt text-3xl mr-3"></i> Transaksi
                        <span id="cart-count" class="ml-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full hidden">0</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('dashboard.company_profile.edit', 1) }}" class="flex items-center py-3 px-4 rounded-xl font-semibold text-sm text-black hover:bg-white hover:text-yellow-900">
                        <i class="bx bx-edit-alt text-3xl mr-3"></i> Company Profile
                    </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.contact.index') }}" class="flex items-center py-3 px-4 rounded-xl font-semibold text-sm text-black hover:bg-white hover:text-yellow-900">
                        <i class="bx bxs-envelope text-3xl mr-3"></i> FeedBack
                    </a>
                </li>
                
                <li x-data="{ open: false }">
                    <a @click="open = !open" class="flex items-center justify-between py-3 px-4 rounded-xl font-semibold text-sm text-black hover:bg-white hover:text-yellow-900 cursor-pointer">
                        <div class="flex items-center">
                            <i class='bx bxs-report text-3xl mr-3'></i> Laporan
                        </div>
                        <i class="bx bx-chevron-down text-lg" :class="{'rotate-180': open}"></i>
                    </a>
                    <ul x-show="open" x-collapse class="mt-2 ml-6 space-y-2">
                        <li>
                            <a href="{{ route('dashboard.income') }}" class="block py-2 px-4 rounded-lg text-sm text-black hover:bg-yellow-100">
                                <i class='bx bx-money text-xl mr-2'></i> Pemasukan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.expenses.index') }}" class="block py-2 px-4 rounded-lg text-sm text-black hover:bg-yellow-100">
                                <i class='bx bx-credit-card text-xl mr-2'></i> Pengeluaran
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- Logout Section -->
        <div class="p-5">
            <a href="{{ route('logout') }}" onclick="confirmLogout(event)" class="inline-flex items-center justify-center h-9 px-4 rounded-xl bg-gray-100 text-purple-500 hover:text-black text-sm ml-10 font-semibold transition">
                <i class='bx bx-log-out'></i>
                <span class="font-bold text-sm ml-2">Logout</span>
            </a>
        </div>
    </aside>
</div>
<script>
    function updateCartCount() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let totalCount = cart.reduce((total, item) => total + item.quantity, 0);

        let cartBadge = document.getElementById('cart-count');
        if (totalCount > 0) {
            cartBadge.textContent = totalCount;
            cartBadge.classList.remove('hidden');
        } else {
            cartBadge.classList.add('hidden');
        }
    }

    // Mengecek perubahan data setiap 1 detik
    setInterval(updateCartCount, 1000);

    function addToCart(productId, productName, productPrice) {
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
        });
    }

    function confirmLogout(event) {
        event.preventDefault(); 
        Swal.fire({
            title: 'Konfirmasi Logout',
            text: 'Apakah Anda yakin ingin logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('logout') }}";
            }
        });
    }
    document.addEventListener('DOMContentLoaded', updateCartCount);
</script>

