<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center p-4">

    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl overflow-hidden flex flex-col md:flex-row">
        
        <!-- Left Side Image -->
        <div class="hidden md:flex md:w-1/2 bg-slate-50items-center justify-center p-8">
            <img src="{{ asset("img/undarw.png") }}" alt="Security Illustration" class="object-cover rounded-lg">
        </div>

        <!-- Right Side Form -->
        <div class="w-full md:w-1/2 p-8">

            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Reset Your Password</h2>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email / Username -->
                <div>
                    <label for="login_by" class="block text-sm font-medium text-gray-700">Username / Email</label>
                    <input id="login_by" name="login_by" type="text" value="{{ old('login_by', $request->email) }}" required autofocus
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    @error('login_by')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    @error('password')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    @error('password_confirmation')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-md transition duration-300">
                        Reset Password
                    </button>
                </div>

            </form>
        </div>

    </div>

</body>
</html>
