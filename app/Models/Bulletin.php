<?php

namespace App\Models;

use App\Models\Edtion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'page_count',
        'cover_image',
        'url_bulletin',
        'status',
        'release_status',
        'notes',
        'edition_id',
    ];
}
