<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['avatar_path', 'tagline', 'bio', 'resume_path', 'socials'];
    protected $casts = [
        'socials' => 'array',
    ];
}
