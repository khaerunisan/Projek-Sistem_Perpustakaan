@extends('layouts.backend.app')

@section('content')
    <style>
        /* Warna latar belakang utama disesuaikan dengan DarkPan agar tidak kontras */
        .card-book { background-color: #4b5563 !important; border: none; }
        .search-bg { background-color: #21262d !important; color: white !important; }
        .card-book h3 { color: #f3f4f6; }
        .card-book p { color: #d1d5db; }
    </style>

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Buku Dipinjam</p>
                        <h6 class="mb-0">{{ $totalDipinjam }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-bar fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Pinjam</p>
                        <h6 class="mb-0">{{ $totalRiwayat }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-area fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Denda</p>
                        <h6 class="mb-0">Rp{{ number_format($totalDenda, 0, ',', '.') }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-pie fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Koleksi Buku</p>
                        <h6 class="mb-0">{{ $totalBuku }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection