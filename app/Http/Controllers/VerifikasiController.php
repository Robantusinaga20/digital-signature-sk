<?php
namespace App\Http\Controllers;

use App\Models\TandaTangan;
use App\Services\RsaService;
use Illuminate\Http\Request;

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
}