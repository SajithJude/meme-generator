<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseVideos extends Model {

	protected $table 		= 'course_videos';
	protected $primaryKey 	= 'id';

	public $timestamps = false;
			
	protected $fillable = [
		'video_title',
		'video_name',
		'video_type',
		'duration',
		'image_name',
		'video_tag',
		'uploader_id',
		'course_id',
		'processed',
	];
	public function __construct() {
		parent::__construct();
	}

	public function getDateFormat()
    {
        return 'U';
    }

    public function user(){
		return $this->belongsTo('User');
    }

	public function course()
	{
		return $this->belongsTo(Course::class, 'course_id');
	}
}