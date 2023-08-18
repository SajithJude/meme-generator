<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultLearningPath extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'opens_on',
    ];

    public function date(): Attribute
    {
        return Attribute::make(
            get: fn($value) => date_format(date_create($value), 'Y-m'),
            set: fn($value) => date_format(date_create($value), 'Y-m-d'),
        );
    }

    public static function isQuotaFull($courseId, $opensOn)
    {
        return !DefaultLearningPath::where([['opens_on', '=', $opensOn], ['course_id', $courseId]])->count() &&
            DefaultLearningPath::where('opens_on', $opensOn)->count() == 2;
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
