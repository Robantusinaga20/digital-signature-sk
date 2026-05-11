<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Verifikasi — Digital Signature SK Penugasan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-gray-50">

    {{-- Header --}}
    <header class="flex items-center justify-between px-8 py-4 bg-white border-b border-gray-200">
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
        <div class="w-full max-w-lg">

            {{-- Status Badge --}}
            <div class="flex justify-center mb-6">
                @if($valid)
                <div class="flex items-center gap-3 px-6 py-3 rounded-full text-white font-bold text-sm shadow"
                     style="background-color:#1e3a5f">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                    Dokumen Valid
                </div>
                @else
                <div class="flex items-center gap-3 px-6 py-3 rounded-full text-white font-bold text-sm shadow"
                     style="background-color:#9b1c1c">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Dokumen Tidak Valid
                </div>
                @endif
            </div>

            {{-- Card Hasil --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- Header card --}}
                <div class="px-6 py-4 font-bold text-white text-sm"
                     style="background-color:{{ $valid ? '#1e3a5f' : '#9b1c1c' }}">
                    Hasil Verifikasi
                </div>

                <div class="p-6">
                    @if($tt)
                    {{-- Detail SK --}}
                    <div class="flex gap-6">
                        {{-- QR Code --}}
                        @if($tt->qr_path)
                        <div class="flex-shrink-0">
                            <img src="{{ Storage::url($tt->qr_path) }}"
                                 alt="QR Code"
                                 class="w-28 h-28 border border-gray-200 rounded-lg p-1 bg-white">
                        </div>
                        @endif

                        {{-- Info --}}
                        <div class="flex-1 space-y-2.5 text-sm">
                            <div class="grid grid-cols-5 gap-1">
                                <span class="col-span-2 font-semibold text-gray-600">No SK</span>
                                <span class="text-gray-400">:</span>
                                <span class="col-span-2 text-gray-800 font-medium">{{ $tt->sk->nomor_sk }}</span>
                            </div>
                            <div class="grid grid-cols-5 gap-1">
                                <span class="col-span-2 font-semibold text-gray-600">Tanggal SK</span>
                                <span class="text-gray-400">:</span>
                                <span class="col-span-2 text-gray-800">{{ $tt->sk->tanggal_sk->format('d/m/Y') }}</span>
                            </div>
                            <div class="grid grid-cols-5 gap-1">
                                <span class="col-span-2 font-semibold text-gray-600">Perihal</span>
                                <span class="text-gray-400">:</span>
                                <span class="col-span-2 text-gray-800">{{ $tt->sk->perihal_sk }}</span>
                            </div>
                            <div class="grid grid-cols-5 gap-1">
                                <span class="col-span-2 font-semibold text-gray-600">Pengesah</span>
                                <span class="text-gray-400">:</span>
                                <span class="col-span-2 text-gray-800">{{ $tt->sk->pengesah }}</span>
                            </div>
                            <div class="grid grid-cols-5 gap-1">
                                <span class="col-span-2 font-semibold text-gray-600">Tgl TTD</span>
                                <span class="text-gray-400">:</span>
                                <span class="col-span-2 text-gray-800">{{ $tt->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="grid grid-cols-5 gap-1">
                                <span class="col-span-2 font-semibold text-gray-600">Status</span>
                                <span class="text-gray-400">:</span>
                                <span class="col-span-2 font-bold
                                            {{ $valid ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $valid ? '✓ Valid' : '✗ Tidak Valid' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @else
                    {{-- Token tidak ditemukan --}}
                    <div class="text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 text-red-300"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-gray-500 text-sm">{{ $pesan }}</p>
                    </div>
                    @endif
                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 border-t border-gray-100 flex justify-end">
                    <a href="{{ route('verifikasi') }}"
                       class="px-5 py-2 rounded-lg text-white text-sm font-bold
                              transition hover:opacity-90"
                       style="background-color:#1e3a5f">
                        Selesai
                    </a>
                </div>
            </div>

        </div>
    </div>

</body>
</html>