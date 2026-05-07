@extends('layouts.app')
@section('page-title', 'Manajemen Akun')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <p class="text-sm text-gray-500">Daftar akun yang dapat mengakses sistem.</p>
    <a href="{{ route('users.create') }}"
       class="px-5 py-2.5 rounded-lg text-white text-sm font-bold transition hover:opacity-90"
       style="background-color:#9b1c1c">
        + Tambah Akun
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
    <table class="w-full text-sm">
        <thead>
            <tr style="background-color:#1e3a5f" class="text-white">
                <th class="px-4 py-3 text-left font-semibold">No</th>
                <th class="px-4 py-3 text-left font-semibold">Nama</th>
                <th class="px-4 py-3 text-left font-semibold">Username</th>
                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($users as $i => $user)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                <td class="px-4 py-3 font-medium text-gray-800">{{ $user->name }}</td>
                <td class="px-4 py-3 text-gray-600 font-mono">{{ $user->username }}</td>
                <td class="px-4 py-3 text-center">
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('users.destroy', $user) }}"
                          onsubmit="return confirm('Hapus akun {{ $user->name }}?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1.5 rounded-lg text-white text-xs font-semibold transition hover:opacity-90"
                                style="background-color:#9b1c1c">
                            Hapus
                        </button>
                    </form>
                    @else
                    <span class="text-xs text-gray-400 italic">Akun aktif</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-4 py-8 text-center text-gray-400 text-sm">
                    Belum ada akun terdaftar.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection