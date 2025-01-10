<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TobaPOS</title>
  <script src="https://cdn.tailwindcss.com/3.2.0"></script>
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="bg-white">
  <!-- Navbar -->
  <header class="bg-gray-300 w-full h-20 flex items-center justify-between px-6 lg:px-10 shadow-md fixed top-0 z-10">
    <!-- Logo -->
    <img src="{{ asset('img/logo-01.png') }}" alt="Logo" class="h-12 w-auto">
  
    <button class="lg:hidden text-black focus:outline-none" id="menu-toggle">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
      </svg>
    </button>
  
    <nav id="desktop-menu" class="hidden lg:flex items-center space-x-6">
      <a href="#home" class="text-lg font-medium text-black hover:text-blue-100 hover:border-2 hover:bg-blue-500 hover:border-blue-100 transition duration-300">Home</a>
      <a href="#about" class="text-lg font-medium text-black hover:text-blue-100 hover:border-2 hover:bg-blue-500 hover:border-blue-100 transition duration-300">About</a>
      <a href="#contact" class="text-lg font-medium text-black hover:text-blue-100 hover:border-2 hover:bg-blue-500 hover:border-blue-100 transition duration-300">Contact</a>
    </nav>
  
    <!-- Desktop Login and Sign In Buttons -->
    <div class="hidden lg:flex items-center space-x-4">
      <a href="{{ route('login') }}"><button class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-2" >login</button></a>
        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Sign In</button>
    </div>
  </header>
  
  <!-- Mobile Navigation Menu -->
  <div id="mobile-menu" class="hidden flex-col bg-gray-300 p-4 space-y-4 lg:hidden">
    <a href="#" class="block text-lg font-medium text-black hover:text-blue-500">Home</a>
    <a href="#" class="block text-lg font-medium text-black hover:text-blue-500">About</a>
    <a href="#" class="block text-lg font-medium text-black hover:text-blue-500">Contact</a>
    <div class="mt-4">
      <a href="{{ route('login') }}"><button class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-2" >login</button>
    </a>
      <button class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Sign In</button>
    </div>
  </div>

  <section id="home_data" class="flex flex-col lg:flex-row items-center justify-center py-20 bg-white pt-24 gap-10 lg:gap-20">
    <img src="{{ asset('img/logo-01.png') }}" alt="Hero Logo" class="w-64 h-64 lg:w-80 lg:h-80 object-cover">
    <div class="text-center lg:text-left max-w-3xl">
      <h2 class="text-5xl lg:text-3xl font-bold text-black mb-6">WELLCOME TO TOBAPOS (Tembakau Poin Of 
        Sale)</h2>
      <p class="text-lg lg:text-xl text-gray-700 leading-relaxed">
        Kami menghadirkan tembakau berkualitas tinggi yang memadukan <br> tradisi,inovasi, dan dedikasi. <br> 
        Dengan mendukung petani lokal dan menjaga standar terbaik,<br> 
        kami bangga menjadi bagian dari setiap langkah menuju kepuasan Anda.<br>
        Temukan cita rasa dan kualitas terbaik bersama kami!.
      </p>
    </div>
  </section>
  

  <!-- About Us Section -->
  <section id="about" class="about py-20 bg-gray-200">
    <div class="max-w-6xl mx-auto text-center">
      <h2 class="text-3xl font-bold text-black mb-8">TENTANG KAMI</h2>
    <div class="max-w-6xl mx-auto flex items-center justify-center space-x-8">
      <img src="{{ asset('img/logo-01.png') }}" alt="Logo" class="h-auto w-auto items-start">
      <p class="text-lg text-gray-700 leading-relaxed max-w-4xl text-left">
        TobaPOS berdiri dengan semangat menghadirkan tembakau berkualitas yang memadukan tradisi dan inovasi. Sejak awal berdiri,kami telah bekerja bersama petani lokal terbaik, memastikan setiap helai tembakau diproses dengan dedikasi tinggi untuk menghasilkan produk unggulan. Berawal dari usaha kecil, kami kini tumbuh menjadi salah satu pemain utama di industri dengan berbagai pencapaian yang diakui. Komitmen kami tak hanya pada kualitas, tetapi juga pada keberlanjutan dan kesejahteraan komunitas.
Mari menjadi bagian dari perjalanan kami untuk terus menciptakan produk yang mencerminkan rasa dan keunggulan sejati.
      </p>
    </div>
  </section>
  
  
  


  <!-- Produk Section -->
  <section class="produk py-20" style="background: rgb(255, 255, 255)">
    <div class="max-w-6xl mx-auto text-center">
      <h2 class="text-3xl font-bold text-black mb-8">Produk</h2>
      <div class="scrolling-wrapper">
        <div class="auto-slide space-x-6 mx-auto">
          <!-- Produk Item -->
          <div class="product-item bg-white shadow-lg p-4 rounded">
            <img src="tmbkau-1-removebg-preview-90.png" alt="Queen Bee SR">
            <h3 class="text-xl font-semibold">Queen Bee</h3>
            <p class="text-gray-600">SR (Surya)</p>
          </div>
          <div class="product-item bg-white shadow-lg p-4 rounded">
            <img src="tmbkau-1-removebg-preview-100.png" alt="Queen Bee SM">
            <h3 class="text-xl font-semibold">Queen Bee</h3>
            <p class="text-gray-600">SM (Samsoe)</p>
          </div>
          <div class="product-item bg-white shadow-lg p-4 rounded">
            <img src="tmbkau-1-removebg-preview-110.png" alt="Queen Bee Mild">
            <h3 class="text-xl font-semibold">Queen Bee</h3>
            <p class="text-gray-600">Mild</p>
          </div>
          <div class="product-item bg-white shadow-lg p-4 rounded">
            <img src="tmbkau-1-removebg-preview-120.png" alt="Virgin Royal">
            <h3 class="text-xl font-semibold">Virgin Royal</h3>
            <p class="text-gray-600">Vanilla</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="contact py-20 bg-gray-300">
    <div class="max-w-6xl mx-auto text-center">
      <h2 class="text-3xl font-bold text-black mb-8">Contact Us</h2>
      <p class="text-lg text-gray-700 mb-4">+62 858-8840-0776</p>
      <p class="text-lg text-gray-700 mb-4">Jl. Pintu Ledeng, Ciomas, Kec. Ciomas, Kabupaten Bogor, Jawa Barat 16610</p>
      <p class="text-lg text-gray-700">admin123@gmail.com</p>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 py-4">
    <div class="text-center text-white">&copy; 2025 TobaPOS. All rights reserved.</div>
  </footer>

  <script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    // Toggle the mobile menu
    menuToggle.addEventListener('click', () => {
      if (mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.remove('hidden');
        mobileMenu.classList.add('block');
      } else {
        mobileMenu.classList.add('hidden');
        mobileMenu.classList.remove('block');
      }
    });
  </script>
</body>
</html>
