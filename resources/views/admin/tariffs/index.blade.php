@extends('layouts.parking')
@section('title', 'Kelola Tarif')
@section('footer-description', 'Kelola Tarif Parkir')
@section('content')
<div class="actions"><h1 style="margin-right:auto">Tarif Parkir</h1><a class="action-add" href="{{ route('admin.tariffs.create') }}">Tambah tarif</a></div>
<table><thead><tr><th>Jenis kendaraan</th><th>Tarif/jam</th><th>Maksimal</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
@forelse($tariffs as $tariff)<tr><td>{{ $tariff->jenis_kendaraan }}</td><td>Rp{{ number_format($tariff->tarif_per_jam,0,',','.') }}</td><td>{{ $tariff->tarif_maksimal === null ? '-' : 'Rp'.number_format($tariff->tarif_maksimal,0,',','.') }}</td><td>{{ $tariff->status_aktif ? 'Aktif' : 'Nonaktif' }}</td><td class="actions"><a class="action-edit" href="{{ route('admin.tariffs.edit',$tariff) }}">Edit</a><form class="inline" method="POST" action="{{ route('admin.tariffs.destroy',$tariff) }}" onsubmit="return confirm('Hapus tarif ini?')">@csrf @method('DELETE')<button class="action-danger">Hapus</button></form></td></tr>
@empty<tr><td colspan="5">Belum ada tarif.</td></tr>@endforelse
</tbody></table>{{ $tariffs->links() }}
@endsection
