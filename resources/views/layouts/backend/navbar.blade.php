<nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
    <a href="/" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-book"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars text-primary"></i>
    </a>
    
    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            {{-- PERBAIKAN: Mengarahkan link langsung ke route profile --}}
            <a href="{{ route('profile.index') }}" class="nav-link">
                <img class="rounded-circle me-lg-2" src="{{ asset('assetsbackend/img/user.jpg') }}" alt="" style="width: 30px; height: 30px; border: 1px solid #ff0000;">
                <span class="d-none d-lg-inline-flex text-white">{{ Auth::user()->name }}</span>
            </a>
        </div>
    </div>
</nav>