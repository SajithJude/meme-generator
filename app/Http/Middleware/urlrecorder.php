<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\logroutes;
use App\Models\Webinar;
use App\Models\Course;
use App\Models\Subscription;

class urlrecorder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        try{
            $data=[];
            $data['user_id'] = Auth::user()->id;
            $data['page'] = request()->segments()[0];
            $data['objectname'] ="N/A";
            switch (request()->segments()[0]) {
              case 'meeting':            
                $data['objecttype']='page';
                break;
              case 'practice':
                $data['objecttype']='page';
                break;
              case 'webinars':            
                $data['objecttype']='page';            
                break;
             case 'book-webinar':
                $data['objecttype']='webinar';
                $data['objectid']=$request->only('web_id')['web_id'];                
                $obj = Webinar::find($data['objectid']);
                $data['objectname']=is_object($obj)?$obj->title:"";
                break;
            case 'course-lesson':
                $data['objecttype']='course-lesson';
                $data['objectid']=request()->segments()[1];
                $obj = Course::find($data['objectid']);
                $data['objectname']=is_object($obj)?$obj->course_title:"NA";
                break;
            case 'membership-plans':
                $data['objecttype']='membership-plans';
                $data['objectid']=request()->segments()[1];
                $obj = Course::find($data['objectid']);
                $data['objectname']=is_object($obj)?$obj->course_title:"NA";
                break;    
            case 'course-lesson-detail':
                $data['objecttype'] = Course::find(request()->segments()[1])->course_title;
                $data['objectid']=request()->segments()[2];
                $obj = \DB::table('curriculum_lectures_quiz')->where('lecture_quiz_id', $data['objectid'])->first();
                $data['objectname']=is_object($obj)?$obj->title:"NA";
                break;    
            case 'payment-details':
                $data['objecttype']='viewsubscription';
                $data['objectid']=$request->only('selected-plan')['selected-plan'];
                $obj = Subscription::find($data['objectid']);
                $data['objectname']=is_object($obj)?$obj->plans:""; 
                break;
            case 'payment':
                $data['objecttype']='buysubscription';
                $data['objectid']=$request->only('subscription_id')['subscription_id'];
                $obj = Subscription::find($data['objectid']);
                $data['objectname']=is_object($obj)?$obj->plans:"";                
                break;
            case 'paypal':
                $data['objecttype']='buysubscriptionpaypal';
                //$data['object_id']=$request->only('subscription_id')['subscription_id'];
                break;

            default:
                
            }
            logroutes::create($data);
        }catch(\Exception $e){
            \Log::info($e->getMessage());
        }        
        return $next($request);
    }
}
