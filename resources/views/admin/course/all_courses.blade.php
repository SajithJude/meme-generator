@extends('layouts.main')
@section('content')

    @php
        $setting = \App\Models\Setting::first();
    @endphp

    <style>
        .video-overlay {
            position: relative;
        }

        .video-overlay::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
    </style>

    @if(count($currentCourses) > 0)
        <div class="upcoming-webinar">
            <div class="container">
                <div class="webinar-inner">
                    <h2 class="head-heding">Current Courses</h2>
                    <div class="row">
                        @php $i =1; $uPlan = \Auth::user()->userSubscribedPlans()->get()->count();@endphp
                        @foreach ($currentCourses as $course)
                            @php
                                $file_name = 'https://www.youtube.com/embed/YLExFohPbBc?rel=0&autoplay=0&controls=0&modestbranding=1&origin=https://academy.susieashfield.com/';
                                if(isset($course->course_videos[0]) && !empty($course->course_videos)) {
                                    $promoVideo = collect($course->course_videos)->where('video_name','Video Link')->first();
                                    if($promoVideo){
                                        $promoVideo->toArray();
                                        $file_name = $promoVideo['video_title']."?rel=0&autoplay=0&controls=0&modestbranding=1&origin=https://academy.susieashfield.com/";
                                    }  
                                }
                            @endphp
                            @if($i > 3 && $i % 3 == 1)
                                </div>
                                <div class="row" style="padding-top:20px;">
                            @endif
                            <div class="col-lg-4">
                                <div class="course-card">
                                    <div class="webinar-heading">{{$course->course_title}}</div>
                                    <div class="webinar-description">Susie Ashfield, Instructor</div>
                                    <div class="webinar-image">
                                        <div id="play_lesson" style="padding:58.00% 0 0 0;position:relative;width:100%;height:100%;">
                                            <iframe id="videoId" src="{{url($file_name)}}" allow=" autoplay; fullscreen; picture-in-picture" allowfullscreen frameborder="0" style="position:absolute;top:0;left:0;width:inherit;height:inherit;"></iframe>
                                        </div>
                                        {{-- <video width="100%" height="100%" controls preload="auto">
                                            <source src="{{ url($file_name)}}" type="video/mp4">
                                        </video> --}}
                                    </div>
                                    <div class="webinar-button">
                                        <a href="{{ !$uPlan ? url('membership-plans/'.$course->id) : route('course-lesson',[$course->id]) }}" style="text-decoration: none;">
                                            <button>@if(!$uPlan) <i class="fa fa-lock" aria-hidden="true"></i>@endif Start learning</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @php $i++; @endphp
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    @if(count($upcomingCourses) > 0)
        <div class="upcoming-webinar">
            <div class="container">
                <div class="webinar-inner">
                    <h2 class="head-heding">Upcoming Courses</h2>
                    <div class="row">
                        @php $i =1; $uPlan = \Auth::user()->userSubscribedPlans()->get()->count();@endphp
                        @foreach ($upcomingCourses as $course)
                            @php
                                $file_name = 'https://www.youtube.com/embed/YLExFohPbBc?rel=0&autoplay=0&controls=0&modestbranding=1&origin=https://academy.susieashfield.com/';
                                if(isset($course->course_videos[0]) && !empty($course->course_videos)) {
                                    $promoVideo = collect($course->course_videos)->where('video_name','Video Link')->first();
                                    if($promoVideo){
                                        $promoVideo->toArray();
                                        $file_name = $promoVideo['video_title']."?rel=0&autoplay=0&controls=0&modestbranding=1&origin=https://academy.susieashfield.com/";
                                    }  
                                }
                            @endphp
                            @if($i > 3 && $i % 3 == 1)
                                </div>
                                <div class="row" style="padding-top:20px;">
                            @endif
                            <div class="col-lg-4">
                                <div class="course-card">
                                    <div class="webinar-heading">{{$course->course_title}}</div>
                                    <div class="webinar-description">Susie Ashfield, Instructor</div>
                                    <div class="webinar-image">
                                        <div id="play_lesson" style="padding:58.00% 0 0 0;position:relative;width:100%;height:100%;">
                                            <iframe id="videoId" src="{{url($file_name)}}" allow=" autoplay; fullscreen; picture-in-picture" allowfullscreen frameborder="0" style="position:absolute;top:0;left:0;width:inherit;height:inherit;"></iframe>
                                        </div>
                                        {{-- <video width="100%" height="100%" controls preload="auto">
                                            <source src="{{ url($file_name)}}" type="video/mp4">
                                        </video> --}}
                                    </div>
                                    <div class="webinar-button">
                                        <a href="javascript:void(0)" style="text-decoration: none;">
                                            <button><i class="fa fa-lock" aria-hidden="true"></i> Start learning</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @php $i++; @endphp
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection