<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 text-black flex flex-col fixed h-full" style="background: #D8D2C2">
        <div class="p-4 text-xl font-bold">Logo</div>
        <nav class="mt-6 space-y-2">
            <a href="#" class="flex items-center py-2.5 px-4 hover:bg-blue-500">
                <i class='bx bxs-home text-xl mr-3'></i> Dashboard
            </a>
            <a href="#" class="flex items-center py-2.5 px-4 hover:bg-blue-500">
                <i class='bx bx-box text-xl mr-3'></i> Product
            </a>
            <a href="#" class="flex items-center py-2.5 px-4 hover:bg-blue-500">
                <i class='bx bxs-package text-xl mr-3'></i> Kelola Stok
            </a>
            <a href="#" class="flex items-center py-2.5 px-4 hover:bg-blue-500">
                <i class='bx bx-transfer-alt text-xl mr-3'></i> Transaksi
            </a>
            <a href="#" class="flex items-center py-2.5 px-4 hover:bg-blue-500">
                <i class='bx bx-history text-xl mr-3'></i> Histori
            </a>

            <a href="#" class="flex items-center py-2.5 px-4 hover:bg-blue-500">
                <i class='bx bx-log-out text-xl mr-3'></i> Logout
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 ml-64">
        <!-- Navbar -->
        <header class="bg-gray-200 h-16 flex items-center justify-between px-4 shadow">
            <input type="text" placeholder="Search" class="w-1/3 px-4 py-2 border rounded-lg">
            <div class="relative">
                <button id="userMenuButton" class="flex items-center space-x-2">
                    <span class="bg-gray-500 text-white px-3 py-1 rounded-full"> {{ Auth::user()->name }}</span>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <!-- Dropdown -->
                <div id="userMenu" class="absolute right-0 mt-2 bg-white border rounded shadow-lg w-48 hidden">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                    <a href="{{ route('logout') }}" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="p-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-200 p-4 rounded shadow flex items-center">
                    <i class='bx bx-wallet text-3xl'></i>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold">0</h2>
                        <p class="text-gray-600">Total Pendapatan</p>
                    </div>
                </div>
                <div class="bg-gray-200 p-4 rounded shadow flex items-center">
                    <i class='bx bx-cube text-3xl'></i>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold">0</h2>
                        <p class="text-gray-600">Stok</p>
                    </div>
                </div>
                <div class="bg-gray-200 p-4 rounded shadow flex items-center">
                    <i class='bx bx-cart text-3xl'></i>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold">0</h2>
                        <p class="text-gray-600">Orders</p>
                    </div>
                </div>
            </div>

            <!-- Graph -->
            <div class="bg-white p-6 rounded shadow mb-6">
                <h2 class="text-xl font-bold">Grafik</h2>
                <div class="mt-4">
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-bold mb-4">Data Transaksi</h2>
                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Customer</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Produk</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Tanggal</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Harga</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">1</td>
                            <td class="border border-gray-300 px-4 py-2">Fathir</td>
                            <td class="border border-gray-300 px-4 py-2">Queen Bee</td>
                            <td class="border border-gray-300 px-4 py-2">12/05/2024</td>
                            <td class="border border-gray-300 px-4 py-2">20,000</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <i class='bx bx-check text-green-500'></i>
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">2</td>
                            <td class="border border-gray-300 px-4 py-2">Fadhlan</td>
                            <td class="border border-gray-300 px-4 py-2">Barack Taste</td>
                            <td class="border border-gray-300 px-4 py-2">15/05/2024</td>
                            <td class="border border-gray-300 px-4 py-2">18,000</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <i class='bx bx-check text-green-500'></i>
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">3</td>
                            <td class="border border-gray-300 px-4 py-2">Naufal</td>
                            <td class="border border-gray-300 px-4 py-2">Queen Bee</td>
                            <td class="border border-gray-300 px-4 py-2">17/05/2024</td>
                            <td class="border border-gray-300 px-4 py-2">20,000</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <i class='bx bx-check text-green-500'></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
<script>
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenu = document.getElementById('userMenu');

    // Tampilkan atau sembunyikan dropdown saat tombol diklik
    userMenuButton.addEventListener('click', () => {
        userMenu.classList.toggle('hidden');
    });

    // Sembunyikan dropdown jika pengguna mengklik di luar area dropdown
    document.addEventListener('click', (event) => {
        if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
            userMenu.classList.add('hidden');
        }
    });
</script>

