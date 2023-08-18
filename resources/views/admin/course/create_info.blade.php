@extends('layouts.default')
@section('title')
Courses Listing
@endsection
@section('body')
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

                                    <form method="POST" action="{{ route('instructor.course.info.save') }}" id="courseForm">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <div class="row">
                                        
                                          <div class="form-group col-md-4">
                                              <label class="form-control-label">Course Title <span class="required">*</span></label>
                                              <input type="text" class="form-control" name="course_title" 
                                                  placeholder="Course Title" value="{{ $course->course_title }}" />
                                                  @if ($errors->has('course_title'))
                                                      <label class="error" for="course_title">{{ $errors->first('course_title') }}</label>
                                                  @endif
                                          </div>
                                  
                                          <div class="form-group col-md-4">
                                              <label class="form-control-label">Category <span class="required">*</span></label>
                                              <select class="form-control" name="category_id">
                                                  <option value="">Select</option>
                                                  @foreach($categories as $category)
                                                      <option value="{{ $category->id }}"
                                                      @if($category->id == $course->category_id){{ 'selected' }}@endif>
                                                          {{ $category->name }}
                                                      </option>
                                                  @endforeach
                                              </select>
                                              
                                              @if ($errors->has('category_id'))
                                                  <label class="error" for="category_id">{{ $errors->first('category_id') }}</label>
                                              @endif
                                          </div>
                                  
                                          <div class="form-group col-md-4">
                                              <label class="form-control-label">Instruction Level <span class="required">*</span></label>
                                              <select class="form-control" name="instruction_level_id">
                                                  <option value="">Select</option>
                                                  @foreach($instruction_levels as $instruction_level)
                                                      <option value="{{ $instruction_level->id }}" 
                                                      @if($instruction_level->id == $course->instruction_level_id){{ 'selected' }}@endif>
                                                          {{ $instruction_level->level }}
                                                      </option>
                                                  @endforeach
                                              </select>
                                              
                                              @if ($errors->has('instruction_level_id'))
                                                  <label class="error" for="instruction_level_id">{{ $errors->first('instruction_level_id') }}</label>
                                              @endif
                                          </div>
                                  
                                          <div class="form-group col-md-4">
                                              <label class="form-control-label">Duration</label>
                                              <input type="text" class="form-control" name="duration" 
                                                  placeholder="Course Duration" value="{{ $course->duration }}" />
                                          </div>
                                  
                                          <div class="form-group col-md-8">
                                              <label class="form-control-label">Keywords</label>
                                              <input type="text" class="form-control" name="keywords" 
                                                  placeholder="Keywords" value="{{ $course->keywords }}" />
                                          </div>
                                  
                                          <div class="form-group col-md-4">
                                              <label class="form-control-label">Price <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="Leave blank if the course is free"></i></label>
                                              <input type="number" class="form-control" name="price" 
                                                  placeholder="Course Price" value="{{ $course->price }}" />
                                          </div>
                                  
                                          <div class="form-group col-md-4">
                                              <label class="form-control-label">Strike Out Price <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="Applied only for paid courses"></i></label>
                                              <input type="text" class="form-control" name="strike_out_price" 
                                                  placeholder="Strike Out Price" value="{{ $course->strike_out_price }}" />
                                          </div>
                                  
                                          <div class="form-group col-md-2">
                                              <label class="form-control-label">Status</label>
                                              <div>
                                                <div class="radio-custom radio-default radio-inline">
                                                  <input type="radio" id="inputBasicActive" name="is_active" value="1" @if($course->is_active) checked @endif />
                                                  <label for="inputBasicActive">Active</label>
                                                </div>
                                                <div class="radio-custom radio-default radio-inline">
                                                  <input type="radio" id="inputBasicInactive" name="is_active" value="0" @if(!$course->is_active) checked @endif/>
                                                  <label for="inputBasicInactive">Inactive</label>
                                                </div>
                                              </div>
                                          </div>
                                  
                                          <div class="form-group col-md-2">
                                              <label class="form-control-label">Accessibility</label>
                                              <div>
                                                <div class="radio-custom radio-default radio-inline">
                                                  <input type="radio" id="inputBasicLocked" name="is_locked" value="1" @if($course->is_locked) checked @endif />
                                                  <label for="inputBasicLocked">Paid</label>
                                                </div>
                                                <div class="radio-custom radio-default radio-inline">
                                                  <input type="radio" id="inputBasicUnLocked" name="is_locked" value="0" @if(!$course->is_locked) checked @endif/>
                                                  <label for="inputBasicUnLocked">Free</label>
                                                </div>
                                              </div>
                                          </div>

                                          <!-- <div class="form-group col-md-4">
                                              <label class="form-control-label">Available For Free</label>
                                              <div>
                                                <div class="radio-custom radio-default radio-inline">
                                                  <input type="radio" id="inputBasicActive" name="is_on_free" value="1" @if($course->is_on_free) checked @endif />
                                                  <label for="inputBasicActive">Yes</label>
                                                </div>
                                                <div class="radio-custom radio-default radio-inline">
                                                  <input type="radio" id="inputBasicInactive" name="is_on_free" value="0" @if(!$course->is_on_free) checked @endif/>
                                                  <label for="inputBasicInactive">No</label>
                                                </div>
                                              </div>
                                          </div> -->
                                  
                                  
                                  
                                  
                                  
                                          <div class="form-group col-md-12">
                                              <label class="form-control-label">Overview</label>
                                              <textarea name="overview" class="curricullamEditor">
                                                  {{ $course->overview }}
                                              </textarea>
                                          </div>
                                  
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                          <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-default btn-outline">Reset</button>
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




@endsection

@section('local-script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://unpkg.com/@yaireo/tagify"></script>
<script src="https://unpkg.com/@yaireo/tagify@3.1.0/dist/tagify.polyfills.min.js"></script>
<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js') }}"></script>
<script >

    $(document).ready(function()
    { 
        // tinymce.init({ 
        //     selector:'textarea',
        //     menubar:false,
        //     statusbar: false,
        //     content_style: "#tinymce p{color:#76838f;}"
        // });
        tinymce.init({  
        mode : "specific_textareas",
        selector : "textarea",
        theme : "advanced",
        theme_advanced_buttons1 : "bold,italic,underline",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        width : "100%",
        plugins : "paste",
        paste_text_sticky : true,
        setup : function(ed) {
          ed.onInit.add(function(ed) {
            ed.pasteAsPlainText = true;
          });
        }
      });

      var tagInput = document.querySelector('input[name=keywords]')
        new Tagify(tagInput);

        $("#courseForm").validate({
            rules: {
                course_title: {
                    required: true
                },
                category_id: {
                    required: true
                },
                instruction_level_id: {
                    required: true
                }
            },
            messages: {
                course_title: {
                    required: 'The course title field is required.'
                },
                category_id: {
                    required: 'The category field is required.'
                },
                instruction_level_id: {
                    required: 'The instruction level field is required.'
                }
            }
        });

        $('.course-id-empty').click(function()
        {
            toastr.error("Fill course info to proceed");
        });
    });
</script>
@endsection