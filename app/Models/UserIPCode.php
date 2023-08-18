<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserIPCode extends Model
{
    protected $table = 'user_ip_codes';

    protected $casts = [
        'verified' => 'boolean',
    ];

    protected $fillable = [
        'user_id',
        'ip_address',
        'code',
        'expires_at',
        'verified',
    ];

    protected $dates = [
        'expires_at',
    ];

    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }
}
