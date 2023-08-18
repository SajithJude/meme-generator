<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginLog extends Model {

    use HasFactory;

    protected $table = 'user_login_logs';
    protected $guarded = ['id',];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'logout_at',
        'login_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    public static function saveData($data,$type) {
        
        if($type == 'login')
            $data['login_at'] = date('Y-m-d H:i:s');
        else if($type == 'logout')
            $data['logout_at'] = date('Y-m-d H:i:s');
        $results = UserLoginLog::create($data);
        return !empty($results) ? $results->toArray() : [];
    }

}
