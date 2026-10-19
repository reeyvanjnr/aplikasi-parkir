<?php

namespace App\Http\Controllers;

use App\Models\TbAreaParkir;
use App\Models\TbKendaraan;
use App\Models\TbLogAktivitas;
use App\Models\TbTarif;
use App\Models\TbTransaksi;
use App\Models\TbUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('admin.index', [
            'userCount' => TbUser::count(),
            'tarifCount' => TbTarif::count(),
            'areaCount' => TbAreaParkir::count(),
            'activeTransactions' => TbTransaksi::whereNull('waktu_keluar')->count(),
        ]);
    }

    public function users(): View
    {
        return view('admin.users.index', ['users' => TbUser::orderBy('nama_user')->paginate(15)]);
    }

    public function createUser(): View
    {
        return view('admin.users.form', ['user' => new TbUser]);
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_user' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:tb_user,username'],
            'email' => ['required', 'email', 'max:255', 'unique:tb_user,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'petugas', 'owner'])],
            'status_aktif' => ['required', 'boolean'],
        ]);

        TbUser::create($data);
        $this->log('user.create', "Membuat user {$data['username']}.");

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser(TbUser $user): View
    {
        return view('admin.users.form', compact('user'));
    }

    public function updateUser(Request $request, TbUser $user): RedirectResponse
    {
        $data = $request->validate([
            'nama_user' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('tb_user', 'username')->ignore($user->id_user, 'id_user')],
            'email' => ['required', 'email', 'max:255', Rule::unique('tb_user', 'email')->ignore($user->id_user, 'id_user')],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'petugas', 'owner'])],
            'status_aktif' => ['required', 'boolean'],
        ]);

        if ($data['password'] === null || $data['password'] === '') {
            unset($data['password']);
        }

        $user->update($data);
        $this->log('user.update', "Memperbarui user {$user->username}.");

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroyUser(TbUser $user): RedirectResponse
    {
        abort_if($user->is(auth()->user()), 403, 'Akun yang sedang digunakan tidak dapat dihapus.');
        if (TbTransaksi::where('id_user', $user->id_user)->exists()) {
            return back()->withErrors(['delete' => 'User memiliki riwayat transaksi dan tidak dapat dihapus.']);
        }

        $username = $user->username;
        $user->delete();
        $this->log('user.delete', "Menghapus user {$username}.");

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function toggleUser(TbUser $user): RedirectResponse
    {
        abort_if($user->is(auth()->user()), 403, 'Status akun yang sedang digunakan tidak dapat diubah.');

        $user->update(['status_aktif' => ! $user->status_aktif]);
        $this->log('user.status', "Mengubah status user {$user->username}.");

        return back()->with('success', 'Status user berhasil diperbarui.');
    }

    public function tariffs(): View
    {
        return view('admin.tariffs.index', ['tariffs' => TbTarif::orderBy('jenis_kendaraan')->paginate(15)]);
    }

    public function createTariff(): View
    {
        return view('admin.tariffs.form', ['tariff' => new TbTarif]);
    }

    public function storeTariff(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'jenis_kendaraan' => ['required', 'string', 'max:30', 'unique:tb_tarif,jenis_kendaraan'],
            'tarif_per_jam' => ['required', 'integer', 'min:0'],
            'tarif_maksimal' => ['nullable', 'integer', 'min:0'],
            'status_aktif' => ['required', 'boolean'],
        ]);
        TbTarif::create($data);
        $this->log('tarif.create', "Menambah tarif {$data['jenis_kendaraan']}.");

        return redirect()->route('admin.tariffs.index')->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function editTariff(TbTarif $tariff): View
    {
        return view('admin.tariffs.form', compact('tariff'));
    }

    public function updateTariff(Request $request, TbTarif $tariff): RedirectResponse
    {
        $data = $request->validate([
            'jenis_kendaraan' => ['required', 'string', 'max:30', Rule::unique('tb_tarif', 'jenis_kendaraan')->ignore($tariff->id_tarif, 'id_tarif')],
            'tarif_per_jam' => ['required', 'integer', 'min:0'],
            'tarif_maksimal' => ['nullable', 'integer', 'min:0'],
            'status_aktif' => ['required', 'boolean'],
        ]);
        $tariff->update($data);
        $this->log('tarif.update', "Memperbarui tarif {$data['jenis_kendaraan']}.");

        return redirect()->route('admin.tariffs.index')->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroyTariff(TbTarif $tariff): RedirectResponse
    {
        if (TbTransaksi::where('id_tarif', $tariff->id_tarif)->exists()) {
            return back()->withErrors(['delete' => 'Tarif digunakan transaksi dan tidak dapat dihapus.']);
        }

        $jenis = $tariff->jenis_kendaraan;
        $tariff->delete();
        $this->log('tarif.delete', "Menghapus tarif {$jenis}.");

        return redirect()->route('admin.tariffs.index')->with('success', 'Tarif berhasil dihapus.');
    }

    public function areas(): View
    {
        return view('admin.areas.index', ['areas' => TbAreaParkir::orderBy('nama_area')->paginate(15)]);
    }

    public function createArea(): View
    {
        return view('admin.areas.form', ['area' => new TbAreaParkir]);
    }

    public function storeArea(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_area' => ['required', 'string', 'max:255', 'unique:tb_area_parkir,nama_area'],
            'jenis_kendaraan' => ['required', 'string', 'max:30', Rule::exists('tb_tarif', 'jenis_kendaraan')],
            'kapasitas' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['required', 'boolean'],
        ]);
        TbAreaParkir::create($data + ['terisi' => 0]);
        $this->log('area.create', "Menambah area {$data['nama_area']}.");

        return redirect()->route('admin.areas.index')->with('success', 'Area berhasil ditambahkan.');
    }

    public function editArea(TbAreaParkir $area): View
    {
        return view('admin.areas.form', compact('area'));
    }

    public function updateArea(Request $request, TbAreaParkir $area): RedirectResponse
    {
        $data = $request->validate([
            'nama_area' => ['required', 'string', 'max:255', Rule::unique('tb_area_parkir', 'nama_area')->ignore($area->id_area, 'id_area')],
            'jenis_kendaraan' => ['required', 'string', 'max:30', Rule::exists('tb_tarif', 'jenis_kendaraan')],
            'kapasitas' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['required', 'boolean'],
        ]);

        if ($data['kapasitas'] < $area->terisi) {
            return back()->withErrors(['kapasitas' => 'Kapasitas tidak boleh kurang dari jumlah slot yang terisi.'])->withInput();
        }
        if ($area->terisi > 0 && $data['jenis_kendaraan'] !== $area->jenis_kendaraan) {
            return back()->withErrors(['jenis_kendaraan' => 'Jenis kendaraan tidak dapat diubah saat area masih terisi.'])->withInput();
        }

        $area->update($data);
        $this->log('area.update', "Memperbarui area {$area->nama_area}.");

        return redirect()->route('admin.areas.index')->with('success', 'Area berhasil diperbarui.');
    }

    public function destroyArea(TbAreaParkir $area): RedirectResponse
    {
        if ($area->terisi > 0 || TbTransaksi::where('id_area', $area->id_area)->exists()) {
            return back()->withErrors(['delete' => 'Area sedang/ pernah digunakan transaksi dan tidak dapat dihapus.']);
        }

        $nama = $area->nama_area;
        $area->delete();
        $this->log('area.delete', "Menghapus area {$nama}.");

        return redirect()->route('admin.areas.index')->with('success', 'Area berhasil dihapus.');
    }

    public function vehicles(): View
    {
        return view('admin.vehicles.index', ['vehicles' => TbKendaraan::orderBy('nomor_polisi')->paginate(15)]);
    }

    public function createVehicle(): View
    {
        return view('admin.vehicles.form', ['vehicle' => new TbKendaraan]);
    }

    public function storeVehicle(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nomor_polisi' => ['required', 'string', 'max:20', 'unique:tb_kendaraan,nomor_polisi'],
            'jenis_kendaraan' => ['required', 'string', 'max:30'],
            'merk' => ['nullable', 'string', 'max:100'],
            'warna' => ['nullable', 'string', 'max:50'],
        ]);
        TbKendaraan::create($data);
        $this->log('kendaraan.create', "Menambah kendaraan {$data['nomor_polisi']}.");

        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function editVehicle(TbKendaraan $vehicle): View
    {
        return view('admin.vehicles.form', compact('vehicle'));
    }

    public function updateVehicle(Request $request, TbKendaraan $vehicle): RedirectResponse
    {
        $data = $request->validate([
            'nomor_polisi' => ['required', 'string', 'max:20', Rule::unique('tb_kendaraan', 'nomor_polisi')->ignore($vehicle->id_kendaraan, 'id_kendaraan')],
            'jenis_kendaraan' => ['required', 'string', 'max:30'],
            'merk' => ['nullable', 'string', 'max:100'],
            'warna' => ['nullable', 'string', 'max:50'],
        ]);
        $vehicle->update($data);
        $this->log('kendaraan.update', "Memperbarui kendaraan {$data['nomor_polisi']}.");

        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroyVehicle(TbKendaraan $vehicle): RedirectResponse
    {
        if (TbTransaksi::where('id_kendaraan', $vehicle->id_kendaraan)->exists()) {
            return back()->withErrors(['delete' => 'Kendaraan memiliki riwayat transaksi dan tidak dapat dihapus.']);
        }

        $plat = $vehicle->nomor_polisi;
        $vehicle->delete();
        $this->log('kendaraan.delete', "Menghapus kendaraan {$plat}.");

        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil dihapus.');
    }

    public function logs(): View
    {
        return view('admin.logs.index', [
            'logs' => TbLogAktivitas::with('user')->latest()->paginate(30),
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
