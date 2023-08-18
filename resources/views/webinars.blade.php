@extends('layouts.main')
@section('content')
<!-- ===============   Webinar Start   ============== -->
<div class="upcoming-webinar">
<div class="container">
   <div class="webinar-inner">
      <h2 class="head-heding">Upcoming webinars</h2>
      <div class="webinar-cards">
         @foreach($data['upcoming'] as $key=>$record)
         <?php 
            $action = $record['video_url'];
            $style = "";
            $btn_label = "Join here";
            $btnDisabled = ''; ?>
         <div class="webinar-card">
            <div class="date">{{$record['date']}}</div>
            <div class="webinar-heading">{{$record['title']}}</div>
            <div class="webinar-image" style="display: flex; align-items: center; justify-content: center; background-color: #1c1c1c;">
               @if(!empty($record['video_url']))
               <img src="{{ asset('assets/img/'.$record['image']) }}" style="max-width: 100%; max-height: 100%;">
               @else
               <img src="{{url('images/f1.png')}}" alt="" style="max-width: 100%; max-height: 100%;">
               @endif
            </div>
            <div class="webinar-button">
               <a href="{{ !auth()->user()->userSubscribedPlans && $record['accessibility'] ? route('membershipPlans') : $action }}" @if(auth()->user()->userSubscribedPlans) target="__blank" @endif>
               <button {{ $btnDisabled }} id="postwebinar" style= <?= $style ?> >@if(!auth()->user()->userSubscribedPlans && $record['accessibility']) <i class="fa fa-lock" aria-hidden="true"></i>@endif {{$btn_label}}</button></a>
            </div>
         </div>
         @endforeach
      </div>      
   </div>
</div>
<!-- ===============   Webinar End   ============== -->
<!-- ===============   Webinar Start   ============== -->
<div class="upcoming-webinar">
<div class="container">
   <div class="webinar-inner">
      <h2 class="head-heding">Previous Webinars</h2>
      <div class="webinar-cards">
         @foreach($data['recorded'] as $key=>$record)
         <div class="webinar-card">
            <div class="date">{{$record['date']}}</div>
            <div class="webinar-heading">{{$record['title']}}</div>
            <div class="webinar-description">{{$record['instructor']}}, Instructor</div>
            <div class="webinar-image" style="display: flex; align-items: center; justify-content: center; background-color: #1c1c1c;">
               @if(!empty($record['video_url']))
               <iframe style="height: inherit;width: inherit" src="{{$record['video_url']}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
               @else
               <img src="{{url('images/f1.png')}}" alt="" style="max-width: 100%; max-height: 100%;">
               @endif
            </div>
            
         </div>
         @endforeach
      </div>
   </div>
</div>
@endsection