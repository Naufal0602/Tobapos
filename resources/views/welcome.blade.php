@php
    use App\Models\Product;
    use App\Models\CompanyProfiles;


    $company_profile = CompanyProfiles::all();
    
    
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


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Eceu BAko</title>
    <link href="https://fonts.googleapis.com/css2?family=Fightree&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/logo_v2.png')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
  </head>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700&display=swap');
    body {
      font-family: 'Figtree', sans-serif;
    }
   /* Add these styles to your existing CSS */
.navbar {
  transition: background-color 0.3s ease, color 0.3s ease;
}

.navbar-menu {
    transition: transform 0.3s ease-in-out;
  }

  .navbar-menu.hidden {
    transform: translateX(-100%);
  }

  .navbar-menu.visible {
    transform: translateX(0);
  }

#main-header {
  transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

#main-header.bg-transparent {
  background-color: transparent;
  box-shadow: none;
}

#main-header.bg-white {
  background-color: white;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.navbar.text-white .nav-link {
  color: white;
}

.active-nav-link {
  color: #F05053 !important; /* Blue-600 color */
  position: relative;
  animation:transition-transform duration-300
}

.active-nav-link::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: -2px;
  width: 100% !important;
  height: 2px;
  background-color:  #F05053;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @keyframes slideIn {
    from { opacity: 0; transform: translateX(-50px); }
    to { opacity: 1; transform: translateX(0); }
  }

  .animate-fade-in { animation: fadeIn 2s ease-in-out forwards; }
  .animate-slide-in { animation: slideIn 1s ease-in-out forwards; }
  
  .responsive-category-select select::-webkit-scrollbar {
    width: 8px;
}

.responsive-category-select select::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.responsive-category-select select::-webkit-scrollbar-thumb {
    background: #10b981;
    border-radius: 4px;
}

.responsive-category-select select::-webkit-scrollbar-thumb:hover {
    background: #059669;
}

/* Animation for cards */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.grid > div {
    animation: fadeInUp 0.6s ease-out forwards;
}

.grid > div:nth-child(1) { animation-delay: 0.1s; }
.grid > div:nth-child(2) { animation-delay: 0.2s; }
.grid > div:nth-child(3) { animation-delay: 0.3s; }
.grid > div:nth-child(4) { animation-delay: 0.4s; }

/* Responsive improvements */
@media (max-width: 640px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .grid {
        gap: 1.5rem;
    }
    
    .responsive-category-select .flex {
        gap: 1rem;
    }
    
    .responsive-category-select select {
        font-size: 0.875rem;
        padding: 0.75rem;
    }
}

/* Premium hover effects */
.group:hover .bg-green-600 {
    background: linear-gradient(135deg, #059669, #10b981);
}

/* Custom pagination styles */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
}

.pagination a,
.pagination span {
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    font-weight: 600;
    transition: all 0.3s;
}

.pagination a {
    background: white;
    color: #059669;
    border: 2px solid #d1fae5;
}

.pagination a:hover {
    background: #059669;
    color: white;
    transform: translateY(-2px);
    shadow: 0 10px 25px rgba(5, 150, 105, 0.3);
}

.pagination .active span {
    background: #059669;
    color: white;
    border: 2px solid #059669;
}
 
