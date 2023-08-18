@extends('layouts.default')
@section('title')
Courses Listing
@endsection
@section('body')
<link rel="stylesheet" href="{{ asset('backend/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min599c.css?v4.0.2') }}">

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

                                    <form method="POST" action="{{ route('instructor.course.image.save') }}" id="courseForm" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <input type="hidden" name="old_course_image" value="{{ $course->course_image }}">
                                        <input type="hidden" name="old_thumb_image" value="{{ $course->thumb_image }}">
                                        <div class="row">
                                           
                                            {{-- {{dd(Crypt::encryptString(json_encode(array('model'=>'courses', 'field'=>'course_image', 'pid' => 'id', 'id' => $course->id, 'photo'=>$course->course_image))))}} --}}
                                          <div class="form-group col-md-6">
                                              <!-- <label class="form-control-label">Course Image</label> -->
                                             
                                               
                                              <label class="cabinet center-block">
                                                  <figure class="course-image-container">
                                                      {{-- <img src="{{ url('storage/'.$course->course_image) }}" /> --}}
                                                      <i data-toggle="tooltip" data-original-title="Delete" data-id="course_image" class="fa fa-trash remove-lp" data-content="{{  Crypt::encryptString(json_encode(array('model'=>'courses', 'field'=>'course_image', 'pid' => 'id', 'id' => $course->id, 'photo'=>$course->course_image))) }}" style="display: @if(!is_null($course->course_image) && Storage::exists($course->course_image)){{ 'block' }} @else {{ 'none' }} @endif"></i>
                                                      
                                                      
                                                        {{-- {{dd($course->course_image)}} --}}
                                                      <img src="@if(!is_null($course->course_image))
                                                      
                                                      {{ url($course->course_image) }}
                                                      
                                                      @else
                                                      {{ asset('backend/assets/images/course_detail.jpg') }}
                                                       
                                                       @endif" class="gambar img-responsive" id="course_image-output" name="course_image-output" />
                                                  </figure>
                                              </label>
                                          </div>
                                  
                                          <div class="form-group col-md-6 pt-4">
                                              <span style="font-size: 10px;">
                                                  Supported File Formats: jpg,jpeg,png 
                                                  <br>Dimesnion: 825px X 550px
                                                  <br> Max File Size: 1MB
                                              </span>
                                              <hr class="my-4">
                                              <div class="row">
                                                  <div class="col-md-12">
                                                    <fieldset class="form-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="course_image" id="course_image">
                                                            <label class="custom-file-label" for="course_image">Choose new file</label>
                                                              <input type="hidden" name="course_image_base64" id="course_image_base64">
                                                        </div>
                                                    </fieldset>
                                                  </div>
                                  
                                                  <div class="col-md-6">
                                                      <button type="submit" class="btn btn-primary">Submit</button>
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







<style type="text/css">

    label.cabinet{
    display: block;
    cursor: pointer;
}

/*label.cabinet input.file{
    position: relative;
    height: 100%;
    width: auto;
    opacity: 0;
    -moz-opacity: 0;
  filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
  margin-top:-30px;
}*/
.cabinet.center-block{
    margin-bottom: -1rem;
}

#upload-demo{
    width: 558px;
    height: 372px;
  padding-bottom:25px;
}
figure figcaption {
    position: absolute;
    bottom: 0;
    color: #fff;
    width: 100%;
    padding-left: 9px;
    padding-bottom: 5px;
    text-shadow: 0 0 10px #000;
}
.course-image-container{
    width: 435px;
    height: 290px;
    border: 1px solid #e4eaec;;
    position: relative;
}
.course-image-container img{
    width: 399px;
    height: 266px;
    position: absolute;  
    top: 0;  
    bottom: 0;  
    left: 0;  
    right: 0;  
    margin: auto;
}
.remove-lp{
    font-size: 16px;
    color: red;
    float: right;
    padding-right: 2px;
}
</style>




<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Photo</h4>
            </div>
            <div class="modal-body">
                <div id="upload-demo" class="center-block"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
            </div>
        </div>
    </div>
</div>



{{-- @section('javascript') --}}







@endsection

@section('local-script')

<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
<script src="{{ asset('theme/app-assets/vendors/js/forms/tags/form-field.js') }}"></script>
<script src="{{ asset('theme/app-assets/js/scripts/forms/custom-file-input.min.js') }}"></script>


<script type="text/javascript">

    $(document).ready(function()
    { 
        // alert("{{ url('storage/'.$course->course_image) }}")  ;
        //image crop start
        $(".gambar").attr("src", @if(!is_null($course->course_image) )"{{ url($course->course_image) }}" @else "{{ asset('backend/assets/images/course_detail.jpg') }}" @endif);

        var $uploadCrop,
        tempFilename,
        rawImg,
        imageId;

        function readFile(input, id) {    
            
            var file_name = input.files[0].name;
            var extension = (input.files[0].name).split('.').pop();
            var allowed_extensions = ["jpg", "jpeg", "png"];
            var fsize = input.files[0].size;
          
            toastr.options.closeButton = true;
            toastr.options.timeOut = 5000;

            if (input.files && input.files[0]) {

                if ($.inArray(extension, allowed_extensions) == -1) {
                    toastr.error("Image format mismatch");
                    return false;
                } else if(fsize > 1048576*10) {
                    toastr.error("Image size exceeds");
                    return false;
                } 
                $('.input-group-file input').attr('value', file_name);
                var reader = new FileReader();
                // reader.onload = function (e) {
                    $('.upload-demo').addClass('ready');

                    $('#cropImageBtn').attr('data-id', id);

                    // $('#cropImagePop').modal('show');
                    // rawImg = e.target.result;
                // }
              
                reader.readAsDataURL(input.files[0]);
                // debugger;
            }
        }

        $uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: 558,
                height: 372,
            },
            enforceBoundary: true,
            enableExif: true
        });

        $('#cropImagePop').on('shown.bs.modal', function(){
            // alert('Shown pop');
            $uploadCrop.croppie('bind', {
                url: rawImg
            }).then(function(){
                console.log('jQuery bind complete');
            });
        });
   
        $('.item-img').on('change', function () { imageId = $(this).data('id'); tempFilename = $(this).val();
      
         readFile(this, $(this).attr('id')); });
        $('#cropImageBtn').on('click', function (ev) {
            var data_id = $(this).attr('data-id');
            $uploadCrop.croppie('result', {
                type: 'base64',
                format: 'jpeg',
                size: {width: 825, height: 550}
            }).then(function (resp) {
                $("#"+data_id+"_base64").val(resp);
                $("#"+data_id+"-output").attr("src", resp);
                $("#cropImagePop").modal("hide");
            });
        });
        //image crop end

        $(".tagsinput").tagsinput();

       
        $('.remove-lp').click(function(event)
        {
            event.preventDefault();
            var this_id = $(this);
            var current_id = $(this).attr('data-id');

            alertify.confirm('Are you sure want to delete this image?', function () {
                var url = "{{ url('delete-photo') }}";
                var data_content = this_id.attr('data-content');
                 $.ajax({
                    type: "POST",
                    url: url,
                    data: {data_content: data_content, _token: "{{ csrf_token() }}"},
                    success: function (data) {
                        $("#"+current_id+"-output").attr("src", "{{ asset('backend/assets/images/course_detail.jpg') }}");
                        this_id.hide();
                    }
                });
            }, function () {    
                return false;
            });

            
        });
    });
</script>


@endsection