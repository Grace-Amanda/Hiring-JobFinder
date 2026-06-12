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

        // 1. LOGIKA UNTUK APPLICANT (CRUD Mahasiswa)
        if ($user->role === 'applicant') {
            $request->validate([
                'status' => 'required|in:active_searching,unactive',
                'full_name' => 'nullable|string|max:255',
                'date_of_birth' => 'nullable|date',
                'location' => 'nullable|string|max:255',
                'education' => 'nullable|string',
                'job_history' => 'nullable|string',
                // Validasi file: maksimal 2MB, format pdf/jpg/png
                'document_ktp' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
                'document_cv' => 'nullable|mimes:pdf|max:2048',
            ]);

            $profile = ApplicantProfile::where('user_id', $user->id)->first();
            $data = $request->except(['document_ktp', 'document_cv']);

            // Proses unggah KTP
            if ($request->hasFile('document_ktp')) {
                if ($profile->document_ktp) Storage::disk('public')->delete($profile->document_ktp);
                $data['document_ktp'] = $request->file('document_ktp')->store('documents/applicant/ktp', 'public');
            }

            // Proses unggah CV
            if ($request->hasFile('document_cv')) {
                if ($profile->document_cv) Storage::disk('public')->delete($profile->document_cv);
                $data['document_cv'] = $request->file('document_cv')->store('documents/applicant/cv', 'public');
            }

            $profile->update($data);
            return redirect()->back()->with('success', 'Profil Applicant berhasil diperbarui!');
        }

        // 2. LOGIKA UNTUK EMPLOYER
        if ($user->role === 'employer') {
            $request->validate([
                'status' => 'required|in:active_searching,unactive',
                'company_name' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'company_type' => 'nullable|string|max:255',
                'document_npwp' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
                'document_legal' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            $profile = EmployerProfile::where('user_id', $user->id)->first();
            $data = $request->except(['document_npwp', 'document_legal']);

            // Proses unggah NPWP
            if ($request->hasFile('document_npwp')) {
                if ($profile->document_npwp) Storage::disk('public')->delete($profile->document_npwp);
                $data['document_npwp'] = $request->file('document_npwp')->store('documents/employer/npwp', 'public');
            }

            // Proses unggah Dokumen Legal
            if ($request->hasFile('document_legal')) {
                if ($profile->document_legal) Storage::disk('public')->delete($profile->document_legal);
                $data['document_legal'] = $request->file('document_legal')->store('documents/employer/legal', 'public');
            }

            $profile->update($data);
            return redirect()->back()->with('success', 'Profil Employer berhasil diperbarui!');
        }
    }
}