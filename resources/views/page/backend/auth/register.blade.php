<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Persdi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <style>
        body { background-color: #000000; }
        .register-card { background-color: #161b22; }
        .input-field {
            background-color: #000000 !important;
            border: 1px solid #30363d !important;
            color: white !important;
        }
        .btn-persdi {
            background-color: #ff0000;
            transition: all 0.3s;
        }
        .btn-persdi:hover { background-color: #cc0000; }
        
        input[type="checkbox"] {
            accent-color: #ff0000;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen py-10 px-4">

    <div class="register-card p-8 rounded-xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-center gap-2 mb-6">
            <i class="fas fa-user-edit text-[#ff0000] text-2xl"></i>
            <h1 class="text-[#ff0000] text-2xl font-bold tracking-tight">Persdi</h1>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-900/20 border border-red-800 text-red-500 text-xs">
                Format pengisian salah, silakan cek kembali.
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required
                    class="input-field w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-600">
                @error('name') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <input type="text" name="prodi" placeholder="Program Studi" value="{{ old('prodi') }}" required
                    class="input-field w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-600">
                @error('prodi') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <input type="text" name="alamat" placeholder="Alamat" value="{{ old('alamat') }}" required
                    class="input-field w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-600">
                @error('alamat') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <input type="text" name="phone" placeholder="No Telphon" value="{{ old('phone') }}" required
                    class="input-field w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-600">
                @error('phone') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required
                    class="input-field w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-600">
                @error('email') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <input type="password" name="password" placeholder="Password" required
                    class="input-field w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-600">
                @error('password') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required
                    class="input-field w-full px-4 py-2.5 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-600">
            </div>

            <div class="text-center mb-6">
                <p class="text-gray-400 text-xs">
                    Sudah Punya Akun? <a href="{{ route('login') }}" class="text-red-600 hover:underline font-semibold">Login</a>
                </p>
            </div>

            <button type="submit" class="btn-persdi w-full text-white font-bold py-3 rounded-lg shadow-lg mb-4">
                Register
            </button>

            <div class="flex items-center gap-2">
                <input type="checkbox" id="check" class="w-4 h-4 rounded" required>
                <label for="check" class="text-gray-400 text-xs cursor-pointer">Check me out</label>
            </div>
        </form>
    </div>

</body>
</html>