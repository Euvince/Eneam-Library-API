<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'month', 'valid_memories_number', 'invalid_memories_number',
        'ebooks_number', 'physical_books_number', 'created_at', 'updated_at'
    ];
}
