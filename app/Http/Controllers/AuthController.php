<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ApplicantProfile;
use App\Models\EmployerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,applicant,employer'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Cek role untuk membuatkan tabel profil yang sesuai
        if ($user->role === 'applicant') {
            ApplicantProfile::create(['user_id' => $user->id, 'full_name' => $user->name]);
        } elseif ($user->role === 'employer') {
            EmployerProfile::create(['user_id' => $user->id, 'company_name' => $user->name]);
        }

        Auth::login($user);
        return $this->redirectBasedOnRole($user->role);
    }

public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // GENERATE TOKEN SANCTUM SAAT LOGIN BERHASIL (jika tersedia)
            if (method_exists($user, 'createToken')) {
                $token = $user->createToken('API_TOKEN')->plainTextToken;
                // Simpan token sementara di session Laravel agar bisa dikirim ke Blade
                session(['api_token' => $token]);
            } else {
                // Jika model User belum menggunakan HasApiTokens, lewati pembuatan token
                session()->forget('api_token');
            }

            $request->session()->regenerate();

            return $this->redirectBasedOnRole($user->role);
        }

        return back()->withErrors(['email' => 'Kredensial tidak cocok dengan data kami.']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    private function redirectBasedOnRole($role) {
        if ($role === 'admin') return redirect('/admin/dashboard');
        if ($role === 'employer') return redirect('/employer/dashboard');
        return redirect('/applicant/home');
    }
}