<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi SK — Digital Signature</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white flex flex-col">

    {{-- Header --}}
    <header class="flex items-center justify-between px-8 py-4 border-b border-gray-200 bg-white">
        <span class="font-black text-sm tracking-wide" style="color:#1e3a5f">
            APLIKASI DIGITAL SIGNATURE SK PENUGASAN
        </span>
        <a href="{{ route('login') }}"
           class="px-5 py-2 rounded-lg text-sm font-bold text-white transition hover:opacity-90"
           style="background-color:#1e3a5f">
            Login
        </a>
    </header>

    {{-- Content --}}
    <div class="flex-1 flex items-center justify-center p-8">
        <div class="flex items-center gap-12">
            {{-- Upload area --}}
            <div class="w-48 h-48 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-blue-400 transition bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            {{-- Text & button --}}
            <div class="max-w-xs">
                <p class="text-gray-600 text-center mb-6 leading-relaxed">
                    Unggah QR Code / SK Penugasan untuk verifikasi Keaslian
                </p>
                <button class="w-full py-3 rounded-xl text-white font-bold text-sm tracking-wide transition hover:opacity-90"
                        style="background-color:#1e3a5f">
                    Verifikasi
                </button>
            </div>
        </div>
    </div>

</body>
</html>