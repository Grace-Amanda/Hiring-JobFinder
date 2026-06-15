<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ApplicantProfile;
use App\Models\EmployerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; 

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
            $rules['document_npwp'] = 'required|file|mimes:pdf|max:2048'; 
            $rules['document_nib'] = 'required|file|mimes:pdf|max:2048'; 
        }

        $request->validate($rules);
        $mainName = $request->role === 'applicant' ? $request->full_name : $request->company_name;

        $user = User::create([
            'name' => $mainName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($user->role === 'applicant') {
            $cvPath = $request->file('document_cv')->store('documents/cv', 'public');
            $ktpPath = $request->file('document_ktp')->store('documents/ktp', 'public');
            $ijazahPath = $request->file('document_ijazah')->store('documents/ijazah', 'public');

            ApplicantProfile::create([
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'date_of_birth' => $request->date_of_birth,
                'location' => $request->location_applicant, // Diubah menjadi 'location'
                'education' => $request->education,
                'document_cv' => $cvPath,
                'document_ktp' => $ktpPath,
                'document_ijazah' => $ijazahPath,
            ]);

        } elseif ($user->role === 'employer') {
            $npwpPath = $request->file('document_npwp')->store('documents/npwp', 'public');
            $nibPath = $request->file('document_nib')->store('documents/nib', 'public');

            EmployerProfile::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'company_type' => $request->company_type,
                'location' => $request->location_employer, // Diubah menjadi 'location'
                'document_npwp' => $npwpPath,
                'document_nib' => $nibPath,
            ]);
        }

        Auth::login($user);

        // KODE BARU: Generate Token Sanctum langsung setelah berhasil Sign Up
        if (method_exists($user, 'createToken')) {
            $token = $user->createToken('API_TOKEN')->plainTextToken;
            session(['api_token' => $token]);
        }

        return $this->redirectBasedOnRole($user->role);
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if (method_exists($user, 'createToken')) {
                $token = $user->createToken('API_TOKEN')->plainTextToken;
                session(['api_token' => $token]);
            } else {
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