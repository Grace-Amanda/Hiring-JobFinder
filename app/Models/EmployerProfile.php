<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EmployerProfile extends Model {
    protected $fillable = [
        'user_id', 'status', 'company_name', 'location', 
        'company_type', 'rating', 'reviews', 
        'document_npwp', 'document_legal'
    ];
    public function user() { 
        return $this->belongsTo(User::class); 
        }
}