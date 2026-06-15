<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Tambahkan ini untuk handle file upload

class AuthController extends Controller {
    
    public function register(Request $request) {
        $rules = [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,applicant,employer'
        ];

        if ($request->role === 'applicant') {
            $rules['full_name'] = 'required|string|max:255';
            $rules['date_of_birth'] = 'required|date';
            $rules['location_applicant'] = 'required|string|max:255';
            $rules['education'] = 'required|string';
            $rules['document_cv'] = 'required|file|mimes:pdf|max:2048'; 
            $rules['document_ktp'] = 'required|file|mimes:pdf|max:2048'; 
            $rules['document_ijazah'] = 'required|file|mimes:pdf|max:2048'; 
        } elseif ($request->role === 'employer') {
            $rules['company_name'] = 'required|string|max:255';
            $rules['company_type'] = 'required|string';
            $rules['location_employer'] = 'required|string|max:255';
            $rules['document_npwp'] = 'required|file|mimes:pdf|max:2048'; // Max 2MB
            $rules['document_nib'] = 'required|file|mimes:pdf|max:2048'; // Max 2MB
        }

        $request->validate($rules);
        $mainName = $request->role === 'applicant' ? $request->full_name : $request->company_name;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($user->role === 'applicant') {
            // Simpan ketiga file ke sub-folder masing-masing
            $cvPath = $request->file('document_cv')->store('documents/cv', 'public');
            $ktpPath = $request->file('document_ktp')->store('documents/ktp', 'public');
            $ijazahPath = $request->file('document_ijazah')->store('documents/ijazah', 'public');

            ApplicantProfile::create([
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'date_of_birth' => $request->date_of_birth,
                'location_applicant' => $request->location_applicant,
                'education' => $request->education,
                'document_cv' => $cvPath,
                'document_ktp' => $ktpPath,
                'document_ijazah' => $ijazahPath,
            ]);

        } elseif ($user->role === 'employer') {
            // Upload NPWP ke folder storage/app/public/documents/npwp
            $npwpPath = $request->file('document_npwp')->store('documents/npwp', 'public');

            // Upload NIB ke folder storage/app/public/documents/nib
            $nibPath = $request->file('document_nib')->store('documents/nib', 'public');

            EmployerProfile::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'company_type' => $request->company_type,
                'location_employer' => $request->location_employer,
                'document_npwp' => $npwpPath,
                'document_nib' => $nibPath,
            ]);
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
}