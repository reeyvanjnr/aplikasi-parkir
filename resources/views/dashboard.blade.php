@extends('layouts.parking')
@section('title', 'Dashboard '.ucfirst($role))
@section('footer-description', 'Dashboard '.ucfirst($role))
@section('content')
<div class="dashboard-card mx-auto max-w-2xl py-10 text-center">
    <div class="mx-auto mb-6 grid size-16 place-items-center rounded-3xl bg-gradient-to-br from-indigo-500 to-violet-500 text-2xl font-bold text-white shadow-xl shadow-indigo-500/25" aria-hidden="true">{{ strtoupper(substr($role, 0, 1)) }}</div>
    <p class="mb-2 text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600">Aplikasi Parkir</p>
    <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Dashboard {{ ucfirst($role) }}</h1>
    <p class="mt-3 text-slate-600">Selamat datang, <span class="font-semibold text-slate-800">{{ $user->nama_user }}</span>.</p>

    <div class="mt-8 rounded-2xl border border-indigo-100/80 bg-indigo-100/40 p-6">
        @if($role === 'admin')
            <a class="inline-flex rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white shadow-lg shadow-indigo-500/20 transition hover:bg-indigo-700" href="{{ route('admin.dashboard') }}">Buka panel admin</a>
        @elseif($role === 'petugas')
            <a class="inline-flex rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white shadow-lg shadow-indigo-500/20 transition hover:bg-indigo-700" href="{{ route('petugas.index') }}">Buka transaksi parkir</a>
        @elseif($role === 'owner')
            <a class="inline-flex rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white shadow-lg shadow-indigo-500/20 transition hover:bg-indigo-700" href="{{ route('owner.report') }}">Buka rekap transaksi</a>
        @endif
    </div>
</div>
@endsection
