@extends('layouts.app')
@section('page-title', 'Edit Data SK')

@section('content')

<div class="max-w-7xl">

    <form method="POST"
          action="{{ route('sk.update', $sk->id_sk) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- WRAPPER UTAMA --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr;
                    gap: 20px; margin-bottom: 20px;">

            {{-- ================= KOLOM KIRI ================= --}}
            <div class="space-y-7">

                {{-- Nomor SK --}}
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color:#1e3a5f">
                        Nomor SK
                    </label>
                    <input type="text" name="nomor_sk"
                           value="{{ old('nomor_sk', $sk->nomor_sk) }}"
                           required maxlength="30"
                           class="w-full px-5 py-3 rounded-xl border text-sm
                                  focus:outline-none focus:ring-2 transition
                                  {{ $errors->has('nomor_sk') ? 'border-red-500 focus:ring-red-300' : 'border-gray-200 focus:ring-blue-300' }}"
                           style="background-color:#f1f5f9">
                    @error('nomor_sk')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color:#1e3a5f">
                        Tanggal
                    </label>
                    <input type="date" name="tanggal_sk"
                           value="{{ old('tanggal_sk', $sk->tanggal_sk->format('Y-m-d')) }}"
                           required
                           class="w-full px-5 py-3 rounded-xl border text-sm
                                  focus:outline-none focus:ring-2 transition
                                  {{ $errors->has('tanggal_sk') ? 'border-red-500 focus:ring-red-300' : 'border-gray-200 focus:ring-blue-300' }}"
                           style="background-color:#f1f5f9">
                    @error('tanggal_sk')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Perihal --}}
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color:#1e3a5f">
                        Perihal
                    </label>
                    <input type="text" name="perihal_sk"
                           value="{{ old('perihal_sk', $sk->perihal_sk) }}"
                           required
                           class="w-full px-5 py-3 rounded-xl border text-sm
                                  focus:outline-none focus:ring-2 transition
                                  {{ $errors->has('perihal_sk') ? 'border-red-500 focus:ring-red-300' : 'border-gray-200 focus:ring-blue-300' }}"
                           style="background-color:#f1f5f9">
                    @error('perihal_sk')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- ================= KOLOM KANAN ================= --}}
            <div class="space-y-7">

                {{-- Pengesah --}}
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color:#1e3a5f">
                        Pengesah
                    </label>
                    <input type="text" name="pengesah"
                           value="{{ old('pengesah', $sk->pengesah) }}"
                           required maxlength="100"
                           class="w-full px-5 py-3 rounded-xl border text-sm
                                  focus:outline-none focus:ring-2 transition
                                  {{ $errors->has('pengesah') ? 'border-red-500 focus:ring-red-300' : 'border-gray-200 focus:ring-blue-300' }}"
                           style="background-color:#f1f5f9">
                    @error('pengesah')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- File --}}
                <div>
                    <label class="block text-sm font-semibold mb-0" style="color:#1e3a5f">
                        File
                    </label>

                    {{-- Info file saat ini --}}
                    <div class="flex items-center gap-2 mb-2 mt-1.5 px-3 py-2 rounded-lg text-xs"
                         style="background-color:#e8f0fb; color:#1e3a5f">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <span class="flex-1 truncate font-medium">{{ basename($sk->sk_path) }}</span>
                        <a href="{{ route('sk.file', $sk->id_sk) }}" target="_blank"
                           class="font-semibold underline hover:opacity-70 flex-shrink-0">
                            Lihat
                        </a>
                    </div>

                    <div class="relative border border-dashed rounded-xl px-5 py-6 h-[118px]
                                {{ $errors->has('sk_file') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"
                         style="background-color:#f8fafc" id="dropzone">

                        <input type="file" name="sk_file" id="sk_file" accept=".pdf"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                               onchange="updateFileName(this)">

                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-6 h-6 text-gray-500 mt-1 flex-shrink-0"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                      d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-700 leading-6" id="file_label">
                                    Ganti File atau seret kesini
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Kosongkan jika tidak ingin mengganti file
                                </p>
                            </div>
                        </div>
                    </div>

                    @error('sk_file')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- BUTTON --}}
                <div class="flex justify-end gap-3 pt-8 mt-6">
                    <a href="{{ route('sk.index') }}"
                       class="px-8 py-3 rounded-full text-sm font-bold border border-gray-300
                              text-gray-600 hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-8 py-2.5 rounded-full text-white text-sm font-bold
                                   transition hover:opacity-90"
                            style="background-color:#9b1c1c">
                        Simpan Perubahan
                    </button>
                </div>

            </div>

        </div>

    </form>

</div>

<script>
function updateFileName(input) {
    const label = document.getElementById('file_label');
    if (input.files && input.files[0]) {
        label.innerHTML        = '✓ ' + input.files[0].name;
        label.style.color      = '#1e3a5f';
        label.style.fontWeight = '600';
    }
}
</script>
@endsection