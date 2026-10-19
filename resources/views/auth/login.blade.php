<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Aplikasi Parkir</title>
    <link rel="stylesheet" href="{{ asset('css/parking.css') }}">
</head>
<body class="login-page flex min-h-screen items-center justify-center bg-gradient-to-br from-indigo-200 via-purple-200 to-teal-100 px-4 py-10 text-slate-800 sm:px-6">
    <main class="login-card w-full max-w-md rounded-3xl border border-white/80 bg-white/60 p-7 shadow-2xl shadow-indigo-900/15 backdrop-blur-xl sm:p-10">
        <div class="mb-8 text-center">
            <div class="login-icon mx-auto mb-5 grid size-16 place-items-center rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 text-white shadow-lg shadow-indigo-500/25" aria-hidden="true">
                <svg class="size-9" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 25.5 12.5 15a4 4 0 0 1 3.8-2.7h15.4a4 4 0 0 1 3.8 2.7L39 25.5v12a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-3H15v3a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-12Z" fill="currentColor" fill-opacity=".96"/>
                    <path d="m13 23 2.2-6.5a1.8 1.8 0 0 1 1.7-1.2h14.2a1.8 1.8 0 0 1 1.7 1.2L35 23H13Z" fill="#C7D2FE"/>
                    <path d="M15.5 28.5h3m11 0h3" stroke="#4F46E5" stroke-width="3" stroke-linecap="round"/>
                    <circle cx="16" cy="29" r="2" fill="#4F46E5"/>
                    <circle cx="32" cy="29" r="2" fill="#4F46E5"/>
                </svg>
            </div>
            <p class="mb-2 text-xs font-bold uppercase tracking-[0.22em] text-indigo-600">Parking management</p>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Selamat datang</h1>
            <p class="mt-2 text-sm text-slate-600">Masuk untuk melanjutkan ke Aplikasi Parkir.</p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-2xl border border-rose-200/80 bg-rose-100/70 px-4 py-3 text-sm text-rose-900" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="login-form space-y-5">
            @csrf
            <div>
                <label for="username" class="mb-2 block text-sm font-semibold text-slate-700">Username atau email</label>
                <input class="w-full rounded-2xl border border-white/90 bg-white/75 px-4 py-3 text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-200/70" id="username" name="username" type="text" value="{{ old('username') }}" placeholder="Masukkan username atau email" autocomplete="username" required autofocus>
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                <input class="w-full rounded-2xl border border-white/90 bg-white/75 px-4 py-3 text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-200/70" id="password" name="password" type="password" placeholder="Masukkan password" autocomplete="current-password" required>
            </div>
            <button class="login-button w-full rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 px-5 py-3.5 font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:-translate-y-0.5 hover:from-indigo-700 hover:to-violet-700 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-indigo-300" type="submit">Masuk ke akun</button>
        </form>
        <p class="mt-7 text-center text-xs text-slate-500">Akses aman untuk admin, petugas, dan owner.</p>
        <footer class="login-footer">Aplikasi Parkir <span aria-hidden="true">·</span> Portal Masuk</footer>
    </main>
</body>
</html>
