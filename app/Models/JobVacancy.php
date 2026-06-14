<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobVacancy extends Model
{
    use HasFactory;
    protected $fillable = ['employer_id', 'title', 'description', 'qualifications', 'is_active'];
    public function employer() { 
        return $this->belongsTo(User::class, 'employer_id'); 
        }
}