</style>
<body class="bg-[#ffff]" style="font-family: 'Fightree';">
 <header id="main-header" class="fixed w-full top-0 shadow-md z-10 transition-all duration-300">
  <nav id="navbar" class="relative px-4 py-4 flex justify-between items-center transition-all duration-300">
    <a class="text-3xl font-bold leading-none" href="#">
      <svg class="h-10" alt="logo" viewBox="0 0 10240 10240">
        <path xmlns="http://www.w3.org/2000/svg" d="M8284 9162 c-2 -207 -55 -427 -161 -667 -147 -333 -404 -644 -733 -886 -81 -59 -247 -169 -256 -169 -3 0 -18 -9 -34 -20 -26 -19 -344 -180 -354 -180 -3 0 -29 -11 -58 -24 -227 -101 -642 -225 -973 -290 -125 -25 -397 -70 -480 -80 -22 -3 -76 -9 -120 -15 -100 -13 -142 -17 -357 -36 -29 -2 -98 -7 -153 -10 -267 -15 -436 -28 -525 -40 -14 -2 -45 -7 -70 -10 -59 -8 -99 -14 -130 -20 -14 -3 -41 -7 -60 -11 -19 -3 -39 -7 -45 -8 -5 -2 -28 -6 -50 -10 -234 -45 -617 -165 -822 -257 -23 -10 -45 -19 -48 -19 -7 0 -284 -138 -340 -170 -631 -355 -1107 -842 -1402 -1432 -159 -320 -251 -633 -308 -1056 -26 -190 -27 -635 -1 -832 3 -19 7 -59 10 -89 4 -30 11 -84 17 -120 6 -36 12 -77 14 -91 7 -43 33 -174 39 -190 3 -8 7 -28 9 -45 6 -35 52 -221 72 -285 7 -25 23 -79 35 -120 29 -99 118 -283 189 -389 67 -103 203 -244 286 -298 75 -49 178 -103 196 -103 16 0 27 16 77 110 124 231 304 529 485 800 82 124 153 227 157 230 3 3 28 36 54 74 116 167 384 497 546 671 148 160 448 450 560 542 14 12 54 45 90 75 88 73 219 172 313 238 42 29 77 57 77 62 0 5 -13 34 -29 66 -69 137 -149 405 -181 602 -7 41 -14 82 -15 90 -1 8 -6 46 -10 83 -3 37 -8 77 -10 88 -2 11 -7 65 -11 122 -3 56 -8 104 -9 107 -2 3 0 12 5 19 6 10 10 8 15 -10 10 -34 167 -346 228 -454 118 -210 319 -515 340 -515 4 0 40 18 80 40 230 128 521 255 787 343 118 40 336 102 395 113 28 5 53 11 105 23 25 5 59 12 75 15 17 3 41 8 55 11 34 7 274 43 335 50 152 18 372 29 565 29 194 0 481 -11 489 -19 2 -3 -3 -6 -12 -6 -9 -1 -20 -2 -24 -3 -33 -8 -73 -16 -98 -21 -61 -10 -264 -56 -390 -90 -649 -170 -1243 -437 -1770 -794 -60 -41 -121 -82 -134 -93 l-24 -18 124 -59 c109 -52 282 -116 404 -149 92 -26 192 -51 220 -55 17 -3 64 -12 105 -21 71 -14 151 -28 230 -41 19 -3 46 -7 60 -10 14 -2 45 -7 70 -10 25 -4 56 -8 70 -10 14 -2 53 -7 88 -10 35 -4 71 -8 81 -10 10 -2 51 -6 92 -9 101 -9 141 -14 147 -21 3 -3 -15 -5 -39 -6 -24 0 -52 -2 -62 -4 -21 -4 -139 -12 -307 -22 -242 -14 -700 -7 -880 13 -41 4 -187 27 -250 39 -125 23 -274 68 -373 111 -43 19 -81 34 -86 34 -4 0 -16 -8 -27 -17 -10 -10 -37 -33 -59 -52 -166 -141 -422 -395 -592 -586 -228 -257 -536 -672 -688 -925 -21 -36 -43 -66 -47 -68 -4 -2 -8 -7 -8 -11 0 -5 -24 -48 -54 -97 -156 -261 -493 -915 -480 -935 2 -3 47 -21 101 -38 54 -18 107 -36 118 -41 58 -25 458 -138 640 -181 118 -27 126 -29 155 -35 14 -2 45 -9 70 -14 66 -15 137 -28 300 -55 37 -7 248 -33 305 -39 28 -3 84 -9 125 -13 163 -16 792 -8 913 12 12 2 58 9 102 15 248 35 423 76 665 157 58 19 134 46 170 60 86 33 344 156 348 166 2 4 8 7 13 7 14 0 205 116 303 184 180 126 287 216 466 396 282 281 511 593 775 1055 43 75 178 347 225 455 100 227 236 602 286 790 59 220 95 364 120 485 6 28 45 245 50 275 2 14 7 41 10 60 3 19 8 49 10 65 2 17 6 46 9 65 15 100 35 262 40 335 3 39 8 89 10 112 22 225 33 803 21 1043 -3 41 -7 129 -11 195 -3 66 -8 136 -10 155 -2 19 -6 76 -10 125 -3 50 -8 101 -10 115 -2 14 -6 57 -10 95 -7 72 -12 113 -20 175 -2 19 -7 55 -10 80 -6 46 -43 295 -51 340 -2 14 -9 54 -15 90 -5 36 -16 97 -24 135 -8 39 -17 84 -20 100 -12 68 -18 97 -50 248 -19 87 -47 204 -61 260 -14 56 -27 109 -29 117 -30 147 -232 810 -253 832 -4 4 -7 -23 -8 -60z"></path>
      </svg>
    </a>
    <div class="lg:hidden">
      <button class="navbar-burger flex items-center text-blue-600 p-3">
        <svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <title>Mobile menu</title>
          <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
        </svg>
      </button>
    </div>
    <ul class="hidden lg:flex space-x-10 justify-center text-center">
      <li><a href="#home" class="nav-link relative text-gray-600 hover:text-blue-600 transition duration-300 transform hover:scale-110 font-bold after:content-[''] after:absolute after:left-0 after:bottom-[-2px] after:w-0 after:h-[2px] after:bg-purple-700 after:transition-all after:duration-300 hover:after:w-full">Home</a></li>
      <li><a href="#about" class="nav-link relative text-gray-600 hover:text-blue-600 transition duration-300 transform hover:scale-110 font-bold after:content-[''] after:absolute after:left-0 after:bottom-[-2px] after:w-0 after:h-[2px] after:bg-purple-700 after:transition-all after:duration-300 hover:after:w-full">About Us</a></li>
      <li><a href="#products" class="nav-link relative text-gray-600 hover:text-blue-600 transition duration-300 transform hover:scale-110 font-bold after:content-[''] after:absolute after:left-0 after:bottom-[-2px] after:w-0 after:h-[2px] after:bg-purple-700 after:transition-all after:duration-300 hover:after:w-full">Products</a></li>
      <li><a href="#contact" class="nav-link relative text-gray-600 hover:text-blue-600 transition duration-300 transform hover:scale-110 font-bold after:content-[''] after:absolute after:left-0 after:bottom-[-2px] after:w-0 after:h-[2px] after:bg-purple-700 after:transition-all after:duration-300 hover:after:w-full">Contact</a></li>
    </ul>
    
    <a class="hidden text-2xl lg:inline-block py-2 px-6 animate-bounce text-white font-bold rounded-xl transition duration-200" href="#"><span class="text-gray-400">Toba</span><span class="text-purple-600">Pos</span></a>
  </nav>
 <div class="navbar-menu relative z-50 hidden">
  <div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"></div>
  {{-- mobile menu --}}
    <nav class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6 border-r overflow-y-auto bg-gradient-to-b from-[#928DAB] to-[#7303c0] translate-x-0 transition-transform duration-300 ease-in-out" data-aos="fade-right" style="animation-duration: 2ms; animation-fill-mode: forwards;">
      <div class="flex items-center mb-8">
        <a class="mr-auto text-3xl font-bold leading-none" href="#">
          <svg class="h-12" alt="logo" viewBox="0 0 10240 10240">
            <path xmlns="http://www.w3.org/2000/svg" d="M8284 9162 c-2 -207 -55 -427 -161 -667 -147 -333 -404 -644 -733 -886 -81 -59 -247 -169 -256 -169 -3 0 -18 -9 -34 -20 -26 -19 -344 -180 -354 -180 -3 0 -29 -11 -58 -24 -227 -101 -642 -225 -973 -290 -125 -25 -397 -70 -480 -80 -22 -3 -76 -9 -120 -15 -100 -13 -142 -17 -357 -36 -29 -2 -98 -7 -153 -10 -267 -15 -436 -28 -525 -40 -14 -2 -45 -7 -70 -10 -59 -8 -99 -14 -130 -20 -14 -3 -41 -7 -60 -11 -19 -3 -39 -7 -45 -8 -5 -2 -28 -6 -50 -10 -234 -45 -617 -165 -822 -257 -23 -10 -45 -19 -48 -19 -7 0 -284 -138 -340 -170 -631 -355 -1107 -842 -1402 -1432 -159 -320 -251 -633 -308 -1056 -26 -190 -27 -635 -1 -832 3 -19 7 -59 10 -89 4 -30 11 -84 17 -120 6 -36 12 -77 14 -91 7 -43 33 -174 39 -190 3 -8 7 -28 9 -45 6 -35 52 -221 72 -285 7 -25 23 -79 35 -120 29 -99 118 -283 189 -389 67 -103 203 -244 286 -298 75 -49 178 -103 196 -103 16 0 27 16 77 110 124 231 304 529 485 800 82 124 153 227 157 230 3 3 28 36 54 74 116 167 384 497 546 671 148 160 448 450 560 542 14 12 54 45 90 75 88 73 219 172 313 238 42 29 77 57 77 62 0 5 -13 34 -29 66 -69 137 -149 405 -181 602 -7 41 -14 82 -15 90 -1 8 -6 46 -10 83 -3 37 -8 77 -10 88 -2 11 -7 65 -11 122 -3 56 -8 104 -9 107 -2 3 0 12 5 19 6 10 10 8 15 -10 10 -34 167 -346 228 -454 118 -210 319 -515 340 -515 4 0 40 18 80 40 230 128 521 255 787 343 118 40 336 102 395 113 28 5 53 11 105 23 25 5 59 12 75 15 17 3 41 8 55 11 34 7 274 43 335 50 152 18 372 29 565 29 194 0 481 -11 489 -19 2 -3 -3 -6 -12 -6 -9 -1 -20 -2 -24 -3 -33 -8 -73 -16 -98 -21 -61 -10 -264 -56 -390 -90 -649 -170 -1243 -437 -1770 -794 -60 -41 -121 -82 -134 -93 l-24 -18 124 -59 c109 -52 282 -116 404 -149 92 -26 192 -51 220 -55 17 -3 64 -12 105 -21 71 -14 151 -28 230 -41 19 -3 46 -7 60 -10 14 -2 45 -7 70 -10 25 -4 56 -8 70 -10 14 -2 53 -7 88 -10 35 -4 71 -8 81 -10 10 -2 51 -6 92 -9 101 -9 141 -14 147 -21 3 -3 -15 -5 -39 -6 -24 0 -52 -2 -62 -4 -21 -4 -139 -12 -307 -22 -242 -14 -700 -7 -880 13 -41 4 -187 27 -250 39 -125 23 -274 68 -373 111 -43 19 -81 34 -86 34 -4 0 -16 -8 -27 -17 -10 -10 -37 -33 -59 -52 -166 -141 -422 -395 -592 -586 -228 -257 -536 -672 -688 -925 -21 -36 -43 -66 -47 -68 -4 -2 -8 -7 -8 -11 0 -5 -24 -48 -54 -97 -156 -261 -493 -915 -480 -935 2 -3 47 -21 101 -38 54 -18 107 -36 118 -41 58 -25 458 -138 640 -181 118 -27 126 -29 155 -35 14 -2 45 -9 70 -14 66 -15 137 -28 300 -55 37 -7 248 -33 305 -39 28 -3 84 -9 125 -13 163 -16 792 -8 913 12 12 2 58 9 102 15 248 35 423 76 665 157 58 19 134 46 170 60 86 33 344 156 348 166 2 4 8 7 13 7 14 0 205 116 303 184 180 126 287 216 466 396 282 281 511 593 775 1055 43 75 178 347 225 455 100 227 236 602 286 790 59 220 95 364 120 485 6 28 45 245 50 275 2 14 7 41 10 60 3 19 8 49 10 65 2 17 6 46 9 65 15 100 35 262 40 335 3 39 8 89 10 112 22 225 33 803 21 1043 -3 41 -7 129 -11 195 -3 66 -8 136 -10 155 -2 19 -6 76 -10 125 -3 50 -8 101 -10 115 -2 14 -6 57 -10 95 -7 72 -12 113 -20 175 -2 19 -7 55 -10 80 -6 46 -43 295 -51 340 -2 14 -9 54 -15 90 -5 36 -16 97 -24 135 -8 39 -17 84 -20 100 -12 68 -18 97 -50 248 -19 87 -47 204 -61 260 -14 56 -27 109 -29 117 -30 147 -232 810 -253 832 -4 4 -7 -23 -8 -60z" fill="white"></path>
          </svg>
        </a>
        <button class="navbar-close">
          <svg class="h-6 w-6 text-white cursor-pointer hover:text-purple-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <div>
        <ul>
          <li class="mb-1">
            <a class="block p-4 text-sm font-semibold text-white hover:bg-purple-700 hover:text-white rounded transition duration-300" href="#home">Home</a>
          </li>
          <li class="mb-1">
            <a class="block p-4 text-sm font-semibold text-white hover:bg-purple-700 hover:text-white rounded transition duration-300" href="#about">About Us</a>
          </li>
          <li class="mb-1">
            <a class="block p-4 text-sm font-semibold text-white hover:bg-purple-700 hover:text-white rounded transition duration-300" href="#products">Product</a>
          </li>
          <li class="mb-1">
            <a class="block p-4 text-sm font-semibold text-white hover:bg-purple-700 hover:text-white rounded transition duration-300" href="#contact">Contact</a>
          </li>
        </ul>
      </div>
      <div class="mt-auto">
        <div class="pt-6">
          <div class="block px-4 py-3 mb-2 leading-loose text-4xl text-center font-semibold">
            <span class="text-[#928DAB] font-bold">Toba</span>
            <span class="text-white font-bold">Pos</span>
          </div>           
        </div>
      </div>
    </nav>
  </div>
</header>

    <!-- Hero Section -->
<section id="home" class="relative w-full lg:h-full md:h-fit flex flex-col xl:ml-9 md:flex-row items-center justify-between px-4 sm:px-6 py-12">
  @foreach($company_profile as $home)
  <!-- Konten teks -->
  <div class="w-full lg:ml-10 md:w-1/2 space-y-4 text-[#33495E] text-center md:text-left animate-fade-in">
    <p class="font-semibold text-lg md:text-xl leading-tight md:mb-0">Sensasi baru</p>
    <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold leading-tight" style="font-family: 'Fightree';">
      Kualitas Premium<br/>
      Pilihan Tepat Buat Kamu!
    </h1>
    <p class="text-base md:text-lg lg:text-xl">
      {{ $home->home_description }}
    </p>
    <div class="mt-4 justify-center">
      <a href="#products" class="px-6 py-3 mb-3 bg-[#33495E] text-white rounded-full shadow-md hover:bg-brown-800 transition-transform transform hover:scale-105 inline-block">Lihat Produk</a>
    </div>
  </div>

<!-- Container Produk -->
<div class="w-full md:w-1/2 relative px-4 sm:px-6 md:px-8 pb-10 sm:pb-16 md:pb-20 md:mb-9 sm:py-6 md:mt-10 lg:py-10 xl:py-12">
  <div class="relative w-full max-w-xs mx-auto group aspect-[3/4]">
      <!-- Gambar belakang -->
      <img src="{{ asset('img/tembakau_1.png') }}" alt="Produk Belakang" 
           class="absolute inset-0 w-full h-full object-cover rounded-xl 
           rotate-6 transition-all duration-300 group-hover:scale-105 
           group-hover:rotate-[-2deg] z-0" />

      <!-- Gambar depan -->
      <img src="{{ asset('img/tembakau-2.png') }}" alt="Produk Depan" 
           class="absolute inset-0 w-full h-full object-cover rounded-xl 
           -rotate-12 transition-all duration-300 group-hover:scale-110 
           z-1" />
  </div>
</div>

@endforeach
</section>
    
    
    <!-- About Section -->
 <section id="about" class="md:h-fit lg:h-screen  flex flex-col lg:flex-row items-center gap-10 px-8 md:px-16">
  @foreach($company_profile as $about)
        <!-- Bagian Gambar dengan Efek Animasi -->
        <div 
            class="relative w-full lg:w-1/2 flex justify-center"
            data-aos="fade-right">
            <!-- Lingkaran Dekoratif -->
            <div class="absolute top-0 left-0 w-[60%] h-[60%] bg-yellow-300 rounded-full -z-10 animate-pulse"></div>
            
            <!-- Gambar dengan Efek Hover -->
            <img src="{{ asset('storage/' . $companyProfile->img_description) }}" 
                alt="Tentang Kami" 
                class="w-full max-w-md md:max-w-lg rounded-full shadow-xl transform transition duration-300 hover:scale-105">
        </div>
    
        <!-- Bagian Deskripsi -->
        <div 
            class="w-full lg:w-1/2 text-center lg:text-left"
            data-aos="fade-left">
            <h2 class="text-xl font-bold text-gray-600 uppercase tracking-wide">Tentang</h2>
            <h1 class="text-4xl md:text-5xl font-bold text-black italic mb-4">
                TobaPOS
            </h1>
            <p class="text-lg md:text-xl text-gray-700 leading-relaxed">
                Kami membawa tradisi tembakau berkualitas ke dalam era modern. Dengan kerja sama petani lokal, setiap produk kami dibuat dengan dedikasi tinggi untuk memberikan pengalaman terbaik bagi pelanggan.
            </p>
            <button id="learn-more-btn"
                class="mt-6 px-6 py-3 bg-[#33495E] text-white font-semibold rounded-full shadow-lg hover:bg-red-700 transform transition-all duration-300 hover:scale-110">
                Lebih banyak
            </button>
        </div>
   
        <!-- Modal -->
        <div id="about-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 p-4 transition-opacity">
        <div class="bg-white rounded-lg max-w-lg p-6 md:p-8 shadow-xl relative animate-fadeIn">
            <h3 class="text-2xl md:text-3xl font-bold text-purple-800 mb-4 text-center">
                Cerita Kami
            </h3>
            <p class="text-gray-700 text-base md:text-lg leading-relaxed">
              {{ $about->about_description }}
            </p>
            <button id="close-modal-btn"
                class="w-full py-2 mt-4 bg-purple-700 text-white font-semibold rounded-lg hover:bg-purple-800 transition-all">
                Tutup
            </button>
        </div>
       </div>
       @endforeach
  </section>
    
    

    <!-- Products Section -->
  <section id="products" class="py-16 bg-gradient-to-b from-green-50 to-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h2 class="text-4xl sm:text-5xl font-bold mb-4 text-green-800">
                Daftar Produk Kami
            </h2>
            <div class="w-24 h-1 bg-green-600 mx-auto mb-6"></div>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Temukan koleksi produk berkualitas tinggi dengan cita rasa yang tak terlupakan
            </p>
        </div>
        
        <!-- Filter Section -->
        <div class="mb-12">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-green-100">
                <form method="GET" action="{{ url('/') }}" class="responsive-category-select">
                    <div class="flex flex-col md:flex-row justify-center gap-6">
                        <!-- Category Filter -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-green-800 mb-2">Kategori Produk</label>
                            <select name="category" onchange="this.form.submit()" 
                                    class="w-full md:w-64 p-4 border-2 border-green-200 rounded-xl shadow-sm bg-white text-gray-700 focus:ring-4 focus:ring-green-200 focus:border-green-500 transition-all duration-300 appearance-none cursor-pointer hover:border-green-400">
                                <option value="">🌟 Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category }}" {{ request('category') == $category->category ? 'selected' : '' }}>
                                        {{ ucfirst($category->category) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none mt-8">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Size Filter -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-green-800 mb-2">Ukuran</label>
                            <select name="size" onchange="this.form.submit()" 
                                    class="w-full md:w-64 p-4 border-2 border-green-200 rounded-xl shadow-sm bg-white text-gray-700 focus:ring-4 focus:ring-green-200 focus:border-green-500 transition-all duration-300 appearance-none cursor-pointer hover:border-green-400">
                                <option value="">📏 Semua Ukuran</option>
                                @foreach($sizes as $size)
                                    <option value="{{ $size->size }}" {{ request('size') == $size->size ? 'selected' : '' }}>
                                        {{ ucfirst($size->size) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none mt-8">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach ($products as $product)
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-green-100 hover:border-green-300 transform hover:-translate-y-2">
                <!-- Product Image -->
                <div class="relative overflow-hidden">
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="Gambar {{ $product->name }}"
                         class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500" />
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <!-- Premium Badge -->
                    <div class="absolute top-4 left-4">
                        <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                            Premium
                        </span>
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-green-700 transition-colors duration-300">
                            {{ $product->name }}
                        </h3>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                {{ ucfirst($product->category) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Product Details -->
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V6a2 2 0 012-2h12a2 2 0 012 2v2m-6 12V10m0 0l3-3m-3 3l-3-3"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ $product->size }}</span>
                        </div>
                    </div>
                    
                    <!-- Price -->
                    <div class="flex justify-between items-center">
                        <div class="text-center flex gap-5">
                            <p class="text-2xl font-bold text-green-700">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <p class="text-sm items-center text-center text-gray-500">Harga terbaik</p>
                        </div>
                    </div>
                </div>
                
                <!-- Bottom accent -->
                <div class="h-1 bg-gradient-to-r from-green-400 to-green-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
            </div>
            @endforeach
        </div>
        
        <!-- No Products Message -->
        @if($products->isEmpty())
        <div class="text-center py-16">
            <div class="bg-white rounded-2xl shadow-lg p-12 max-w-md mx-auto border border-green-100">
                <svg class="w-16 h-16 text-green-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.467.901-6.06 2.37l-.894-.894C6.068 15.454 8.92 14 12 14s5.932 1.454 6.954 2.476l-.894.894A7.962 7.962 0 0112 15z"></path>
                </svg>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Tidak ada produk ditemukan</h3>
                <p class="text-gray-500">Coba ubah filter pencarian Anda</p>
            </div>
        </div>
        @endif
        
        <!-- Pagination -->
        <div class="mt-16">
            <div class="flex justify-center">
                <div class="bg-white rounded-2xl shadow-lg p-4 border border-green-100">
                    {{ $products->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-green-200 rounded-full opacity-10"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-green-300 rounded-full opacity-10"></div>
    </div>
</section>
    
    
        
    <!-- Contact Section -->
    <section id="contact" class="py-16">
      <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">Contact Me</h2>
        <div class="flex flex-col md:flex-row items-center md:items-start justify-between space-y-8 md:space-y-0 md:space-x-8">
          <!-- Google Maps -->
          <div class="w-full h-full sm:h-56 md:w-1/2 rounded-lg" style="height: 531px;">
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2521.6435474205796!2d106.80093418777968!3d-6.562194482781595!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c30e3294cccd%3A0x1317f9c6c5e26c8d!2sJl.%20Pintu%20Ledeng%2C%20Ciomas%2C%20Kec.%20Ciomas%2C%20Kabupaten%20Bogor%2C%20Jawa%20Barat%2016610!5e0!3m2!1sen!2sid!4v1695745256000!5m2!1sen!2sid" 
              width="100%" 
              height="100%" 
              class="border-0"
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
          
      <!-- Contact Form -->
        <div class="w-full md:w-1/2 bg-gray-100 p-6 rounded-lg shadow-lg mt-20 mx-auto">
          <h2 class="text-4xl font-bold mb-4 justify-center text-center p-7">CONTACT US</h2>
          <form action="{{ route('send.message') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
              <label class="block text-[#33495E] text-sm font-bold mb-2">Name</label>
              <input type="text" name="name" class="w-full px-3 py-2 border border-purple-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#928DAB]" placeholder="Enter your name" required>
            </div>
            <div class="mb-4">
              <label class="block text-[#33495E] text-sm font-bold mb-2">Email</label>
              <input type="email" name="email" class="w-full px-3 py-2 border border-purple-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#928DAB]" placeholder="Enter your email" required>
            </div>
            <div class="mb-4">
              <label class="block text-[#33495E] text-sm font-bold mb-2">Message</label>
              <textarea type="text" name="message" class="w-full px-3 py-2 border border-purple-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#928DAB]" rows="4" placeholder="Enter your message" required></textarea>
            </div>
            <button type="submit" class="w-full bg-[#33495E] text-white py-2 rounded-lg hover:bg-[#8023d0] transition duration-300 font-medium">Kirim</button>          
          </form>
        </div>
        </div>
      </div>
    </section>
    
    <!-- Footer -->
    @foreach ($company_profile as $welcome)
    <footer class="bg-gray-900 text-gray-300 py-12">
      <div class="container mx-auto px-6 lg:px-12">
        
        <!-- Garis Gradasi -->
        <div class="w-full h-1 bg-gradient-to-r from-yellow-400 via-red-500 to-purple-600 mb-6"></div>
    
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          
          <!-- About Section -->
          <div>
            <img src="{{ asset('img/logo-v3.png') }}" alt="TobaPOS Logo" class="w-28 left-7 h-30 bg-white rounded-full hover:scale-105 transition duration-300" />
            <h2 class="text-lg font-semibold text-white mt-2">{{ $welcome->name }}</h2>
            <p class="text-sm text-gray-400 mt-2">
              Temukan produk terbaik dengan kualitas premium. Kepuasan pelanggan adalah prioritas kami.
            </p>
          </div>
    
          <!-- Quick Links -->
          <div class="text-center md:text-left">
            <h3 class="text-white font-semibold text-lg mb-3">Quick Links</h3>
            <ul class="space-y-2">
              <li><a href="#home" class="text-gray-400 hover:text-yellow-400 transition-all">🏠 Home</a></li>
              <li><a href="#about" class="text-gray-400 hover:text-yellow-400 transition-all">ℹ️ About</a></li>
              <li><a href="#products" class="text-gray-400 hover:text-yellow-400 transition-all">🛍️ Products</a></li>
              <li><a href="#contact" class="text-gray-400 hover:text-yellow-400 transition-all">📩 Contact</a></li>
            </ul>
          </div>
    
          <!-- Contact & Social Media -->
          <div class="text-center md:text-left">
            <h3 class="text-white font-semibold text-lg mb-3">Contact Us</h3>
            <p class="text-gray-400 text-sm">📍 {{ $welcome->address }}</p>
            <p class="text-gray-400 text-sm">📞 {{ $welcome->phone }}</p>
            <p class="text-gray-400 text-sm">✉️ {{ $welcome->email }}</p>
    
            <!-- Social Media -->
            <div class="flex justify-center md:justify-start space-x-4 mt-4">
              <a href="#" class="text-gray-400 hover:text-yellow-400 transition-all transform hover:scale-110">
                <i class="fab fa-facebook-f text-xl"></i>
              </a>
              <a href="#" class="text-gray-400 hover:text-yellow-400 transition-all transform hover:scale-110">
                <i class="fab fa-twitter text-xl"></i>
              </a>
              <a href="#" class="text-gray-400 hover:text-yellow-400 transition-all transform hover:scale-110">
                <i class="fab fa-instagram text-xl"></i>
              </a>
              <a href="#" class="text-gray-400 hover:text-yellow-400 transition-all transform hover:scale-110">
                <i class="fab fa-linkedin-in text-xl"></i>
              </a>
            </div>
          </div>
    
        </div>
    
        <!-- Copyright -->
        <div class="mt-8 text-center text-gray-500 text-sm">
          &copy; 2025 <span class="font-semibold text-yellow-400">TobaPOS</span>. All rights reserved.
        </div>
      </div>
      @endforeach
    </footer>
    
    <!-- FontAwesome untuk ikon sosial media -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    
            <!-- Notifikasi Modal -->
      @if(session('success'))
      <div x-data="{ open: true }" x-show="open" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
          <div class="bg-white p-6 rounded-lg shadow-lg w-96">
              <h2 class="text-lg font-semibold text-green-600">Sukses!</h2>
              <p class="mt-2 text-gray-700">{{ session('success') }}</p>
              <button @click="open = false" class="mt-4 w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-green-700 transition">Tutup</button>
          </div>
      </div>
      @endif
    
  </body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
    // Burger menus
    document.addEventListener('DOMContentLoaded', function() {
    // Burger menu functionality
    const burger = document.querySelectorAll('.navbar-burger');
    const menu = document.querySelectorAll('.navbar-menu');

    if (burger.length && menu.length) {
      for (var i = 0; i < burger.length; i++) {
        burger[i].addEventListener('click', function() {
          for (var j = 0; j < menu.length; j++) {
            menu[j].classList.toggle('hidden');
          }
        });
      }
    }

    // Close menu
    const close = document.querySelectorAll('.navbar-close');
    const backdrop = document.querySelectorAll('.navbar-backdrop');

    if (close.length) {
      for (var i = 0; i < close.length; i++) {
        close[i].addEventListener('click', function() {
          for (var j = 0; j < menu.length; j++) {
            menu[j].classList.toggle('hidden');
          }
        });
      }
    }

    if (backdrop.length) {
      for (var i = 0; i < backdrop.length; i++) {
        backdrop[i].addEventListener('click', function() {
          for (var j = 0; j < menu.length; j++) {
            menu[j].classList.toggle('hidden');
          }
        });
      }
    }

    // Get all sections for scroll tracking
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');
    const navbar = document.getElementById('navbar');
    const header = document.getElementById('main-header');
    
    // Initial check for home section to set proper navbar appearance
    if (window.scrollY < 50) {
      // At top of page - transparent for home section
      header.classList.remove('bg-white');
      header.classList.add('bg-transparent');
      navbar.classList.add('text-white');
    } else {
      // Scrolled down - add white background
      header.classList.add('bg-white');
      header.classList.remove('bg-transparent');
      navbar.classList.remove('text-white');
    }
    
    // Handle scroll events to update navbar appearance and active states
    function onScroll() {
      // Get current scroll position
      const scrollY = window.scrollY;
      
      // Update navbar appearance based on scroll position
      if (scrollY < 50) {
        // At top of page - transparent for home section
        header.classList.remove('bg-white');
        header.classList.add('bg-transparent');
        navbar.classList.add('text-white');
      } else {
        // Scrolled down - add white background
        header.classList.add('bg-white');
        header.classList.remove('bg-transparent');
        navbar.classList.remove('text-white');
      }
      
      // Determine which section is currently in view
      sections.forEach(section => {
        const sectionTop = section.offsetTop - 100; // Adjust offset as needed
        const sectionHeight = section.offsetHeight;
        const sectionId = section.getAttribute('id');
        
        if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
          // If in this section, activate corresponding nav link
          navLinks.forEach(link => {
            link.classList.remove('text-blue-600', 'after:w-full');
            if (link.getAttribute('href') === `#${sectionId}`) {
              link.classList.add('text-blue-600', 'after:w-full');
            }
          });
        }
      });
    }
    
    // Add scroll listener
    window.addEventListener('scroll', onScroll);
    
    // Initial call to set correct state on page load
    onScroll();
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);
        
        if (targetElement) {
          const targetPosition = targetElement.offsetTop;
          window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
          });
        }
      });
    });
  });
  const modal = document.getElementById("about-modal");
  const openBtn = document.getElementById("learn-more-btn");
  const closeBtn = document.getElementById("close-modal-btn");

  openBtn.addEventListener("click", () => {
    modal.classList.remove("hidden");
  });

  closeBtn.addEventListener("click", () => {
    modal.classList.add("hidden");
  });

  window.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.classList.add("hidden");
    }
  });

  window.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      modal.classList.add("hidden");
    }
  });

  window.addEventListener("scroll", function () {
    var header = document.getElementById("main-header");
    if (window.scrollY > 50) {
      header.classList.add("bg-gray-50");
    } else {
      header.classList.remove("bg-transparent");
    }
  });

  var swiper = new Swiper(".mySwiper", {
    loop: true,
    autoplay: { delay: 2500, disableOnInteraction: false },
    effect: "fade",
    fadeEffect: { crossFade: true },
  });
 
  AOS.init();
    setTimeout(() => {
        document.querySelector('[x-data]').remove();
    }, 3000); // Hilang setelah 3 detik

  </script>
  