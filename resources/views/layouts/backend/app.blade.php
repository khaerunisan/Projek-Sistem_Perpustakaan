<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Persdi - Management</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <link href="{{ asset('assetsbackend/img/favicon.ico') }}" rel="icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assetsbackend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assetsbackend/css/style.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* CSS Utama untuk merapikan halaman */
        body { background-color: #0b0e14 !important; }
        .content { background: #0b0e14 !important; min-height: 100vh; }
        
        /* Gaya Kartu Buku agar konsisten seperti permintaan sebelumnya */
        .card-book { 
            background-color: #4b5563 !important; 
            border: none !important; 
            transition: transform 0.2s;
        }
        .card-book:hover { transform: translateY(-5px); }
        .search-bg { background-color: #21262d !important; color: white !important; border: 1px solid #374151 !important; }
        
        /* Perbaikan untuk Navbar & Sidebar DarkPan */
        .bg-secondary { background-color: #161b22 !important; }
        .sidebar { background: #161b22 !important; }
    </style>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        @include('layouts.backend.sidebar')

        <div class="content">
            @include('layouts.backend.navbar')

            <div class="container-fluid pt-4 px-4">
                @yield('content')
            </div>

            <div class="container-fluid pt-4 px-4 mt-auto">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start text-muted text-xs">
                            &copy; {{ date('Y') }} <a href="#" class="text-primary">Persdi Library</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assetsbackend/js/main.js') }}"></script>
</body>
</html>