@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('content')
<p class="text-gray-500 mb-8">Selamat Datang, <strong>{{ Auth::user()->name }}</strong>.</p>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    {{-- Card Data Kunci --}}
    <a href="{{ route('kunci.index') }}"
       class="flex items-center gap-4 p-6 bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition hover:-translate-y-0.5">
        <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color:#e8f0fb">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" style="color:#1e3a5f" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
        </div>
        <div>
            <p class="font-bold text-gray-800">Data Kunci</p>
            <p class="text-xs text-gray-500 mt-0.5">Kelola kunci RSA</p>
        </div>
    </a>

    {{-- Card Data SK --}}
    <a href="{{ route('sk.index') }}"
       class="flex items-center gap-4 p-6 bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition hover:-translate-y-0.5">
        <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color:#e8f0fb">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" style="color:#1e3a5f" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div>
            <p class="font-bold text-gray-800">Data SK</p>
            <p class="text-xs text-gray-500 mt-0.5">Kelola SK Penugasan</p>
        </div>
    </a>

    {{-- Card Tanda Tangan --}}
    <a href="{{ route('tanda-tangan.index') }}"
       class="flex items-center gap-4 p-6 bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition hover:-translate-y-0.5">
        <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color:#fde8e8">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" style="color:#9b1c1c" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
        </div>
        <div>
            <p class="font-bold text-gray-800">Data Tanda Tangan</p>
            <p class="text-xs text-gray-500 mt-0.5">Tanda tangani SK</p>
        </div>
    </a>
</div>
@endsection