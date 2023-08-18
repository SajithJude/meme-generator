<link rel="stylesheet" href="{{asset('/css/lesson.css')}}">
@extends('layouts.main')
@section('content')
<style>
  .download-notes-btn {
    font-size: 16px;
    line-height: 10px;
    padding: 10px;
    border-radius: 6px;
    display: inline-block;
    font-family: 'Space Grotesk', sans-serif;
    text-transform: capitalize;
    text-align: center;
    background: #000;
    color: #FFFFC8;
  }
</style>
<!-- ===============   Practice Start   ============== -->
<div class="daily-goals">
  <div class="container-main">
    <div class="daily-goal">
      <div class="trophy">
        <img src="{{url('images/trophy.png')}}" alt="">
      </div>
      <div class="daily-progress">
        {{-- <h3>Daily Goals<span><img src="{{url('images/edit.svg')}}" alt="">Edit Goals</span></h3> --}}
        <h3>Course Progress</h3>
        <div class="progress">
          <div id="progress-percentage" class="progress-bar" role="progressbar"
            style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <small id="progress-percentage-show">Progress: {{ $progressPercentage }}%</small>
      </div>
      @if ($progressPercentage == 100)
        <div id="course-complete-confetti" class="trophy">
          <img alt="Logo" src="{{ asset('images/confetti.png') }}" style="height:70px; width: 70px; margin-left: 20px;" class="logo">
        </div>
      @endif
    </div>
  </div>
</div>
<!-- ===============   Practice End   ============== -->

<!-- ===============   Chapter Start   ============== -->
@php $sectioncount = '1'; $lecturecount = '1'; $quizcount = '1'; @endphp

<div class="chapter-detail">
  <div class="container-main">
    <div class="chapter-detail-content">
      <div class="chapter-header">
        <h1>{{ $course['course_title'] }}</h1>
      </div>

      <div class="chapter-playlist">
        <div class="chapter-video">
          @php
            $file_name = $first_video->video_title;
            $promo_video_name = $promo_video . "?rel=0&autoplay=0&controls=0&modestbranding=1&origin=https://academy.susieashfield.com/"
          @endphp
          <div id="play_lesson" style="padding:58.00% 0 0 0;position:relative;border-radius: 12px;">
            @if (!$file_name)
              <iframe id="videoId" src="{{url($promo_video_name)}}" allow="autoplay; fullscreen; picture-in-picture"
                allowfullscreen frameborder="0"
                style="position:absolute;top:0;left:0;width:100%;height:100%;border-radius: 12px;">
              </iframe>
            @else
              <iframe id="videoId1" src="{{url($file_name)}}" allow="autoplay; picture-in-picture" allowfullscreen
                frameborder="0" style="position:absolute;top:0;left:0;width:100%;height:100%;border-radius: 12px;">
              </iframe>
            @endif
          </div>
        </div>

        <div class="chapter-list" Style="min-height: 422px;">
          <div class="accordion" id="accordionExample">
            @foreach($sections as $section)
              @php
                $acc = "secacc".$section->section_id;
                $show = ($section->section_id == $slectedsessionid)?"show":"";
              @endphp
              <div class="accordion-item" sect="{{$section->section_id}}" Selectedsession="{{$slectedsessionid}}">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#{{$acc}}"
                    aria-expanded="true" aria-controls="collapseOne">
                    Chapter {{$sectioncount}}: {{ $section->title}}
                  </button>
                </h2>
                <div id="{{$acc}}" class="accordion-collapse collapse {{$show}}" aria-labelledby="headingOne"
                  data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    @foreach($lecturesquiz[$section->section_id] as $lecturequiz)
                      @php
                        $videopath = "";
                        if($lecturequiz->media == NULL)
                          $video=null;
                        else
                          $video = $course_video[$lecturequiz->media];

                        if($video != null)
                          $videopath =$video->video_title;

                        $imgsrc = url('images/Play button.svg');
                        $completed = "";
                        $checked = "";
                        if((isset($lecturesnotes[$section->section_id][$lecturequiz->lecture_quiz_id]) && isset($lecturesnotes[$section->section_id][$lecturequiz->lecture_quiz_id]->completed) && $lecturesnotes[$section->section_id][$lecturequiz->lecture_quiz_id]->completed == 1 )){
                          $imgsrc = url('images/greentick.png');
                          $cl =  "done-video";
                          $checkbox = "checked";
                          $checked = "checked";
                          //$completed = "hide";
                        }
                        else if((isset($lecturesnotes[$section->section_id][$lecturequiz->lecture_quiz_id]) && isset($lecturesnotes[$section->section_id][$lecturequiz->lecture_quiz_id]->completed) && $lecturesnotes[$section->section_id][$lecturequiz->lecture_quiz_id]->completed == 0 )){
                          $cl =  "selected-video";
                        }
                        else{
                          $cl = "active-video";
                        }
                      @endphp
                      <div class="play-list {{$cl}} main-div">
                        <img onclickevent="play(this)" course_id="{{$course->id}}"
                          lesson_id="{{$lecturequiz->lecture_quiz_id}}" id="play_btn" class="play" attr="{{$videopath}}"
                          alt="" src="{{$imgsrc}}">
                        <span>{!! $lecturequiz->title !!}</span>
                        <span class="pull-right completed {{$completed}}" id="mark_completed" course_id="{{$course->id}}"
                          lesson_id="{{$lecturequiz->lecture_quiz_id}}">
                          <div class="checkbox-container">
                            <input type="checkbox" id="myCheckbox" title="Mark as completed" {{$checked}}>
                            <label for="myCheckbox"></label>
                          </div>
                        </span>
                      </div>
                      @php
                      @endphp
                    @endforeach
                  </div>
                </div>
              </div>
              @php $sectioncount++ @endphp
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="chapter-tabs">
  <div class="container-main">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
          role="tab" aria-controls="nav-home" aria-selected="true">Description</button>
        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
          role="tab" aria-controls="nav-profile" aria-selected="false">Notes</button>
      </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div id="lessondesc">
          <p></p>
        </div>
      </div>

      <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <span id="save_notes"> </span>
        <span id="save_notes"> </span>
        <form class="text_area">
          <input id="course_id" name="course_id" value="{{ $course->id }}" type='hidden'>
          <input id="lesson_id" name="lesson_id" value="{{ $selectedlesson }}" type='hidden'>
          <textarea id="notes" class="text_area_value" rows="5" cols="33"
            style="
              overflow: auto;
              resize: vertical;
              border: none;
              width: 100%;
              background-color: #eeeeee;"
            placeholder="Write something">{{ isset($selectedLessonUserNotes) ? $selectedLessonUserNotes->notes : '' }}</textarea>
            <div class="mt-2">
              <button class="download-notes-btn">Download Notes</button>
            </div>
            {{-- @if (isset($selectedLessonUserNotes) && strlen($selectedLessonUserNotes->notes))
            @endif --}}
        </form>
      </div>
    </div>
  </div>
