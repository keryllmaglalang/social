<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'avatar',
        'website',
        'birth_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // Inverse One-to-One relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}