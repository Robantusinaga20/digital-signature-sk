@extends('layouts.app')
@section('page-title', 'Tambah Akun')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold mb-1.5" style="color:#1e3a5f">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required maxlength="25"
                       class="w-full px-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition
                              {{ $errors->has('name') ? 'border-red-500 focus:ring-red-300' : 'border-gray-200 focus:ring-blue-300' }}"
                       style="background-color:#f1f5f9">
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1.5" style="color:#1e3a5f">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required maxlength="12"
                       class="w-full px-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition
                              {{ $errors->has('username') ? 'border-red-500 focus:ring-red-300' : 'border-gray-200 focus:ring-blue-300' }}"
                       style="background-color:#f1f5f9">
                @error('username')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1.5" style="color:#1e3a5f">Password</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition
                              {{ $errors->has('password') ? 'border-red-500 focus:ring-red-300' : 'border-gray-200 focus:ring-blue-300' }}"
                       style="background-color:#f1f5f9">
                @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1.5" style="color:#1e3a5f">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                       class="w-full px-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition
                              border-gray-200 focus:ring-blue-300"
                       style="background-color:#f1f5f9">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg text-white text-sm font-bold transition hover:opacity-90"
                        style="background-color:#1e3a5f">
                    Simpan
                </button>
                <a href="{{ route('users.index') }}"
                   class="px-6 py-2.5 rounded-lg text-sm font-bold border border-gray-300 text-gray-600 hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection