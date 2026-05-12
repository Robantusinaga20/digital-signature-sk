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
        <form method="POST" action="{{ route('verifikasi.proses') }}"
              enctype="multipart/form-data">
            @csrf
            <div class="flex items-center gap-12">

                {{-- Upload area --}}
                <div class="relative w-48 h-48 rounded-xl border-2 border-dashed border-gray-300
                            flex items-center justify-center cursor-pointer
                            hover:border-blue-400 transition bg-gray-50"
                     id="dropzone"
                     onclick="document.getElementById('file-input').click()">

                    <input type="file" id="file-input" name="qr_image"
                           accept="image/*" class="hidden"
                           onchange="previewGambar(this)">

                    {{-- Preview --}}
                    <img id="preview-img" src="" alt="preview"
                         class="hidden absolute inset-0 w-full h-full
                                object-contain rounded-xl p-2">

                    {{-- Icon plus --}}
                    <div id="icon-plus">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="1.5" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                </div>

                {{-- Text & button --}}
                <div class="max-w-xs">
                    <p class="text-gray-600 text-center mb-6 leading-relaxed">
                        Unggah QR Code SK Penugasan<br>untuk verifikasi Keaslian
                    </p>

                    {{-- Error --}}
                    @if(session('error'))
                    <div class="mb-4 px-3 py-2 rounded-lg text-xs font-medium
                                text-white text-center"
                         style="background-color:#9b1c1c">
                        {{ session('error') }}
                    </div>
                    @endif

                    <button type="submit"
                        id="btn-verifikasi"
                        onclick="return cekFile()"
                        class="w-full py-3 rounded-xl text-white font-bold text-sm
                            tracking-wide transition hover:opacity-90"
                        style="background-color:#1e3a5f">
                        Verifikasi
                    </button>

                {{-- Pesan error file kosong --}}
                    <p id="error-file" class="hidden mt-2 text-xs text-center font-medium"
                    style="color:#9b1c1c">
                        ⚠ Silakan unggah gambar QR Code terlebih dahulu.
                    </p>
                </div>

            </div>
        </form>
    </div>

<script>
function previewGambar(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('preview-img').classList.remove('hidden');
        document.getElementById('icon-plus').classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}

// Drag & drop
const dropzone = document.getElementById('dropzone');
dropzone.addEventListener('dragover', function(e) {
    e.preventDefault();
    dropzone.style.borderColor = '#1e3a5f';
});
dropzone.addEventListener('dragleave', function() {
    dropzone.style.borderColor = '#d1d5db';
});
dropzone.addEventListener('drop', function(e) {
    e.preventDefault();
    dropzone.style.borderColor = '#d1d5db';
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const dt    = new DataTransfer();
        dt.items.add(file);
        const input = document.getElementById('file-input');
        input.files = dt.files;
        previewGambar(input);
    }
});
function cekFile() {
    const input = document.getElementById('file-input');
    const error = document.getElementById('error-file');

    if (!input.files || input.files.length === 0) {
        error.classList.remove('hidden');

        // Highlight dropzone
        const dropzone = document.getElementById('dropzone');
        dropzone.style.borderColor = '#9b1c1c';
        dropzone.style.backgroundColor = '#fef2f2';

        // Reset setelah 3 detik
        setTimeout(() => {
            error.classList.add('hidden');
            dropzone.style.borderColor = '#d1d5db';
            dropzone.style.backgroundColor = '#f9fafb';
        }, 3000);

        return false; // Cegah form submit
    }

    return true; // Lanjutkan submit
}
</script>

</body>
</html>