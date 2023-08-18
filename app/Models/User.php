<?php

namespace App\Models;

use App\Library\Mailchimp;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserSubscribedPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'city',
        'phone_number',
        'email',
        'password',
        'is_active',
        'status',
        'email_verified_at',
        'is_sign_up_free',
        'created_by',
        'password_updated_at',
        'learning_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

     protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Auto hash password when create/update
     * @param $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::needsRehash($value) ? \Hash::make($value) : $value;
    }
    public function getUserSubscription($user_id)
    {

        return UserSubscribedPlan::where('user_id',$user_id)->whereRaw('subscription_end_date >= now()')->orderby('subscription_end_date','desc')->first();
    }

    public function getStatusLabelAttribute()
    {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }

    public function userCurrentAndUpcomingCourses()
    {
        $courses = Course::with(['course_videos', 'categories'])
            ->whereDoesntHave('users', function ($query) {
                $query->where('users.id', $this->id);
            })->where('is_active', 1)->get();

        if (isset($this->userSubscribedPlans)) {
            if ($this->learning_path == 'manual') {
                $currentUserCourses = $allUserCourses = $this->courses()->with(['course_videos', 'categories'])
                    ->where([['is_active', '=', 1], ['is_locked', '=', 1]])->whereNotNull('course_user.created_at')
                    ->orderBy('course_user.created_at', 'desc')->get();
            } else {
                $monthsPassed = date_diff(date_create(
                    $this->userSubscribedPlans->subscription_start_date
                ), date_create(date_create('Y-m-d H:i:s')))->m + 1;
                $userCourseIds = DefaultLearningPath::where('opens_on', '<=', $monthsPassed);
                $allUserCourses = Course::with(['course_videos', 'categories'])->where([['is_active', '=', 1], ['is_locked', '=', 1]])
                    ->whereIn('id', $userCourseIds->pluck('course_id')->toArray())->get();

                $currentUserCoursesIds = $userCourseIds->where('opens_on', $monthsPassed);
                $currentUserCourses = $allUserCourses->whereIn('id', $currentUserCoursesIds->pluck('course_id')->toArray());
            }
        } else {
            $allUserCourses = collect([]);
            $currentUserCourses = Course::with(['course_videos', 'categories'])->where('is_locked', 0)->get();
        }

        return [
            $allUserCourses->concat(Course::with(['course_videos', 'categories'])->where('is_locked', 0)->get()),
            $currentUserCourses,
            $courses->where('is_locked', 1)->whereNotIn('id', $allUserCourses->pluck('id')->toArray()),
        ];
    }

    public function availableBookingCounts()
    {
        return $this->hasOne(AvailableBookingCount::class);
    }

    public function coachPayments()
    {
        return $this->hasMany(CoachPayment::class);
    }

    public function eventBookings()
    {
        return $this->hasMany(EventBooking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function userSubscribedPlans()
    {
        return $this->hasOne(UserSubscribedPlan::class);
    }

    public static function getstudent($id) {
        $results = User::where('id', $id)
                ->first();
        return !empty($results) ? $results->toArray() : [];
    }

    public static function updateData($data, $count = null) {
        $user = User::where('id', $data['id'])->first();
        $update = $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone_number' => $data['phone_number'],
            'city' => $data['city'],
            'status' => $data['status']
        ]);
        if ($update && $count) {
            AvailableBookingCount::updateOrCreate([
                'user_id' => $data['id'],
            ],[
                'booking_count' => $data['booking_count'],
            ]);
        }
        return ($update) ? true : false;
    }

    public function saveToMailchimp() {
        try {
            $client = new Mailchimp();
            $user = $this->mailchimp_id ? $client->updateListMember($client->listId, $this) : $client->addListMember($client->listId, $this);

            $this->mailchimp_id = $user->id;
            $this->save();
        } catch (ClientException $e) {
            Log::error($e->getResponse()->getBody()->getContents());
        }

        return $this;
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id')->withPivot(['id', 'created_at']);
    }

    public function logs()
    {
        return $this->hasMany(logroutes::class);
    }
}
