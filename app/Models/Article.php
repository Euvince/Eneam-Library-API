<?php

namespace App\Models;

use App\Models\Loan;
use App\Models\Comment;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function comments () : HasMany {
        return $this->hasMany(related : Comment::class, foreignKey : 'article_id');
    }

    public function loans () : BelongsToMany {
        return $this->belongsToMany(related : Loan::class);
    }

    public function reservations () : BelongsToMany {
        return $this->belongsToMany(related : Reservation::class);
    }

}
