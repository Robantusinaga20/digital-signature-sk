<?php
namespace App\Http\Controllers;

use App\Models\SkPenugasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class SkPenugasanController extends Controller
{
    public function index()
    {
        $sks = SkPenugasan::latest()->get();
        return view('sk.index', compact('sks'));
    }

    public function create()
    {
        return view('sk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_sk'   => ['required', 'string', 'max:30'],
            'tanggal_sk' => ['required', 'date'],
            'perihal_sk' => ['required', 'string'],
            'pengesah'   => ['required', 'string', 'max:100'],
            'sk_file'    => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ], [
            'sk_file.required' => 'File PDF SK wajib diunggah.',
            'sk_file.mimes'    => 'File harus berformat PDF.',
            'sk_file.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        // Validasi jumlah halaman PDF — hanya boleh 1 halaman
        $tempPath = $request->file('sk_file')->getRealPath();
        if (!$this->validatePdfPages($tempPath)) {
            return back()
                ->withInput()
                ->withErrors(['sk_file' => 'File PDF hanya boleh terdiri dari 1 halaman.']);
        }

        $path = $request->file('sk_file')->store('sk_files', 'public');

        SkPenugasan::create([
            'nomor_sk'   => $request->nomor_sk,
            'tanggal_sk' => $request->tanggal_sk,
            'perihal_sk' => $request->perihal_sk,
            'pengesah'   => $request->pengesah,
            'sk_path'    => $path,
        ]);

        return redirect()->route('sk.index')
                        ->with('success', 'Data SK berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $sk = SkPenugasan::findOrFail($id);
        return view('sk.edit', compact('sk'));
    }

    public function update(Request $request, $id)
    {
        $sk = SkPenugasan::findOrFail($id);

        $request->validate([
            'nomor_sk'   => ['required', 'string', 'max:30'],
            'tanggal_sk' => ['required', 'date'],
            'perihal_sk' => ['required', 'string'],
            'pengesah'   => ['required', 'string', 'max:100'],
            'sk_file'    => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ], [
            'sk_file.mimes' => 'File harus berformat PDF.',
            'sk_file.max'   => 'Ukuran file maksimal 5MB.',
        ]);

        // Validasi jumlah halaman jika ada file baru
        if ($request->hasFile('sk_file')) {
            $tempPath = $request->file('sk_file')->getRealPath();
            if (!$this->validatePdfPages($tempPath)) {
                return back()
                    ->withInput()
                    ->withErrors(['sk_file' => 'File PDF hanya boleh terdiri dari 1 halaman.']);
            }

            Storage::disk('public')->delete($sk->sk_path);
            $data['sk_path'] = $request->file('sk_file')->store('sk_files', 'public');
        }

        $data = [
            'nomor_sk'   => $request->nomor_sk,
            'tanggal_sk' => $request->tanggal_sk,
            'perihal_sk' => $request->perihal_sk,
            'pengesah'   => $request->pengesah,
        ];

        if ($request->hasFile('sk_file')) {
            Storage::disk('public')->delete($sk->sk_path);
            $data['sk_path'] = $request->file('sk_file')->store('sk_files', 'public');
        }

        $sk->update($data);

        return redirect()->route('sk.index')
                         ->with('success', 'Data SK berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sk = SkPenugasan::with('tandaTangan')->findOrFail($id);

        // Jika sudah ditandatangani — hapus data tanda tangan dulu
        if ($sk->tandaTangan) {
            // Hapus file QR Code
            Storage::disk('public')->delete($sk->tandaTangan->qr_path);

            // Hapus record tanda tangan
            $sk->tandaTangan->delete();

            // Hapus file PDF signed
            Storage::disk('public')->delete($sk->sk_path);

            // Hapus file PDF asli
            if ($sk->original_sk_path) {
                Storage::disk('public')->delete($sk->original_sk_path);
            }
        } else {
            // Belum ditandatangani — hapus file PDF asli saja
            Storage::disk('public')->delete($sk->sk_path);
        }

        $sk->delete();

        return redirect()->route('sk.index')
                        ->with('success', 'Data SK berhasil dihapus.');
    }

    public function viewFile($id)
    {
        $sk   = SkPenugasan::findOrFail($id);
        $path = storage_path('app/public/' . $sk->sk_path);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->file($path, ['Content-Type' => 'application/pdf']);
    }
    private function validatePdfPages(string $filePath): bool
    {
        try {
            $parser  = new Parser();
            $pdf     = $parser->parseFile($filePath);
            $pages   = $pdf->getPages();
            return count($pages) === 1;
        } catch (\Exception $e) {
            return false;
        }
    }
    }