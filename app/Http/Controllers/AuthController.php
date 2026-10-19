<?php

namespace App\Http\Controllers;

use App\Models\TbLogAktivitas;
use App\Models\TbUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): RedirectResponse|View
    {
        if (Auth::check()) {
            return $this->redirectForRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $user = TbUser::query()
            ->where('username', $credentials['username'])
            ->orWhere('email', $credentials['username'])
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'username' => 'Username/email atau password tidak valid.',
            ]);
        }

        if (! $user->status_aktif) {
            throw ValidationException::withMessages([
                'username' => 'Akun tidak aktif. Hubungi administrator.',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        TbLogAktivitas::create([
            'id_user' => $user->id_user,
            'aktivitas' => 'login',
            'deskripsi' => 'Login berhasil.',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return $this->redirectForRole($user->role);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function dashboard(string $role): RedirectResponse|View
    {
        $user = Auth::user();

        if (! $user || $user->role !== $role) {
            return $this->redirectForRole($user?->role);
        }

        return view('dashboard', ['role' => $role, 'user' => $user]);
    }

    private function redirectForRole(?string $role): RedirectResponse
    {
        $route = match ($role) {
            'admin' => 'admin.dashboard',
            'petugas' => 'petugas.index',
            'owner' => 'owner.report',
            default => 'login',
        };

        return redirect()->route($route);
    }
}