</div>
<!-- ===============   Chapter End   ============== -->


<!-- ================   Modal   =============== -->
<!-- <div class="action" ">
    <div style="display: flex; justify-content: center; margin-bottom: 2%;" class="container-main">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Get full access
      </button>
    </div>
  </div> -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content"
      style="background-color: #fff0 !important;    border: 1px solid rgb(0 0 0 / 0%) !important;">
      <div class="modal-body" style="margin-left: 3%">
        <div class="membership-plan-pop">
          <i class="fa fa-lock"></i>
          <h3>Get full access</h3>
          <i class="fas fa-band-aid"></i>

          <div class="toggle-membership">
            Monthly
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
            </div>
            Annually
          </div>

          <h3>
            <span id="plan-price">
              @if(isset($subscriptionPlanMonthly->price))
                ${{ $subscriptionPlanMonthly->price }}.00
              @else
                $0.00
              @endif
            </span>
          </h3>

          <h6>
            Annual membership
            <span>
              ${{ isset($subscriptionPlanAnually->price) ? number_format($subscriptionPlanAnually->price/12,2) : '0' }}/month
            </span>
          </h6>

          @php $plan = isset($subscriptionPlanMonthly)?$subscriptionPlanMonthly:$subscriptionPlanAnually @endphp

          <a
            href="{{ route('paymentDetails',
              ['user_id' => (Crypt::encrypt(auth()->user()->id)), 'subscription_id' => (Crypt::encrypt($plan->id))]) }}">
            <button class="start-membership">Start membership</button>
          </a>

          @if (Auth::check() && (isset(Auth::user()->email_verified_at) && !empty(Auth::user()->email_verified_at) ) &&
            Auth::user()->is_sign_up_free == 0)

            <a href="{{url('signupfree')}}">Sign up for free</a>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://player.vimeo.com/api/player.js"></script>

