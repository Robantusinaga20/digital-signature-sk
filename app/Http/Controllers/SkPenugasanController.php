<?php
namespace App\Http\Controllers;

use App\Models\SkPenugasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $sk = SkPenugasan::findOrFail($id);

        if ($sk->tandaTangan) {
            return back()->with('error', 'SK tidak dapat dihapus karena sudah ditandatangani.');
        }

        Storage::disk('public')->delete($sk->sk_path);
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
}