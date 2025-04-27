<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center p-4">

    <div class="bg-white rounded-lg shadow-xl w-full max-w-5xl overflow-hidden flex flex-col md:flex-row relative">

        <!-- Image Section -->
        <div class="md:w-1/2 hidden md:block">
            <img src="{{ asset("img/fg_pw.jpeg") }}" alt="Forgot Password Illustration" class="h-full w-full object-cover">
        </div>

        <!-- Form Section -->
        <div class="w-full md:w-1/2 p-8 flex flex-col justify-center relative z-10">

            <h2 class="text-3xl font-bold text-gray-800 mb-2">Forgot Your Password?</h2>
            <p class="text-sm text-gray-600 mb-6">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
            </p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <input id="login_by" 
                        class="block mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" 
                        type="text" 
                        name="login_by" 
                        value="{{ old('login_by') }}" 
                        placeholder="Username / Email"
                        required 
                        autofocus 
                    />
                    @error('login_by')
                        <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 rounded-md transition duration-300">
                    Email Password Reset Link
                </button>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-sm text-purple-600 hover:text-purple-800">Back to Login</a>
                </div>
            </form>
        </div>

    </div>

</body>
</html>
