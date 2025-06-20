<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'phone',
        'gender',
        'birthdate',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
