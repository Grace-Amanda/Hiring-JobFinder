<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantProfile extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id', 'status', 'full_name', 'date_of_birth', 
        'location_applicant', 'education', 'rating', 'job_history', 
        'document_ktp', 'document_ijazah', 'document_cv', 'profile_photo'
    ];

    public function user() { 
        return $this->belongsTo(User::class); 
    }
}