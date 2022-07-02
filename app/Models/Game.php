<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Game extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'Tirada_Uno', 'Tirada_Dos', 'Derrota_Victoria', 'user_id'];
    
    public function User() {
        return $this->belongsTo(User::class);
    }

    
}
