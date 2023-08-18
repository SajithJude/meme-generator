<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNote extends Model
{
    use HasFactory;

    protected $table = 'user_notes';

    protected $fillable = [
        'lesson_id',
        'user_id',
        'notes',
        'completed',
        'last_played',
        'completed_at',
        'lesson_timestamp',
    ];
}
