<header class="fixed top-0 left-0 w-full flex items-center justify-between px-6 shadow-md z-40 bg-gradient-to-tr from-[#D5A4CF] to-[#B689B0]" style="height: 68px;">
    <div class="flex-1"></div> <!-- Spacer untuk menjaga posisi -->

    <!-- User Dropdown dengan Alpine.js -->
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="flex items-center space-x-2">
            <span class="bg-purple-500 text-white font-bold px-3 py-1 rounded-md">
                {{ Auth::user()->name }}
            </span>
            <svg class="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-180': open }" 
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="open" @click.away="open = false" 
             x-transition:enter="transition ease-out duration-200 transform opacity-0 scale-95"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150 transform opacity-100 scale-100"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="absolute right-0 mt-2 bg-white border rounded shadow-lg w-48 origin-top-right z-50">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-purple-300">Profile</a>
            <a href="{{ route('logout') }}" class="block px-4 py-2 hover:bg-purple-300">Logout</a>
        </div>
    </div>
</header>

<!-- Spacer untuk menghindari konten tertutup oleh header -->
<div class="h-16"></div>
