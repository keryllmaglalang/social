<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image',
    ];

    // Inverse One-to-Many relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // One-to-Many relationship with Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Many-to-Many relationship with Hashtags
    public function hashtags()
    {
        return $this->belongsToMany(Hashtag::class);
    }
}