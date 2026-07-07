<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceArea extends Model
{
    protected $fillable = [
        'name', 'slug', 'region', 'description', 'map_link', 'icon',
        'meta_title', 'meta_description', 'meta_keywords', 'content_html', 'faqs',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'faqs' => 'array',
    ];
}
