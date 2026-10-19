@extends('layouts.parking')
@section('title', 'Kelola Kendaraan')
@section('footer-description', 'Kelola Data Kendaraan')
@section('content')
<div class="actions"><h1 style="margin-right:auto">Kendaraan</h1><a class="action-add" href="{{ route('admin.vehicles.create') }}">Tambah kendaraan</a></div>
<table><thead><tr><th>Nomor polisi</th><th>Jenis</th><th>Merk</th><th>Warna</th><th>Aksi</th></tr></thead><tbody>
@forelse($vehicles as $vehicle)<tr><td>{{ $vehicle->nomor_polisi }}</td><td>{{ $vehicle->jenis_kendaraan }}</td><td>{{ $vehicle->merk ?: '-' }}</td><td>{{ $vehicle->warna ?: '-' }}</td><td class="actions"><a class="action-edit" href="{{ route('admin.vehicles.edit',$vehicle) }}">Edit</a><form class="inline" method="POST" action="{{ route('admin.vehicles.destroy',$vehicle) }}" onsubmit="return confirm('Hapus kendaraan ini?')">@csrf @method('DELETE')<button class="action-danger">Hapus</button></form></td></tr>
@empty<tr><td colspan="5">Belum ada kendaraan.</td></tr>@endforelse
</tbody></table>{{ $vehicles->links() }}
@endsection
