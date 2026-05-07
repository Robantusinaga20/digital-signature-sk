<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Digital Signature SK Penugasan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col" style="background-color:#1e3a5f">

    {{-- Header --}}
    <header class="flex items-center justify-between px-8 py-4 bg-white border-b border-gray-200">
        <span class="font-black text-sm tracking-wide" style="color:#1e3a5f">
            APLIKASI DIGITAL SIGNATURE SK PENUGASAN
        </span>
        <a href="{{ route('login') }}"
           class="px-5 py-2 rounded-lg text-sm font-bold text-white transition hover:opacity-90"
           style="background-color:#9b1c1c">
            ← Kembali
        </a>
    </header>

    {{-- Register Card --}}
    <div class="flex-1 flex items-center justify-center p-6">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8">
            <h2 class="text-2xl font-black text-center mb-8" style="color:#1e3a5f">Daftar Akun</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-semibold mb-1.5" style="color:#1e3a5f">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full px-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition
                                  {{ $errors->has('name') ? 'border-red-500 focus:ring-red-300' : 'border-gray-200 focus:ring-blue-300' }}"
                           style="background-color:#f1f5f9">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Username --}}
                <div>
                    <label class="block text-sm font-semibold mb-1.5" style="color:#1e3a5f">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required
                           maxlength="12"
                           class="w-full px-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition
                                  {{ $errors->has('username') ? 'border-red-500 focus:ring-red-300' : 'border-gray-200 focus:ring-blue-300' }}"
                           style="background-color:#f1f5f9">
                    @error('username')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-semibold mb-1.5" style="color:#1e3a5f">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition
                                  {{ $errors->has('password') ? 'border-red-500 focus:ring-red-300' : 'border-gray-200 focus:ring-blue-300' }}"
                           style="background-color:#f1f5f9">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label class="block text-sm font-semibold mb-1.5" style="color:#1e3a5f">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition
                                  border-gray-200 focus:ring-blue-300"
                           style="background-color:#f1f5f9">
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full py-3 rounded-lg text-white font-bold text-sm tracking-wide transition hover:opacity-90"
                        style="background-color:#1e3a5f">
                    Daftar
                </button>

                <p class="text-center text-sm text-gray-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}"
                       class="font-semibold hover:underline"
                       style="color:#9b1c1c">
                        Login disini
                    </a>
                </p>
            </form>
        </div>
    </div>

</body>
</html>