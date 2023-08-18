<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       'free_sign_up','contact_email','instagram','facebook',
             'tiktok','linkedin'
    ];

    

    // use HasFactory;

    // protected $fillable1 = [
    //     'title',
    //     'key',
    //     'value',
    //     'status',
    // ];
}
