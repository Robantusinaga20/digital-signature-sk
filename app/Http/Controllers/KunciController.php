<?php
namespace App\Http\Controllers;

use App\Models\Kunci;
use App\Services\RsaService;
use Illuminate\Http\Request;

class KunciController extends Controller
{
    protected RsaService $rsa;

    public function __construct(RsaService $rsa)
    {
        $this->rsa = $rsa;
    }

   public function index()
{
    $kunciAktif = Kunci::latest()->first();
    return view('kunci.index', compact('kunciAktif'));
}


    public function generate()
    {
        $keys = $this->rsa->generateKeyPair();
        return response()->json($keys);
    }

    public function store(Request $request)
{
    $request->validate([
        'n' => ['required', 'string'],
        'e' => ['required', 'string'],
        'd' => ['required', 'string'],
    ]);

    // Update kunci lama atau buat baru
    Kunci::updateOrCreate(
        ['id_kunci' => Kunci::latest()->first()?->id_kunci ?? 0],
        [
            'n' => $request->n,
            'e' => $request->e,
            'd' => $request->d,
        ]
    );

    return redirect()->route('kunci.index')
                     ->with('success', 'Kunci RSA berhasil disimpan.');
}

    public function destroy($id)
    {
        $kunci = Kunci::findOrFail($id);

        if ($kunci->tandaTangan()->count() > 0) {
            return back()->with('error', 'Kunci tidak dapat dihapus karena sedang digunakan.');
        }

        $kunci->delete();
        return redirect()->route('kunci.index')
                         ->with('success', 'Kunci berhasil dihapus.');
    }
}