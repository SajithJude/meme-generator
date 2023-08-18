<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logroutes extends Model
{
    use HasFactory;
    protected $fillable = [
        'objecttype','objectid','user_id','page','objectname'
    ];

    public function curriculumLecturesQuiz()
    {
        return $this->belongsTo(CurriculumLecturesQuiz::class, 'objectid', 'lecture_quiz_id');
    }
}
