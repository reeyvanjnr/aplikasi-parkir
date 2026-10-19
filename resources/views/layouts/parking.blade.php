<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aplikasi Parkir')</title>
    <link rel="stylesheet" href="{{ asset('css/parking.css') }}">
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-200 via-purple-200 to-teal-100 px-4 py-5 text-slate-800 sm:px-6 lg:px-8">
    <div class="parking-shell mx-auto max-w-7xl">
        <header class="site-header mb-6 flex flex-wrap items-center gap-4 rounded-3xl border border-white/80 bg-white/50 px-5 py-4 shadow-xl shadow-indigo-900/5 backdrop-blur-xl sm:px-7">
            <a href="{{ auth()->check() ? match(auth()->user()->role) { 'admin' => route('admin.dashboard'), 'petugas' => route('petugas.index'), 'owner' => route('owner.report'), default => route('login') } : route('login') }}" class="flex items-center gap-3 text-lg font-bold tracking-tight text-slate-800 no-underline">
                <span class="nav-logo grid size-11 place-items-center rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 text-white shadow-lg shadow-indigo-500/20" aria-hidden="true">
                    <svg class="size-7" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 26.5 10.7 15a4 4 0 0 1 3.8-2.8h19a4 4 0 0 1 3.8 2.8L41 26.5v11a2.5 2.5 0 0 1-2.5 2.5H36a2 2 0 0 1-2-2v-3H14v3a2 2 0 0 1-2 2H9.5A2.5 2.5 0 0 1 7 37.5v-11Z" fill="currentColor"/>
                        <path d="m12 23 2.1-6.3a2 2 0 0 1 1.9-1.4h16a2 2 0 0 1 1.9 1.4L36 23H12Z" fill="#C7D2FE"/>
                        <circle cx="15.5" cy="29" r="2" fill="#4F46E5"/>
                        <circle cx="32.5" cy="29" r="2" fill="#4F46E5"/>
                        <path d="M20 29h8" stroke="#4F46E5" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
                <span>Aplikasi Parkir<span class="block text-xs font-medium tracking-wide text-slate-500">PARKING MANAGEMENT</span></span>
            </a>

            @auth
                <nav aria-label="Navigasi utama" class="site-nav flex w-full flex-wrap items-center gap-2 sm:w-auto sm:flex-1 sm:justify-center">
                    @if(auth()->user()->role === 'admin')
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <a class="nav-link" href="{{ route('admin.users.index') }}">User</a>
                        <a class="nav-link" href="{{ route('admin.tariffs.index') }}">Tarif</a>
                        <a class="nav-link" href="{{ route('admin.areas.index') }}">Area</a>
                        <a class="nav-link" href="{{ route('admin.vehicles.index') }}">Kendaraan</a>
                        <a class="nav-link" href="{{ route('admin.logs.index') }}">Log</a>
                    @elseif(auth()->user()->role === 'petugas')
                        <a class="nav-link" href="{{ route('petugas.index') }}">Transaksi parkir</a>
                    @elseif(auth()->user()->role === 'owner')
                        <a class="nav-link" href="{{ route('owner.report') }}">Rekap transaksi</a>
                    @endif
                </nav>

                <div class="ml-auto flex items-center gap-3">
                    <span class="hidden text-sm font-medium text-slate-600 sm:inline">{{ auth()->user()->nama_user }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="rounded-xl border border-white/80 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-white hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400" type="submit">Logout</button>
                    </form>
                </div>
            @endauth
        </header>

        <main class="glass-panel min-h-[70vh] rounded-3xl border border-white/80 bg-white/60 p-5 shadow-2xl shadow-indigo-900/10 backdrop-blur-xl sm:p-8 lg:p-10">
            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200/80 bg-emerald-100/70 px-5 py-4 text-sm font-medium text-emerald-900" role="status">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-200/80 bg-rose-100/70 px-5 py-4 text-sm text-rose-900" role="alert">
                    <p class="mb-2 font-semibold">Mohon periksa kembali data berikut:</p>
                    <ul class="list-inside list-disc space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </main>
        <footer class="site-footer py-6 text-center text-xs font-medium tracking-wide text-slate-600/80">Aplikasi Parkir <span aria-hidden="true">·</span> {{ trim($__env->yieldContent('footer-description')) ?: trim($__env->yieldContent('title', 'Dashboard')) }}</footer>
    </div>
</body>
</html>
