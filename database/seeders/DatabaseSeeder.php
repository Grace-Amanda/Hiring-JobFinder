<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\ApplicantProfile;
use App\Models\EmployerProfile;
use App\Models\JobVacancy; 
use App\Models\Swipe;
use App\Models\Interview;
use App\Models\Message;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // BUAT DATA EMPLOYER (Perusahaan)
        $employers = User::factory(5)->create(['role' => 'employer']);
        
        foreach ($employers as $employer) {
            Profile::factory()->create(['user_id' => $employer->id]);
            EmployerProfile::factory()->create(['user_id' => $employer->id]);
            
            // Bikin lowongan kerja menggunakan JobVacancy
            JobVacancy::factory(3)->create(['employer_id' => $employer->id]);
        }

        // BUAT DATA APPLICANT (Pelamar)
        $applicants = User::factory(10)->create(['role' => 'applicant']);
        
        foreach ($applicants as $applicant) {
            Profile::factory()->create(['user_id' => $applicant->id]);
            ApplicantProfile::factory()->create(['user_id' => $applicant->id]);
        }

        // BUAT DATA INTERAKSI (Swipe, Message, Interview)
        $vacancies = JobVacancy::all();

        foreach ($vacancies as $vacancy) {
            $randomApplicants = $applicants->random(2); 

            foreach ($randomApplicants as $applicant) {
                // Buat data Swipe
                $swipe = Swipe::factory()->create([
                    'applicant_id' => $applicant->id,
                    'employer_id' => $vacancy->employer_id,
                    'job_vacancy_id' => $vacancy->id, // Sesuaikan nama kolom jika di migration pakai job_vacancy_id
                    'status' => 'matched',
                ]);

                // Buat pesan obrolan
                Message::factory()->create([
                    'swipe_id' => $swipe->id,
                    'sender_id' => $vacancy->employer_id,
                ]);
                Message::factory()->create([
                    'swipe_id' => $swipe->id,
                    'sender_id' => $applicant->id,
                ]);

                // Buat jadwal interview
                Interview::factory()->create([
                    'employer_id' => $vacancy->employer_id,
                    'applicant_id' => $applicant->id,
                    'job_vacancy_id' => $vacancy->id, // Sesuaikan nama kolom di tabel interviews kamu
                ]);
            }
        }
    }
}