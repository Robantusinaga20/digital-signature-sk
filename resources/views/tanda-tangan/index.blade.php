@extends('layouts.app')
@section('page-title', 'Data Tanda Tangan')

@section('content')
<p class="text-sm text-gray-500 mb-6">Tanda Tangani Data SK Penugasan.</p>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
    <table class="w-full text-sm">
        <thead>
            <tr style="background-color:#1e3a5f" class="text-white">
                <th class="px-4 py-3 text-left font-semibold">No</th>
                <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                <th class="px-4 py-3 text-left font-semibold">No SK</th>
                <th class="px-4 py-3 text-left font-semibold">Perihal</th>
                <th class="px-4 py-3 text-center font-semibold">Status</th>
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
                <td class="px-4 py-3 text-center">
                    @if($sk->tandaTangan)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold text-white"
                              style="background-color:#1e3a5f">
                            Sudah Ditandatangani
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-semibold text-white"
                              style="background-color:#9b1c1c">
                            Belum Ditandatangani
                        </span>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center justify-center gap-2">
                        @if(!$sk->tandaTangan)
                            {{-- Belum ditandatangani --}}
                         <form id="sign-sk-{{ $sk->id_sk }}" method="POST"
                            action="{{ route('tanda-tangan.sign', $sk->id_sk) }}">
                            @csrf
                            <button type="button"
                                    onclick="bukaModalSign(
                                        'sign-sk-{{ $sk->id_sk }}',
                                        'Tandatangani SK {{ $sk->nomor_sk }}? Proses ini tidak dapat dibatalkan.'
                                    )"
                                    class="px-3 py-1.5 rounded-lg text-white text-xs font-semibold
                                        transition hover:opacity-90"
                                    style="background-color:#9b1c1c">
                                Sign
                            </button>
                        </form>
                        @else
                            {{-- Sudah ditandatangani: hanya Detail --}}
                            <a href="{{ route('tanda-tangan.detail', $sk->tandaTangan->id_tt) }}"
                            class="px-3 py-1.5 rounded-lg text-white text-xs font-semibold
                                    transition hover:opacity-90"
                            style="background-color:#1e3a5f">
                                Detail
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-gray-400 text-sm">
                    Belum ada data SK. Silakan tambah data SK terlebih dahulu.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection