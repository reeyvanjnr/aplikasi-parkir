<?php

namespace Tests\Feature;

use App\Models\TbAreaParkir;
use App\Models\TbTransaksi;
use App\Models\TbUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParkingOperationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_petugas_entry_exit_updates_area_and_printable_receipt(): void
    {
        $this->seed();
        $petugas = TbUser::where('role', 'petugas')->firstOrFail();
        $this->actingAs($petugas);

        $area = TbAreaParkir::where('jenis_kendaraan', 'motor')->firstOrFail();
        $this->post(route('petugas.entry'), [
            'nomor_polisi' => 'b 1234 xyz',
            'jenis_kendaraan' => 'motor',
            'id_area' => $area->id_area,
        ])->assertRedirect(route('petugas.index'));

        $transaction = TbTransaksi::firstOrFail();
        $this->assertSame(1, $area->fresh()->terisi);

        $transaction->update(['waktu_masuk' => now()->subMinutes(61)]);
        $this->post(route('petugas.exit', $transaction))
            ->assertRedirect(route('petugas.receipt', $transaction));

        $this->assertSame(4000, $transaction->fresh()->biaya);
        $this->assertSame(0, $area->fresh()->terisi);
        $this->get(route('petugas.receipt', $transaction))->assertOk()->assertSee('BUKTI PARKIR');

        $owner = TbUser::where('role', 'owner')->firstOrFail();
        $this->actingAs($owner);
        $this->get(route('owner.report'))
            ->assertOk()
            ->assertSee('Total pendapatan periode terpilih')
            ->assertSee('Rp4.000');
        $this->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_full_area_rejects_entry_and_keeps_capacity_unchanged(): void
    {
        $this->seed();
        $petugas = TbUser::where('role', 'petugas')->firstOrFail();
        $this->actingAs($petugas);

        $area = TbAreaParkir::where('jenis_kendaraan', 'motor')->firstOrFail();
        $area->update(['kapasitas' => 1, 'terisi' => 1]);

        $this->from(route('petugas.index'))->post(route('petugas.entry'), [
            'nomor_polisi' => 'C 5555 ABC',
            'jenis_kendaraan' => 'motor',
            'id_area' => $area->id_area,
        ])->assertRedirect(route('petugas.index'))->assertSessionHasErrors('id_area');

        $this->assertSame(1, $area->fresh()->terisi);
        $this->assertSame(0, TbTransaksi::count());
    }

    public function test_admin_views_render_and_can_create_a_vehicle_record(): void
    {
        $this->seed();

        $this->get('/login')
            ->assertOk()
            ->assertSee('<svg', false)
            ->assertSee('from-indigo-600 to-violet-500');

        $admin = TbUser::where('role', 'admin')->firstOrFail();
        $this->actingAs($admin);

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('stat-icon')
            ->assertSee('quick-access-card');

        foreach ([
            route('admin.dashboard'),
            route('admin.users.index'),
            route('admin.users.create'),
            route('admin.tariffs.index'),
            route('admin.tariffs.create'),
            route('admin.areas.index'),
            route('admin.areas.create'),
            route('admin.vehicles.index'),
            route('admin.vehicles.create'),
            route('admin.logs.index'),
        ] as $url) {
            $this->get($url)->assertOk();
        }

        $this->get(route('admin.users.index'))
            ->assertSee('Aplikasi Parkir')
            ->assertSee('Kelola Pengguna')
            ->assertSee('action-edit')
            ->assertSee('action-danger');
        $this->get(route('admin.tariffs.index'))->assertSee('Kelola Tarif Parkir');
        $this->get(route('admin.areas.index'))->assertSee('Kelola Area Parkir');
        $this->get(route('admin.vehicles.index'))->assertSee('Kelola Data Kendaraan');
        $this->get(route('admin.logs.index'))->assertSee('Riwayat Log Aktivitas');

        $this->post(route('admin.vehicles.store'), [
            'nomor_polisi' => 'D 9999 TEST',
            'jenis_kendaraan' => 'motor',
            'merk' => 'Contoh',
            'warna' => 'Hitam',
        ])->assertRedirect(route('admin.vehicles.index'));

        $this->assertDatabaseHas('tb_kendaraan', ['nomor_polisi' => 'D 9999 TEST']);
    }

    public function test_reseeding_does_not_clear_currently_occupied_area_count(): void
    {
        $this->seed();
        $area = TbAreaParkir::where('jenis_kendaraan', 'motor')->firstOrFail();
        $area->update(['terisi' => 3]);

        $this->seed();

        $this->assertSame(3, $area->fresh()->terisi);
    }
}
