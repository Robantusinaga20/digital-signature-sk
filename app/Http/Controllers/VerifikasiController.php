<?php
namespace App\Http\Controllers;

use App\Models\TandaTangan;
use App\Services\RsaService;
use Illuminate\Http\Request;
use Zxing\QrReader;

class VerifikasiController extends Controller
{
    protected RsaService $rsa;

    public function __construct(RsaService $rsa)
    {
        $this->rsa = $rsa;
    }

    // Halaman utama verifikasi publik
    public function index()
    {
        return view('verifikasi.index');
    }

    // Proses verifikasi via token dari QR Code
    public function cek($token)
    {
        // Cari tanda tangan berdasarkan token
        $tt = TandaTangan::with(['sk', 'kunci'])
                         ->where('token', $token)
                         ->first();

        // Token tidak ditemukan
        if (!$tt) {
            return view('verifikasi.hasil', [
                'valid'  => false,
                'pesan'  => 'Token tidak ditemukan. Dokumen tidak valid atau QR Code telah dimanipulasi.',
                'tt'     => null,
            ]);
        }

        // Dekripsi ciphertext dengan kunci publik (e)
        try {
            $cipherArray  = $this->rsa->deserializeCipher($tt->ciphertext);
            $decrypted    = $this->rsa->decrypt($cipherArray, $tt->kunci->e, $tt->kunci->n);
            $valid        = $decrypted === $tt->plaintext;
        } catch (\Exception $e) {
            $valid     = false;
            $decrypted = '';
        }

        return view('verifikasi.hasil', [
            'valid'     => $valid,
            'pesan'     => $valid
                            ? 'Dokumen SK ini valid dan asli.'
                            : 'Dokumen tidak valid. Tanda tangan digital tidak cocok.',
            'tt'        => $tt,
            'decrypted' => $decrypted,
        ]);
    }
    public function proses(Request $request)
{
    $request->validate([
        'qr_image' => ['required', 'image', 'max:5120'],
    ], [
        'qr_image.required' => 'Silakan unggah gambar QR Code terlebih dahulu.',
        'qr_image.image'    => 'File harus berupa gambar.',
    ]);

    $imagePath = $request->file('qr_image')->getRealPath();

    // Decode QR Code dari gambar menggunakan GD
    $token = $this->decodeQrFromImage($imagePath);

    if (!$token) {
        return back()->with('error', 'QR Code tidak terdeteksi. Pastikan gambar jelas dan berisi QR Code yang valid.');
    }

    // Ekstrak token dari URL jika QR berisi URL penuh
    if (filter_var($token, FILTER_VALIDATE_URL)) {
        // Ambil segment terakhir dari URL sebagai token
        $parts = explode('/', rtrim($token, '/'));
        $token = end($parts);
    }

    return redirect()->route('verifikasi.cek', ['token' => $token]);
}

  private function decodeQrFromImage(string $imagePath): ?string
{
    try {
        $reader = new QrReader($imagePath);
        $text   = $reader->text();
        return $text ?: null;
    } catch (\Exception $e) {
        return null;
    }
}
}