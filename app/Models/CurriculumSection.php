<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumSection extends Model
{
    use HasFactory;

    protected $table = 'curriculum_sections';

    protected $fillable = [
        'section_id',
        'course_id',
        'title',
        'sort_order',
        'createdOn',
        'updatedOn',
    ];

    public function lessons()
    {
        return $this->hasMany(CurriculumLecturesQuiz::class, 'section_id', 'section_id');
    }

}
