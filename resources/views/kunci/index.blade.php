@extends('layouts.app')
@section('page-title', 'Data Kunci')

@section('content')
<p class="text-sm text-gray-500 mb-6">Bangkitkan pasangan kunci untuk menandatangani SK.</p>

<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <form method="POST" action="{{ route('kunci.store') }}" id="formKunci" class="space-y-5">
            @csrf

        {{-- Modulus N --}}
            <div>
                <label class="block text-sm font-semibold mb-1.5" style="color:#1e3a5f">n</label>
                <textarea name="n" id="field_n" rows="3" readonly
                          placeholder="Klik Generate untuk membangkitkan nilai n..."
                          class="w-full px-4 py-3 rounded-lg border border-gray-200 text-xs font-mono
                                 focus:outline-none bg-gray-50 resize-none text-gray-700">{{ $kunciAktif?->n ?? old('n') }}</textarea>
                @error('n')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                {{-- Kunci Publik E --}}
                <div>
                    <label class="block text-sm font-semibold mb-1.5" style="color:#1e3a5f">Kunci Publik (e)</label>
                    <textarea name="e" id="field_e" rows="3" readonly
                              placeholder="Nilai e..."
                              class="w-full px-4 py-3 rounded-lg border border-gray-200 text-xs font-mono
                                     focus:outline-none bg-gray-50 resize-none text-gray-700">{{ $kunciAktif?->e ?? old('e') }}</textarea>
                    @error('e')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Kunci Privat D --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-sm font-semibold" style="color:#1e3a5f">Kunci Privat (d)</label>
                        <button type="button" onclick="togglePrivat()"
                                class="flex items-center gap-1 text-xs font-medium transition hover:opacity-70"
                                style="color:#1e3a5f" id="btnToggleD" title="Tampilkan/Sembunyikan">
                            {{-- Icon Eye --}}
                            <svg id="iconEye" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{-- Icon Eye Off --}}
                            <svg id="iconEyeOff" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                            <span id="labelToggleD">Tampilkan</span>
                        </button>
                    </div>

                    {{-- Field D tersembunyi (blur) --}}
                    <div class="relative">
                        <textarea name="d" id="field_d" rows="3" readonly
                                  placeholder="Nilai d..."
                                  class="w-full px-4 py-3 rounded-lg border border-gray-200 text-xs font-mono
                                         focus:outline-none bg-gray-50 resize-none text-gray-700 transition-all duration-300"
                                  style="filter: blur(4px); user-select: none;">{{ $kunciAktif?->d ?? old('d') }}</textarea>

                        {{-- Overlay klik untuk tampilkan --}}
                        <div id="overlayD" onclick="togglePrivat()"
                             class="absolute inset-0 flex items-center justify-center cursor-pointer rounded-lg"
                             style="background:rgba(30,58,95,0.04)">
                            <span class="text-xs font-semibold px-3 py-1.5 rounded-full text-white"
                                  style="background-color:#1e3a5f; opacity:0.85">
                                🔒 Klik untuk tampilkan
                            </span>
                        </div>
                    </div>
                    @error('d')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Info kunci aktif --}}
            @if($kunciAktif)
            <div class="flex items-start gap-3 p-3 rounded-lg border text-sm"
                 style="background-color:#fff7ed; border-color:#fed7aa">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 mt-0.5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
                <div>
                    <p class="font-semibold text-orange-700">Sudah ada kunci aktif</p>
                    <p class="text-orange-600 text-xs mt-0.5">
                        Kunci dibuat pada {{ $kunciAktif->created_at->format('d/m/Y H:i') }}.
                        Menyimpan kunci baru akan menggantikan kunci lama.
                    </p>
                </div>
            </div>
            @endif

            {{-- Loading --}}
            <div id="loadingIndicator" class="hidden text-sm font-medium" style="color:#1e3a5f">
                ⏳ Sedang membangkitkan kunci RSA...
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3 pt-2">
                <button type="button" id="btnGenerate" onclick="generateKunci()"
                        class="px-6 py-2.5 rounded-lg text-white text-sm font-bold transition hover:opacity-90"
                        style="background-color:#1e3a5f">
                    Generate
                </button>
                <button type="submit" id="btnSimpan" disabled
                        class="px-6 py-2.5 rounded-lg text-white text-sm font-bold transition disabled:opacity-40 hover:opacity-90"
                        style="background-color:#9b1c1c">
                    Simpan
                </button>
                <button type="button" id="btnBatal" onclick="resetForm()" disabled
                        class="px-6 py-2.5 rounded-lg text-sm font-bold border border-gray-300 text-gray-600
                               hover:bg-gray-50 transition disabled:opacity-40">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// State
let isPrivatVisible = false;

function generateKunci() {
    const btn       = document.getElementById('btnGenerate');
    const btnSimpan = document.getElementById('btnSimpan');
    const btnBatal  = document.getElementById('btnBatal');
    const loading   = document.getElementById('loadingIndicator');

    btn.disabled = true;
    loading.classList.remove('hidden');

    fetch('{{ route('kunci.generate') }}')
        .then(res => res.json())
        .then(data => {
            document.getElementById('field_n').value = data.n;
            document.getElementById('field_e').value = data.e;
            document.getElementById('field_d').value = data.d;

            // Reset tampilan d ke tersembunyi saat generate baru
            isPrivatVisible = false;
            applyVisibilityD();

            btnSimpan.disabled = false;
            btnBatal.disabled  = false;
            btn.disabled       = false;
            loading.classList.add('hidden');
        })
        .catch(() => {
            alert('Gagal generate kunci. Silakan coba lagi.');
            btn.disabled = false;
            loading.classList.add('hidden');
        });
}

function resetForm() {
    document.getElementById('field_n').value = '';
    document.getElementById('field_e').value = '';
    document.getElementById('field_d').value = '';

    // Sembunyikan kembali field d
    isPrivatVisible = false;
    applyVisibilityD();

    document.getElementById('btnSimpan').disabled = true;
    document.getElementById('btnBatal').disabled  = true;
}

function togglePrivat() {
    isPrivatVisible = !isPrivatVisible;
    applyVisibilityD();
}

function applyVisibilityD() {
    const fieldD      = document.getElementById('field_d');
    const overlayD    = document.getElementById('overlayD');
    const iconEye     = document.getElementById('iconEye');
    const iconEyeOff  = document.getElementById('iconEyeOff');
    const labelToggle = document.getElementById('labelToggleD');

    if (isPrivatVisible) {
        fieldD.style.filter        = 'blur(0)';
        fieldD.style.userSelect    = 'text';
        overlayD.style.display     = 'none';
        iconEye.classList.add('hidden');
        iconEyeOff.classList.remove('hidden');
        labelToggle.textContent    = 'Sembunyikan';
    } else {
        fieldD.style.filter        = 'blur(4px)';
        fieldD.style.userSelect    = 'none';
        overlayD.style.display     = 'flex';
        iconEye.classList.remove('hidden');
        iconEyeOff.classList.add('hidden');
        labelToggle.textContent    = 'Tampilkan';
    }
}
</script>
@endsection