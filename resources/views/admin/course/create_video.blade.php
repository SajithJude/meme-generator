@extends('layouts.default')
@section('title')
Courses Listing
@endsection
@section('body')
<link rel="stylesheet" href="{{ asset('backend/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min599c.css?v4.0.2') }}">



<style type="text/css">
label.cabinet{
    display: block;
    cursor: pointer;
}

.cabinet.center-block{
    margin-bottom: -1rem;
}

#upload-demo{
    width: 825px;
    height: 325px;
  padding-bottom:25px;
}

.course-image-container{
    width: 435px;
    height: 246px;
    border: 1px solid #e4eaec;;
    position: relative;
}

.custom-blockquote{
  margin-top: 85px;
}
</style>

@php
    $rec = App\Models\CourseVideos::find($course->course_video);
    $promoVideo = isset($rec) ? $rec->video_title : '';
@endphp
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12 mb-2">
                <h3 class="content-header-title">
                    Courses Listing
                </h3>
            </div>
            <div class="content-header-right col-md-8 col-12">
                <div class="breadcrumbs-top float-md-right">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Courses Listing
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Base style table -->
            <section id="base-style">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        {{-- <li><a data-action="close"><i class="ft-x"></i></a></li> --}}
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    @include('includes.error')

                                    @include('includes.cousetabs')
                                   

                                    <form  action="{{ route('instructor.course.video.save') }}" id="courseForm" name="frmupload" method="post" enctype="multipart/form-data">
                                      {{ csrf_field() }}
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <div class="row">
                                    
                                      <div class="col-md-6">
                                          <label class="cabinet center-block">
                                              <figure class="course-image-container" style="border-radius: 12px;">
                                                  {{-- <div class="video-preview"> --}}
                                                  @if($video)
                                                    @php
                                                      $file_name = 'course/'.$video->course_id.'/'.$video->video_title.'.'.$video->video_type;
                                                    @endphp
                                                    {{-- {{dd(url('public/'.$file_name)) }} --}}
                                                    {{-- {{dd( storage_path())}} --}}
                                                    
                                                    @if(!empty($file_name))
                                                        <iframe src="{{ $video->video_title .'?rel=0&autoplay=0&controls=0&modestbranding=1&origin=https://academy.susieashfield.com/' }}" width="100%" height="100%" frameborder="0" allowfullscreen style="border-radius: 12px;"></iframe>
                                                      {{-- <video width="100%" height="100%" controls preload="auto"><source src="{{ $video->video_title }}"></video> --}}
                                                    @else
                                                      <blockquote class="blockquote custom-blockquote blockquote-success mt-4">
                                                      <p class="mb-0">Promo video not yet uploaded</p>
                                                      </blockquote>
                                                    @endif
                                                  @else
                                                      <blockquote class="blockquote custom-blockquote blockquote-success">
                                                      <p class="mb-0">Promo video not yet uploaded</p>
                                                      </blockquote>
                                                  @endif
                                                  
                                                  {{-- </div> --}}
                                              </figure>
                                          </label>
                                      </div>
                                      
                                      <div class="col-md-6">
                                          <span style="font-size: 10px;">
                                              Supported File Formats: Youtube Vide Link
                                              <br>Duration: 5-10 Mins
                                              <br> Max File Size: 300MB
                                          </span>
                                          <hr class="my-4">
                              
                              
                                          <div class="progress" id="progress_div" style="display:none;">
                                            <div class="progress-bar progress-bar-success" id="bar" role="progressbar" style="width:0%">
                                              <span id="percent">0%</span>
                                            </div>
                                          </div>
                              
                                          <div id='output_image'></div>
                              
                                          <div class="row">
                                              <div class="col-md-12">
                                                <fieldset class="form-group">
                                                    <div class="input-group input-group-file" data-plugin="inputGroupFile">
                                                        <input type="url" class="form-control" name="promo_video_link" id="promo_video_link" placeholder="Enter Video Link" data-url="{!! route('save.course.lesson.vimeo.url', 0) !!}" value="{{ $promoVideo }}">
                                                    </div>
                                                </fieldset>
                                              </div>
                              
                                              <div class="col-md-6">
                                                  <input type="submit" class="btn btn-primary upload-promo-video" value="Submit">
                                              </div>
                                          </div>
                              
                                      </div>
                                    </div>
                                  </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/ Base style table -->

        </div>
    </div>
</div>







{{-- @section('javascript') --}}






@endsection

@section('local-script')

<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>

<script type="text/javascript">
  // function upload_video() 
  // {
  //   var bar = $('#bar');
  //   var percent = $('#percent');
  //   $('#courseForm').ajaxForm({
  //     beforeSubmit: function() {
  //       document.getElementById("progress_div").style.display="block";
  //       var percentVal = '0%';
  //       bar.width(percentVal)
  //       percent.html(percentVal);
  //     },
  
  //     uploadProgress: function(event, position, total, percentComplete) {
  //       var percentVal = percentComplete + '%';
  //       bar.width(percentVal)
  //       percent.html(percentVal);
  //     },
      
  //     success: function() {
  
  //       var percentVal = '100%';
  //       bar.width(percentVal);
  //       percent.html(percentVal);
  
  //     },
  
  //     complete: function(xhr) {
  //       if(xhr.responseText)
  //       {
  //         $('#progress_div').hide();
  //         var data = JSON.parse(xhr.responseText);
  //         var output_video = '<video width="100%" height="100%" controls preload="auto"><source src="'+data.file_link+'" type="video/mp4"></video>';
  //         $('.video-preview').html(output_video);
  //       }
  //     }
  //   }); 
  // }
  
  
  function readFile(input, id) {    
              
      var file_name = input.files[0].name;
      var extension = (input.files[0].name).split('.').pop();
      var allowed_extensions = ["mp4"];
      var fsize = input.files[0].size;
      
      if (input.files && input.files[0]) {
  
          if ($.inArray(extension, allowed_extensions) == -1) {
              toastr.error("Video format mismatch");
              return false;
          } else if(fsize > 1048576*300) {
              toastr.error("Video size exceeds");
              return false;
          } 
          $('.input-group-file input').attr('value', file_name);
          
      }
  }
  $(document).ready(function()
  { 
      $('#course_video').on('change', function () { 
          imageId = $(this).data('id'); 
          tempFilename = $(this).val();
          readFile(this, $(this).attr('id')); 
      });
  });

    $('body').on('click','.upload-promo-video',function(e){
      e.preventDefault();
      var elem = $('#promo_video_link');
      var embed_url = elem.val();
      if (embed_url.startsWith('https://www.youtube.com/watch?v=') || embed_url.startsWith('https://www.youtube.com/embed/')) {
          var input_link = embed_url.replace('watch?v=', 'embed/');
          var url = elem.attr('data-url');
          $.ajax({
            url: url,
            data:{link:input_link, course_id:$('[name="course_id"]').val()},
            method:'POST',
            success: function(result)
            {
            alert('updated')
            },
            error: function (response) {
            alert('error')
            }
        });
      } else {
        alert('Please enter valid youtube video link!')
      }
    });
  </script>
@endsection