<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableBookingCount extends Model {

    use HasFactory;

    protected $table = 'available_booking_counts';
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'booking_count'
    ];

    public static function createOrUpdate($data = []) {

        $check = AvailableBookingCount::where('user_id', $data['user_id'])->first();
        if ($check) {
            $save = AvailableBookingCount::where('user_id', $data['user_id'])->increment('booking_count', $data['booking_count']);
        } else {
            $save = AvailableBookingCount::create($data);
        }
       
        return ($save) ? true : false;
    }

    public static function decrementCount($user_id) {
        $save = AvailableBookingCount::where('user_id', $user_id)->decrement('booking_count', 1);

        return ($save) ? true : false;
    }

}

