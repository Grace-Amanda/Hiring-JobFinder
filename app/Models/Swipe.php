<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Swipe extends Model {
    protected $fillable = ['applicant_id', 'employer_id', 'job_id', 'status'];
    public function applicant() {
         return $this->belongsTo(User::class, 'applicant_id'); 
         }
    public function employer() { 
        return $this->belongsTo(User::class, 'employer_id'); 
        }
    public function job() { 
        return $this->belongsTo(Job::class); 
        }
    public function messages() { 
        return $this->hasMany(Message::class); 
        }
}