<script>
  localStorage.clear();

  var stopAction = false;
  var player = new Vimeo.Player(document.querySelector('iframe#videoId1'));

  $("#flexSwitchCheckDefault").click(function(){
    $("#display").toggle();
    if($(this).text() == "Show") {
      $price = '<?php  echo isset($subscriptionPlanMonthly)? $subscriptionPlanMonthly->price : '0'; ?>';
      $('#plan-price').html('$'+$price+'.00');
      $(this).text("Hide");
    }else{
      $price = '<?php echo isset($subscriptionPlanAnually)? $subscriptionPlanAnually->price : '0'; ?>';
      $('#plan-price').html('$'+$price+'.00');
      $(this).text("Show");
    }
  });

  var access = "<?php echo isset($access)?$access:'false'; ?>";

  if(access == 'false')
  {
    $('#exampleModal').modal({backdrop: 'static', keyboard: false}, 'show');
  }


  $(document).ready(function() {
    @if (isset($selectedLessonUserNotes) && isset($selectedLessonUserNotes->lesson_timestamp))
      player.setCurrentTime({{ $selectedLessonUserNotes->lesson_timestamp ?? 0 }})
        .then(currentTime => {
          console.log(`Lesson resumed from ${currentTime} seconds`);
        }).catch(e => {
          console.log(e);
        });
    @endif

    var timer;
    var timeout = 2000; // Timout duration
    $(`#play_btn[course_id="${$('#course_id').val()}"][lesson_id="${$('#lesson_id').val()}"]`)
      .parent().addClass('playing');

    $('.text_area_value').keyup(function() {
      var lesson_id = $('#lesson_id').val();

      if (lesson_id != "") {
        $('#save_notes').html("<span style='color:gray'> Saving... </span>")
        if (timer) { clearTimeout(timer); }

        timer = setTimeout(saveNotes, timeout);
      } else {
        alert('Select any lesson first');
      }
    });

    $('div.main-div').click(function() {
      if (($(this).find('span#mark_completed').hasClass('in-progress')) == true )
        return;

      if ($(this).find('#play_btn').attr('class') == "play")
        play($(this).find('#play_btn'), true);
      else if ($(this).find('#play_btn').attr('class') == "pause")
        pause($(this).find('#play_btn'), true);
    });

    $('span.completed').click(function() { markAsCompleted(this) });
  });

  function saveData(course_id, lesson_id, completed = 0, goToNextLesson = false) {
    var url = $(location).attr('href');
    var segments = url.split( '/' );

    $.ajax({
      url: "{{ url('save_lesson_notes') }}",
      method:'GET',
      data: {
        lesson_id: lesson_id,
        course_id: course_id,
        is_completed: completed,
        notes: $('.text_area_value').val(),
      },
      success: function(result) {
        obj = $('span.in-progress');
        obj.parent().removeClass('in-progress');
        obj.parent().addClass('done');

        obj.addClass('done');
        obj.removeClass('completed');
        obj.removeClass('in-progress');
        obj.parent().find('img').removeAttr('src');

        if (completed == 1)
          obj.parent().find('img').attr('src',"{{ url('images/greentick.png') }}");
        else
          obj.parent().find('img').attr('src',"{{ url('images/Play button.svg') }}");

        obj.parent().find('img').addClass('play');
        obj.parent().find('img').attr('onclickevent','play(this)');
        obj.parent().find('img').removeClass('pause');

        showProgress(result.progress_percentage);

        if (completed && goToNextLesson) {
          if ($(`#play_btn[course_id="${course_id}"][lesson_id="${lesson_id}"]`).parent().next().length)
            $(`#play_btn[course_id="${course_id}"][lesson_id="${lesson_id}"]`).parent().next().click();
          else if ($(`#play_btn[course_id="${course_id}"][lesson_id="${lesson_id}"]`).parent().parent()
            .parent().parent().next().length) {

            $(`#play_btn[course_id="${course_id}"][lesson_id="${lesson_id}"]`).parent().parent().parent()
              .parent().next().find('.accordion-button').click();
            $(`#play_btn[course_id="${course_id}"][lesson_id="${lesson_id}"]`).parent().parent().parent()
              .parent().next().find('#play_btn')[0].click();
          }
        }
      }
    });
  }

  function saveNotes() {
    var url = $(location).attr('href');
    var segments = url.split( '/' );
    var lesson_id = $('#lesson_id').val();
    var course_id = $('#course_id').val();

    $.ajax({
      url:'{{ url('save_lesson_notes') }}',
      data: {
        lesson_id: lesson_id,
        notes: $('.text_area_value').val(),
        course_id: course_id,
      },
      method:'GET',
      success: function(result) {
        $('#save_notes').html("<span style='color:gray'> Saved </span>")
      }
    });

  }

  function getLessonDetail(course_id, lesson_id, video_url) {
    player.getCurrentTime().then(currentTime => {
      const playBtn = $(`#play_btn[course_id="${$('#course_id').val()}"][lesson_id="${$('#lesson_id').val()}"]`);
      playBtn.parent().removeClass('playing');

      $('input#course_id').val(course_id);
      $('input#lesson_id').val(lesson_id);
      $(`#play_btn[course_id="${$('#course_id').val()}"][lesson_id="${$('#lesson_id').val()}"]`)
        .parent().addClass('playing');

      $('#save_notes').html('');

      // empty notes and desc
      $('#lessondesc p').html('');
      $('textarea#notes').val('');
      $('textarea#notes').attr('disabled', true);

      $.ajax({
        url:`{{ url('course-lesson-detail') }}/${course_id}/${lesson_id}`,
        method:'GET',
        success: function(result) {
          obj = $('span.in-progress');
          obj.addClass('done');
          obj.removeClass('completed');
          obj.removeClass('in-progress');

          $('#lessondesc p').html(result.desc);
          $('textarea#notes').attr('disabled', false);
          $('textarea#notes').val(result.notes);

          player.loadVideo(video_url).then(function() {
            window.history.pushState(document.title, document.title, `${window.location.origin}/course-lesson-number/${course_id}/${lesson_id}`);

            if (result.lesson_timestamp && result.lesson_timestamp > 0) {
              player.setCurrentTime(result.lesson_timestamp)
                .then(currentTime => {
                  player.play();
                  console.log('Lesson resumed from ' + currentTime + ' seconds');
                }).catch(e => {
                  console.log(e);
                })
            } else {
              player.play();
            }
          });
        }
      });
    });
  }

  function play(obj,from_play=false) {
    var course_id =  $(obj).attr("course_id");
    var lesson_id =  $(obj).attr("lesson_id");

    const currentTimeKey = `currentTime_${course_id}_${lesson_id}`;
    const storedTime = localStorage.getItem(currentTimeKey);

    if (!isNaN(storedTime))
      player.currentTime = storedTime;

    // in case of new lesson load video  else play from last pause
    if (storedTime <= 0 || isNaN(storedTime)) {
      getLessonDetail(course_id, lesson_id, $(obj).attr("attr"));
    } else {
      player.play()
    }

    $('#lessondesc p').html();
    $('span#save_notes textarea').val();
    $(obj).parent().find('span#mark_completed').removeClass('hide');
  };

  function pause(obj,from_play=false) {
    player.pause();
  }

  function getCurrentTime() {
    return player.getCurrentTime()
      .then(function(time) {
        return time;
      })
      .catch(function(error) {
        console.log('Failed to get current time');
      });
  }

  function timeUpdateEvent() {
    removeTimeUpdateEvent();
    player.on('timeupdate', (time) => {
      if (time.seconds % 1 >= 0 && time.seconds % 1 <= 0.4) {
        updateTime(time.seconds, $('#lesson_id').val());
      }
    });
  }

  function updateTime(time, lesson_id, async = true) {
    $.ajax({
      url: "{{ route('save_lesson_timestamp') }}",
      data: {
        lesson_id: lesson_id,
        lesson_timestamp: parseInt(time)
      },
      async: async,
      complete: function (result) {
        return true;
      }
    });
  }

  function removeTimeUpdateEvent(params) {
    player.off('timeupdate');
  }

  function markAsCompleted(el, goToNextLesson = false) {
    stopAction = true;

    $('#lesson_id').val($(el).attr('lesson_id'));
    $('#course_id').val($(el).attr('course_id'));
    $(el).addClass('in-progress');

    const checkboxValue = $(el).find('input[type="checkbox"]').prop('checked');
    saveData($(el).attr('course_id'),$(el).attr('lesson_id'), checkboxValue ? 1 : 0, goToNextLesson);
  }

  function showProgress(progress_percentage) {
    $('#progress-percentage').css('width', `${progress_percentage}%`);
    $('#progress-percentage-show').text(`Progress: ${progress_percentage}%`);

    $('#course-complete-confetti').remove();
    if (progress_percentage === 100) {
      confetti({
        particleCount: 400,
        spread: 100,
        origin: { y: 1 },
      });

      $('.daily-goal').html(`${$('.daily-goal').html()}
        <div id="course-complete-confetti" class="trophy">
          <img alt="Logo" src="{{ asset('images/confetti.png') }}" style="height:70px; width: 70px; margin-left: 20px;" class="logo">
        </div>`
      );
    }

  }

  player.on('play', () => {
    var lesson_id = $('#lesson_id').val();
    var course_id = $('#course_id').val();
    const play_btn = `#play_btn[lesson_id="${lesson_id}"][course_id="${course_id}"]`;

    $('div.play-list img.pause').each(function() {
      $(this).addClass("play");
      $(this).removeClass("pause");

      if ($(this).parent().find('input[type="checkbox"]').prop('checked'))
        $(this).attr('src',"{{ url('images/greentick.png') }}");
      else
        $(this).attr('src',"{{ url('images/Play button.svg') }}");
    });

    $(play_btn).removeAttr("src");
    $(play_btn).attr("src", "{{ url('images/pause.svg') }}");
    $(play_btn).addClass('pause');
    $(play_btn).parent().addClass('in-progress');
    $(play_btn).attr('onclickevent','pause(this)');
    $(play_btn).removeClass('play');

    // delete the localStorage value for the previous video, if it exists
    const prevCourseId = localStorage.getItem('currentCourseId');
    const prevLessonId = localStorage.getItem('currentLessonId');

    // set the current course_id and lesson_id in localStorage
    localStorage.setItem('currentCourseId', course_id);
    localStorage.setItem('currentLessonId', lesson_id);

    // verify that the value has been set correctly
    if((prevCourseId == course_id) && (prevLessonId != lesson_id)) {
      localStorage.removeItem('currentTime_' + prevCourseId + '_' + prevLessonId);
    }

    timeUpdateEvent();
  });

  player.on('pause', () => {
    var lesson_id = $('#lesson_id').val();
    var course_id = $('#course_id').val();
    const play_btn = `#play_btn[lesson_id="${lesson_id}"][course_id="${course_id}"]`;

    $(play_btn).attr("src", '<?php echo url('images/Play button.svg'); ?>');
    $(play_btn).addClass('play');
    $(play_btn).removeClass('pause');

    // save current playback position to localStorage
    player.getCurrentTime()
      .then(function(time) {
        localStorage.setItem("currentTime_" + course_id + "_" + lesson_id, time);
      })
      .catch(function(error) {
        console.log('Failed to get current time');
      });

    removeTimeUpdateEvent();
  });

  // save progress and go to the next lesson
  player.on('ended', () => {
    removeTimeUpdateEvent();

    const markCompleteCheckbox = `#mark_completed[lesson_id="${$('#lesson_id').val()}"][course_id="${$('#course_id').val()}"]`;
    $(markCompleteCheckbox).find('input[type="checkbox"]').attr('checked', 'checked');

    updateTime(0, $('#lesson_id').val(), false);
    markAsCompleted(markCompleteCheckbox, true);
  });

  $(document).ready(function () {
    $('.download-notes-btn').on('click', function (e) {
      e.preventDefault();
      let btn = $(this)
      btn.text('Downloading...');
      var lesson_id = $('#lesson_id').val();
      var course_id = $('#course_id').val();
      $('div.loaderImage').show();
      
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:'{{ route('download-lesson-notes') }}',
        data: {
          course_id: course_id,
        },
        method:'Post',
        success: function(result) {
          $('div.loaderImage').hide();
          const link = document.createElement("a");
          link.href = result.url;
          link.setAttribute("download", result.name);
          document.body.appendChild(link);
          link.click();
          btn.text('Download Notes');
        },
        error: function(error) {
          console.log(error);
          $('div.loaderImage').hide();
          btn.text('Download Notes');
        },
      });

    })
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.9.3/tsparticles.confetti.bundle.min.js"></script>
@endsection
