<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ApplicantProfile;
use App\Models\EmployerProfile;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman Login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Memproses data Login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Percobaan otentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Membuat API Token untuk kebutuhan fetch JavaScript di frontend (Swipe Card)
            // Pastikan model User Anda menggunakan trait HasApiTokens (Sanctum)
            if (method_exists($user, 'createToken')) {
                $token = $user->createToken('api_token')->plainTextToken;
                session(['api_token' => $token]);
            }

            // Arahkan sesuai dengan role
            if ($user->role === 'applicant') {
                return redirect('/applicant/home');
            } elseif ($user->role === 'employer') {
                return redirect('/employer/dashboard');
            }

            return redirect('/');
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Invalid email address or password.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan halaman Register
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Memproses data Register
     */
    public function register(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:applicant,employer',
        ]);

        try {
            // Memulai Transaksi Database (Biar aman kalau ada error)
            DB::beginTransaction();

            // 2. Buat akun User baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            // 3. Buat profil dasar
            if ($request->role === 'applicant') {
                ApplicantProfile::create([
                    'user_id' => $user->id,
                    'full_name' => $user->name,
                    'status' => 'active_searching',
                    'rating' => 0.00
                ]);
            } else {
                EmployerProfile::create([
                    'user_id' => $user->id,
                    'company_name' => $user->name,
                    'status' => 'active_searching'
                ]);
            }

            // Simpan permanen ke database
            DB::commit();

            // 4. Redirect ke login
            return redirect('/login')->with('success', 'Account created successfully! Please sign in.');

        } catch (\Exception $e) {
            // Batalkan pembuatan User jika profil gagal dibuat
            DB::rollBack();
            
            // TAMPILKAN ERROR ASLINYA DI LAYAR BIAR KITA TAHU PENYAKITNYA!
            dd('GAGAL BIKIN PROFIL! ALASANNYA: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        // Pengecekan aman: Hapus token API HANYA jika usernya ada DAN tokennya juga ada
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}