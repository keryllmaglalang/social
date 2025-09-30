<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // One-to-One relationship with Profile
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // One-to-Many relationship with Posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // One-to-Many relationship with Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}