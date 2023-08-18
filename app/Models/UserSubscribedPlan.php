<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscribedPlan extends Model {

    use HasFactory;

    protected $table = 'user_subscribed_plans';
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subscription_id',
        'user_id',
        'price',
        'subscription_start_date',
        'subscription_end_date',
        'paid_with',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    public static function saveData($data) {
        $results = UserSubscribedPlan::create($data);
        return !empty($results) ? $results->toArray() : [];
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

}
