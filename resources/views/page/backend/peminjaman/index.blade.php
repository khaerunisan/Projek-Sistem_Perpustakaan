@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#0b0e14] p-6 text-white">
    <h2 class="text-xl font-semibold mb-6">Daftar Riwayat Peminjaman</h2>
    
    <div class="overflow-x-auto bg-[#161b22] rounded-lg border border-gray-800 shadow-xl">
        <table class="w-full text-left text-sm text-gray-400">
            <thead class="bg-[#000000] text-gray-300 uppercase text-xs font-bold">
                <tr>
                    <th class="px-6 py-4 border-b border-gray-800">No</th>
                    <th class="px-6 py-4 border-b border-gray-800">Nama</th>
                    <th class="px-6 py-4 border-b border-gray-800">Judul Buku</th>
                    <th class="px-6 py-4 border-b border-gray-800">Id Buku</th>
                    <th class="px-6 py-4 border-b border-gray-800">Tanggal Pinjam</th>
                    <th class="px-6 py-4 border-b border-gray-800">Tanggal Pengembalian</th>
                    <th class="px-6 py-4 border-b border-gray-800 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($riwayat as $key => $item)
                <tr class="hover:bg-[#1c2128] transition duration-200">
                    <td class="px-6 py-4">{{ $key + 1 }}</td>
                    <td class="px-6 py-4 font-medium">{{ $item->user->name }}</td>
                    <td class="px-6 py-4 text-blue-400 font-semibold">{{ $item->buku->judul }}</td>
                    <td class="px-6 py-4">{{ $item->buku_id }}</td>
                    <td class="px-6 py-4 italic text-gray-500">
                        {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d F Y') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{-- MENAMPILKAN TANGGAL JIKA SUDAH KEMBALI --}}
                        @if($item->status == 'dikembalikan')
                            {{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d F Y') }}
                        @else
                            <span class="text-gray-600">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{-- LOGIKA TOMBOL: DISESUAIKAN UNTUK KONFIRMASI --}}
                        @if($item->status == 'dipinjam')
                            <form action="{{ route('anggota.ajukan_kembali', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-[#10b981] hover:bg-green-600 text-white px-4 py-1.5 rounded-md text-xs font-medium transition duration-300 inline-block">
                                    Kembalikan Buku
                                </button>
                            </form>
                        @elseif($item->status == 'menunggu_konfirmasi')
                            <span class="bg-yellow-600/20 text-yellow-500 px-4 py-1.5 rounded-md text-xs font-medium border border-yellow-600/30">
                                Menunggu Konfirmasi
                            </span>
                        @else
                            <span class="bg-gray-800 text-gray-500 px-4 py-1.5 rounded-md text-xs font-medium border border-gray-700 opacity-60 cursor-not-allowed">
                                Selesai
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                        Belum ada riwayat peminjaman buku.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Script SweetAlert2 untuk Notifikasi Berhasil --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Notifikasi Berhasil Pinjam --}}
@if(session('success_pinjam'))
<script>
    Swal.fire({
        title: 'Berhasil',
        text: "{{ session('success_pinjam') }}",
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#f37021',
        background: '#1c2128',
        color: '#ffffff',
        iconColor: '#000000',
        customClass: {
            popup: 'rounded-3xl border border-gray-700',
            confirmButton: 'rounded-lg px-10'
        }
    });
</script>
@endif

{{-- Notifikasi Berhasil Mengajukan Pengembalian --}}
@if(session('success'))
<script>
    Swal.fire({
        title: 'Berhasil',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#10b981',
        background: '#1c2128',
        color: '#ffffff',
        iconColor: '#10b981',
        customClass: {
            popup: 'rounded-3xl border border-gray-700',
            confirmButton: 'rounded-lg px-10'
        }
    });
</script>
@endif

@endsection