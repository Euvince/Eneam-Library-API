<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'type', 'summary', 'author', 'cote', 'ISBN',
        'editor', 'editing_year', 'number_pages', 'available_stock',
        'available', 'loaned', 'reserved', 'hasEbook', 'hasPodcast',
        'keywords', 'formats', 'access_paths',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $casts = [
        'keywords' => 'array',
        'formats' => 'array',
        'access_paths' => 'array'
    ];

}
