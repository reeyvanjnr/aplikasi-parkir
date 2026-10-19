@extends('layouts.parking')
@section('title', 'Transaksi Parkir')
@section('footer-description', 'Transaksi Parkir')
@section('content')
<div class="mb-8">
    <p class="mb-2 text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600">Operasional</p>
    <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Transaksi Parkir</h1>
    <p class="mt-2 text-slate-600">Catat kendaraan masuk dan selesaikan transaksi kendaraan keluar.</p>
</div>

<section class="entry-card rounded-2xl border border-indigo-100/80 bg-indigo-100/35 p-5 sm:p-7">
    <div class="mb-5 flex items-center gap-3">
        <span class="grid size-10 place-items-center rounded-xl bg-indigo-500 text-lg font-bold text-white shadow-md shadow-indigo-500/20" aria-hidden="true">+</span>
        <div>
            <h2 class="text-xl font-bold text-slate-900">Kendaraan Masuk</h2>
            <p class="text-sm text-slate-600">Waktu masuk akan dicatat otomatis.</p>
        </div>
    </div>
    <form method="POST" action="{{ route('petugas.entry') }}" class="entry-form grid gap-4 sm:grid-cols-2 xl:grid-cols-4 xl:items-end">
        @csrf
        <div>
            <label class="form-label" for="nomor_polisi">Nomor polisi</label>
            <input class="form-control" id="nomor_polisi" name="nomor_polisi" required maxlength="20" value="{{ old('nomor_polisi') }}" placeholder="B 1234 XYZ">
        </div>
        <div>
            <label class="form-label" for="jenis_kendaraan">Jenis kendaraan</label>
            <select class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" required>
                <option value="">Pilih jenis</option>
                @foreach($areas->pluck('jenis_kendaraan')->unique() as $jenis)
                    <option value="{{ $jenis }}" @selected(old('jenis_kendaraan') === $jenis)>{{ ucfirst($jenis) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label" for="id_area">Area parkir</label>
            <select class="form-control" id="id_area" name="id_area" required>
                <option value="">Pilih area</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id_area }}" @disabled($area->terisi >= $area->kapasitas) @selected((string)old('id_area') === (string)$area->id_area)>
                        {{ $area->nama_area }} ({{ $area->terisi }}/{{ $area->kapasitas }}){{ $area->terisi >= $area->kapasitas ? ' - PENUH' : '' }}
                    </option>
                @endforeach
            </select>
        </div>
        <button class="rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-5 py-3 font-semibold text-white shadow-lg shadow-indigo-500/20 transition hover:-translate-y-0.5 hover:from-indigo-700 hover:to-violet-700 focus:outline-none focus:ring-4 focus:ring-indigo-300" type="submit">Catat kendaraan masuk</button>
    </form>
</section>

<section class="mt-8">
    <div class="mb-4 flex flex-wrap items-end justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Sedang Parkir</h2>
            <p class="mt-1 text-sm text-slate-600">Daftar kendaraan yang belum menyelesaikan transaksi.</p>
        </div>
        <span class="rounded-full border border-white/80 bg-white/60 px-3 py-1.5 text-sm font-semibold text-slate-600">{{ $transactions->total() }} kendaraan</span>
    </div>
    <div class="table-panel overflow-hidden rounded-2xl border border-white/90 bg-white/45 shadow-sm">
        <div class="overflow-x-auto">
            <table class="data-table min-w-[850px]">
                <thead><tr><th>No. tiket</th><th>Nomor polisi</th><th>Jenis</th><th>Area</th><th>Waktu masuk</th><th>Petugas</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td class="font-semibold text-indigo-700">#{{ $transaction->id_parkir }}</td>
                            <td class="font-semibold text-slate-900">{{ $transaction->kendaraan->nomor_polisi }}</td>
                            <td>{{ ucfirst($transaction->kendaraan->jenis_kendaraan) }}</td>
                            <td>{{ $transaction->area->nama_area }}</td>
                            <td>{{ $transaction->waktu_masuk->format('d-m-Y H:i:s') }}</td>
                            <td>{{ $transaction->petugas->nama_user }}</td>
                            <td><form method="POST" action="{{ route('petugas.exit',$transaction) }}" onsubmit="return confirm('Proses kendaraan keluar?')">@csrf<button class="rounded-lg bg-teal-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-400" type="submit">Proses keluar</button></form></td>
                        </tr>
                    @empty
                        <tr><td class="py-10 text-center text-slate-500" colspan="7">Tidak ada kendaraan yang sedang parkir.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-5">{{ $transactions->links() }}</div>
</section>
@endsection
