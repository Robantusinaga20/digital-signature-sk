<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi SK — Digital Signature</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col" style="background-color:#f8fafc">

    {{-- Header --}}
    <header class="flex items-center justify-between px-8 py-4 border-b border-gray-200 shadow-sm" style="background-color:#1e3a5f">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                 style="background-color:#ffffff">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" style="color:#1e3a5f"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0
                             01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <span class="font-black text-sm tracking-wide" style="color:#ffffff">
                APLIKASI DIGITAL SIGNATURE SK PENUGASAN
            </span>
        </div>
        <a href="{{ route('login') }}"
           class="px-5 py-2 rounded-lg text-sm font-bold text-primary transition hover:opacity-90 shadow-sm"
           style="background-color:#ffffff">
            Login
        </a>
    </header>

    {{-- Content --}}
    <div class="flex-1 flex items-center justify-center p-8">
        <form method="POST" action="{{ route('verifikasi.proses') }}"
              enctype="multipart/form-data">
            @csrf

            <div class="flex items-center gap-14">

                {{-- Upload area --}}
                <div class="flex flex-col items-center gap-3">
                    <div class="relative rounded-2xl border-2 border-dashed cursor-pointer
                                transition-all duration-300 overflow-hidden"
                         id="dropzone"
                         style="width:220px; height:220px;
                                border-color:#cbd5e1;
                                background-color:#f1f5f9"
                         onclick="document.getElementById('file-input').click()">

                        <input type="file" id="file-input" name="qr_image"
                               accept="image/*" class="hidden"
                               onchange="previewGambar(this)">

                        {{-- Preview --}}
                        <img id="preview-img" src="" alt="preview"
                             class="hidden absolute inset-0 w-full h-full
                                    object-contain rounded-2xl p-3">

                        {{-- Placeholder --}}
                        <div id="placeholder"
                             class="absolute inset-0 flex flex-col items-center
                                    justify-center gap-3 p-4">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center"
                                 style="background-color:#e2e8f0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7"
                                     style="color:#94a3b8" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="1.5" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <p class="text-xs text-center font-medium" style="color:#94a3b8">
                                Klik atau seret gambar<br>QR Code kesini
                            </p>
                        </div>
                    </div>

                    {{-- Nama file --}}
                    <p id="nama-file"
                       class="hidden text-xs font-medium text-center max-w-[220px] truncate"
                       style="color:#1e3a5f"></p>
                </div>

                {{-- Kanan --}}
                <div class="flex flex-col gap-4" style="width:280px">

                    {{-- Judul & deskripsi --}}
                    <div>
                        <h2 class="text-lg font-black mb-1" style="color:#1e3a5f">
                            Verifikasi Keaslian
                        </h2>
                        <p class="text-sm leading-relaxed" style="color:#64748b">
                            Unggah gambar QR Code dari SK Penugasan untuk memverifikasi keaslian dokumen.
                        </p>
                    </div>

                    {{-- Divider --}}
                    <div class="h-px w-full" style="background-color:#e2e8f0"></div>

                    {{-- Info steps --}}
                    <div class="flex flex-col gap-2.5">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center
                                        text-white text-xs font-bold flex-shrink-0"
                                 style="background-color:#1e3a5f">1</div>
                            <p class="text-xs" style="color:#64748b">Unggah gambar QR Code</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center
                                        text-white text-xs font-bold flex-shrink-0"
                                 style="background-color:#1e3a5f">2</div>
                            <p class="text-xs" style="color:#64748b">Klik tombol Verifikasi</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center
                                        text-white text-xs font-bold flex-shrink-0"
                                 style="background-color:#1e3a5f">3</div>
                            <p class="text-xs" style="color:#64748b">Lihat hasil verifikasi dokumen</p>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="h-px w-full" style="background-color:#e2e8f0"></div>

                    {{-- Error session --}}
                    @if(session('error'))
                    <div class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs
                                font-medium text-white"
                         style="background-color:#9b1c1c">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                    @endif

                    {{-- Error file kosong --}}
                    <p id="error-file"
                       class="hidden text-xs font-medium text-center"
                       style="color:#9b1c1c">
                        ⚠ Silakan unggah gambar QR Code terlebih dahulu.
                    </p>

                    {{-- Tombol Verifikasi --}}
                    <button type="submit"
                            id="btn-verifikasi"
                            onclick="return cekFile()"
                            class="w-full py-3 rounded-xl text-white font-bold text-sm
                                   tracking-wide transition hover:opacity-90 shadow-sm"
                            style="background-color:#9b1c1c">
                        Verifikasi
                    </button>

                </div>
            </div>
        </form>
    </div>

    {{-- Footer --}}
    <footer class="text-center py-4 text-xs" style="color:#94a3b8">
        PKBM HANUBA &copy; {{ date('Y') }} — Sistem Digital Signature SK Penugasan
    </footer>

<script>
function previewGambar(input) {
    if (!input.files || !input.files[0]) return;

    const file     = input.files[0];
    const reader   = new FileReader();
    const dropzone = document.getElementById('dropzone');

    reader.onload = function(e) {
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('preview-img').classList.remove('hidden');
        document.getElementById('placeholder').classList.add('hidden');
        document.getElementById('nama-file').textContent = file.name;
        document.getElementById('nama-file').classList.remove('hidden');
        document.getElementById('error-file').classList.add('hidden');

        // Update style dropzone saat ada gambar
        dropzone.style.borderColor       = '#1e3a5f';
        dropzone.style.backgroundColor   = '#f0f4ff';
        dropzone.style.borderStyle       = 'solid';
    };

    reader.readAsDataURL(file);
}

function cekFile() {
    const input    = document.getElementById('file-input');
    const error    = document.getElementById('error-file');
    const dropzone = document.getElementById('dropzone');

    if (!input.files || input.files.length === 0) {
        error.classList.remove('hidden');
        dropzone.style.borderColor     = '#9b1c1c';
        dropzone.style.backgroundColor = '#fef2f2';

        setTimeout(() => {
            error.classList.add('hidden');
            dropzone.style.borderColor     = '#cbd5e1';
            dropzone.style.backgroundColor = '#f1f5f9';
        }, 3000);

        return false;
    }
    return true;
}

// Drag & drop
const dropzone = document.getElementById('dropzone');
dropzone.addEventListener('dragover', function(e) {
    e.preventDefault();
    dropzone.style.borderColor     = '#1e3a5f';
    dropzone.style.backgroundColor = '#e8f0fb';
});
dropzone.addEventListener('dragleave', function() {
    const hasFile = document.getElementById('file-input').files.length > 0;
    if (!hasFile) {
        dropzone.style.borderColor     = '#cbd5e1';
        dropzone.style.backgroundColor = '#f1f5f9';
    }
});
dropzone.addEventListener('drop', function(e) {
    e.preventDefault();
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const dt    = new DataTransfer();
        dt.items.add(file);
        const input = document.getElementById('file-input');
        input.files = dt.files;
        previewGambar(input);
    }
});
</script>

</body>
</html>