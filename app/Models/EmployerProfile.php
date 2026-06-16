<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerProfile extends Model {
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'status', 'company_name', 'location_employer', 
        'company_type', 'rating', 'reviews', 
        'document_npwp', 'document_nib'
    ];
    
    public function user() { 
        return $this->belongsTo(User::class); 
        }
}