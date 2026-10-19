@extends('layouts.parking')
@section('title', $user->exists ? 'Edit User' : 'Tambah User')
@section('footer-description', 'Kelola Pengguna')
@section('content')
<h1>{{ $user->exists ? 'Edit User' : 'Tambah User' }}</h1>
<form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">
@csrf @if($user->exists) @method('PUT') @endif
<label>Nama<input name="nama_user" required value="{{ old('nama_user', $user->nama_user) }}"></label>
<label>Username<input name="username" required value="{{ old('username', $user->username) }}"></label>
<label>Email<input type="email" name="email" required value="{{ old('email', $user->email) }}"></label>
<label>Password<input type="password" name="password" {{ $user->exists ? '' : 'required' }} minlength="8" autocomplete="new-password"></label>
<label>Role<select name="role" required>@foreach(['admin','petugas','owner'] as $role)<option value="{{ $role }}" @selected(old('role', $user->role) === $role)>{{ ucfirst($role) }}</option>@endforeach</select></label>
<label>Status<select name="status_aktif"><option value="1" @selected((string)old('status_aktif', $user->exists ? (int)$user->status_aktif : 1) === '1')>Aktif</option><option value="0" @selected((string)old('status_aktif', $user->exists ? (int)$user->status_aktif : 1) === '0')>Nonaktif</option></select></label>
<button type="submit">Simpan</button> <a href="{{ route('admin.users.index') }}">Batal</a>
</form>
@endsection
