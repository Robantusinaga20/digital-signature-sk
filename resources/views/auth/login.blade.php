<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Digital Signature SK Penugasan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col" style="background-color:#1e3a5f">

    {{-- Header --}}
    <header class="flex items-center justify-between px-8 py-4 bg-white border-b border-gray-200">
        <span class="font-black text-sm tracking-wide" style="color:#1e3a5f">
            APLIKASI DIGITAL SIGNATURE SK PENUGASAN
        </span>
        <a href="{{ route('verifikasi') }}"
           class="px-5 py-2 rounded-lg text-sm font-bold text-white transition hover:opacity-90"
           style="background-color:#9b1c1c">
            ← Kembali
        </a>
    </header>

    {{-- Login Card --}}
    <div class="flex-1 flex items-center justify-center p-6">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8">
            <h2 class="text-2xl font-black text-center mb-8" style="color:#1e3a5f">Selamat Datang</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Notif username/password salah --}}
                @if($errors->any())
                <div id="alert-login"
                    class="flex items-center justify-between gap-3 px-4 py-3 rounded-lg
                            text-sm font-medium text-white"
                    style="background-color:#9b1c1c">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Username atau password salah. Silakan coba lagi.</span>
                    </div>
                    <button type="button" onclick="document.getElementById('alert-login').remove()"
                            class="flex-shrink-0 hover:opacity-70 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                @endif

                {{-- Username --}}
                <div>
                    <label class="block text-sm font-semibold mb-1.5" style="color:#1e3a5f">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required autofocus
                           class="w-full px-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition
                                  {{ $errors->has('username') ? 'border-red-500 focus:ring-red-300' : 'border-gray-200 focus:ring-blue-300' }}"
                           style="background-color:#f1f5f9">
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-semibold mb-1.5" style="color:#1e3a5f">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition
                                  {{ $errors->has('password') ? 'border-red-500 focus:ring-red-300' : 'border-gray-200 focus:ring-blue-300' }}"
                           style="background-color:#f1f5f9">
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full py-3 rounded-lg text-white font-bold text-sm tracking-wide transition hover:opacity-90"
                        style="background-color:#1e3a5f">
                    Login
                </button>

           

            </form>
        </div>
    </div>

</body>

<script>
// Auto dismiss notif login setelah 4 detik
document.addEventListener('DOMContentLoaded', function() {
    const alert = document.getElementById('alert-login');
    if (!alert) return;

    // Progress bar
    const bar = document.createElement('div');
    bar.style.cssText = 'position:absolute;bottom:0;left:0;height:3px;width:100%;' +
                        'background:rgba(255,255,255,0.4);border-radius:0 0 8px 8px;';
    const progress = document.createElement('div');
    progress.style.cssText = 'height:100%;width:100%;background:rgba(255,255,255,0.8);' +
                             'border-radius:0 0 8px 8px;transition:width 4s linear;';
    bar.appendChild(progress);
    alert.style.position = 'relative';
    alert.appendChild(bar);

    setTimeout(() => { progress.style.width = '0%'; }, 100);
    setTimeout(() => {
        alert.style.opacity    = '0';
        alert.style.transform  = 'translateY(-8px)';
        alert.style.transition = 'opacity 0.4s, transform 0.4s';
        setTimeout(() => alert.remove(), 400);
    }, 4000);
});
</script>
</html>