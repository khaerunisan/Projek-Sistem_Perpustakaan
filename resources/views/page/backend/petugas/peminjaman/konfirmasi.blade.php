@extends('layouts.backend.app')

@section('content')
{{-- 
  1. lg:pl-[260px] = Memberi ruang tetap untuk sidebar (sesuaikan 260px dengan lebar sidebar kamu).
  2. flex justify-center = Memastikan pembungkus di dalamnya berada di tengah area sisa.
--}}
<div class="min-h-screen bg-[#0b0e14] p-4 lg:p-10 lg:pl-[260px] flex justify-center items-start text-white transition-all duration-300">
    
    {{-- Container ini yang akan berada di tengah --}}
    <div class="w-full max-w-5xl mx-auto">
        
        <div class="mb-8">
            <h2 class="text-2xl font-bold">Konfirmasi Pengembalian Buku</h2>
            <p class="text-gray-500 text-sm mt-1">Halaman verifikasi penerimaan buku dari anggota.</p>
        </div>
        
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 text-green-500 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-[#161b22] rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-400">
                    <thead class="bg-[#000000] text-gray-300 uppercase text-xs font-bold">
                        <tr>
                            <th class="px-6 py-5 border-b border-gray-800">No</th>
                            <th class="px-6 py-5 border-b border-gray-800">Kode</th>
                            <th class="px-6 py-5 border-b border-gray-800">Nama Anggota</th>
                            <th class="px-6 py-5 border-b border-gray-800">Judul Buku</th>
                            <th class="px-6 py-5 border-b border-gray-800 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($konfirmasi as $item)
                        <tr class="hover:bg-[#1c2128] transition duration-200">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-mono text-orange-400 font-bold">{{ $item->kode_peminjaman }}</td>
                            <td class="px-6 py-4 text-gray-200">{{ $item->user->name }}</td>
                            <td class="px-6 py-4 text-blue-400 font-semibold">{{ $item->buku->judul }}</td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="toggleModal('modalSetujui{{ $item->id }}')" class="bg-[#10b981] hover:bg-green-600 text-white px-5 py-2 rounded-lg text-xs font-bold transition-all shadow-lg shadow-green-900/20">
                                    Terima Buku
                                </button>

                                {{-- Modal --}}
                                <div id="modalSetujui{{ $item->id }}" class="fixed inset-0 z-[999] hidden overflow-y-auto bg-black/80 flex items-center justify-center p-4 backdrop-blur-sm">
                                    <div class="bg-[#1c2128] border border-gray-700 w-full max-w-md rounded-2xl shadow-2xl p-6 text-left relative">
                                        <form action="{{ route('petugas.setujui', $item->id) }}" method="POST">
                                            @csrf
                                            <h3 class="text-lg font-bold mb-4 text-white">Konfirmasi Penerimaan</h3>
                                            <p class="text-gray-400 mb-6 text-sm leading-relaxed">
                                                Apakah anda sudah menerima buku <span class="text-white font-semibold">"{{ $item->buku->judul }}"</span> dari <span class="text-white font-semibold">{{ $item->user->name }}</span>?
                                            </p>
                                            
                                            <div class="mb-6">
                                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Denda Keterlambatan</label>
                                                <input type="number" name="denda" class="w-full bg-[#0b0e14] border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-all" value="0">
                                            </div>

                                            <div class="flex justify-end gap-3">
                                                <button type="button" onclick="toggleModal('modalSetujui{{ $item->id }}')" class="px-5 py-2.5 text-sm font-semibold text-gray-400 hover:text-white transition">Batal</button>
                                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition shadow-lg shadow-green-900/40">
                                                    Konfirmasi Sekarang
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-500">
                                <p class="italic">Tidak ada permintaan pengembalian buku saat ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-8 flex justify-center">
            {{ $konfirmasi->links() }}
        </div>
    </div>
</div>

<script>
    function toggleModal(modalID) {
        const modal = document.getElementById(modalID);
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden'; {{-- Biar ga bisa scroll pas modal buka --}}
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }
</script>
@endsection