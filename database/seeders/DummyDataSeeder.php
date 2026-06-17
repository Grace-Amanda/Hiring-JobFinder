<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\EmployerProfile;
use App\Models\ApplicantProfile;
use App\Models\JobVacancy;
use App\Models\Swipe;
use App\Models\Interview;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // 1. EMPLOYER
        // =============================================
        $employer = User::firstOrCreate(
            ['email' => 'hrd@tekojaya.com'],
            [
                'name'     => 'PT Teknologi Jaya',
                'password' => Hash::make('password123'),
                'role'     => 'employer',
            ]
        );
        EmployerProfile::firstOrCreate(
            ['user_id' => $employer->id],
            [
                'company_name'      => 'PT Teknologi Jaya',
                'location_employer' => 'Jakarta Selatan', // UBAH BARIS INI
                'company_type'      => 'Information Technology',
                'status'            => 'active_searching', // TAMBAHKAN BARIS INI (Sesuai Enum)
                'rating'            => 4.5,
            ]
        );

        // =============================================
        // 2. LOWONGAN PEKERJAAN
        // =============================================
        $job1 = JobVacancy::firstOrCreate(
            ['employer_id' => $employer->id, 'title' => 'Software Engineer'],
            [
                'description'    => 'Membangun aplikasi backend berbasis Laravel dan REST API.',
                'qualifications' => "- Menguasai PHP & Laravel\n- Paham REST API\n- Pengalaman minimal 1 tahun",
                'is_active'      => true,
            ]
        );

        $job2 = JobVacancy::firstOrCreate(
            ['employer_id' => $employer->id, 'title' => 'UI/UX Designer'],
            [
                'description'    => 'Mendesain tampilan aplikasi mobile dan web yang intuitif.',
                'qualifications' => "- Menguasai Figma\n- Memahami alur UX dan Wireframing\n- Portfolio desain diperlukan",
                'is_active'      => true,
            ]
        );

        $job3 = JobVacancy::firstOrCreate(
            ['employer_id' => $employer->id, 'title' => 'Data Analyst'],
            [
                'description'    => 'Menganalisis data bisnis untuk mendukung keputusan strategis.',
                'qualifications' => "- Menguasai SQL dan Python\n- Pengalaman dengan Tableau atau Power BI\n- Kemampuan statistik dasar",
                'is_active'      => true,
            ]
        );

        // =============================================
        // 3. APPLICANT 1 — Budi (sudah MATCHED job1)
        // =============================================
        $applicant1 = User::firstOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name'     => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'role'     => 'applicant',
            ]
        );
        ApplicantProfile::firstOrCreate(
            ['user_id' => $applicant1->id],
            [
                'full_name'   => 'Budi Santoso',
                'location'    => 'Surabaya',
                'education'   => 'Universitas Kristen Petra - Sistem Informasi',
                'job_history' => 'Magang 6 bulan di Startup Lokal sebagai Backend Developer. Menguasai Laravel, MySQL, dan REST API.',
                'rating'      => 4.50,
                'status'      => 'active_searching',
            ]
        );

        // Swipe MATCHED antara Budi dan job1
        $swipe1 = Swipe::firstOrCreate(
            ['applicant_id' => $applicant1->id, 'job_vacancy_id' => $job1->id],
            ['employer_id' => $employer->id, 'status' => 'matched']
        );

        // =============================================
        // 4. APPLICANT 2 — Siti (sudah MATCHED job2)
        // =============================================
        $applicant2 = User::firstOrCreate(
            ['email' => 'siti@gmail.com'],
            [
                'name'     => 'Siti Rahayu',
                'password' => Hash::make('password123'),
                'role'     => 'applicant',
            ]
        );
        ApplicantProfile::firstOrCreate(
            ['user_id' => $applicant2->id],
            [
                'full_name'   => 'Siti Rahayu',
                'location'    => 'Bandung',
                'education'   => 'Institut Teknologi Bandung - Desain Komunikasi Visual',
                'job_history' => 'Freelance UI Designer 2 tahun. Menguasai Figma, Adobe XD, dan Prototyping.',
                'rating'      => 4.80,
                'status'      => 'active_searching',
            ]
        );

        $swipe2 = Swipe::firstOrCreate(
            ['applicant_id' => $applicant2->id, 'job_vacancy_id' => $job2->id],
            ['employer_id' => $employer->id, 'status' => 'matched']
        );

        // =============================================
        // 5. APPLICANT 3 — Andi (masih PENDING job1)
        //    → untuk test swipe employer di dashboard
        // =============================================
        $applicant3 = User::firstOrCreate(
            ['email' => 'andi@gmail.com'],
            [
                'name'     => 'Andi Wijaya',
                'password' => Hash::make('password123'),
                'role'     => 'applicant',
            ]
        );
        ApplicantProfile::firstOrCreate(
            ['user_id' => $applicant3->id],
            [
                'full_name'   => 'Andi Wijaya',
                'location'    => 'Jakarta',
                'education'   => 'Universitas Indonesia - Ilmu Komputer',
                'job_history' => 'Fresh graduate. Proyek akhir: Aplikasi manajemen kos berbasis Laravel.',
                'rating'      => 4.20,
                'status'      => 'active_searching',
            ]
        );

        Swipe::firstOrCreate(
            ['applicant_id' => $applicant3->id, 'job_vacancy_id' => $job1->id],
            ['employer_id' => $employer->id, 'status' => 'pending']
        );

        // =============================================
        // 6. DATA INTERVIEW (untuk test kalender langsung)
        //    Budi: interview besok (scheduled)
        //    Siti: interview lusa (confirmed)
        // =============================================
        $tomorrow  = now()->addDay()->format('Y-m-d');
        $dayAfter  = now()->addDays(2)->format('Y-m-d');
        $nextWeek  = now()->addDays(7)->format('Y-m-d');

        // Interview 1: Budi — scheduled (belum dikonfirmasi)
        Interview::firstOrCreate(
            [
                'employer_id'    => $employer->id,
                'applicant_id'   => $applicant1->id,
                'job_vacancy_id' => $job1->id,
                'schedule_date'  => $tomorrow,
            ],
            [
                'schedule_time'    => '10:00:00',
                'location_or_link' => 'https://meet.google.com/abc-defg-hij',
                'interview_type'   => 'online',
                'notes'            => 'Siapkan portfolio dan CV terbaru. Interview akan berlangsung 45 menit.',
                'status'           => 'scheduled',
            ]
        );

        // Interview 2: Siti — confirmed (sudah dikonfirmasi applicant)
        Interview::firstOrCreate(
            [
                'employer_id'    => $employer->id,
                'applicant_id'   => $applicant2->id,
                'job_vacancy_id' => $job2->id,
                'schedule_date'  => $dayAfter,
            ],
            [
                'schedule_time'    => '14:00:00',
                'location_or_link' => 'Jl. Sudirman No. 1, Jakarta Selatan, Lantai 5 Ruang Meeting A',
                'interview_type'   => 'offline',
                'notes'            => 'Bawa 2 lembar CV dan dokumen pendukung.',
                'status'           => 'confirmed',
            ]
        );

        // Interview 3: Budi — next week (untuk test kalender navigasi bulan)
        Interview::firstOrCreate(
            [
                'employer_id'    => $employer->id,
                'applicant_id'   => $applicant1->id,
                'job_vacancy_id' => $job1->id,
                'schedule_date'  => $nextWeek,
            ],
            [
                'schedule_time'    => '09:00:00',
                'location_or_link' => 'https://zoom.us/j/1234567890',
                'interview_type'   => 'online',
                'notes'            => 'Interview teknikal tahap 2. Akan ada sesi coding test.',
                'status'           => 'scheduled',
            ]
        );

        $this->command->info('');
        $this->command->info('✅ Dummy Data Berhasil Dibuat!');
        $this->command->info('');
        $this->command->info('📧 AKUN LOGIN:');
        $this->command->info('   Employer  : hrd@tekojaya.com  | password123');
        $this->command->info('   Applicant : budi@gmail.com    | password123  (matched + ada jadwal interview)');
        $this->command->info('   Applicant : siti@gmail.com    | password123  (matched + ada jadwal interview)');
        $this->command->info('   Applicant : andi@gmail.com    | password123  (pending, untuk test swipe employer)');
        $this->command->info('');
        $this->command->info('📅 DATA INTERVIEW:');
        $this->command->info("   - Budi vs PT Teknologi Jaya: $tomorrow 10:00 (scheduled)");
        $this->command->info("   - Siti vs PT Teknologi Jaya: $dayAfter 14:00 (confirmed)");
        $this->command->info("   - Budi vs PT Teknologi Jaya: $nextWeek 09:00 (scheduled, teknikal)");
    }
}