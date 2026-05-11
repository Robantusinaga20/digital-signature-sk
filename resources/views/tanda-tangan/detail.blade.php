@extends('layouts.app')
@section('page-title', 'Detail Data Tanda Tangan')

@section('content')
<div class="max-w-2xl space-y-4">

    {{-- Detail SK --}}
    <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm">
        <div class="px-5 py-3 font-bold text-white text-sm" style="background-color:#1e3a5f">
            Detail Data Tanda Tangan
        </div>
        <div class="bg-gray-50 px-5 py-5 space-y-3 text-sm">
            <div class="grid grid-cols-3 gap-2">
                <span class="font-semibold text-gray-700">No SK</span>
                <span class="text-gray-500">:</span>
                <span class="text-gray-800">{{ $tt->sk->nomor_sk }}</span>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <span class="font-semibold text-gray-700">Tanggal SK</span>
                <span class="text-gray-500">:</span>
                <span class="text-gray-800">{{ $tt->sk->tanggal_sk->format('d/m/Y') }}</span>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <span class="font-semibold text-gray-700">Perihal</span>
                <span class="text-gray-500">:</span>
                <span class="text-gray-800">{{ $tt->sk->perihal_sk }}</span>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <span class="font-semibold text-gray-700">Pengesah</span>
                <span class="text-gray-500">:</span>
                <span class="text-gray-800">{{ $tt->sk->pengesah }}</span>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <span class="font-semibold text-gray-700">Plaintext</span>
                <span class="text-gray-500">:</span>
                <span class="text-gray-800 font-mono text-xs break-all">{{ $tt->plaintext }}</span>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <span class="font-semibold text-gray-700">Tgl Ditandatangani</span>
                <span class="text-gray-500">:</span>
                <span class="text-gray-800">{{ $tt->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>

    {{-- QR Code --}}
    @if($tt->qr_path)
    <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm">
        <div class="px-5 py-3 font-bold text-white text-sm" style="background-color:#1e3a5f">
            QR Code Tanda Tangan
        </div>
        <div class="bg-gray-50 px-5 py-5 flex items-center gap-6">
            <img src="{{ Storage::url($tt->qr_path) }}"
                 alt="QR Code" class="w-28 h-28 border border-gray-200 rounded-lg p-1 bg-white">
            <div class="text-xs text-gray-500 leading-relaxed">
                <p class="font-semibold text-gray-700 mb-1">URL Verifikasi:</p>
                <p class="font-mono break-all">{{ route('verifikasi.cek', ['token' => hash('sha256', $tt->id_sk . $tt->plaintext . $tt->created_at)]) }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Unduh SK Penugasan --}}
    <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm">
        </div>
        <div class="bg-gray-50 px-5 py-5">
            <p class="text-sm text-gray-500 mb-4">
                Pilih file yang ingin diunduh.
            </p>

            <div class="relative inline-block" x-data="{ open: false }">
                {{-- Tombol utama + dropdown trigger --}}
                <div class="flex">
                    {{-- Tombol kiri: label --}}
                    <div class="flex items-center gap-2 px-5 py-2.5 text-white text-sm font-bold rounded-l-lg"
                         style="background-color:#9b1c1c">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Unduh
                    </div>

                    {{-- Tombol kanan: chevron dropdown --}}
                    <button type="button"
                            onclick="toggleDropdown()"
                            class="flex items-center px-3 py-2.5 text-white rounded-r-lg
                                   border-l border-red-800 transition hover:opacity-90"
                            style="background-color:#9b1c1c">
                        <svg id="chevron-icon" xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 transition-transform duration-200"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>

                {{-- Dropdown — muncul ke atas --}}
                 <div id="dropdown-menu"
                     class="hidden absolute left-0 w-60 bg-white rounded-xl
                            shadow-xl border border-gray-100 overflow-hidden z-10"
                     style="bottom: calc(100% + 8px);">

                    {{-- Opsi 1: SK Bertanda Tangan --}}
                    <a href="{{ route('tanda-tangan.download', $tt->id_tt) }}"
                       class="flex items-center gap-3 px-4 py-3.5 hover:bg-gray-50
                              transition border-b border-gray-100 group">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center
                                    flex-shrink-0" style="background-color:#e8f0fb">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                 style="color:#1e3a5f" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0
                                         012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1
                                         0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">SK Bertanda Tangan</p>
                            <p class="text-xs text-gray-400 mt-0.5">PDF dengan QR Code</p>
                        </div>
                    </a>

                    {{-- Opsi 2: QR Code saja --}}
                    <a href="{{ route('tanda-tangan.download-qr', $tt->id_tt) }}"
                       class="flex items-center gap-3 px-4 py-3.5 hover:bg-gray-50
                              transition group">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center
                                    flex-shrink-0" style="background-color:#fde8e8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                 style="color:#9b1c1c" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6z
                                         M17 14h.01M14 14h.01M20 14h.01M14 17h.01
                                         M17 17h.01M20 17h.01M14 20h.01M17 20h.01M20 20h.01"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">QR Code Saja</p>
                            <p class="text-xs text-gray-400 mt-0.5">File gambar PNG</p>
                        </div>
                    </a>

                </div>
            </div>
    </div>

    {{-- Kembali --}}
    <div>
        <a href="{{ route('tanda-tangan.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold hover:opacity-70 transition"
           style="color:#1e3a5f">
            ← Kembali ke Daftar
        </a>
    </div>

</div>

<script>
function toggleDropdown() {
    const menu    = document.getElementById('dropdown-menu');
    const chevron = document.getElementById('chevron-icon');

    menu.classList.toggle('hidden');
    chevron.style.transform = menu.classList.contains('hidden')
        ? 'rotate(0deg)'
        : 'rotate(180deg)';
}

// Tutup dropdown kalau klik di luar
document.addEventListener('click', function(e) {
    const menu    = document.getElementById('dropdown-menu');
    const trigger = e.target.closest('button[onclick="toggleDropdown()"]');
    if (!trigger && menu && !menu.classList.contains('hidden')) {
        menu.classList.add('hidden');
        document.getElementById('chevron-icon').style.transform = 'rotate(0deg)';
    }
});
</script>
@endsection