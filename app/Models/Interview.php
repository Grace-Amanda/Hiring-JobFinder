<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model {
    use HasFactory;
    
    protected $fillable = ['employer_id', 'applicant_id', 'job_id', 'schedule_date', 'schedule_time', 'location_or_link', 'status'];
    public function employer() { 
        return $this->belongsTo(User::class, 'employer_id'); 
        }
    public function applicant() { 
        return $this->belongsTo(User::class, 'applicant_id'); 
        }
    public function job() { 
        return $this->belongsTo(Job::class); 
        }
}
