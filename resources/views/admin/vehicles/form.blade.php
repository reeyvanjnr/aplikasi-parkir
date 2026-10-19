@extends('layouts.parking')
@section('title', $vehicle->exists ? 'Edit Kendaraan' : 'Tambah Kendaraan')
@section('footer-description', 'Kelola Data Kendaraan')
@section('content')
<h1>{{ $vehicle->exists ? 'Edit Kendaraan' : 'Tambah Kendaraan' }}</h1>
<form method="POST" action="{{ $vehicle->exists ? route('admin.vehicles.update',$vehicle) : route('admin.vehicles.store') }}">
@csrf @if($vehicle->exists) @method('PUT') @endif
<label>Nomor polisi<input name="nomor_polisi" required value="{{ old('nomor_polisi',$vehicle->nomor_polisi) }}"></label>
<label>Jenis kendaraan<input name="jenis_kendaraan" required value="{{ old('jenis_kendaraan',$vehicle->jenis_kendaraan) }}"></label>
<label>Merk<input name="merk" value="{{ old('merk',$vehicle->merk) }}"></label>
<label>Warna<input name="warna" value="{{ old('warna',$vehicle->warna) }}"></label>
<button>Simpan</button> <a href="{{ route('admin.vehicles.index') }}">Batal</a>
</form>
@endsection
