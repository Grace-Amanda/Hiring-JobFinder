<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model {
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'applicant_id',
        'job_vacancy_id',
        'schedule_date',
        'schedule_time',
        'location_or_link',
        'interview_type',
        'notes',
        'status'
    ];

    public function employer() {
        return $this->belongsTo(User::class, 'employer_id');
    }
    public function applicant() {
        return $this->belongsTo(User::class, 'applicant_id');
    }
    public function jobVacancy() {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }
}