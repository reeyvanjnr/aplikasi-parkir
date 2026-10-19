<?php

namespace Tests\Feature;

use App\Models\TbUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParkingAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_admin_can_log_in_and_login_is_logged(): void
    {
        $this->seed();

        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs(TbUser::where('username', 'admin')->first());
        $this->assertDatabaseHas('tb_log_aktivitas', [
            'aktivitas' => 'login',
            'deskripsi' => 'Login berhasil.',
        ]);

        $this->get('/admin')->assertOk();
    }

    public function test_inactive_user_cannot_log_in(): void
    {
        TbUser::create([
            'nama_user' => 'Nonaktif',
            'username' => 'nonaktif',
            'email' => 'nonaktif@parkir.test',
            'password' => 'password',
            'role' => 'admin',
            'status_aktif' => false,
        ]);

        $this->from('/login')->post('/login', [
            'username' => 'nonaktif',
            'password' => 'password',
        ])->assertRedirect('/login')->assertSessionHasErrors('username');

        $this->assertGuest();
        $this->assertDatabaseCount('tb_log_aktivitas', 0);
    }

    public function test_petugas_and_owner_are_redirected_to_their_role_dashboards(): void
    {
        $this->seed();

        foreach ([
            ['petugas', '/petugas'],
            ['owner@parkir.test', '/owner'],
        ] as [$identifier, $destination]) {
            $this->post('/login', [
                'username' => $identifier,
                'password' => 'password',
            ])->assertRedirect($destination);

            $this->post('/logout')->assertRedirect('/login');
            $this->assertGuest();
        }
    }
}
