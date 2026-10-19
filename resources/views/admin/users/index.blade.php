@extends('layouts.parking')
@section('title', 'Kelola User')
@section('footer-description', 'Kelola Pengguna')
@section('content')
<div class="actions"><h1 style="margin-right:auto">Pengguna</h1><a class="action-add" href="{{ route('admin.users.create') }}">Tambah pengguna</a></div>
<table><thead><tr><th>Nama</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
@forelse($users as $user)
<tr><td>{{ $user->nama_user }}</td><td>{{ $user->username }}</td><td>{{ $user->email }}</td><td>{{ $user->role }}</td><td>{{ $user->status_aktif ? 'Aktif' : 'Nonaktif' }}</td><td class="actions">
<a class="action-edit" href="{{ route('admin.users.edit', $user) }}">Edit</a>
<form class="inline" method="POST" action="{{ route('admin.users.status', $user) }}">@csrf @method('PATCH')<button class="action-toggle {{ $user->status_aktif ? 'action-danger' : 'action-enable' }}">{{ $user->status_aktif ? 'Nonaktifkan' : 'Aktifkan' }}</button></form>
<form class="inline" method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')">@csrf @method('DELETE')<button class="action-danger">Hapus</button></form>
</td></tr>
@empty<tr><td colspan="6">Belum ada data user.</td></tr>@endforelse
</tbody></table>{{ $users->links() }}
@endsection
