<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Persdi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <style>
        body {
            background-color: #000000; /* Hitam pekat sesuai gambar */
        }
        .login-card {
            background-color: #161b22; /* Abu-abu gelap kontainer */
        }
        .input-field {
            background-color: #000000 !important;
            border: 1px solid #30363d !important;
            color: white !important;
        }
        .btn-persdi {
            background-color: #ff0000; /* Merah sesuai tombol */
            transition: all 0.3s;
        }
        .btn-persdi:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="login-card p-10 rounded-xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-center gap-2 mb-8">
            <i class="fas fa-user-edit text-[#ff0000] text-3xl"></i>
            <h1 class="text-[#ff0000] text-3xl font-bold tracking-tight">Persdi</h1>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                    placeholder="Email address"
                    class="input-field w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 transition-all">
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-8">
                <input id="password" type="password" name="password" required 
                    placeholder="Password"
                    class="input-field w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 transition-all">
                @error('password')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-persdi w-full text-white font-bold py-3 rounded-lg shadow-lg mb-6">
                Login
            </button>

            <div class="text-center">
                <p class="text-gray-500 text-sm">
                    Belum Punya Akun? 
                    <a href="{{ route('register') }}" class="text-red-600 hover:underline">Daftar Disini</a>
                </p>
            </div>
        </form>
    </div>

</body>
</html>