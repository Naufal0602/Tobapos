<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('input.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- AOS Animation Library -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <!-- Animate.css for SweetAlert animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        .form-control {
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(213, 164, 207, 0.3);
            transform: translateY(-2px);
        }
        
        .image-preview {
            transition: all 0.3s ease;
        }
        
        .image-preview:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .upload-area {
            border: 2px dashed #d1d5db;
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            border-color: #8b5cf6;
            background-color: #faf5ff;
        }

        .upload-area.dragover {
            border-color: #8b5cf6;
            background-color: #f3e8ff;
        }
        
        /* Page transition */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .page-enter {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* Floating label effect */
        .floating-label {
            position: relative;
        }

        .floating-label input:focus + label,
        .floating-label input:not(:placeholder-shown) + label,
        .floating-label textarea:focus + label,
        .floating-label textarea:not(:placeholder-shown) + label,
        .floating-label select:focus + label {
            transform: translateY(-1.5rem) scale(0.85);
            color: #8b5cf6;
        }

        .floating-label label {
            position: absolute;
            left: 0.75rem;
            top: 0.75rem;
            transition: all 0.3s ease;
            pointer-events: none;
            background: white;
            padding: 0 0.25rem;
        }
    </style>
</head>
<body class="bg-[#f5f7fa] font-inter">

    <!-- Sidebar & Navbar using Tailwind CSS for responsiveness -->
    @include('layouts.sidebar')
    @include('layouts.navbar')

    <div class="p-2 sm:p-4 md:p-6 lg:ml-60 transition-all duration-300 page-enter">
        <div class="container mx-auto px-2 sm:px-4 py-4 sm:py-6 bg-white rounded-xl shadow-lg transition-all duration-300" data-aos="fade-up">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-center mb-6">
                <div class="flex items-center mb-2 sm:mb-0">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-800">Tambah Produk Baru</h2>
                </div>
            </div>

            <div class="border-b border-gray-200 mb-6"></div>

            <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div data-aos="fade-right" data-aos-delay="150">
                        <!-- Nama Produk -->
                        <div class="mb-6">
                            <label class="block mb-2 font-semibold text-gray-700">Nama Produk <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                name="name" 
                                value="{{ old('name') }}" 
                                class="form-control w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:outline-none focus:border-purple-400" 
                                placeholder="Masukkan nama produk..."
                                required
                            >
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-6 relative">
                            <label class="block mb-2 font-semibold text-gray-700">Kategori <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="category" class="form-control w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:outline-none focus:border-purple-400 appearance-none bg-white" required>
                                    <option value="" disabled selected>Pilih kategori produk...</option>
                                    <option value="menthol" {{ old('category') == 'menthol' ? 'selected' : '' }}>Menthol</option>
                                    <option value="herbal" {{ old('category') == 'herbal' ? 'selected' : '' }}>Herbal</option>
                                    <option value="ice" {{ old('category') == 'ice' ? 'selected' : '' }}>Ice</option>
                                    <option value="bussa_mild" {{ old('category') == 'bussa_mild' ? 'selected' : '' }}>Bussa Mild</option>
                                    <option value="bussa_esse" {{ old('category') == 'bussa_esse' ? 'selected' : '' }}>Bussa Esse</option>
                                    <option value="vapir" {{ old('category') == 'vapir' ? 'selected' : '' }}>Vapir</option>
                                    <option value="bussa_reguler" {{ old('category') == 'bussa_reguler' ? 'selected' : '' }}>Bussa Reguler</option>
                                </select>
                                
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="bx bx-chevron-down"></i>
                                </div>
                            </div>
                            @error('category')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Size -->
                        <div class="mb-6">
                            <label class="block mb-2 font-semibold text-gray-700">Ukuran <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="size" class="form-control w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:outline-none focus:border-purple-400 appearance-none bg-white" required>
                                    <option value="" disabled selected>Pilih ukuran produk...</option>
                                    <option value="50 gram" {{ old('size') == '50 gram' ? 'selected' : '' }}>50 gram</option>
                                    <option value="100 gram" {{ old('size') == '100 gram' ? 'selected' : '' }}>100 gram</option>
                                    <option value="200 gram" {{ old('size') == '200 gram' ? 'selected' : '' }}>200 gram</option>
                                    <option value="500 gram" {{ old('size') == '500 gram' ? 'selected' : '' }}>500 gram</option>
                                    <option value="1 kg" {{ old('size') == '1 kg' ? 'selected' : '' }}>1 kg</option>
                                </select>
                                
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="bx bx-chevron-down"></i>
                                </div>
                            </div>
                            @error('size')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div class="mb-6">
                            <label class="block mb-2 font-semibold text-gray-700">Harga <span class="text-red-500">*</span></label>
                            <input 
                                type="number" 
                                name="price" 
                                value="{{ old('price') }}" 
                                class="form-control w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:outline-none focus:border-purple-400" 
                                placeholder="Rp 0"
                                min="0"
                                required
                            >
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div data-aos="fade-left" data-aos-delay="200">
                        <!-- Stok -->
                        <div class="mb-6">
                            <label class="block mb-2 font-semibold text-gray-700">Stok <span class="text-red-500">*</span></label>
                            <input 
                                type="number" 
                                name="stock" 
                                value="{{ old('stock') }}" 
                                class="form-control w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:outline-none focus:border-purple-400" 
                                placeholder="Masukkan jumlah stok..."
                                min="0"
                                required
                            >
                            @error('stock')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-6">
                            <label class="block mb-2 font-semibold text-gray-700">Deskripsi <span class="text-red-500">*</span></label>
                            <textarea 
                                name="description" 
                                class="form-control w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:outline-none focus:border-purple-400 min-h-[120px] sm:min-h-[140px] resize-none" 
                                placeholder="Masukkan deskripsi produk..."
                                required
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Upload Gambar -->
                <div class="mt-6" data-aos="fade-up" data-aos-delay="250">
                    <label class="block mb-2 font-semibold text-gray-700">Gambar Produk <span class="text-red-500">*</span></label>
                    
                    <div class="flex flex-col lg:flex-row gap-6">
                        <!-- Upload Area -->
                        <div class="flex-1">
                            <div class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer" onclick="document.getElementById('imageInput').click()">
                                <div class="space-y-4">
                                    <div class="mx-auto w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                                        <i class="bx bx-cloud-upload text-2xl text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-lg font-medium text-gray-700">Pilih gambar produk</p>
                                        <p class="text-sm text-gray-500">atau drag & drop gambar di sini</p>
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        <p>Format: JPG, PNG, GIF</p>
                                        <p>Maksimal: 2MB</p>
                                    </div>
                                </div>
                                <input 
                                    type="file" 
                                    name="image" 
                                    id="imageInput"
                                    class="hidden" 
                                    accept="image/*" 
                                    onchange="previewImage(this)"
                                    required
                                >
                            </div>
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preview Area -->
                        <div class="lg:w-64" id="previewContainer" style="display: none;">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm font-medium text-gray-700 mb-3">Preview Gambar</p>
                                <div class="relative">
                                    <img id="imagePreview" class="image-preview w-full h-48 object-cover rounded-lg shadow-md border border-gray-200" alt="Preview">
                                    <button 
                                        type="button" 
                                        onclick="removeImage()" 
                                        class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs transition-colors"
                                    >
                                        <i class="bx bx-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row sm:justify-end gap-3 sm:gap-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('dashboard.products.index') }}" class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg text-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md active:translate-y-0 active:shadow-sm flex items-center justify-center">
                        <i class="bx bx-arrow-back mr-2"></i>
                        Kembali
                    </a>
                  
                    <button type="submit" class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md active:translate-y-0 active:shadow-sm">
                        <i class="bx bx-check mr-2"></i>
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Initialize AOS Animation
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-out',
                once: true,
                disable: window.innerWidth < 640 // Disable on small mobile for better performance
            });
            
            // Initialize Feather Icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
            
            // Initialize drag and drop functionality
            initializeDragAndDrop();
            
            // SweetAlert for form submission
            const form = document.getElementById('productForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Simpan Produk?',
                        text: 'Apakah Anda yakin ingin menambahkan produk ini?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Simpan',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#d33',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        },
                        width: window.innerWidth < 768 ? '90%' : '32em',
                        customClass: {
                            confirmButton: 'px-4 py-2 text-sm sm:text-base',
                            cancelButton: 'px-4 py-2 text-sm sm:text-base'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading indicator
                            Swal.fire({
                                title: 'Menyimpan...',
                                html: 'Mohon tunggu sebentar',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                                width: window.innerWidth < 768 ? '90%' : '32em'
                            });
                            
                            form.submit();
                        }
                    });
                });
            }

            // Reset form confirmation
            const resetButton = document.querySelector('button[type="reset"]');
            if (resetButton) {
                resetButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Reset Form?',
                        text: 'Semua data yang sudah diisi akan dihapus. Apakah Anda yakin?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Reset',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#f59e0b',
                        cancelButtonColor: '#6b7280',
                        width: window.innerWidth < 768 ? '90%' : '32em'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.reset();
                            removeImage();
                            Swal.fire({
                                title: 'Form Direset!',
                                text: 'Semua field telah dikosongkan.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    });
                });
            }
        });

        // Drag and Drop functionality
        function initializeDragAndDrop() {
            const uploadArea = document.querySelector('.upload-area');
            const fileInput = document.getElementById('imageInput');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                uploadArea.classList.add('dragover');
            }

            function unhighlight(e) {
                uploadArea.classList.remove('dragover');
            }

            uploadArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    fileInput.files = files;
                    previewImage(fileInput);
                }
            }
        }
        
        // Image Preview Function
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const previewContainer = document.getElementById('previewContainer');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        title: 'File Terlalu Besar!',
                        text: 'Ukuran file maksimal 2MB',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    input.value = '';
                    return;
                }

                // Validate file type
                if (!file.type.startsWith('image/')) {
                    Swal.fire({
                        title: 'Format File Tidak Valid!',
                        text: 'Silakan pilih file gambar (JPG, PNG, GIF)',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    input.value = '';
                    return;
                }
                
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';
                    
                    // Add animation
                    previewContainer.classList.add('animate__animated', 'animate__fadeIn');
                }
                
                reader.readAsDataURL(file);
            }
        }

        // Remove Image Function
        function removeImage() {
            const fileInput = document.getElementById('imageInput');
            const previewContainer = document.getElementById('previewContainer');
            
            fileInput.value = '';
            previewContainer.style.display = 'none';
            previewContainer.classList.remove('animate__animated', 'animate__fadeIn');
        }

        // Format price input with thousand separators and Rp prefix
        const priceInput = document.querySelector('input[name="price"]');
        const priceDisplay = document.createElement('input');
        priceDisplay.type = 'text';
        priceDisplay.className = priceInput.className;
        priceDisplay.placeholder = 'Rp 0';
        
        // Hide the original input and show the display input
        priceInput.style.display = 'none';
        priceInput.parentNode.appendChild(priceDisplay);
        
        // Format number with thousand separators
        function formatRupiah(number) {
            return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
        
        // Remove formatting to get clean number
        function cleanNumber(text) {
            return text.replace(/[^\d]/g, '');
        }
        
        priceDisplay.addEventListener('input', function(e) {
            let value = cleanNumber(e.target.value);
            if (value) {
                e.target.value = formatRupiah(value);
                priceInput.value = value;
            } else {
                e.target.value = '';
                priceInput.value = '';
            }
        });
        
        priceDisplay.addEventListener('focus', function(e) {
            if (e.target.value === '' || e.target.value === 'Rp 0') {
                e.target.value = 'Rp ';
            }
        });
        
        priceDisplay.addEventListener('blur', function(e) {
            if (e.target.value === 'Rp ' || e.target.value === 'Rp 0') {
                e.target.value = '';
                priceInput.value = '';
            }
        });
        
        // Initialize with old value if exists
        if (priceInput.value) {
            priceDisplay.value = formatRupiah(priceInput.value);
        }

        // SweetAlert for Success Notification
        @if (session('success'))
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
                },
                width: window.innerWidth < 768 ? '90%' : '32em'
            });
        });
        @endif
        
        @if (session('error'))
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Error!",
                text: "{{ session('error') }}",
                icon: "error",
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                width: window.innerWidth < 768 ? '90%' : '32em',
                customClass: {
                    confirmButton: 'px-4 py-2 text-sm sm:text-base'
                }
            });
        });
        @endif
        
        // SweetAlert for validation errors
        @if ($errors->any())
        document.addEventListener("DOMContentLoaded", function() {
            let errorMessage = '';
            @foreach ($errors->all() as $error)
                errorMessage += "{{ $error }}<br>";
            @endforeach
            
            Swal.fire({
                title: "Validasi Gagal!",
                html: errorMessage,
                icon: "error",
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                width: window.innerWidth < 768 ? '90%' : '32em',
                customClass: {
                    confirmButton: 'px-4 py-2 text-sm sm:text-base'
                }
            });
        });
        @endif
    </script>
</body>
</html>