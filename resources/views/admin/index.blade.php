@extends('layouts.parking')
@section('title', 'Dashboard Admin')
@section('footer-description', 'Ringkasan Dashboard Admin')
@section('content')
<div class="mb-8 flex flex-wrap items-end justify-between gap-4">
    <div>
        <p class="mb-2 text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600">Ringkasan sistem</p>
        <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Dashboard Admin</h1>
        <p class="mt-2 text-slate-600">Pantau dan kelola operasional parkir dari satu tempat.</p>
    </div>
    <span class="rounded-full border border-white/80 bg-white/60 px-4 py-2 text-sm font-medium text-slate-600 shadow-sm">{{ now()->format('d M Y') }}</span>
</div>

<div class="stats grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <article class="stat-card stat-users rounded-2xl border border-indigo-100/80 bg-indigo-100/55 p-6 shadow-sm shadow-indigo-900/5">
        <span class="stat-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 19h5v-1.5a3.5 3.5 0 0 0-5.6-2.8M16 19H8m8 0v-1.5c0-.99-.36-1.9-.96-2.6M8 19H3v-1.5a3.5 3.5 0 0 1 5.6-2.8M8 19v-1.5c0-.99.36-1.9.96-2.6m0 0a5 5 0 0 1 6.08 0M15 7.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm5 2a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0ZM9 9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
            </svg>
        </span>
        <p class="text-sm font-semibold text-indigo-700">Total pengguna</p>
        <p class="mt-3 text-4xl font-bold tracking-tight text-slate-900">{{ $userCount }}</p>
        <a class="mt-4 inline-flex text-sm font-semibold text-indigo-700 hover:text-indigo-900" href="{{ route('admin.users.index') }}">Kelola user <span class="ml-1" aria-hidden="true">→</span></a>
    </article>
    <article class="stat-card stat-tariffs rounded-2xl border border-violet-100/80 bg-violet-100/55 p-6 shadow-sm shadow-violet-900/5">
        <span class="stat-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                <path stroke-linecap="round" stroke-linejoin="round" d="m20.6 13.4-7.2 7.2a2 2 0 0 1-2.8 0l-7.2-7.2a2 2 0 0 1 0-2.8l7.2-7.2a2 2 0 0 1 1.4-.6h6a2 2 0 0 1 2 2v6a2 2 0 0 1-.6 1.4Z"/>
                <circle cx="16.5" cy="7.5" r="1.25"/>
            </svg>
        </span>
        <p class="text-sm font-semibold text-violet-700">Jenis tarif</p>
        <p class="mt-3 text-4xl font-bold tracking-tight text-slate-900">{{ $tarifCount }}</p>
        <a class="mt-4 inline-flex text-sm font-semibold text-violet-700 hover:text-violet-900" href="{{ route('admin.tariffs.index') }}">Kelola tarif <span class="ml-1" aria-hidden="true">→</span></a>
    </article>
    <article class="stat-card stat-areas rounded-2xl border border-teal-100/80 bg-teal-100/55 p-6 shadow-sm shadow-teal-900/5">
        <span class="stat-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                <path stroke-linecap="round" stroke-linejoin="round" d="m3 7 9-4 9 4v10l-9 4-9-4V7Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="m3.5 7.2 8.5 4 8.5-4M12 11.5V21"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 5.2 17 9.5"/>
            </svg>
        </span>
        <p class="text-sm font-semibold text-teal-700">Area parkir</p>
        <p class="mt-3 text-4xl font-bold tracking-tight text-slate-900">{{ $areaCount }}</p>
        <a class="mt-4 inline-flex text-sm font-semibold text-teal-700 hover:text-teal-900" href="{{ route('admin.areas.index') }}">Kelola area <span class="ml-1" aria-hidden="true">→</span></a>
    </article>
    <article class="stat-card stat-vehicles rounded-2xl border border-amber-100/80 bg-amber-100/55 p-6 shadow-sm shadow-amber-900/5">
        <span class="stat-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                <path stroke-linecap="round" stroke-linejoin="round" d="m3 14 1.8-5.4A2.5 2.5 0 0 1 7.2 7h9.6a2.5 2.5 0 0 1 2.4 1.6L21 14v5h-2v-2H5v2H3v-5Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 13h15M7 15.5h.01M17 15.5h.01"/>
            </svg>
        </span>
        <p class="text-sm font-semibold text-amber-700">Kendaraan sedang parkir</p>
        <p class="mt-3 text-4xl font-bold tracking-tight text-slate-900">{{ $activeTransactions }}</p>
        <a class="mt-4 inline-flex text-sm font-semibold text-amber-700 hover:text-amber-900" href="{{ route('admin.logs.index') }}">Lihat log aktivitas <span class="ml-1" aria-hidden="true">→</span></a>
    </article>
</div>

<section class="quick-access mt-8 rounded-2xl border border-white/80 bg-white/40 p-6">
    <h2 class="text-lg font-bold text-slate-900">Akses cepat</h2>
    <div class="quick-access-grid mt-4 flex flex-wrap gap-3">
        <a class="quick-access-card rounded-xl border border-white/90 bg-white/70 px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:bg-white hover:shadow-md" href="{{ route('admin.vehicles.index') }}">
            <span class="quick-access-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m3 14 1.8-5.4A2.5 2.5 0 0 1 7.2 7h9.6a2.5 2.5 0 0 1 2.4 1.6L21 14v5h-2v-2H5v2H3v-5Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 13h15M7 15.5h.01M17 15.5h.01"/></svg>
            </span>
            <span><strong>Data kendaraan</strong><small>Kelola data kendaraan terdaftar</small></span>
            <span class="quick-access-arrow" aria-hidden="true">→</span>
        </a>
        <a class="quick-access-card rounded-xl border border-white/90 bg-white/70 px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:bg-white hover:shadow-md" href="{{ route('admin.logs.index') }}">
            <span class="quick-access-icon quick-access-icon-violet" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 1.5M20 12a8 8 0 1 1-2.34-5.66M20 4v5h-5"/></svg>
            </span>
            <span><strong>Log aktivitas</strong><small>Lihat riwayat aktivitas sistem</small></span>
            <span class="quick-access-arrow" aria-hidden="true">→</span>
        </a>
    </div>
</section>
@endsection
