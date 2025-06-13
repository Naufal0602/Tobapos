<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tobapos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body class="h-screen flex items-center justify-center bg-gradient-to-r from-[#ffff] to-[#33495E] px-4">

  <div class="w-full max-w-4xl flex flex-col md:flex-row bg-white shadow-lg rounded-2xl overflow-hidden animate-slideUp">
      
      <!-- Bagian Kiri: Logo & Welcome (Hanya Muncul di Desktop) -->
      <div class="hidden md:flex flex-1 flex-col items-center justify-center text-white bg-gradient-to-t from-[#33495E] to-[#ffff] p-10">
          <img src="{{ asset('img/logo_update.png') }}" alt="Logo" class="w-40 md:w-60 mb-4">
          <h2 class="text-3xl font-bold">Welcome Back!</h2>
      </div>

      <!-- Bagian Kanan: Form Login -->
      <div class="flex-1 p-8 md:p-10">
          <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">Login</h2>
          <p class="text-gray-500 text-center mb-6">Selamat datang kembali! Silakan masuk ke akun Anda.</p>

          <form action="{{ route('login') }}" method="POST">
              @csrf
              
              <!-- Input Email -->
              <div class="mb-4">
                  <label for="email" class="block text-sm font-semibold text-gray-600">Email</label>
                  <div class="relative mt-2">
                      <i class='bx bx-envelope absolute left-3 top-3 text-gray-400 text-lg'></i>
                      <input type="email" id="email" name="email" required
                          class="w-full pl-10 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                  </div>
              </div>

              <!-- Input Password -->
              <div class="mb-6">
                <label for="password" class="block text-sm font-semibold text-gray-600">Password</label>
                <div class="relative mt-2">
                    <i class='bx bx-lock absolute left-3 top-3 text-gray-400 text-lg'></i>
                    <input type="password" id="password" name="password" required
                        class="w-full pl-10 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>
            </div>
            
            <!-- Forgot Password Link -->
            <div class="mb-6 text-right">
                <a href="{{ route('password.request') }}" class="text-sm text-[#3DA8D6] hover:underline">
                    Forgot Password?
                </a>
            </div>
            
            <!-- Tombol Login dengan Hover Animasi -->
            <button type="submit"
                class="w-full bg-[#33495E] hover:bg-[##33495E] text-white font-semibold py-3 rounded-lg transition-transform transform hover:scale-105">
                Login
            </button>
          </form>
      </div>
  </div>

</body>
</html>

<script>
  tailwind.config = {
      theme: {
          extend: {
              animation: {
                  fadeIn: "fadeIn 1s ease-in-out",
                  slideUp: "slideUp 0.8s ease-out",
                  bounceSlow: "bounce 2s infinite",
              },
              keyframes: {
                  fadeIn: {
                      "0%": { opacity: "0" },
                      "100%": { opacity: "1" },
                  },
                  slideUp: {
                      "0%": { transform: "translateY(20px)", opacity: "0" },
                      "100%": { transform: "translateY(0)", opacity: "1" },
                  }
              }
          }
      }
  }
</script>
