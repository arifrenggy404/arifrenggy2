<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'slug', 'summary', 'desc_content', 
        'arch_content', 'code_content', 'image_path', 
        'github_url', 'demo_url', 'is_featured', 'order', 'tags'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
    ];
}
