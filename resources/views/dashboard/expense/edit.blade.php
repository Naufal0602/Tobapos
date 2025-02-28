<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengeluaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('input.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .form-control {
            transition: all 0.3s ease;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(213, 164, 207, 0.3);
            transform: translateY(-2px);
        }
        .page-enter {
            animation: fadeIn 0.5s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#F5E6F0] to-[#E8D7E3]">

    @include('layouts.sidebar')
    @include('layouts.navbar')

    <div class="p-2 sm:p-4 md:p-6 lg:ml-60 transition-all duration-300 page-enter">
        <div class="container mx-auto px-2 sm:px-4 py-4 sm:py-6 bg-white rounded-xl shadow-lg transition-all duration-300" data-aos="fade-up">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-center mb-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-2 md:text-center md:justify-center sm:text-center sm:justify-center sm:mb-0">Edit Pengeluaran</h2>
            </div>

            <div class="border-b border-gray-200 mb-6"></div>

            <form id="editExpenseForm" action="{{ route('dashboard.expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div data-aos="fade-right" data-aos-delay="150">
                        <div class="mb-4">
                            <label class="block mb-2 font-semibold text-gray-700">Tanggal</label>
                            <input type="date" name="created_at" value="{{ $expense->created_at->format('Y-m-d') }}" class="form-control w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:outline-none focus:border-purple-400" required>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-semibold text-gray-700">Nama</label>
                            <input type="text" name="name" value="{{ $expense->name }}" class="form-control w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:outline-none focus:border-purple-400" required>
                        </div>
                    </div>

                    <div data-aos="fade-left" data-aos-delay="200">
                        <div class="mb-4">
                            <label class="block mb-2 font-semibold text-gray-700">Kategori</label>
                            <input type="text" name="category" value="{{ $expense->category }}" class="form-control w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:outline-none focus:border-purple-400" required>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-semibold text-gray-700">Pengeluaran (Rp)</label>
                            <input type="number" name="amount" value="{{ $expense->amount }}" class="form-control w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-lg focus:outline-none focus:border-purple-400" required>
                        </div>
                    </div>
                </div>

                <div class="mt-4 sm:mt-6" data-aos="fade-up" data-aos-delay="250">
                    <label class="block mb-2 font-semibold text-gray-700">Bukti Pengeluaran</label>
                    
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6">
                        @if ($expense->receipt_image)
                            <div class="relative group w-full sm:w-auto">
                                <img src="{{ asset('storage/' . $expense->receipt_image) }}" alt="Bukti Pengeluaran" class="image-preview w-full h-48 sm:w-48 sm:h-48 object-cover rounded-lg shadow-md border border-gray-200 mx-auto sm:mx-0" id="imagePreview">
                                <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="text-white text-sm">Gambar Saat Ini</span>
                                </div>
                            </div>
                        @endif
                        
                        <div class="relative overflow-hidden inline-block w-full sm:w-auto">
                            <button type="button" class="w-full sm:w-auto bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md active:translate-y-0 active:shadow-sm">
                                <i class="bx bx-upload mr-2"></i> Pilih Gambar Baru
                            </button>
                            <input type="file" name="receipt_image" class="absolute left-0 top-0 opacity-0 w-full h-full cursor-pointer" accept="image/*" onchange="previewImage(this)">
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">*Kosongkan jika tidak ingin mengubah gambar</p>
                </div>

                <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row sm:justify-end gap-2 sm:gap-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('dashboard.expenses.index') }}" class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 sm:px-6 sm:py-3 rounded-lg text-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md active:translate-y-0 active:shadow-sm">Batal</a>
                    <button type="button" onclick="confirmEdit()" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 sm:px-8 sm:py-3 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md active:translate-y-0 active:shadow-sm">
                        <i class="bx bx-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

 </body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            easing: 'ease-out',
            once: true,
            disable: window.innerWidth < 640
        });
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });

    function confirmEdit() {
        Swal.fire({
            title: 'Yakin ingin menyimpan perubahan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('editExpenseForm').submit();
            }
        });
    }

    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (preview) {
                    preview.src = e.target.result;
                } else {
                    const newPreview = document.createElement('img');
                    newPreview.id = 'imagePreview';
                    newPreview.src = e.target.result;
                    newPreview.classList.add('image-preview', 'w-full', 'h-48', 'sm:w-48', 'sm:h-48', 'object-cover', 'rounded-lg', 'shadow-md', 'border', 'border-gray-200', 'mx-auto', 'sm:mx-0');
                    
                    const fileInputContainer = input.closest('div');
                    fileInputContainer.parentElement.insertBefore(newPreview, fileInputContainer);
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

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
