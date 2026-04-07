<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="/" class="navbar-brand mx-4 mb-3">
            <h3 class="text-[#ff0000]"><i class="fa fa-user-edit me-2"></i>PERSDI</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('assetsbackend/img/user.jpg') }}" alt="" style="width: 40px; height: 40px; border: 2px solid #ff0000;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0 text-white">{{ Auth::user()->name }}</h6>
                <small class="text-red-500 uppercase font-bold" style="font-size: 9px;">{{ Auth::user()->role }}</small>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="/" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>

            {{-- MENU KHUSUS PETUGAS --}}
            @if(Auth::user()->role == 'petugas')
                <li class="mb-2">
                    <a href="{{ route('petugas.buku') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('petugas/buku*') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-th-large w-5 text-center"></i>
                        <span>Data Buku</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('petugas.anggota') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('petugas/anggota*') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-desktop w-5 text-center"></i>
                        <span>Data Anggota</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('petugas.peminjaman') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('petugas/peminjaman') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-keyboard w-5 text-center"></i>
                        <span>Peminjaman</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('petugas.pengembalian') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('petugas/pengembalian*') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-table w-5 text-center"></i>
                        <span>Pengembalian</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('petugas.denda') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('petugas/denda*') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-file-alt w-5 text-center"></i>
                        <span>Denda</span>
                    </a>
                </li>
            @endif

            {{-- MENU KHUSUS KEPALA --}}
            @if(Auth::user()->role == 'kepala')
                <li class="mb-2">
                    <a href="{{ route('kepala.data-buku') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('kepala/data-buku*') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-th-large w-5 text-center"></i>
                        <span>Data Buku</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('kepala.anggota') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('kepala/data-anggota*') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-desktop w-5 text-center"></i>
                        <span>Data Anggota</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('kepala.petugas') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('petugas-data*') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-user-shield w-5 text-center"></i>
                        <span>Data Petugas</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('kepala.peminjaman') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('petugas/peminjaman*') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-keyboard w-5 text-center"></i>
                        <span>Peminjaman</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('kepala.pengembalian') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('petugas/pengembalian*') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-table w-5 text-center"></i>
                        <span>Pengembalian</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('kepala.denda') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('petugas/denda*') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-file-alt w-5 text-center"></i>
                        <span>Denda</span>
                    </a>
                </li>

                {{-- MENU LAPORAN KHUSUS KEPALA --}}
                <li class="mb-2">
                    <a href="{{ route('kepala.laporan') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('laporan*') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-chart-line w-5 text-center"></i>
                        <span>Laporan</span>
                    </a>
                </li>
            @endif

            {{-- MENU KHUSUS ANGGOTA --}}
            @if(Auth::user()->role == 'anggota')
                <li class="mb-2">
                    <a href="{{ route('anggota.daftarbuku') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('daftarbuku*') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-book w-5"></i>
                        <span>Daftar Buku</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('peminjaman.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('peminjaman*') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-hand-holding-heart w-5"></i>
                        <span>Peminjaman</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('pengembalian.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('pengembalian*') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-undo w-5"></i>
                        <span>Pengembalian</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('denda.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-600 transition text-gray-300 hover:text-white {{ Request::is('denda*') ? 'bg-red-600 text-white' : '' }}">
                        <i class="fas fa-money-bill-wave w-5"></i>
                        <span>Denda</span>
                    </a>
                </li>
            @endif

            <hr class="border-gray-700 mx-3 my-2">
            
            <a href="{{ route('logout') }}" class="nav-item nav-link text-danger flex items-center gap-3 p-3" 
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt w-5 text-center"></i>Logout
            </a>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </nav>
</div>