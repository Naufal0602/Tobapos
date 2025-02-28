<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Perusahaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('input.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- AOS Animation Library -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    
    <style>
        /* Custom animations and effects */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .tab-content {
            display: none;
            min-height: 300px; /* Ensure minimum height for tab content */
        }
        
        .tab-content.active {
            display: block;
            animation: fadeIn 0.4s ease-out forwards;
        }
        
        .tab-button.active {
            border-bottom: 3px solid #3B82F6;
            color: #3B82F6;
            font-weight: 600;
        }
        
        /* Custom scrollbar for any overflow */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c7d2fe;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #818cf8;
        }
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        
        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-50 h-screen"> <!-- Ensure full height and hide overflow -->

    <!-- Include the Sidebar and Header Components -->
    @include('layouts.sidebar')
    @include('layouts.navbar') 

    <!-- Main content area with responsive classes -->
    <div class="w-full transition-all duration-300 lg:ml-60 ml-0 p-2 lg:p-3 overflow-auto h-full" id="content"> <!-- Ensure full height and allow vertical scrolling -->

            <div class="bg-white rounded-xl shadow-lg p-3 lg:p-4 transition-all duration-300 max-w-6xl mt-4 xl:ml-10 ">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-2 md:mb-0">
                        <i class="bx bx-building-house text-blue-500 mr-2"></i> Profil Perusahaan
                    </h2>
                    <a href="{{ route('dashboard.index') }}" class="w-full md:w-auto flex items-center justify-center px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-md" data-aos="fade-left" data-aos-delay="100">
                        <i class="bx bx-arrow-back mr-2"></i> Kembali ke Dashboard
                    </a>
                </div>

                <div class="border-b border-gray-200 mb-4"></div>

                @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-3 rounded" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "{{ session('success') }}",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        });
                    });
                </script>
                @endif
                
                <!-- Tabs Navigation with horizontal scroll on mobile -->
                <div class="flex border-b border-gray-200 mb-4 overflow-x-auto pb-1 scrollbar-hide" data-aos="fade-right">
                    <button type="button" class="tab-button active px-3 py-1.5 mr-3 text-sm whitespace-nowrap transition-all duration-300" data-tab="general">
                        <i class="bx bx-info-circle mr-1"></i> Informasi Umum
                    </button>
                    <button type="button" class="tab-button px-3 py-1.5 mr-3 text-sm whitespace-nowrap transition-all duration-300" data-tab="about">
                        <i class="bx bx-book-open mr-1"></i> Tentang Kami
                    </button>
                    <button type="button" class="tab-button px-3 py-1.5 text-sm whitespace-nowrap transition-all duration-300" data-tab="home">
                        <i class="bx bx-home mr-1"></i> Halaman Utama
                    </button>
                </div>
                
                <!-- Use the proper route, and ensure it uses the ID from the controller -->
                <form action="{{ route('dashboard.company_profile.update', $companyProfile->id ?? 1) }}" method="POST" enctype="multipart/form-data" id="companyForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- General Information Tab -->
                    <div class="tab-content active" id="general-tab">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4" data-aos="fade-up" data-aos-delay="100">
                            <div>
                                <label class="block mb-1 font-semibold text-gray-700">Nama Perusahaan</label>
                                <input type="text" name="name" value="{{ old('name', $companyProfile->name ?? '') }}" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200 transition-all duration-300" required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block mb-1 font-semibold text-gray-700">Alamat</label>
                                <input type="text" name="address" value="{{ old('address', $companyProfile->address ?? '') }}" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200 transition-all duration-300" required>
                                @error('address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block mb-1 font-semibold text-gray-700">Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone', $companyProfile->phone) }}" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200 transition-all duration-300" required>
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block mb-1 font-semibold text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ old('email', $companyProfile->email ?? '') }}" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200 transition-all duration-300" required>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- About Tab -->
                    <div class="tab-content" id="about-tab">
                        <div data-aos="fade-up" data-aos-delay="100">
                            <label class="block mb-1 font-semibold text-gray-700">Deskripsi Tentang Kami</label>
                            <textarea name="about_description" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200 transition-all duration-300 h-24 md:h-28" required>{{ old('about_description', $companyProfile->about_description ?? '') }}</textarea>
                            @error('about_description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mt-3 md:mt-4" data-aos="fade-up" data-aos-delay="150">
                            <label class="block mb-1 font-semibold text-gray-700">Gambar Tentang Kami</label>
                            
                            <div class="flex flex-col md:flex-row items-start gap-3 md:gap-4">
                                <!-- Preview About Image if exists -->
                                @if(isset($companyProfile->img_about))
                                <div class="relative group w-full md:w-auto">
                                    <img src="{{ asset('storage/' . $companyProfile->img_about) }}" alt="Gambar Tentang Kami" class="w-full md:w-32 h-32 object-cover rounded-lg shadow-md border border-gray-200 transition-all duration-300 group-hover:scale-105 group-hover:shadow-lg" id="aboutImagePreview">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <span class="text-white text-xs">Gambar Tentang Kami Saat Ini</span>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="relative overflow-hidden inline-block w-full md:w-auto">
                                    <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center w-full md:w-auto transition-all duration-300 hover:-translate-y-1 hover:shadow-md text-sm">
                                        <i class="bx bx-upload mr-2"></i> Pilih Gambar
                                    </button>
                                    <input type="file" name="img_about" class="absolute left-0 top-0 opacity-0 w-full h-full cursor-pointer" accept="image/*" onchange="previewImage(this, 'aboutImagePreview')">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">*Kosongkan jika tidak ingin mengubah gambar</p>
                            @error('img_about')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Home Tab -->
                    <div class="tab-content" id="home-tab">
                        <div data-aos="fade-up" data-aos-delay="100">
                            <label class="block mb-1 font-semibold text-gray-700">Deskripsi Halaman Utama</label>
                            <textarea name="home_description" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200 transition-all duration-300 h-24 md:h-28" required>{{ old('home_description', $companyProfile->home_description ?? '') }}</textarea>
                            @error('home_description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mt-3 md:mt-4" data-aos="fade-up" data-aos-delay="150">
                            <label class="block mb-1 font-semibold text-gray-700">Gambar Halaman Utama</label>
                            
                            <div class="flex flex-col md:flex-row items-start gap-3 md:gap-4">
                                <!-- Preview Home Image if exists -->
                                @if(isset($companyProfile->img_home))
                                <div class="relative group w-full md:w-auto">
                                    <img src="{{ asset('storage/' . $companyProfile->img_home) }}" alt="Gambar Halaman Utama" class="w-full md:w-32 h-32 object-cover rounded-lg shadow-md border border-gray-200 transition-all duration-300 group-hover:scale-105 group-hover:shadow-lg" id="homeImagePreview">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <span class="text-white text-xs">Gambar Halaman Utama Saat Ini</span>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="relative overflow-hidden inline-block w-full md:w-auto">
                                    <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center w-full md:w-auto transition-all duration-300 hover:-translate-y-1 hover:shadow-md text-sm">
                                        <i class="bx bx-upload mr-2"></i> Pilih Gambar
                                    </button>
                                    <input type="file" name="img_home" class="absolute left-0 top-0 opacity-0 w-full h-full cursor-pointer" accept="image/*" onchange="previewImage(this, 'homeImagePreview')">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">*Kosongkan jika tidak ingin mengubah gambar</p>
                            @error('img_home')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 mt-4 pt-4 flex justify-center md:justify-end" data-aos="fade-up" data-aos-delay="200">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg flex items-center justify-center w-full md:w-auto transition-all duration-300 hover:-translate-y-1 hover:shadow-md text-sm">
                            <i class="bx bx-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

 
</body>
</html>

<script>
    // Initialize AOS Animation
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 600,
            easing: 'ease-out',
            once: true,
            disable: window.innerWidth < 768 // Disable on mobile for better performance
        });
        
        // Initialize Feather Icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
        
        // Tab Navigation
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabId = button.getAttribute('data-tab');
                
                // Remove active class from all buttons and contents
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));
                
                // Add active class to clicked button and corresponding content
                button.classList.add('active');
                document.getElementById(`${tabId}-tab`).classList.add('active');
            });
        });
        
        // SweetAlert for form submission
        const form = document.getElementById('companyForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Simpan Perubahan?',
                text: 'Apakah Anda yakin ingin memperbarui profil perusahaan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
        
        // Responsive sidebar functionality
        const sidebarToggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.sidebar'); // Update this with your actual sidebar class
        const content = document.getElementById('content');
        
        // Toggle sidebar function
        function toggleSidebar() {
            if (sidebar) {
                sidebar.classList.toggle('translate-x-0');
                sidebar.classList.toggle('-translate-x-full');
                
                // Handle content margin on larger screens
                if (window.innerWidth >= 1024) {
                    content.classList.toggle('lg:ml-60');
                    content.classList.toggle('lg:ml-0');
                }
            }
        }
        
        // Add event listener to toggle button if it exists
        if (sidebarToggleBtn) {
            sidebarToggleBtn.addEventListener('click', toggleSidebar);
        }
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (sidebar) {
                // Check if sidebar is open
                const isSidebarOpen = !sidebar.classList.contains('-translate-x-full');
                
                if (window.innerWidth >= 1024) {
                    // On large screens, adjust content margin based on sidebar state
                    if (isSidebarOpen) {
                        content.classList.add('lg:ml-60');
                        content.classList.remove('lg:ml-0');
                    }
                } else {
                    // On small screens, always remove margin
                    content.classList.remove('lg:ml-60');
                }
            }
        });
    });
    
    // Image Preview Function
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (preview) {
                    preview.src = e.target.result;
                } else {
                    // Create new preview if it doesn't exist
                    const newPreview = document.createElement('img');
                    newPreview.id = previewId;
                    newPreview.src = e.target.result;
                    newPreview.classList.add('w-full', 'md:w-32', 'h-32', 'object-cover', 'rounded-lg', 'shadow-md', 'border', 'border-gray-200', 'transition-all', 'duration-300', 'hover:scale-105');
                    
                    const previewContainer = document.createElement('div');
                    previewContainer.classList.add('relative', 'group', 'w-full', 'md:w-auto');
                    previewContainer.appendChild(newPreview);
                    
                    // Insert before the file input
                    input.parentElement.parentElement.insertBefore(previewContainer, input.parentElement);
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>