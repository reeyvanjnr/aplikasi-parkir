@extends('layouts.parking')
@section('title', 'Kelola Area')
@section('footer-description', 'Kelola Area Parkir')
@section('content')
<div class="actions"><h1 style="margin-right:auto">Area Parkir</h1><a class="action-add" href="{{ route('admin.areas.create') }}">Tambah area</a></div>
<table><thead><tr><th>Nama</th><th>Jenis kendaraan</th><th>Kapasitas</th><th>Terisi</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
@forelse($areas as $area)<tr><td>{{ $area->nama_area }}</td><td>{{ $area->jenis_kendaraan }}</td><td>{{ $area->kapasitas }}</td><td>{{ $area->terisi }}</td><td>{{ $area->status_aktif ? 'Aktif' : 'Nonaktif' }}</td><td class="actions"><a class="action-edit" href="{{ route('admin.areas.edit',$area) }}">Edit</a><form class="inline" method="POST" action="{{ route('admin.areas.destroy',$area) }}" onsubmit="return confirm('Hapus area ini?')">@csrf @method('DELETE')<button class="action-danger">Hapus</button></form></td></tr>
@empty<tr><td colspan="6">Belum ada area.</td></tr>@endforelse
</tbody></table>{{ $areas->links() }}
@endsection
