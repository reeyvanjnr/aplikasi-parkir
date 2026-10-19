@extends('layouts.parking')
@section('title', 'Log Aktivitas')
@section('footer-description', 'Riwayat Log Aktivitas')
@section('content')
<h1>Log Aktivitas</h1>
<table><thead><tr><th>Waktu</th><th>User</th><th>Aktivitas</th><th>Deskripsi</th><th>Alamat IP</th></tr></thead><tbody>
@forelse($logs as $log)<tr><td>{{ $log->created_at->format('d-m-Y H:i:s') }}</td><td>{{ $log->user?->nama_user ?? 'User dihapus' }}</td><td>{{ $log->aktivitas }}</td><td>{{ $log->deskripsi }}</td><td>{{ $log->ip_address }}</td></tr>
@empty<tr><td colspan="5">Belum ada log aktivitas.</td></tr>@endforelse
</tbody></table>{{ $logs->links() }}
@endsection
