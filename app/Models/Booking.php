<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model {

    use HasFactory;

    protected $table = 'bookings';
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'status',
        'name',
        'event_uuid',
        'invitee_uuid',
        'booking_uri',
        'is_active'
    ];

    public static function saveBooking($data = []) {
        $save = Booking::create($data);
        return ($save) ? $save->toArray() : [];
    }

}
