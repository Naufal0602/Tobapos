<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
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
        
        /* Page transition */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .page-enter {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#F5E6F0] to-[#E8D7E3]">

    <!-- Sidebar & Navbar using Tailwind CSS for responsiveness -->
    @include('layouts.sidebar')
    @include('layouts.navbar')

    <div class="p-2 sm:p-4 md:p-6 lg:ml-60 transition-all duration-300 page-enter">
        <div class="container mx-auto px-2 sm:px-4 py-4 sm:py-6 bg-white rounded-xl shadow-lg transition-all duration-300" data-aos="fade-up">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-center mb-6">
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-800 mb-2 md:text-center md:justify-center sm:text-center sm:justify-center sm:mb-0">Edit Produk</h2>
            </div>

            <div class="border-b border-gray-200 mb-6"></div>

            <form action="{{ route('dashboard.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div data-aos="fade-right" data-aos-delay="150">
                        <!-- Nama Produk -->
                        <div class="mb-4">
                            <label class="block mb-2 font-semibold text-gray-700">Nama Produk</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:outline-none focus:border-purple-400" required>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-4 relative">
                            <label class="block mb-2 font-semibold text-gray-700">Kategori</label>
                            <div class="relative">
                                <select name="category" class="form-control w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:outline-none focus:border-purple-400 appearance-none bg-white" required>
                                    <option value="menthol" {{ $product->category == 'menthol' ? 'selected' : '' }}>Menthol</option>
                                    <option value="herbal" {{ $product->category == 'herbal' ? 'selected' : '' }}>Herbal</option>
                                    <option value="ice" {{ $product->category == 'ice' ? 'selected' : '' }}>Ice</option>
                                    <option value="bussa_mild" {{ $product->category == 'bussa_mild' ? 'selected' : '' }}>Bussa Mild</option>
                                    <option value="bussa_esse" {{ $product->category == 'bussa_esse' ? 'selected' : '' }}>Bussa Esse</option>
                                    <option value="vapir" {{ $product->category == 'vapir' ? 'selected' : '' }}>Vapir</option>
                                    <option value="bussa_medium" {{ $product->category == 'bussa_medium' ? 'selected' : '' }}>Bussa Medium</option>
                                </select>
                                
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="bx bx-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <label class="block mb-2">Size</label>
                        <select name="size" class="w-full border px-3 py-2 mb-2 rounded">
                            <option value="50 gram" {{ $product->size == '50 gram' ? 'selected' : '' }}>50 gram</option>
                            <option value="1 kg" {{ $product->size == '1 kg' ? 'selected' : '' }}>1 kg</option>
                        </select>

                        <!-- Harga -->
                        <div class="mb-4">
                            <label class="block mb-2 font-semibold text-gray-700">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" class="form-control w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:outline-none focus:border-purple-400" required>
                        </div>
                    </div>

                    <div data-aos="fade-left" data-aos-delay="200">
                        <!-- Stok -->
                        <div class="mb-4">
                            <label class="block mb-2 font-semibold text-gray-700">Stok</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="form-control w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:outline-none focus:border-purple-400" required>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
                            <textarea name="description" class="form-control w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:outline-none focus:border-purple-400 min-h-[100px] sm:min-h-[120px]" required>{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Upload Gambar -->
                <div class="mt-4 sm:mt-6" data-aos="fade-up" data-aos-delay="250">
                    <label class="block mb-2 font-semibold text-gray-700">Gambar Produk</label>
                    
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6">
                        <!-- Preview Gambar Jika Ada -->
                        @if ($product->image)
                            <div class="relative group w-full sm:w-auto">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk" class="image-preview w-full h-48 sm:w-48 sm:h-48 object-cover rounded-lg shadow-md border border-gray-200 mx-auto sm:mx-0" id="imagePreview">
                                <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="text-white text-sm">Gambar Saat Ini</span>
                                </div>
                            </div>
                        @endif
                        
                        <div class="relative overflow-hidden inline-block w-full sm:w-auto">
                            <button type="button" class="w-full sm:w-auto bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md active:translate-y-0 active:shadow-sm">
                                <i class="bx bx-upload mr-2"></i> Pilih Gambar Baru
                            </button>
                            <input type="file" name="image" class="absolute left-0 top-0 opacity-0 w-full h-full cursor-pointer" accept="image/*" onchange="previewImage(this)">
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">*Kosongkan jika tidak ingin mengubah gambar</p>
                </div>

                <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row sm:justify-end gap-2 sm:gap-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('dashboard.products.index') }}" class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 sm:px-6 sm:py-3 rounded-lg text-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md active:translate-y-0 active:shadow-sm">Batal</a>
                    <button type="submit" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 sm:px-8 sm:py-3 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md active:translate-y-0 active:shadow-sm">
                        <i class="bx bx-save mr-2"></i> Simpan Perubahan
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
            
            // SweetAlert for form submission
            const form = document.getElementById('productForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Simpan Perubahan?',
                        text: 'Apakah Anda yakin ingin menyimpan perubahan produk ini?',
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
                        },
                        // Mobile responsive settings
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
        });
        
        // Image Preview Function
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (preview) {
                        preview.src = e.target.result;
                    } else {
                        // Create new preview if it doesn't exist
                        const newPreview = document.createElement('img');
                        newPreview.id = 'imagePreview';
                        newPreview.src = e.target.result;
                        newPreview.classList.add('image-preview', 'w-full', 'h-48', 'sm:w-48', 'sm:h-48', 'object-cover', 'rounded-lg', 'shadow-md', 'border', 'border-gray-200', 'mx-auto', 'sm:mx-0');
                        
                        // Insert before the file input container
                        const fileInputContainer = input.closest('div');
                        fileInputContainer.parentElement.insertBefore(newPreview, fileInputContainer);
                    }
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        // SweetAlert for Success Notification
        @if (session('success'))
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Sukses!",
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