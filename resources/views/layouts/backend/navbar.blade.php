<nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
    <a href="/" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-book"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars text-primary"></i>
    </a>
    
    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img class="rounded-circle me-lg-2" src="{{ asset('assetsbackend/img/user.jpg') }}" alt="" style="width: 30px; height: 30px;">
                <span class="d-none d-lg-inline-flex text-white">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                <a href="#" class="dropdown-item">My Profile</a>
                <a href="#" class="dropdown-item">Settings</a>
                <hr class="dropdown-divider border-gray-700">
                <a href="{{ route('logout') }}" class="dropdown-item text-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   Log Out
                </a>
            </div>
        </div>
    </div>
</nav>