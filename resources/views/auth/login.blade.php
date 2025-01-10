<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.0/dist/tailwind.min.css" />
  <script src="https://cdn.tailwindcss.com/3.2.0"></script>

  <title>Login - Tobapos</title>
</head>
<body class="h-screen flex">
  <!-- Bagian Kiri: Logo -->
  <div class="bg-white flex-1 flex items-center justify-center">
    <img src="{{ asset('img/logo-01.png') }}" alt="Logo" class="w-72" />
  </div>
  
  <!-- Bagian Kanan: Form Login -->
  <div class="bg-gray-200 flex-1 flex flex-col items-center justify-center px-8 py-6">
    <div class="bg-white w-full max-w-md px-8 py-6 rounded-2xl shadow-lg border border-gray-300">
      <h1 class="text-4xl font-bold text-black mb-6 text-center">LOGIN</h1>

      <!-- Session Status -->
      <x-auth-session-status class="mb-4" :status="session('status')" />

      <form method="POST" action="{{ route('login') }}" class="w-full">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
          <x-input-label for="email" :value="__('Email')" />
          <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
          <x-input-label for="password" :value="__('Password')" />
          <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
          <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center mb-4">
          <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" name="remember" />
          <label for="remember_me" class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</label>
        </div>

        <!-- Login Button -->
        <div class="flex justify-between items-center">
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-indigo-500">{{ __('Forgot your password?') }}</a>
          @endif

          <x-primary-button>
            {{ __('Log in') }}
          </x-primary-button>
        </div>
      </form>

      <div class="mt-6 text-center text-sm text-gray-600">
        <span>Don't have an account?</span>
        <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Sign Up</a>
      </div>
    </div>
  </div>
</body>
</html>
