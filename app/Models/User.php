<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    // Pemisahan Relasi Profil
    public function applicantProfile() { 
        return $this->hasOne(ApplicantProfile::class); 
        }
    public function employerProfile() { 
        return $this->hasOne(EmployerProfile::class); 
        }
    
    // Relasi Interaksi
    public function jobs() { 
        return $this->hasMany(Job::class, 'employer_id'); 
        }
    public function applicantSwipes() { 
        return $this->hasMany(Swipe::class, 'applicant_id'); 
        }
    public function employerSwipes() { 
        return $this->hasMany(Swipe::class, 'employer_id'); 
        }
    public function sentMessages() { 
        return $this->hasMany(Message::class, 'sender_id'); 
        }
    public function interviewsAsApplicant() { 
        return $this->hasMany(Interview::class, 'applicant_id'); 
        }
    public function interviewsAsEmployer() { 
        return $this->hasMany(Interview::class, 'employer_id'); 
        }
}