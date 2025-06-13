@php
    $currentRoute = Route::currentRouteName();
@endphp

<div x-data="{ openSidebar: false }">
    <!-- Toggle Button for Mobile -->
    <button @click="openSidebar = !openSidebar" class="fixed top-4 left-4 z-50 p-2 rounded-md md:hidden">
        <i class="bx text-white bx-menu text-2xl"></i>
    </button>

    <!-- Sidebar -->
    <aside 
        :class="openSidebar ? 'translate-x-0' : '-translate-x-full'"
        class="font-serif  font-bold   fixed inset-y-0 left-0 shadow-md w-60 z-50 bg-[#34495E] flex flex-col h-screen transition-transform duration-300 md:translate-x-0">
        
        <!-- Header Section -->
        <div class="px-4 py-4 flex justify-between items-center">
            <h1 class="font-bold w-32 h-auto xl:text  rounded-full ml-6">
                <img src="{{ asset('img/logo_update.png') }}" alt="Logo" class="mx-auto">
            </h1>
            <button @click="openSidebar = false" class="md:hidden text-white text-2xl">
                <i class="bx bx-x"></i>
            </button>
        </div>

        <!-- Navigation -->
        <div class="flex-grow overflow-y-auto p-4">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('dashboard.index') }}" 
                       class="flex items-center py-3 px-4 rounded-xl text-sm 
                              {{ $currentRoute === 'dashboard.index' ? 'bg-white text-yellow-900' : 'text-white hover:bg-white hover:text-yellow-900' }}">
                        <i class="bx bxs-home text-3xl mr-3"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.products.menu') }}" 
                       class="flex items-center py-3 px-4 rounded-xl text-sm 
                              {{ $currentRoute === 'dashboard.products.menu' ? 'bg-white text-yellow-900' : 'text-white hover:bg-white hover:text-yellow-900' }}">
                        <i class="bx bx-box text-3xl mr-3"></i> Product
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.products.index') }}" 
                       class="flex items-center py-3 px-4 rounded-xl text-sm 
                              {{ $currentRoute === 'dashboard.products.index' ? 'bg-white text-yellow-900' : 'text-white hover:bg-white hover:text-yellow-900' }}">
                        <i class="bx bxs-package text-3xl mr-3"></i> Kelola Barang
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.transactions.index') }}" 
                       class="flex items-center py-3 px-4 rounded-xl text-sm 
                              {{ $currentRoute === 'dashboard.transactions.index' ? 'bg-white text-yellow-900' : 'text-white hover:bg-white hover:text-yellow-900' }}">
                        <i class="bx bx-transfer-alt text-3xl mr-3"></i> Transaksi
                        <span id="cart-count" class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full hidden">0</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.company_profile.edit', 1) }}" 
                       class="flex items-center py-3 px-4 rounded-xl text-sm 
                              {{ $currentRoute === 'dashboard.company_profile.edit' ? 'bg-white text-yellow-900' : 'text-white hover:bg-white hover:text-yellow-900' }}">
                        <i class="bx bx-edit-alt text-3xl mr-3"></i> Company Profile
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.contact.index') }}" 
                       class="flex items-center py-3 px-4 rounded-xl text-sm 
                              {{ $currentRoute === 'dashboard.contact.index' ? 'bg-white text-yellow-900' : 'text-white hover:bg-white hover:text-yellow-900' }}">
                        <i class="bx bxs-envelope text-3xl mr-3"></i> FeedBack
                    </a>
                </li>

                <li x-data="{ open: {{ in_array($currentRoute, ['dashboard.income', 'dashboard.expenses.index']) ? 'true' : 'false' }} }">
                    <a @click="open = !open" 
                       class="flex items-center justify-between py-3 px-4 rounded-xl text-sm text-white hover:bg-white hover:text-yellow-900 cursor-pointer">
                        <div class="flex items-center">
                            <i class='bx bxs-report text-3xl mr-3'></i> Laporan
                        </div>
                        <i class="bx bx-chevron-down text-lg" :class="{'rotate-180': open}"></i>
                    </a>
                    <ul x-show="open" x-collapse class="mt-2 ml-6 space-y-2">
                        <li>
                            <a href="{{ route('dashboard.income') }}" 
                               class="block py-2 px-4 rounded-lg text-sm 
                                      {{ $currentRoute === 'dashboard.income' ? 'bg-white text-yellow-900' : 'text-white hover:text-yellow-900 hover:bg-white' }}">
                                <i class='bx bx-money text-xl mr-2'></i> Pemasukan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.expenses.index') }}" 
                               class="block py-2 px-4 rounded-lg text-sm 
                                      {{ $currentRoute === 'dashboard.expenses.index' ? 'bg-white text-yellow-900' : 'text-white hover:text-yellow-900 hover:bg-white' }}">
                                <i class='bx bx-credit-card text-xl mr-2'></i> Pengeluaran
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- Logout -->
        <div class="p-5">
            <button onclick="confirmLogout(event)" 
               class="inline-flex items-center justify-center h-9 px-4 rounded-xl bg-gray-100 hover:bg-gray-300  hover:text-yellow-900 text-sm ml-10 transition">
                <i class='bx bx-log-out text-[#000]'></i>
                <span class="font-bold text-[#000] text-sm ml-2">Logout</span>
            </button>
        </div>
    </aside>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmLogout() {
    Swal.fire({
        title: 'Konfirmasi Logout',
        text: 'Apakah Anda yakin ingin keluar dari sistem?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Logout!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Tampilkan loading
            Swal.fire({
                title: 'Logging out...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Redirect ke logout route
            window.location.href = "{{ route('logout') }}";
        }
    });
}
</script>