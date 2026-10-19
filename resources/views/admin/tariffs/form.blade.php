@extends('layouts.parking')
@section('title', $tariff->exists ? 'Edit Tarif' : 'Tambah Tarif')
@section('footer-description', 'Kelola Tarif Parkir')
@section('content')
<h1>{{ $tariff->exists ? 'Edit Tarif' : 'Tambah Tarif' }}</h1>
<form method="POST" action="{{ $tariff->exists ? route('admin.tariffs.update',$tariff) : route('admin.tariffs.store') }}">
@csrf @if($tariff->exists) @method('PUT') @endif
<label>Jenis kendaraan<input name="jenis_kendaraan" required value="{{ old('jenis_kendaraan',$tariff->jenis_kendaraan) }}"></label>
<label>Tarif per jam (Rp)<input type="number" name="tarif_per_jam" min="0" required value="{{ old('tarif_per_jam',$tariff->tarif_per_jam) }}"></label>
<label>Tarif maksimal (opsional)<input type="number" name="tarif_maksimal" min="0" value="{{ old('tarif_maksimal',$tariff->tarif_maksimal) }}"></label>
<label>Status<select name="status_aktif"><option value="1" @selected((string)old('status_aktif',$tariff->exists ? (int)$tariff->status_aktif : 1)==='1')>Aktif</option><option value="0" @selected((string)old('status_aktif',$tariff->exists ? (int)$tariff->status_aktif : 1)==='0')>Nonaktif</option></select></label>
<button>Simpan</button> <a href="{{ route('admin.tariffs.index') }}">Batal</a>
</form>
@endsection
