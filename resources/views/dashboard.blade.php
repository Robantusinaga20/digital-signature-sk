@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('content')
<p class="text-gray-500 mb-6">
    Selamat Datang, <strong>{{ Auth::user()->name }}</strong>.
</p>

{{-- Statistik --}}
<div class="grid grid-cols-3 gap-5 mb-6">

    {{-- Total SK --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background-color:#e8f0fb">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" style="color:#1e3a5f"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0
                         01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div>
            <p class="text-3xl font-black" style="color:#1e3a5f">{{ $totalSk }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Total SK Penugasan</p>
        </div>
    </div>

    {{-- Sudah TTD --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background-color:#dcfce7">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-3xl font-black text-green-600">{{ $totalTtd }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Sudah Ditandatangani</p>
        </div>
    </div>

    {{-- Belum TTD --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background-color:#fde8e8">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" style="color:#9b1c1c"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-3xl font-black" style="color:#9b1c1c">{{ $totalBelumTtd }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Belum Ditandatangani</p>
        </div>
    </div>

</div>

{{-- Menu navigasi --}}
<div class="grid grid-cols-3 gap-5">

    {{-- Card Data Kunci --}}
    <a href="{{ route('kunci.index') }}"
       class="flex items-center gap-4 p-5 bg-white rounded-xl border border-gray-200
              shadow-sm hover:shadow-md transition hover:-translate-y-0.5">
        <div class="w-11 h-11 rounded-lg flex items-center justify-center flex-shrink-0"
             style="background-color:#e8f0fb">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color:#1e3a5f"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1
                         1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="font-bold text-gray-800 text-sm">Data Kunci</p>
            <p class="text-xs text-gray-500 mt-0.5">Kelola kunci RSA</p>
        </div>
        @if($kunciAktif)
            <span class="text-xs px-2 py-1 rounded-full font-medium flex-shrink-0"
                  style="background-color:#dcfce7; color:#16a34a">Aktif</span>
        @else
            <span class="text-xs px-2 py-1 rounded-full font-medium flex-shrink-0"
                  style="background-color:#fde8e8; color:#9b1c1c">Belum ada</span>
        @endif
    </a>

    {{-- Card Data SK --}}
    <a href="{{ route('sk.index') }}"
       class="flex items-center gap-4 p-5 bg-white rounded-xl border border-gray-200
              shadow-sm hover:shadow-md transition hover:-translate-y-0.5">
        <div class="w-11 h-11 rounded-lg flex items-center justify-center flex-shrink-0"
             style="background-color:#e8f0fb">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color:#1e3a5f"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0
                         01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="font-bold text-gray-800 text-sm">Data SK</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ $totalSk }} surat keputusan</p>
        </div>
    </a>

    {{-- Card Tanda Tangan --}}
    <a href="{{ route('tanda-tangan.index') }}"
       class="flex items-center gap-4 p-5 bg-white rounded-xl border border-gray-200
              shadow-sm hover:shadow-md transition hover:-translate-y-0.5">
        <div class="w-11 h-11 rounded-lg flex items-center justify-center flex-shrink-0"
             style="background-color:#fde8e8">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color:#9b1c1c"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536
                         3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="font-bold text-gray-800 text-sm">Tanda Tangan</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ $totalTtd }} sudah ditandatangani</p>
        </div>
    </a>

</div>
@endsection