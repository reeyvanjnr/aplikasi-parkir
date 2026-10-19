<?php

namespace App\Http\Controllers;

use App\Models\TbAreaParkir;
use App\Models\TbKendaraan;
use App\Models\TbLogAktivitas;
use App\Models\TbTarif;
use App\Models\TbTransaksi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PetugasController extends Controller
{
    public function index(): View
    {
        return view('petugas.index', [
            'areas' => TbAreaParkir::where('status_aktif', true)->orderBy('nama_area')->get(),
            'transactions' => TbTransaksi::with(['kendaraan', 'area', 'petugas'])
                ->whereNull('waktu_keluar')->latest('waktu_masuk')->paginate(20),
        ]);
    }

    public function vehicleEntry(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nomor_polisi' => ['required', 'string', 'max:20'],
            'jenis_kendaraan' => ['required', 'string', 'max:30'],
            'id_area' => ['required', 'integer', 'exists:tb_area_parkir,id_area'],
        ]);

        $transaction = DB::transaction(function () use ($data) {
            $area = TbAreaParkir::whereKey($data['id_area'])->lockForUpdate()->firstOrFail();
            $tariff = TbTarif::where('jenis_kendaraan', $data['jenis_kendaraan'])
                ->where('status_aktif', true)->first();

            if (! $area->status_aktif || $area->jenis_kendaraan !== $data['jenis_kendaraan']) {
                throw ValidationException::withMessages([
                    'id_area' => 'Area tidak aktif atau jenis kendaraan tidak sesuai.',
                ]);
            }
            if (! $tariff) {
                throw ValidationException::withMessages([
                    'jenis_kendaraan' => 'Tarif aktif untuk jenis kendaraan ini belum tersedia.',
                ]);
            }
            if ($area->terisi >= $area->kapasitas) {
                throw ValidationException::withMessages([
                    'id_area' => 'Area parkir penuh.',
                ]);
            }

            $vehicle = TbKendaraan::where('nomor_polisi', strtoupper(trim($data['nomor_polisi'])))->first();
            if ($vehicle && TbTransaksi::where('id_kendaraan', $vehicle->id_kendaraan)->whereNull('waktu_keluar')->exists()) {
                throw ValidationException::withMessages([
                    'nomor_polisi' => 'Kendaraan ini masih tercatat berada di area parkir.',
                ]);
            }

            $vehicle = TbKendaraan::updateOrCreate(
                ['nomor_polisi' => strtoupper(trim($data['nomor_polisi']))],
                ['jenis_kendaraan' => $data['jenis_kendaraan']],
            );

            $transaction = TbTransaksi::create([
                'id_kendaraan' => $vehicle->id_kendaraan,
                'id_user' => auth()->id(),
                'id_tarif' => $tariff->id_tarif,
                'id_area' => $area->id_area,
                'waktu_masuk' => now(),
                'status' => 'parkir',
            ]);

            $area->increment('terisi');

            return $transaction;
        });

        $this->log('parkir.masuk', "Kendaraan {$transaction->kendaraan->nomor_polisi} masuk.");

        return redirect()->route('petugas.index')
            ->with('success', "Kendaraan masuk tercatat. Nomor tiket: {$transaction->id_parkir}.");
    }

    public function vehicleExit(TbTransaksi $transaction): RedirectResponse
    {
        $closedTransaction = DB::transaction(function () use ($transaction) {
            $locked = TbTransaksi::whereKey($transaction->id_parkir)->lockForUpdate()->firstOrFail();
            if ($locked->waktu_keluar !== null) {
                throw ValidationException::withMessages(['transaksi' => 'Transaksi ini sudah ditutup.']);
            }

            $area = TbAreaParkir::whereKey($locked->id_area)->lockForUpdate()->firstOrFail();
            if ($area->terisi < 1) {
                abort(409, 'Jumlah slot terisi tidak konsisten dengan transaksi.');
            }

            $keluar = now();
            $durasiDetik = $locked->waktu_masuk->diffInSeconds($keluar);
            $jam = max(1, (int) ceil($durasiDetik / 3600));
            $tariff = TbTarif::findOrFail($locked->id_tarif);

            $locked->update([
                'waktu_keluar' => $keluar,
                'biaya' => $jam * $tariff->tarif_per_jam,
                'status' => 'selesai',
            ]);
            $area->decrement('terisi');

            return $locked->fresh(['kendaraan', 'area', 'tarif', 'petugas']);
        });

        $this->log('parkir.keluar', "Kendaraan {$closedTransaction->kendaraan->nomor_polisi} keluar, biaya Rp".number_format($closedTransaction->biaya, 0, ',', '.').'.');

        return redirect()->route('petugas.receipt', $closedTransaction)
            ->with('success', 'Kendaraan keluar berhasil diproses.');
    }

    public function receipt(TbTransaksi $transaction): View
    {
        abort_if($transaction->waktu_keluar === null, 404, 'Struk tersedia setelah transaksi selesai.');

        return view('petugas.receipt', [
            'transaction' => $transaction->load(['kendaraan', 'area', 'tarif', 'petugas']),
        ]);
    }

    private function log(string $action, string $description): void
    {
        TbLogAktivitas::create([
            'id_user' => auth()->id(),
            'aktivitas' => $action,
            'deskripsi' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
