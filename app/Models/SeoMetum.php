<?php

namespace App\Models;

use App\Models\Concerns\HasImageBlobs;
use Illuminate\Database\Eloquent\Model;

class SeoMetum extends Model
{
    use HasImageBlobs;

    protected $table = 'seo_meta';

    protected $fillable = [
        'page_name', 'meta_title', 'meta_description', 'meta_keywords',
        'og_title', 'og_description', 'og_image', 'structured_data', 'canonical_url',
    ];

    protected function imageBlobFields(): array
    {
        return [
            'og_image' => ['og_image_blob', 'og_image_mime'],
        ];
    }
}
