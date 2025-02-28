<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        lavender: {
                            light: '#E6E6FA',
                            DEFAULT: '#D8B4FE',
                            dark: '#A78BFA'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body style="background:#F5E6F0;">

    <!-- Include the Sidebar and Header Components -->
    @include('layouts.sidebar')
    @include('layouts.navbar') 

    <!-- Main Content - Responsive Container -->
    <div class="transition-all duration-300 lg:ml-60 md:ml-56 sm:ml-0 p-4 md:p-6">
        <!-- SweetAlert Notification -->
        @if(session('status'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Success!",
                        text: "{{ session('status') }}",
                        icon: "success",
                        confirmButtonColor: "#A78BFA",
                        background: "#FDFAFF",
                        iconColor: "#8B5CF6"
                    });
                });
            </script>
        @endif

        <!-- Responsive Container -->
        <div class="max-w-7xl mx-auto">
            <!-- Profile Section -->
            <section class="p-6 bg-violet text-gray-800 rounded-xl shadow-lg mb-6">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <!-- Avatar -->
                    <div class="relative w-24 h-24 rounded-full bg-white/60 flex items-center justify-center text-2xl font-bold shadow-md">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="User Avatar" class="w-full h-full rounded-full object-cover">
                        @else
                            {{ substr(auth()->user()->name, 0, 1) }}
                        @endif
                    </div>

                    <!-- User Information -->
                    <div class="text-center md:text-left flex-1">
                        <h2 class="text-2xl md:text-3xl font-bold mb-2">{{ auth()->user()->name }}</h2>
                        <div class="flex items-center justify-center md:justify-start gap-2 mb-1">
                            <i data-feather="mail" class="w-4 h-4 text-purple-700"></i>
                            <span>{{ auth()->user()->email }}</span>
                        </div>
                        <div class="flex items-center justify-center md:justify-start gap-2">
                            <i data-feather="shield" class="w-4 h-4 text-purple-700"></i>
                            <span>Account secured with password</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Forms Section -->
            <section class="bg-gray-50 rounded-xl shadow-md overflow-hidden">
                <div class=" bg-gradient-to-r from-fuchsia-600 to-fuchsia-700 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">Update Your Information</h2>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Form Update Profile -->
                        <div class="bg-lavender-light/30 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-purple-800 mb-4">Profile Details</h3>
                            <form method="post" action="{{ route('profile.update') }}" id="profileForm">
                                @csrf
                                @method('patch')

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                        class="w-full p-3 rounded-lg border border-lavender focus:ring-2 focus:ring-lavender-dark focus:border-lavender-dark transition" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                        class="w-full p-3 rounded-lg border border-lavender focus:ring-2 focus:ring-lavender-dark focus:border-lavender-dark transition" required>
                                </div>

                                <button type="button" onclick="showSweetAlert('profileForm')" class="w-full bg-indigo-500 hover:bg-purple-600 mt-14 text-white font-medium py-2.5 px-4 rounded-lg transition duration-200 ease-in-out transform hover:scale-105">
                                    Update Profile
                                </button>
                            </form>
                        </div>

                        <!-- Form Update Password -->
                        <div class="bg-lavender-light/30 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-purple-800 mb-4">Password Security</h3>
                            <form method="post" action="{{ route('password.update') }}" id="passwordForm">
                                @csrf
                                @method('put')

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                    <input type="password" name="current_password"
                                        class="w-full p-3 rounded-lg border border-lavender focus:ring-2 focus:ring-lavender-dark focus:border-lavender-dark transition" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                    <input type="password" name="password"
                                        class="w-full p-3 rounded-lg border border-lavender focus:ring-2 focus:ring-lavender-dark focus:border-lavender-dark transition" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                    <input type="password" name="password_confirmation"
                                        class="w-full p-3 rounded-lg border border-lavender focus:ring-2 focus:ring-lavender-dark focus:border-lavender-dark transition" required>
                                </div>

                                <button type="button" onclick="showSweetAlert('passwordForm')" class="w-full bg-indigo-500 hover:bg-purple-600 text-white font-medium py-2.5 px-4 rounded-lg transition duration-200 ease-in-out transform hover:scale-105">
                                    Update Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

</body>
</html>

    <!-- Sweet Alert Confirmation Script -->
    <script>
        function showSweetAlert(formId) {
            Swal.fire({
                title: 'Apa kamu yakin?',
                text: 'Untuk memperbarui information akun?',
                icon: 'Pilih!',
                showCancelButton: true,
                confirmButtonColor: '#A78BFA',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!',
                background: '#FDFAFF',
                iconColor: '#8B5CF6'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
   
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSidebar = document.getElementById('toggle-sidebar');
            const sidebar = document.getElementById('sidebar');
            
            if (toggleSidebar && sidebar) {
                toggleSidebar.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                });
            }
        });
    </script>