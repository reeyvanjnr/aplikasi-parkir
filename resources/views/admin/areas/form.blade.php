@extends('layouts.parking')
@section('title', $area->exists ? 'Edit Area' : 'Tambah Area')
@section('footer-description', 'Kelola Area Parkir')
@section('content')
<h1>{{ $area->exists ? 'Edit Area' : 'Tambah Area' }}</h1>
<form method="POST" action="{{ $area->exists ? route('admin.areas.update',$area) : route('admin.areas.store') }}">
@csrf @if($area->exists) @method('PUT') @endif
<label>Nama area<input name="nama_area" required value="{{ old('nama_area',$area->nama_area) }}"></label>
<label>Jenis kendaraan<input name="jenis_kendaraan" required value="{{ old('jenis_kendaraan',$area->jenis_kendaraan) }}"></label>
<label>Kapasitas<input type="number" min="{{ $area->terisi ?: 1 }}" name="kapasitas" required value="{{ old('kapasitas',$area->kapasitas) }}"></label>
@if($area->exists)<p>Slot saat ini terisi: {{ $area->terisi }}</p>@endif
<label>Status<select name="status_aktif"><option value="1" @selected((string)old('status_aktif',$area->exists ? (int)$area->status_aktif : 1)==='1')>Aktif</option><option value="0" @selected((string)old('status_aktif',$area->exists ? (int)$area->status_aktif : 1)==='0')>Nonaktif</option></select></label>
<button>Simpan</button> <a href="{{ route('admin.areas.index') }}">Batal</a>
</form>
@endsection
