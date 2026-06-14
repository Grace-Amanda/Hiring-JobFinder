<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\EmployerProfile;
use App\Models\ApplicantProfile;
use App\Models\JobVacancy;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Employer (Perusahaan)
        $employer = User::create([
            'name' => 'PT Teknologi Jaya',
            'email' => 'hrd@tekojaya.com',
            'password' => Hash::make('password123'),
            'role' => 'employer',
        ]);
        EmployerProfile::create([
            'user_id' => $employer->id,
            'company_name' => 'PT Teknologi Jaya',
            'location' => 'Jakarta Selatan',
            'company_type' => 'Information Technology',
        ]);

        // 2. Buat Beberapa Lowongan Pekerjaan
        JobVacancy::create([
            'employer_id' => $employer->id,
            'title' => 'Software Engineer',
            'description' => 'Membangun aplikasi backend berbasis Laravel.',
            'qualifications' => '- Menguasai PHP & Laravel\n- Paham REST API\n- Pengalaman minimal 1 tahun.',
            'is_active' => true,
        ]);
        JobVacancy::create([
            'employer_id' => $employer->id,
            'title' => 'UI/UX Designer',
            'description' => 'Mendesain tampilan aplikasi mobile.',
            'qualifications' => '- Menguasai Figma\n- Memahami alur UX dan Wireframing.',
            'is_active' => true,
        ]);

        // 3. Buat Akun Applicant (Pelamar) untuk dicari oleh Employer
        $applicant = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'applicant',
        ]);
        ApplicantProfile::create([
            'user_id' => $applicant->id,
            'full_name' => 'Budi Santoso',
            'location' => 'Surabaya',
            'education' => 'Universitas A - Sistem Informasi Bisnis',
            'job_history' => 'Magang di Startup Lokal',
            'rating' => 4.50,
            'status' => 'active_searching'
        ]);

        echo "Dummy Data Berhasil Dibuat!\n";
    }
}