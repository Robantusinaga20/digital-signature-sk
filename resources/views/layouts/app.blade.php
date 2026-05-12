<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans">
<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 flex-shrink-0 flex flex-col" style="background-color:#1e3a5f">
        {{-- Logo --}}
        <div class="p-5 border-b border-blue-900">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="text-white font-bold text-sm leading-tight">APLIKASI DIGITAL SIGNATURE SK PENUGASAN</span>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('dashboard') ? 'bg-white text-blue-900' : 'text-blue-100 hover:bg-blue-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('kunci.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('kunci.*') ? 'bg-white text-blue-900' : 'text-blue-100 hover:bg-blue-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
                Data Kunci
            </a>
            <a href="{{ route('sk.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('sk.*') ? 'bg-white text-blue-900' : 'text-blue-100 hover:bg-blue-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Data SK
            </a>
            <a href="{{ route('tanda-tangan.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('tanda-tangan.*') ? 'bg-white text-blue-900' : 'text-blue-100 hover:bg-blue-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Tanda Tangan
            </a>
        </nav>

    {{-- Logout + Manajemen Akun --}}
        <div class="p-4 border-t border-blue-900 flex items-center gap-2">
            {{-- Ikon User / Manajemen Akun --}}
            <a href="{{ route('users.index') }}"
               title="Manajemen Akun"
               class="flex items-center justify-center w-10 h-10 rounded-lg transition flex-shrink-0
                      {{ request()->routeIs('users.*') ? 'bg-white text-blue-900' : 'text-blue-100 hover:bg-blue-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </a>

            {{-- Tombol Logout --}}
            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold text-white transition hover:opacity-90"
                        style="background-color:#9b1c1c">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col">
        {{-- Header --}}
        <header class="px-8 py-4 border-b border-gray-200 flex items-center justify-between bg-white">
            <h1 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
            <span class="text-sm text-gray-500">Halo, <strong>{{ Auth::user()->name }}</strong></span>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-8 bg-gray-50">
            {{-- Alert success --}}
            @if(session('success'))
            <div id="alert-success"
                 class="mb-4 flex items-center justify-between gap-3 px-4 py-3 rounded-lg text-sm font-medium text-white transition-all duration-500"
                 style="background-color:#1e3a5f">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <div class="flex items-center gap-3">
                    {{-- Progress bar --}}
                    <div class="w-16 h-1 rounded-full bg-white bg-opacity-30 overflow-hidden">
                        <div id="progress-success"
                             class="h-full rounded-full bg-white transition-all ease-linear"
                             style="width:100%">
                        </div>
                    </div>
                    {{-- Tombol close --}}
                    <button onclick="dismissAlert('success')"
                            class="flex-shrink-0 hover:opacity-70 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            @endif

            {{-- Alert error --}}
            @if(session('error'))
            <div id="alert-error"
                 class="mb-4 flex items-center justify-between gap-3 px-4 py-3 rounded-lg text-sm font-medium text-white transition-all duration-500"
                 style="background-color:#9b1c1c">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
                <div class="flex items-center gap-3">
                    {{-- Progress bar --}}
                    <div class="w-16 h-1 rounded-full bg-white bg-opacity-30 overflow-hidden">
                        <div id="progress-error"
                             class="h-full rounded-full bg-white transition-all ease-linear"
                             style="width:100%">
                        </div>
                    </div>
                    {{-- Tombol close --}}
                    <button onclick="dismissAlert('error')"
                            class="flex-shrink-0 hover:opacity-70 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

</div>

{{-- Modal Konfirmasi Hapus --}}
{{-- Modal Konfirmasi Hapus --}}
<div id="modal-hapus" class="fixed inset-0 z-50 hidden items-center justify-center"
     style="background:rgba(0,0,0,0.4); display:none">
    <div class="bg-white rounded-2xl shadow-xl mx-4 overflow-hidden"
         style="width:100%; max-width:360px">

        {{-- Body --}}
        <div class="flex items-start gap-3 px-5 py-5">
            <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"
                 style="background-color:#fde8e8">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" style="color:#9b1c1c"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0
                             01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1
                             1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-gray-800 text-sm">Konfirmasi Hapus</p>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed" id="modal-pesan">
                    Apakah Anda yakin ingin menghapus data ini?
                </p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex border-t border-gray-100">
            <button onclick="tutupModal()"
                    class="flex-1 py-2.5 text-xs font-semibold text-gray-600
                           hover:bg-gray-50 transition">
                Batal
            </button>
            <div class="w-px bg-gray-100"></div>
            <button id="modal-confirm-btn" onclick="konfirmasiHapus()"
                    class="flex-1 py-2.5 text-xs font-bold text-white transition hover:opacity-90"
                    style="background-color:#9b1c1c">
                Hapus
            </button>
        </div>
    </div>
</div>

<script>
        function dismissAlert(type) {
            const alert = document.getElementById('alert-' + type);
            if (!alert) return;

            // Fade out
            alert.style.opacity    = '0';
            alert.style.transform  = 'translateY(-8px)';
            alert.style.transition = 'opacity 0.4s ease, transform 0.4s ease';

            setTimeout(() => alert.remove(), 400);
        }

        function autoAlert(type, duration) {
            const alert    = document.getElementById('alert-' + type);
            const progress = document.getElementById('progress-' + type);
            if (!alert) return;

            // Jalankan progress bar
            setTimeout(() => {
                if (progress) {
                    progress.style.transitionDuration = duration + 'ms';
                    progress.style.width = '0%';
                }
            }, 100);

            // Auto dismiss setelah duration
            setTimeout(() => dismissAlert(type), duration);
        }

        // Jalankan saat halaman load — 4 detik
        document.addEventListener('DOMContentLoaded', () => {
            autoAlert('success', 4000);
            autoAlert('error', 4000);
        });

            let formToSubmit = null;
        function bukaModa(formId, pesan) {
            formToSubmit = document.getElementById(formId);
            document.getElementById('modal-pesan').textContent = pesan;
            document.getElementById('modal-confirm-btn').textContent = 'Hapus';
            document.getElementById('modal-confirm-btn').style.backgroundColor = '#9b1c1c';
            document.getElementById('modal-hapus').style.display = 'flex';
        }

        function bukaModalSign(formId, pesan) {
            formToSubmit = document.getElementById(formId);
            document.getElementById('modal-pesan').textContent = pesan;
            document.getElementById('modal-confirm-btn').textContent = 'Tandatangani';
            document.getElementById('modal-confirm-btn').style.backgroundColor = '#1e3a5f';
            document.getElementById('modal-hapus').style.display = 'flex';
        }

        function tutupModal() {
            document.getElementById('modal-hapus').style.display = 'none';
            formToSubmit = null;
        }

        function konfirmasiHapus() {
            if (formToSubmit) formToSubmit.submit();
            tutupModal();
        }

        // Tutup modal klik background
        document.getElementById('modal-hapus').addEventListener('click', function(e) {
            if (e.target === this) tutupModal();
        });
    
</script>
</body>
</html>