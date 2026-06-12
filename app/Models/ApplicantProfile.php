<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ApplicantProfile extends Model {
    protected $fillable = [
        'user_id', 'status', 'full_name', 'date_of_birth', 
        'location', 'education', 'rating', 'job_history', 
        'document_ktp', 'document_cv'
    ];
    public function user() { 
        return $this->belongsTo(User::class); 
        }
}