<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ApplicantProfile;
use App\Models\EmployerProfile;

class ProfileController extends Controller {
    
    // Fungsi untuk memperbarui profil dan mengunggah dokumen
    public function update(Request $request) {
        $user = Auth::user();

        // 1. LOGIKA UNTUK APPLICANT (Pelamar)
        if ($user->role === 'applicant') {
            $request->validate([
                'status' => 'required|in:active_searching,unactive',
                'full_name' => 'nullable|string|max:255',
                'date_of_birth' => 'nullable|date',
                'location_applicant' => 'nullable|string|max:255',
                'education' => 'nullable|string',
                'job_history' => 'nullable|string',
                'document_ktp' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
                'document_ijazah' => 'nullable|mimes:pdf|max:2048',
                'document_cv' => 'nullable|mimes:pdf|max:2048',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Ditambahkan!
            ]);

            $profile = ApplicantProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $user->name,
                    'status' => 'active_searching',
                    'rating' => 0.00
                ]
            );

            // Kecualikan semua input file agar tidak langsung masuk ke update() secara mass-assignment
            $data = $request->except(['document_ktp', 'document_ijazah', 'document_cv', 'profile_photo']);

            // Proses pembaruan foto profil pelamar jika ada berkas baru yang masuk
            if ($request->hasFile('profile_photo')) {
                if ($profile->profile_photo) Storage::disk('public')->delete($profile->profile_photo);
                $data['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
            }

            // Proses unggah KTP
            if ($request->hasFile('document_ktp')) {
                if ($profile->document_ktp) Storage::disk('public')->delete($profile->document_ktp);
                $data['document_ktp'] = $request->file('document_ktp')->store('documents/applicant/ktp', 'public');
            }

            // Proses unggah Ijazah
            if ($request->hasFile('document_ijazah')) {
                if ($profile->document_ijazah) Storage::disk('public')->delete($profile->document_ijazah);
                $data['document_ijazah'] = $request->file('document_ijazah')->store('documents/applicant/ijazah', 'public');
            }

            // Proses unggah CV
            if ($request->hasFile('document_cv')) {
                if ($profile->document_cv) Storage::disk('public')->delete($profile->document_cv);
                $data['document_cv'] = $request->file('document_cv')->store('documents/applicant/cv', 'public');
            }

            $profile->update($data);
            return redirect()->back()->with('success', 'Profil Applicant berhasil diperbarui!');
        }

        // 2. LOGIKA UNTUK EMPLOYER (Perusahaan)
        if ($user->role === 'employer') {
            $request->validate([
                'status' => 'required|in:active_searching,unactive',
                'company_name' => 'nullable|string|max:255',
                'location_employer' => 'nullable|string|max:255',
                'company_type' => 'nullable|string|max:255',
                'document_npwp' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
                'document_nib' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Ditambahkan!
            ]);

            $profile = EmployerProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name' => $user->name,
                    'status' => 'active_searching'
                ]
            );
        
            $data = $request->except(['document_npwp', 'document_nib', 'profile_photo']);

            // Proses pembaruan foto profil/logo perusahaan jika ada berkas baru yang masuk
            if ($request->hasFile('profile_photo')) {
                if ($profile->profile_photo) Storage::disk('public')->delete($profile->profile_photo);
                $data['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
            }

            // Proses unggah NPWP
            if ($request->hasFile('document_npwp')) {
                if ($profile->document_npwp) Storage::disk('public')->delete($profile->document_npwp);
                $data['document_npwp'] = $request->file('document_npwp')->store('documents/employer/npwp', 'public');
            }

            // Proses unggah Dokumen NIB
            if ($request->hasFile('document_nib')) {
                if ($profile->document_nib) Storage::disk('public')->delete($profile->document_nib);
                $data['document_nib'] = $request->file('document_nib')->store('documents/employer/nib', 'public');
            }

            $profile->update($data);
            return redirect()->back()->with('success', 'Profil Employer berhasil diperbarui!');
        }
    }
}