<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Swipe extends Model {
    use HasFactory;
    
    protected $fillable = ['applicant_id', 'employer_id', 'job_vacancy_id', 'status'];
    
    public function applicant() {
        return $this->belongsTo(User::class, 'applicant_id'); 
    }
    
    public function employer() { 
        return $this->belongsTo(User::class, 'employer_id'); 
    }
    
    public function job() { 
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id'); 
    }
    
    public function messages() { 
        return $this->hasMany(Message::class); 
    }
}