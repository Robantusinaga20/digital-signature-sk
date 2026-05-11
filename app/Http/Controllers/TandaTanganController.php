<?php
namespace App\Http\Controllers;

use App\Models\Kunci;
use App\Models\SkPenugasan;
use App\Models\TandaTangan;
use App\Services\RsaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

class TandaTanganController extends Controller
{
    protected RsaService $rsa;

    public function __construct(RsaService $rsa)
    {
        $this->rsa = $rsa;
    }

    public function index()
    {
        $sks = SkPenugasan::with('tandaTangan')->latest()->get();
        return view('tanda-tangan.index', compact('sks'));
    }

    public function sign($id_sk)
    {
        $sk    = SkPenugasan::findOrFail($id_sk);
        $kunci = Kunci::latest()->first();

        if (!$kunci) {
            return back()->with('error', 'Belum ada kunci RSA. Silakan generate kunci terlebih dahulu.');
        }

        if ($sk->tandaTangan) {
            return back()->with('error', 'SK ini sudah ditandatangani.');
        }

        // Format plaintext
        $plaintext = $this->rsa->formatPlaintext(
            $sk->nomor_sk,
            $sk->pengesah,
            $sk->tanggal_sk->year
        );

        // Enkripsi dengan kunci privat (d)
        $encrypted       = $this->rsa->encrypt($plaintext, $kunci->d, $kunci->n);
        $ciphertextStore = $this->rsa->serializeCipher($encrypted);

        // Generate token verifikasi unik
        $token = hash('sha256', $sk->id_sk . $plaintext . now());

        // URL verifikasi publik
        $verifyUrl = route('verifikasi.cek', ['token' => $token]);

        // Generate QR Code PNG
        Storage::disk('public')->makeDirectory('qr_codes');
        $qrFilename = 'qr_' . $sk->id_sk . '_' . time() . '.png';
        $qrPath     = 'qr_codes/' . $qrFilename;
        $qrFullPath = storage_path('app/public/' . $qrPath);

        $this->generateQrPng($verifyUrl, $qrFullPath);

        // Simpan path PDF asli SEBELUM dimodifikasi
        $originalSkPath = $sk->sk_path;

        // Embed QR ke PDF asli — hasilnya disimpan ke file BARU
        $signedFilename = 'signed_' . $sk->id_sk . '_' . time() . '.pdf';
        $signedPath     = 'sk_files/' . $signedFilename;
        $signedFullPath = storage_path('app/public/' . $signedPath);

        $this->embedQrToPdf(
            storage_path('app/public/' . $originalSkPath),
            $qrFullPath,
            $signedFullPath,
        );

        // Simpan tanda tangan ke database
        TandaTangan::create([
            'id_sk'      => $sk->id_sk,
            'id_kunci'   => $kunci->id_kunci,
            'plaintext'  => $plaintext,
            'ciphertext' => $ciphertextStore,
            'qr_path'    => $qrPath,
            'token'      => $token,
        ]);

        // Update sk_path ke file signed yang baru
        $sk->update(['sk_path' => $signedPath]);

        return redirect()->route('tanda-tangan.index')
                         ->with('success', "SK {$sk->nomor_sk} berhasil ditandatangani.");
    }

    private function generateQrPng(string $url, string $outputPath): void
    {
        $qrCode = new QrCode(
            data: $url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255),
        );

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        file_put_contents($outputPath, $result->getString());
    }

    private function embedQrToPdf(
        string $originalPdfPath,
        string $qrFullPath,
        string $signedFullPath
    ): void {
        // Verifikasi file PNG valid
        if (!file_exists($qrFullPath) || filesize($qrFullPath) === 0) {
            throw new \RuntimeException('File QR Code tidak valid: ' . $qrFullPath);
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $qrFullPath);
        finfo_close($finfo);

        if ($mime !== 'image/png') {
            throw new \RuntimeException('File QR bukan PNG valid. MIME: ' . $mime);
        }

        // Inisialisasi FPDI dengan PDF ASLI
        $pdf = new Fpdi();
        $pdf->setSourceFile($originalPdfPath);

        $templateId = $pdf->importPage(1);
        $size       = $pdf->getTemplateSize($templateId);

        $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
        $pdf->AddPage($orientation, [$size['width'], $size['height']]);
        $pdf->useTemplate($templateId, 0, 0, $size['width'], $size['height']);

        // =============================================
        // POSISI QR — SK HANUBA
        // Area TTD: kanan bawah, di antara
        // "HANUBA" dan "JONTAR SINAGA, SE"
        // A4 = 210 x 297 mm
        // =============================================
        $qrSize = 35; // mm — lebih kecil agar rapi

        // X: di kanan teks blok TTD (~115mm dari kiri)
        $x = $size['width'] * 0.67;

        // Y: di bawah "HANUBA", sebelum "JONTAR SINAGA"
        // ~74% dari tinggi = sekitar 220mm dari atas
        $y = $size['height'] * 0.68;

        $pdf->Image($qrFullPath, $x, $y, $qrSize, $qrSize, 'PNG');

        // Simpan ke file BARU (bukan replace asli)
        $pdf->Output('F', $signedFullPath);
    }

    public function detail($id_tt)
    {
        $tt = TandaTangan::with(['sk', 'kunci'])->findOrFail($id_tt);
        return view('tanda-tangan.detail', compact('tt'));
    }

    public function download($id_tt)
    {
        $tt   = TandaTangan::with('sk')->findOrFail($id_tt);
        $path = storage_path('app/public/' . $tt->sk->sk_path);

        if (!file_exists($path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download(
            $path,
            'SK_' . $tt->sk->nomor_sk . '_signed.pdf'
        );
    }

        public function downloadQr($id_tt)
    {
        $tt   = TandaTangan::findOrFail($id_tt);
        $path = storage_path('app/public/' . $tt->qr_path);

        if (!file_exists($path)) {
            return back()->with('error', 'File QR Code tidak ditemukan.');
        }

        return response()->download(
            $path,
            'QR_SK_' . $tt->id_sk . '.png'
        );
    }
}