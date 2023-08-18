<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachPayment extends Model {

    use HasFactory;

    protected $table = 'coachpayments';
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [        
        'user_id',
        'price',
        'exp_month',
        'exp_year',
        'card_number',
        'card_name',
        'card_type',
        'intent_id',
        'payment_method_id',
        'receipt_url',
        'gateway_response',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    public static function saveData($data) {

        $results = CoachPayment::create($data);
        return !empty($results) ? $results->toArray() : [];
    }

}
