@extends('layouts.app')
@section('page-title', 'Data SK Penugasan')

@section('content')
<div class="mb-6">
    
    <p class="text-sm text-gray-500 mb-4">
        Kelola Data Surat Keputusan Penugasan.
    </p>

    <a href="{{ route('sk.create') }}"
        class="inline-block px-5 py-2.5 rounded-lg text-white text-sm font-bold transition hover:opacity-90"
        style="background-color:#9b1c1c">
        + Tambah Data SK
    </a>

</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
    <table class="w-full text-sm">
        <thead>
            <tr style="background-color:#1e3a5f" class="text-white">
                <th class="px-4 py-3 text-left font-semibold">No</th>
                <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                <th class="px-4 py-3 text-left font-semibold">No SK</th>
                <th class="px-4 py-3 text-left font-semibold">Perihal</th>
                <th class="px-4 py-3 text-left font-semibold">Pengesah</th>
                <th class="px-4 py-3 text-center font-semibold">File</th>
                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
            </tr>
        </thead>
                <tbody class="divide-y divide-gray-100">
            @forelse($sks as $i => $sk)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $sk->tanggal_sk->format('d/m/Y') }}</td>
                <td class="px-4 py-3 font-medium text-gray-800">{{ $sk->nomor_sk }}</td>
                <td class="px-4 py-3 text-gray-600 max-w-xs truncate">{{ $sk->perihal_sk }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $sk->pengesah }}</td>

                {{-- Lihat PDF — selalu file asli --}}
                <td class="px-4 py-3 text-center">
                    <a href="{{ route('sk.file', $sk->id_sk) }}" target="_blank"
                    class="px-3 py-1.5 rounded-lg text-white text-xs font-semibold
                            transition hover:opacity-90 inline-block"
                    style="background-color:#1e3a5f">
                        Lihat PDF
                    </a>
                </td>

                <td class="px-4 py-3">
                    <div class="flex items-center justify-center gap-2">

                        {{-- Edit: hanya sebelum ditandatangani --}}
                        @if(!$sk->tandaTangan)
                        <a href="{{ route('sk.edit', $sk->id_sk) }}"
                        class="px-3 py-1.5 rounded-lg text-white text-xs font-semibold
                                transition hover:opacity-90"
                        style="background-color:#1e3a5f">
                            Edit
                        </a>
                        @endif

                        {{-- Hapus: selalu bisa diklik --}}
                        <form method="POST" action="{{ route('sk.destroy', $sk->id_sk) }}"
                            onsubmit="return confirm(
                                '{{ $sk->tandaTangan
                                    ? 'SK ini sudah ditandatangani. Menghapus SK akan menghapus tanda tangan juga. Lanjutkan?'
                                    : 'Hapus SK ' . $sk->nomor_sk . '?' }}'
                            )">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1.5 rounded-lg text-white text-xs
                                        font-semibold transition hover:opacity-90"
                                    style="background-color:#9b1c1c">
                                Hapus
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-8 text-center text-gray-400 text-sm">
                    Belum ada data SK. Silakan tambah data SK baru.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection