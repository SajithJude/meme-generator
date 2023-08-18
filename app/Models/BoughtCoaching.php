<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoughtCoaching extends Model
{
    use HasFactory;
    protected $table = 'user_bought_coaching';
    protected $guarded = array();
}
