<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model {

    use HasFactory;

    protected $table = 'webinars';
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'video_url',
        'date',
        'instructor',
        'type',
        'is_active',
        'accessibility',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    public static function saveData($data) {
        $results = Webinar::create($data);
        return !empty($results) ? $results->toArray() : [];
    }
    public static function updateData($data) {
        $toupdate = ['title' => $data['title'],
            'video_url' => $data['video_url'],
            'date' => $data['date'],
            'instructor' => $data['instructor'],
            'type' => $data['type'],
            'accessibility' => $data['accessibility']
            ];
        if(isset($data['image']) && $data['image'] != null)   
            $toupdate['image'] = $data['image'];        
        $update = Webinar::where('id', $data['id'])
                ->update($toupdate);

        return ($update) ? true : false;
    }
    public static function updateData1($data) {
        $update = Webinar::where('id', $data['id'])
                ->update(['title' => $data['title'],
            'video_url' => $data['video_url'],
            'date' => $data['date'],
            'instructor' => $data['instructor'],
            'type' => $data['type'],
            'accessibility' => $data['accessibility'],
            'image' => !empty($data['image']) ? $data['image'] : null,
        ]);
        return ($update) ? true : false;
    }

    public static function getWebinars() {
        $results = Webinar::where('is_active', 1)->get();
        return !empty($results) ? $results->toArray() : [];
    }

    public static function getWebinarsAgainstType($col, $val) {
        $results = Webinar::where($col, $val)->where('is_active', 1)->get();
        return !empty($results) ? $results->toArray() : [];
    }

    public static function getWebinar($id) {
        $results = Webinar::where('id', $id)
                ->first();
        return !empty($results) ? $results->toArray() : [];
    }

}
