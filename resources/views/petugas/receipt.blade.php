<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk Parkir #{{ $transaction->id_parkir }}</title>
    <style>
        body{font:12px/1.45 monospace;color:#000;margin:0;padding:12px}
        .receipt{width:72mm;margin:auto}
        h1,p{text-align:center;margin:5px 0}
        hr{border:0;border-top:1px dashed #000;margin:8px 0}
        .line{display:flex;justify-content:space-between;gap:8px}
        .amount{font-weight:bold;font-size:14px}
        @media print{body{padding:0}.receipt{width:72mm}.no-print{display:none}}
    </style>
</head>
<body>
<article class="receipt">
    <h1>BUKTI PARKIR</h1>
    <p>Aplikasi Parkir</p>
    <hr>
    <div class="line"><span>No. tiket</span><span>#{{ $transaction->id_parkir }}</span></div>
    <div class="line"><span>Nomor polisi</span><span>{{ $transaction->kendaraan->nomor_polisi }}</span></div>
    <div class="line"><span>Jenis</span><span>{{ ucfirst($transaction->kendaraan->jenis_kendaraan) }}</span></div>
    <div class="line"><span>Area</span><span>{{ $transaction->area->nama_area }}</span></div>
    <div class="line"><span>Waktu masuk</span><span>{{ $transaction->waktu_masuk->format('d/m/Y H:i') }}</span></div>
    <div class="line"><span>Waktu keluar</span><span>{{ $transaction->waktu_keluar->format('d/m/Y H:i') }}</span></div>
    <hr>
    <div class="line"><span>Tarif per jam</span><span>Rp{{ number_format($transaction->tarif->tarif_per_jam,0,',','.') }}</span></div>
    <div class="line amount"><span>TOTAL</span><span>Rp{{ number_format($transaction->biaya,0,',','.') }}</span></div>
    <hr>
    <p>Terima kasih</p>
    <p>Petugas: {{ $transaction->petugas->nama_user }}</p>
    <div class="no-print" style="text-align:center;margin-top:16px">
        <button onclick="window.print()">Cetak struk</button>
        <a href="{{ route('petugas.index') }}">Kembali</a>
    </div>
</article>
</body>
</html>
