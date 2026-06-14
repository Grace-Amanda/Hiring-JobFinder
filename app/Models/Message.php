<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model {
    use HasFactory;
    
    protected $fillable = ['swipe_id', 'sender_id', 'message', 'is_read'];
    public function swipe() { 
        return $this->belongsTo(Swipe::class); 
        }
    public function sender() { 
        return $this->belongsTo(User::class, 'sender_id'); 
        }
}
