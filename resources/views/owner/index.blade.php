@extends('layouts.parking')
@section('title', 'Rekap Transaksi')
@section('footer-description', 'Rekap Laporan Keuangan')
@section('content')
<div class="mb-8">
    <p class="mb-2 text-sm font-semibold uppercase tracking-[0.18em] text-teal-700">Laporan keuangan</p>
    <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Rekap Transaksi</h1>
    <p class="mt-2 text-slate-600">Pantau transaksi selesai dan pendapatan berdasarkan periode.</p>
</div>

<section class="rounded-2xl border border-teal-100/80 bg-teal-100/35 p-5 sm:p-6">
    <h2 class="text-lg font-bold text-slate-900">Filter periode</h2>
    <form method="GET" action="{{ route('owner.report') }}" class="report-filter mt-4 flex flex-wrap items-end gap-4">
        <div class="w-full sm:w-auto">
            <label class="form-label" for="tanggal_awal">Tanggal awal</label>
            <input class="form-control min-w-52" id="tanggal_awal" type="date" name="tanggal_awal" value="{{ $tanggalAwal }}">
        </div>
        <div class="w-full sm:w-auto">
            <label class="form-label" for="tanggal_akhir">Tanggal akhir</label>
            <input class="form-control min-w-52" id="tanggal_akhir" type="date" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
        </div>
        <button class="rounded-xl bg-gradient-to-r from-teal-600 to-emerald-600 px-5 py-3 font-semibold text-white shadow-lg shadow-teal-500/20 transition hover:-translate-y-0.5 hover:from-teal-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-teal-300" type="submit">Tampilkan laporan</button>
        <a class="rounded-xl border border-white/90 bg-white/70 px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-white" href="{{ route('owner.report') }}">Reset</a>
    </form>
</section>

<section class="income-summary my-6 rounded-2xl border border-violet-100/80 bg-violet-100/45 p-6 shadow-sm shadow-violet-900/5 sm:p-7">
    <p class="text-sm font-semibold text-violet-700">Total pendapatan periode terpilih</p>
    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Rp{{ number_format($totalPendapatan,0,',','.') }}</p>
</section>

<section>
    <div class="mb-4 flex flex-wrap items-end justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Transaksi selesai</h2>
            <p class="mt-1 text-sm text-slate-600">Rentang tanggal menggunakan waktu kendaraan keluar.</p>
        </div>
        <span class="rounded-full border border-white/80 bg-white/60 px-3 py-1.5 text-sm font-semibold text-slate-600">{{ $transactions->total() }} transaksi</span>
    </div>
    <div class="table-panel overflow-hidden rounded-2xl border border-white/90 bg-white/45 shadow-sm">
        <div class="overflow-x-auto">
            <table class="data-table min-w-[1100px]">
                <thead><tr><th>No. tiket</th><th>Nomor polisi</th><th>Jenis</th><th>Area</th><th>Petugas</th><th>Masuk</th><th>Keluar</th><th>Tarif/jam</th><th>Biaya</th></tr></thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td class="font-semibold text-indigo-700">#{{ $transaction->id_parkir }}</td>
                            <td class="font-semibold text-slate-900">{{ $transaction->kendaraan->nomor_polisi }}</td>
                            <td>{{ ucfirst($transaction->kendaraan->jenis_kendaraan) }}</td>
                            <td>{{ $transaction->area->nama_area }}</td>
                            <td>{{ $transaction->petugas->nama_user }}</td>
                            <td>{{ $transaction->waktu_masuk->format('d-m-Y H:i') }}</td>
                            <td>{{ $transaction->waktu_keluar->format('d-m-Y H:i') }}</td>
                            <td>Rp{{ number_format($transaction->tarif->tarif_per_jam,0,',','.') }}</td>
                            <td class="font-semibold text-slate-900">Rp{{ number_format($transaction->biaya,0,',','.') }}</td>
                        </tr>
                    @empty
                        <tr><td class="py-10 text-center text-slate-500" colspan="9">Tidak ada transaksi selesai pada rentang tanggal tersebut.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-5">{{ $transactions->links() }}</div>
</section>
@endsection
