<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\BookedWebinar;
use App\Models\Webinar;
use App\Events\BookedwebinarNotification;
use App\Notifications\EmailNotification;
use Notification;


class WebinarController extends Controller {

    public function getWebinars() {
        $recorded = \App\Models\Webinar::getWebinarsAgainstType('type', 'recorded');
        foreach($recorded as $key=>$record){
            $url = $record['video_url'];
            $parsedUrl = parse_url($url);
            if(!isset($parsedUrl['query']))
              continue;
            parse_str($parsedUrl['query'], $queryParams);
            $videoId = $queryParams['v'];
            $recorded[$key]['video_url']= "https://www.youtube.com/embed/". $videoId;
        }
        //dd($recorded);
        $data['recorded'] =  $recorded;
        $data['userbooked'] = array_keys(\App\Models\Webinar::leftjoin('booked_webinar','booked_webinar.webinar_id','webinars.id')->where('type','upcoming')->where('user_id',Auth::user()->id)->select('webinars.id')->get()->keyBy('id')->toArray());
        $data['upcoming'] = \App\Models\Webinar::getWebinarsAgainstType('type', 'upcoming');
        
       
        return view('webinars', compact('data'));
    }
    public function bookWebinar(Request $request) {

    	$inputs = $request->toArray();
    	$data['user_id'] = Auth::user()->id;
        $data['webinar_id'] = $request->web_id;
        $book = BookedWebinar::create($data);
        $detail = BookedWebinar::join('webinars','webinar_id','webinars.id')->join('users','users.id','booked_webinar.user_id')->select('users.first_name','users.last_name',
        'users.email','webinars.*')->first();

        $project = [
            'greeting' => 'Hi '.$detail->first_name.' '.$detail->first_name,
            'body' => 'You can follow us on url'. $detail->video_url,
            'thanks' => 'Thank you for booking this webinar',
            'actionText' => 'View webinar',
            'actionURL' => url('/webinars'),
            'id' => $detail->id
        ];
  
        Notification::send(Auth::user(), new EmailNotification($project));
        
        return redirect('webinars')->with('success', 'You have successfully booked the webinar! 
            A notification has been sent to your registered email address.');
        //return view('webinars', compact('data'));
    }
    

}
