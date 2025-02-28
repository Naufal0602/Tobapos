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
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="flex-1 ml-64">
        <!-- Navbar -->
        @include('layouts.navbar')   

        <!-- Dashboard Content -->
        <main class="p-6">
          
          
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

