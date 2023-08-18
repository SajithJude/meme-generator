@extends('layouts.default')

@section('title') Courses Listing @endsection

@php
    use App\Library\ulearnHelpers;
    $course_id = $course->id;
@endphp

@section('body')
    <link href="{{ asset('backend/curriculum/css/createcourse/style.css') }}" rel="stylesheet">
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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
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
                                      
                                        <form method="POST" action="{{ 'course/updatecourse' }}" accept-charset="UTF-8" class="form-horizontal saveLabel" parsley-validate="" novalidate=" " enctype="multipart/form-data">
                                            <input name="course_id" type="hidden" value="{{ $course->id }}">
                                            <input name="coursesection" type="hidden" value="{{ url('admin/courses/section/save') }}">
                                            <input name="courselecture" type="hidden" value="{{ url('admin/courses/lecture/save') }}">
                                            <input name="coursequiz" type="hidden" value="{{ url('admin/courses/quiz/save') }}">
                                            <input name="coursecurriculumsort" type="hidden" value="{{ url('admin/courses/curriculum/sort') }}">
                                            <input name="coursecurriculumquizquestionsort" type="hidden" value="{{ url('admin/courses/curriculum/sortquiz') }}">
                                            <input name="coursesectiondel" type="hidden" value="{{ url('admin/courses/section/delete') }}">
                                            <input name="courselecturequizdel" type="hidden" value="{{ url('admin/courses/lecturequiz/delete') }}">
                                            <input name="courselecturedesc" type="hidden" value="{{ url('admin/courses/lecturedesc/save') }}">
                                            <input name="courselecturepublish" type="hidden" value="{{ url('admin/courses/lecturepublish/save') }}">
                                            <input name="courselecturevideo" type="hidden" value="{{ url('admin/courses/lecturevideo/save') }}">
                                            <input name="courselecturevideourl" type="hidden" value="{{ url('admin/courses/lecturevideourl/save') }}">
                                            <input name="courselecturetext" type="hidden" value="{{ url('admin/courses/lecturetext/save') }}">
                                            <input name="courselectureres" type="hidden" value="{{ url('admin/courses/lectureres/delete') }}">
                                            <input name="courseselectlibrary" type="hidden" value="{{ url('admin/courses/lecturelib/save') }}">
                                            <input name="courseselectlibraryres" type="hidden" value="{{ url('admin/courses/lecturelibres/save') }}">
                                            <input name="courseexternalres" type="hidden" value="{{ url('admin/courses/lectureexres/save') }}">
                                        
                                            <div class="su_course_curriculam">
                                                <div class="su_course_curriculam_sortable">
                                                    <ul class="clearfix ui-sortable">
                                                        @php
                                                            $sectioncount = '1';
                                                            $lecturecount = '1';
                                                            $quizcount = '1';
                                                        @endphp
                                                        @foreach($sections as $section)
                                                            <li class="su_gray_curr parentli section-{!! $section->section_id !!}">
                                                                <div class="row-fluid sorthandle">
                                                                    <div class="col col-lg-12">
                                                                        <div class="su_course_section_label su_gray_curr_block" style="text-transform: none;">
                                                                            <div class="edit_option edit_option_section">Chapter Section <span class="serialno">{!! $sectioncount !!}</span>: <label class="slqtitle">{!! $section->title !!}</label>
                                                                                <input type="text" maxlength="80"  style="text-transform: none;" class="chcountfield su_course_update_section_textbox" @if($section->title == 'Start Here') placeholder="Start Here" value="" @else value="{!! $section->title !!}" @endif>
                                                                                <span class="ch-count">@if($section->title == 'Start Here') 80 @else{!! 80-strlen($section->title) !!}@endif</span>
                                                                            </div>
                                                                            <input type="hidden" value="{!! $section->section_id !!}" class="sectionid" name="sectionids[]">
                                                                            <input type="hidden" value="{!! $section->sort_order !!}" class="sectionpos" name="sectionposition[]">
                                                                            <div class="deletesection" onclick="deletesection({!! $section->section_id !!})"></div>
                                                                            <div class="updatesection" onclick="updatesection({!! $section->section_id !!})"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                          
                                                            @if(isset($lecturesquiz[$section->section_id]))
                                                                @foreach($lecturesquiz[$section->section_id] as $lecturequiz)
                                                                    @php
                                                                        $video_title = isset($lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]) ? $lecturesmedia[$section->section_id][$lecturequiz->lecture_quiz_id][0]->video_title : '';
                                                                    @endphp
                                                                    @if($lecturequiz->type == 0)
                                                                        <li class="lq_sort su_lgray_curr childli lecture-{!! $lecturequiz->lecture_quiz_id !!} lecture parent-s-{!! $section->section_id !!}">
                                                                            <div class="row-fluid sorthandle">
                                                                                <div class="col col-lg-12">
                                                                                    <div style="text-transform: none" class="su_course_lecture_label @if(!is_null($lecturequiz->media_type) && $lecturequiz->publish == 0) su_orange_curr_block @elseif(!is_null($lecturequiz->media_type) && $lecturequiz->publish == 1) su_green_curr_block @else su_lgray_curr_block @endif">
                                                                                        <div class="edit_option edit_option_lecture">Lesson<span class="serialno">{!! $lecturecount !!}</span>: <label class="slqtitle">{!! $lecturequiz->title !!}</label>
                                                                                            <input type="text" class="su_course_update_lecture_textbox chcountfield" style="text-transform:none" value="{!! $lecturequiz->title !!}" maxlength="80">
                                                                                            <span class="ch-count">{!! 80-strlen($lecturequiz->title) !!}</span>
                                                                                        </div>
                                                                                        <input type="hidden" value="{!! $lecturequiz->lecture_quiz_id !!}" class="lectureid" name="lectureids[]">
                                                                                        <input type="hidden" value="{!! $lecturequiz->sort_order !!}" class="lecturepos" name="lectureposition[]">
                                                                                        <input type="hidden" value="{!! $section->section_id !!}" class="lecturesectionid" name="lecturesectionid">
                                                                                        <div class="deletelecture" onclick="deletelecture({!! $lecturequiz->lecture_quiz_id !!},{!! $section->section_id !!})"></div>
                                                                                        <div class="updatelecture" onclick="updatelecture({!! $lecturequiz->lecture_quiz_id !!},{!! $section->section_id !!})"></div>
                                                                                        <div class="lecture_add_content" id="lecture_add_content{!! $lecturequiz->lecture_quiz_id !!}">
                                                                                            @if(empty(trim(strip_tags($lecturequiz->description))))
                                                                                                <input type="button" name="lecture_add_content" class="adddescription" value="Add Lesson Description" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                                                                            @else
                                                                                                <input type="button" name="lecture_add_content" class="adddescription" value="Edit Lesson Description" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                                                                            @endif
                                                                                            @if(empty($lecturequiz->media) && is_null($lecturequiz->media_type))
                                                                                                <input type="button" name="lecture_add_content" value="Add Video URL" class="addvideocontents" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                                                                            @else
                                                                                                <input type="button" name="lecture_add_content" value="Edit Video URL" class="addvideocontents" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                                                                            @endif
                                                                                            <div class="closeheader">
                                                                                                <span class="closetext"></span>
                                                                                                <input type="button" name="lecture_close_content" value="X" class="btn-danger closecontents closebtn" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <!-- add contents block start -->
                                                                            <div class="lecturecontent" id="wholeblock-{!! $lecturequiz->lecture_quiz_id !!}" style="display:none;">
                                                                                <div class="su_course_add_section_content su_course_add_content_form" style="display:block;padding:0;">
                                                                                    <div class="formrow">
                                                                                        <div class="row-fluid">
                                                                                            <div class="col col-lg-3">
                                                                                                <label>Video URL: <span class="text-danger">*</span></label>
                                                                                            </div>
                                                                                            <div class="col col-lg-9">
                                                                                                <input type="url" value="{{ isset($course_video[$lecturequiz->media]) ? $course_video[$lecturequiz->media]->video_title : '' }}" class="form-control mr-2" name="course_lesson_vimeo_url-{!! $lecturequiz->lecture_quiz_id !!}" id="course_lesson_vimeo_url-{!! $lecturequiz->lecture_quiz_id !!}" placeholder="Enter Video Link"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="formrow">
                                                                                        <div class="row-fluid">
                                                                                            <div class="col col-lg-9">
                                                                                                <input type="button" name="su_course_add_video_section_submit" value="Add" data-lid="{!! $lecturequiz->lecture_quiz_id !!}" class="btn btn-warning su_course_add_video_section_submit">
                                                                                                <input type="button" id="btn_section" name="su_course_add_video_section_cancel" value="Cancel" class="btn btn-warning su_course_add_video_section_cancel">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Add contents block end -->
                                                                            
                                                                            <!-- add description start -->
                                                                            <div style="display:none;" class="su_course_add_lecture_desc_content su_course_add_content_desc_form @if(empty(trim(strip_tags($lecturequiz->description)))) hideit editing @endif" id="adddescblock-{!! $lecturequiz->lecture_quiz_id !!}">
                                                                                {{-- Label --}}
                                                                                <div class="divtitlehead">
                                                                                    <p><strong>Lesson Description</strong></p>
                                                                                </div>
                                                                                {{-- Previous Description --}}
                                                                                <div class="formrow @if(empty(trim(strip_tags($lecturequiz->description)))) hideit @endif" id="descblock{!! $lecturequiz->lecture_quiz_id !!}">
                                                                                    <div class="row-fluid">
                                                                                        <div class="editdescription" id="descriptions{!! $lecturequiz->lecture_quiz_id !!}" data-lid="{!! $lecturequiz->lecture_quiz_id !!}">{!! strlen(trim(strip_tags($lecturequiz->description))) ? validateAndFixHTML($lecturequiz->description) : 'Click to add description' !!}</div>
                                                                                    </div>
                                                                                </div>
                                                                                {{-- Editor --}}
                                                                                <div class="formrow @if(!empty(trim(strip_tags($lecturequiz->description)))) hideit @endif" id="editblock{!! $lecturequiz->lecture_quiz_id !!}">
                                                                                    <div class="row-fluid">
                                                                                        <div class="col col-lg-12">
                                                                                            <textarea name="lecturedescription" id="lecturedesc-{!! $lecturequiz->lecture_quiz_id !!}" class="form-control curricullamEditor"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                {{-- Buttons --}}
                                                                                <div class="formrow @if(!empty(trim(strip_tags($lecturequiz->description)))) hideit @endif" id="editblockfooter{!! $lecturequiz->lecture_quiz_id !!}">
                                                                                    <div class="row-fluid">
                                                                                        <div class="col col-lg-12"> 
                                                                                            <input type="button" name="su_course_add_lecture_desc_submit" value="Save" class="btn btn-warning su_course_add_lecture_desc_submit"  data-lid="{!! $lecturequiz->lecture_quiz_id !!}">
                                                                                            <input type="button" id="btn_description" name="su_course_add_lecture_desc_cancel" value="Cancel" class="btn btn-warning su_course_add_lecture_desc_cancel" data-blockid="{!! $lecturequiz->lecture_quiz_id !!}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- add description end -->
                                                                        </li>
                                                                        @php $lecturecount++; @endphp
                                                                        @php $quizcount++; @endphp
                                                                    @endif
                                                                @endforeach
                                                                <!-- Add Lecture Here -->
                                                                <div class="add_section_lecture" id="{!!$section->section_id!!}">
                                                                    <ul class="clearfix">
                                                                        <li class="su_blue_curr">
                                                                            <div class="col col-lg-12">
                                                                                <div class="row-fluid add_quiz_lecture_part">
                                                                                    <div class="col col-lg-6">
                                                                                        <div class="su_course_add_lecture_label su_blue_curr_block">
                                                                                            <span> Add Lecture</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="su_course_add_lecture_content su_course_add_content_form">
                                                                                    <div class="formrow">
                                                                                        <div class="row-fluid">
                                                                                            <div class="col col-lg-3">
                                                                                                <label>New Lecture: <span class="text-danger">*</span></label>
                                                                                            </div>
                                                                                            <div class="col col-lg-9">
                                                                                                <input type="text" id="new_lecture" name="su_course_add_lecture_textbox" value="" placeholder="Lecture Title" class="form-element su_course_add_lecture_textbox chcountfield" maxlength="80">
                                                                                                <span id="lecture_title_counter" class="ch-count">80</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="formrow">
                                                                                        <div class="row-fluid">
                                                                                            <div class="col col-lg-9">
                                                                                                <input type="button" name="su_course_add_lecture_submit" value="Add Lecture" class="btn btn-warning su_course_add_lecture_submit">
                                                                                                <input type="button" id="btn_lecture" name="su_course_add_lecture_cancel" value="Cancel" class="btn btn-warning su_course_add_lecture_cancel">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="su_course_add_quiz_content su_course_add_content_form su_course_add_quiz_form">
                                                                                    <div class="formrow">
                                                                                        <div class="row-fluid">
                                                                                            <div class="col col-lg-3">
                                                                                                <label>{!! Lang::get('curriculum.New_Quiz')!!}: <span class="text-danger">*</span></label>
                                                                                            </div>
                                                                                            <div class="col col-lg-9">
                                                                                                <input type="text" id="new_quiz" name="su_course_add_quiz_textbox" value="" placeholder="{!! Lang::get('curriculum.quiz_title')!!}" class="form-element su_course_add_quiz_textbox chcountfield" maxlength="80">
                                                                                                <span id="quiz_title_counter" class="ch-count">80</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="formrow">
                                                                                        <div class="row-fluid">
                                                                                            <div class="col col-lg-3">
                                                                                                <label> {!! Lang::get('curriculum.Description')!!}: <span class="text-danger">*</span></label>
                                                                                            </div>
                                                                                            <div class="col col-lg-9">
                                                                                                <div><textarea name="quizdescription" id="quizdesc" class="form-control curricullamEditor su_course_add_quiz_desc"></textarea></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="clearfix"></div>
                                                                                    <div class="formrow">
                                                                                        <div class="row-fluid">
                                                                                            <div class="col col-lg-9">
                                                                                                <input type="button" name="su_course_add_quiz_submit" value=" {!! Lang::get('curriculum.Add_Quiz')!!}" class="btn btn-warning su_course_add_quiz_submit">
                                                                                                <input type="button" id="btn_quiz" name="su_course_add_quiz_cancel" value=" {!! Lang::get('curriculum.cancel')!!}" class="btn btn-warning su_course_add_quiz_cancel">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- end Add Lecture Here -->
                                                            @endif
                                                            @php $sectioncount++; @endphp
                                                        @endforeach
                                                    </ul>
                                                </div>
                                
                                                <div class="su_course_curriculam_default">
                                                    <ul class="clearfix">
                                                        <li class="su_gray_curr">
                                                            <div class="row-fluid">
                                                                <div class="col col-lg-12">
                                                                    <div class="su_course_add_section_label su_gray_curr_block">
                                                                        <span> Add Section</span>
                                                                    </div>
                                                                    <div class="su_course_add_section_content su_course_add_content_form">
                                                                        <div class="formrow">
                                                                            <div class="row-fluid">
                                                                                <div class="col col-lg-3">
                                                                                    <label>New Section: <span class="text-danger">*</span></label>
                                                                                </div>
                                                                                <div class="col col-lg-9">
                                                                                    <input type="text" id="new_section" name="su_course_add_section_textbox" value="" placeholder="Section Title" class="form-element su_course_add_section_textbox chcountfield" maxlength="80">
                                                                                    <span id="section_title_counter" class="ch-count">80</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="formrow">
                                                                          <div class="row-fluid">
                                                                              <div class="col col-lg-9">
                                                                                  <input type="button" name="su_course_add_section_submit" value="Add Section" class="btn btn-warning su_course_add_section_submit">
                                                                                  <input type="button" id="btn_section" name="su_course_add_section_cancel" value="Cancel" class="btn btn-warning su_course_add_section_cancel">
                                                                              </div>
                                                                          </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
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

{{-- @section('javascript') --}}
@section('local-script')

<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>

<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/fileupload/jquery.ui.widget.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/fileupload/jquery.fileupload.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/fileupload/jquery.fileupload-process.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/fileupload/jquery.fileupload-validate.js') }}"></script> --}}
setTimeout(function() {
  loadScript('/backend/curriculum/js/plugins/fileupload/jquery.fileupload-validate.js');
}, 5000);

<script type="text/javascript">

function loadScript(src) {
    var script = document.createElement('script');
    script.src = src;
    document.head.appendChild(script);
}

$('.curriculam-block').bind({
    dragenter: function(e) {
        $(this).addClass('highlighted');
        return false;
    },
    dragover: function(e) {
        e.stopPropagation();
        e.preventDefault();
        return false;
    },
    dragleave: function(e) {
        $(this).removeClass('highlighted');
        return false;
    },
    drop: function(e) {
        var dt = e.originalEvent.dataTransfer;
        return false;
    }
});

$(document).bind({
    dragenter: function(e) {
        e.stopPropagation();
        e.preventDefault();
        var dt = e.originalEvent.dataTransfer;
        dt.effectAllowed = dt.dropEffect = 'none';
    },
    dragover: function(e) {
        e.stopPropagation();
        e.preventDefault();
        var dt = e.originalEvent.dataTransfer;
        dt.effectAllowed = dt.dropEffect = 'none';
    }
});

$(document).ready(function(){
    $("#btn_lecture").click(function () {
        $('#new_lecture').val('');
    });
    $("#btn_quiz").click(function () {
        $('#new_quiz').val('');   
        tinyMCE.activeEditor.setContent("");
    });
    $("#btn_section").click(function () {
        $('#new_section').val('');
    });
    $("#btn_lecture").click(function () {
        $('#new_lecture').val('');
    });
    $(document).on('click','div.cctabs .cctab-link',function(){
        var tab_id = $(this).attr('data-tab');
        var tab_cc = $(this).attr('data-cc');
        if(tab_cc == '1'){
            $("#fromlibrary"+tab_id).removeClass('current');
            $("#fromlibrarytab"+tab_id).removeClass('current');
            $("#externalres"+tab_id).removeClass('current');
            $("#externalrestab"+tab_id).removeClass('current');
            $("#upfile"+tab_id).addClass('current');
            $("#upfiletab"+tab_id).addClass('current');
        } else if(tab_cc == '2'){
            $("#upfile"+tab_id).removeClass('current');
            $("#upfiletab"+tab_id).removeClass('current');
            $("#externalres"+tab_id).removeClass('current');
            $("#externalrestab"+tab_id).removeClass('current');
            $("#fromlibrary"+tab_id).addClass('current');
            $("#fromlibrarytab"+tab_id).addClass('current');
        } else if(tab_cc == '3'){
            $("#upfile"+tab_id).removeClass('current');
            $("#upfiletab"+tab_id).removeClass('current');
            $("#fromlibrary"+tab_id).removeClass('current');
            $("#fromlibrarytab"+tab_id).removeClass('current');
            $("#externalres"+tab_id).addClass('current');
            $("#externalrestab"+tab_id).addClass('current');
        }
        //remove error message
        $('#resresponse'+tab_id+' p').text(" ");
    });
  
    $(document).on('input','.chcountfield', function() {
        var len = $(this).val().length;
        var setval = parseInt('80')-parseInt(len);
        $(this).next('.ch-count').text(setval);
    });
    $(document).on('input','.count600', function() {
        var len = $(this).val().length;
        var setval = parseInt('600')-parseInt(len);
        $(this).next('.ch-count').text(setval);
    });
    
    tinymce.init({
        mode : "specific_textareas",
        editor_selector : "curricullamEditor",
        theme : "advanced",
        theme_advanced_buttons1 : "bold,italic,underline,link",
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
    $('.curriculam_page').addClass('active');

    $( ".quizquestions" ).sortable({
        handle : '.quessort',
        update: function(e, ui) { 
            updatequizsorting($(this).data('lid'));
        }
    });

    $( ".su_course_curriculam_sortable ul" ).sortable({
        handle : '.sorthandle',
        connectWith : '.su_course_curriculam_sortable ul',
        //  update function 
        update: function(e, ui) { 
            // check lecture under section
            if($('.su_course_curriculam_sortable li:first-child').hasClass('childli')) {
                $(this).sortable('cancel');
                $(ui.sender).sortable('cancel');
            }
            // check quiz under section
            if($('.su_course_curriculam_sortable li:first-child').hasClass('quiz')) {
                $(this).sortable('cancel');
                $(ui.sender).sortable('cancel');
            }
            updatesorting();
        },
        start: function(e, ui){
            $(this).find('.curricullamEditor').each(function(){
                tinyMCE.execCommand( 'mceRemoveControl', false, $(this).attr('id') );
                $(this).hide();
            });
        },
        stop: function(e,ui) {
            $(this).find('.curricullamEditor').each(function(){
                $(this).show();
                tinyMCE.execCommand( 'mceAddControl', true, $(this).attr('id') );
            });
        }
    });
    
    /*
     * Adding new section
     */ 
    $('.su_course_add_section_label').click(function(){
        $(this).hide();
        $('.su_course_add_section_content').show();
        $('#section_title_counter').text('80');
    });

    $('.su_course_add_section_cancel').click(function(){
        $(this).parents('.su_course_add_section_content').hide();
        $('.su_course_add_section_label').show();
        $('.su_course_add_section_textbox').removeClass('error');
    });

    // add video url work
    $('.su_course_add_video_section_cancel').click(function(){
        var cid = $(this).parents('.lecturecontent').attr('id');
        $('#'+cid).hide();
    });

    $('.addvideocontents').click(function(){
        var cid = $(this).data('blockid');
        if ($('#wholeblock-'+cid).is(':visible')) { 
            $("#wholeblock-"+cid).hide(); 
        } 
        if ($("#wholeblock-"+cid).is(':visible')) { 
            $("#wholeblock-"+cid).hide();
        } else {
            $("#wholeblock-"+cid).show();
        }
    });
    $(document).on('click','.su_course_add_video_section_submit',function(){
        var lid = $(this).data('lid');
        var courselecturevideourl =$('[name="courselecturevideourl"]').val();
        var _token =$('[name="_token"]').val();
        var id = "course_lesson_vimeo_url-" + lid;
        var videourl = $('#'+id).val()
        if(videourl == '') {
            alert('Please enter valid video url');
            return false;
        }
        $(this).val('Please Wait..');
        $.ajax ({
            type: "POST",
            url: courselecturevideourl,
            data: "course_lesson_vimeo_url="+videourl+"&courseid="+$('[name="course_id"]').val()+"&publish=1&lid="+lid+"&_token="+_token,
            success: function (msg)
            {
                alert("success");
                $('.lecture-'+lid).find('.su_course_lecture_label').removeClass('su_orange_curr_block');
                $('.lecture-'+lid).find('.su_course_lecture_label').addClass('su_green_curr_block');
                $('.su_course_add_video_section_submit').val('Add');
                var cid = 'wholeblock-'+lid;
                $('#'+cid).hide();
            }
        });
    });
    // end video url work
    
  //Add new section for course
  $('.su_course_add_section_submit').click(function(){
    $('.su_course_add_section_submit').prop("disabled", true);
    if($.trim($('.su_course_add_section_textbox').val()).length >= 2) {
      var sno=$('.su_course_curriculam li.parentli').length+1;
      var cno=sno+1;
      var sval=$('.su_course_add_section_textbox').val();
      var courseid=$('[name="course_id"]').val();
      var coursesection=$('[name="coursesection"]').val();
      var _token=$('[name="_token"]').val();
      
      $.ajax ({
        type: "POST",
        url: coursesection,
        data: "&courseid="+courseid+"&section="+sval+"&position="+sno+"&id=0"+"&_token="+_token,
        success: function (msg)
        {
          //$('.su_course_curriculam_sortable ul').append('<li class="su_gray_curr parentli section-'+msg+'"><div class="row-fluid sorthandle"><div class="col col-lg-12"><div class="su_course_section_label su_gray_curr_block"><div class="edit_option edit_option_section">Section <span class="serialno">'+sno+'</span>: <label  class="slqtitle">'+sval+'</label> <input type="text" maxlength="80" class="chcountfield su_course_update_section_textbox" value="'+sval+'" /><span class="ch-count">'+(80-sval.length)+'</span></div> <input type="hidden" value="'+msg+'" class="sectionid" name="sectionids[]"/> <input type="hidden" value="'+sno+'" class="sectionpos" name="sectionposition[]"/><div class="deletesection" onclick="deletesection('+msg+')"></div><div class="updatesection" onclick="updatesection('+msg+')"></div></div></div></div></li>');
          $('.su_course_add_section_textbox').val('')
          $('.su_course_add_section_label').show();
          $('.su_course_add_section_content').hide();
          $('.su_course_add_section_submit').prop("disabled", false);
          location.reload(true);
        }
      });
    } else {
      $('.su_course_add_section_textbox').addClass('error');
      $('.su_course_add_section_submit').prop("disabled", false);
    }
  });
    // end video url work
  //Add new lecture for course
  $('.su_course_add_lecture_submit').click(function(){
    $('.su_course_add_lecture_submit').prop("disabled", true);
    $('.su_course_add_lecture_submit').val("Please wait");
    var lecture_name = $(this).closest('.su_course_add_lecture_content').find('.su_course_add_lecture_textbox').val()
    if(lecture_name.length > 1) {
      var sid = $(this).closest('.add_section_lecture').attr('id');
      var sno=1
      $( '.childli' ).each(function(){
        sno++;
      });
      var lqno=1;
      $( '.lq_sort' ).each(function(){
        lqno++;
      });
      var cno=$('.su_course_curriculam_sortable li.childli').length+2;
      var sval=lecture_name;
      var courseid=$('[name="course_id"]').val();
      var courselecture=$('[name="courselecture"]').val();
      var _token=$('[name="_token"]').val();

      
      $.ajax ({
        type: "POST",
        url: courselecture,
        data: "&courseid="+courseid+"&lecture="+sval+"&position="+lqno+"&sectionid="+sid+"&_token="+_token,
        success: function (msg)
        {
          $('.su_course_add_lecture_submit').prop("disabled", false);
          $('.su_course_add_lecture_submit').val("Add Lecture");
          $('.su_course_curriculam_sortable ul').append('');
          
          
          $( ".su_course_curriculam_sortable ul" ).sortable('refresh');
          //$('.su_course_add_lecture_content .col.col-lg-3 span').text(cno);
          $('.su_course_add_lecture_textbox').val('');
          $('.add_quiz_lecture_part').show();
          $('.su_course_add_lecture_content').hide();
          //filesuploadajax();
          
          tinyMCE.execCommand('mceAddControl', false, 'textdesc-'+msg);
          tinyMCE.execCommand('mceAddControl', false, 'lecturedesc-'+msg);
          location.reload(true);
        }
      });
    } else {
      $('.su_course_add_lecture_textbox').addClass('error');
      $('.su_course_add_lecture_submit').prop("disabled", false);
    }
  });

  $('.su_course_add_quiz_submit').click(function(){
    $('.su_course_add_quiz_submit').prop("disabled", true);
    if($.trim($('.su_course_add_quiz_textbox').val()).length>1) {
      var sid=$('.su_course_curriculam_sortable li.parentli').last().find('.sectionid').val();
      var sno=1;
      $( '.quiz' ).each(function(){
        sno++;
      });
      var lqno=1;
      $( '.lq_sort_quiz' ).each(function(){
        lqno++;
      });
      var stxt=$('.su_course_add_quiz_textbox').val();
      var sval=$('.su_course_add_quiz_textbox').val();
      var desc=$.trim(tinyClean(tinyMCE.get('quizdesc').getContent()));

      var courseid=$('[name="course_id"]').val();
      var coursequiz=$('[name="coursequiz"]').val();
      var _token=$('[name="_token"]').val();
      
      if(desc != ''){
        $.ajax ({
          type: "POST",
          url: coursequiz,
          data: "&courseid="+courseid+"&quiz="+stxt+"&description="+desc+"&position="+lqno+"&sectionid="+sid+"&_token="+_token,
          success: function (msg)
          {
            $('.su_course_curriculam_sortable ul').append('<li class="lq_sort_quiz su_lgray_curr quiz quiz-'+msg+' parent-s-'+sid+'"> <div class="row-fluid sorthandle"> <div class="col col-lg-12"> <div class="su_course_quiz_label su_lgray_curr_block">  <div class="edit_option edit_option_quiz">Quiz <span class="serialno">'+sno+'</span>: <label class="slqtitle">'+stxt+'</label><input type="text" maxlength="80" class="chcountfield su_course_update_quiz_textbox" value="'+stxt+'"><span class="ch-count">'+(80-stxt.length)+'</span> </div> <input type="hidden" value="'+msg+'" class="quizid" name="quizids[]"> <input type="hidden" value="'+lqno+'" class="quizpos" name="quizposition[]"> <input type="hidden" value="'+sid+'" class="quizsectionid" name="quizsectionid"> <div class="deletequiz" onclick="deletequiz('+msg+','+sid+')"></div> <div class="updatequiz" onclick="updatequiz('+msg+','+sid+')"></div> <div class="lecture_add_content" id="lecture_add_quiz'+msg+'"> <input type="button" name="lecture_add_quiz" value="Add Questions" class="addquestions" data-blockid="'+msg+'"> <div class="closeheader"> <span class="closetext"></span> <input type="button" name="lecture_close_question" value="X" class="btn-danger closequestion" data-blockid="'+msg+'"> </div> </div> </div> </div> </div> <div class="su_course_add_lecture_desc_content hideit nondata" id="questionsblock'+msg+'"> <div class="lecture_buttons lecture_edit_content"><input type="button" name="lecture_publish_content_quiz" class="btn btn-warning publishcontentquiz" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+msg+'"></div> <div class="divtitlehead"><p><strong>Questions</strong></p></div> <div class="formrow questionlist"> <div class="row-fluid quizquestions"> </div> </div> </div> <div class="lecturepopup hideit" id="quesblock-'+msg+'"> <div class="quizques"> <div class="quiz-type"> <div class="clearfix"> <div class="divli lquiz-multiple" data-lid="'+msg+'"  alt="multiple"><div class="quiztype"><span>Multiple Choice</span></div><label>Multiple Choice</label><div class="innershadowquiz"></div></div> <div class="divli lquiz-truefalse" data-lid="'+msg+'"  alt="truefalse"><div class="quiztype"><span>True / False</span></div><label>True / False</label><div class="innershadowquiz"></div></div> </div> </div> </div> </div> <div class="lecturepopup hideit" id="contentques-'+msg+'"> <div class="quizques"> <div class="divtitlehead"><p><strong>Question</strong></p></div> <div class="formrow margbot"> <div class="row-fluid"> <div><textarea name="quizquestion" id="quizquestion-'+msg+'" class="form-control curricullamEditor"></textarea></div> </div> </div> <div class="divtitlehead"><p><strong>Answers</strong></p></div> <div class="qmultiple hideit" id="multipleques-'+msg+'"> <div class="divtitlesub"><p>Write up to 5 believable options and choose the best answer.</p></div> <div class="qanswer"> <div class="col col-lg-12"> <input type="radio" name="answers-radio'+msg+'" value="1"> <input type="text" placeholder="Add an answer." class="chcountfield count600 answer" maxlength="600" name="answers[]" data-lid="'+msg+'"> <span class="answers-counter ch-count">600</span> </div> <div class="col col-lg-12"> <input type="text" placeholder="Explain why this is or isn\'t the best answer." class="chcountfield count600 answer-feedback" maxlength="600" name="answersfeedback[]"> <span class="answers-feedback-counter ch-count">600</span> </div> </div> <div class="qanswer"> <div class="col col-lg-12"> <input type="radio" name="answers-radio'+msg+'" value="2"> <input type="text" placeholder="Add an answer." class="chcountfield count600 answer" maxlength="600" name="answers[]" data-lid="'+msg+'"> <span class="answers-counter ch-count">600</span> </div> <div class="col col-lg-12"> <input type="text" placeholder="Explain why this is or isn\'t the best answer." class="chcountfield count600 answer-feedback" maxlength="600" name="answersfeedback[]"> <span class="answers-feedback-counter ch-count">600</span> </div> </div> <div class="qanswer"> <div class="col col-lg-12"> <div class="delques"><i class="fa fa-trash-o"></i></div> <input type="radio" name="answers-radio'+msg+'" value="3"> <input type="text" placeholder="Add an answer." class="chcountfield count600 qlastchild answer" maxlength="600" name="answers[]" data-lid="'+msg+'"> <span class="answers-counter ch-count">600</span> </div> <div class="col col-lg-12"> <input type="text" placeholder="Explain why this is or isn\'t the best answer." class="chcountfield count600 answer-feedback" maxlength="600" name="answersfeedback[]"> <span class="answers-feedback-counter ch-count">600</span> </div> </div> </div> <div class="qtruefalse hideit" id="truefalseques-'+msg+'"> <div class="divtitlesub"><p>Check the correct answer, and click Save.</p></div> <div class="formrow"> <div class="row-fluid"> <div class="col col-lg-2"> <input type="radio" id="radtrue'+msg+'" name="answers-radio'+msg+'" value="1"> True </div> <div class="col col-lg-2"> <input type="radio" id="radfalse'+msg+'" name="answers-radio'+msg+'" value="2"> False </div> </div> </div> </div> <div class="formrow"> <div class="row-fluid"> <input type="button" name="su_course_add_quiz_question_submit" value="Save" class="btn btn-warning su_course_add_quiz_question_submit"  data-lid="'+msg+'"> <input type="hidden" value="0" id="quiztype'+msg+'"> <input type="hidden" value="0" id="coption'+msg+'"> </div> </div> </div> </div> <div class="lecturepopup hideit editquestionpart" id="editquestionpart'+msg+'"></div> <div class="su_course_add_lecture_desc_content quizeditdesc" id="quizeditdesc'+msg+'"> <div class="divtitlehead"><p><strong>Description</strong></p></div> <textarea name="lectureeditdescription" id="lectureeditdesc-'+msg+'" class="form-control curricullamEditor"></textarea> <div class="quizeditdescription" id="quizeditdescription'+msg+'">'+desc+'</div> </div> </li>');
            $( ".su_course_curriculam_sortable ul" ).sortable('refresh');
            $('.su_course_add_quiz_textbox').val('');
            $('.add_quiz_lecture_part').show();
            $('.su_course_add_quiz_content').hide();
            $('.su_course_add_quiz_submit').prop("disabled", false);
            tinyMCE.get('quizdesc').setContent('');
            
            $('input[type="radio"]').iCheck({
              checkboxClass: 'icheckbox_square-green',
              radioClass: 'iradio_square-green',
            }); 
            
            tinyMCE.execCommand('mceAddControl', false, 'quizquestion-'+msg);
            tinyMCE.execCommand('mceAddControl', false, 'lectureeditdesc-'+msg);
            location.reload(true);
          }
        });
      } else {
        alert("{!! Lang::get('Add some description to save.') !!}");
        $('.su_course_add_quiz_submit').prop("disabled", false);
      } 
    } else {
      $('.su_course_add_quiz_textbox').addClass('error');
      $('.su_course_add_quiz_submit').prop("disabled", false);
    }

  });
  
  /*
  * Update course section text
  */
  $(document).on('click','.edit_option_section',function(){
    var id=$(this).next().val();
    $('.section-'+id).addClass('editon');
  });

  /*
  * Update course lecture text
  */
  $(document).on('click','.edit_option_lecture',function(){
    var id=$(this).next().val();
    $('.lecture-'+id).addClass('editon');
  });

  /*
  * Update course quiz text
  */
  $(document).on('click','.edit_option_quiz',function(){
    var id=$(this).next().val();
    if(!$('.quiz-'+id).hasClass('editon')) {
      var getdescr = $('#quizeditdescription'+id).html();
      tinyMCE.get('lectureeditdesc-'+id).setContent(getdescr);
    }
    $('.quiz-'+id).addClass('editon');
    $('#quizeditdesc'+id).show();
  });


  /*
  *   show hide for lecture and Quiz
  */

  //lecture
  
  $('.su_course_add_lecture_label').click(function(){
    $('#lecture_title_counter').text('80');
    if($('.su_course_curriculam_sortable li.parentli').length>0) {
      $(this).closest('.add_quiz_lecture_part').hide();
      $(this).closest('.add_quiz_lecture_part').next('.su_course_add_lecture_content').show();

    } else {
      alert('{!! Lang::get("curriculum.section_message")!!}');
    }
  });

  $('.su_course_add_lecture_cancel').click(function(){
    $(this).parents('.su_course_add_lecture_content').hide();
    $('.add_quiz_lecture_part').show();
    $('.su_course_add_lecture_textbox').removeClass('error');
  });

  //quiz

  $('.su_course_add_quiz_label').click(function(){
    $('#quiz_title_counter').text('80');
    if($('.su_course_curriculam_sortable li.parentli').length>0) {
      $('.add_quiz_lecture_part').hide();
      $('.su_course_add_quiz_content').show();
    } else {
      alert('{!! Lang::get("curriculum.quiz_message")!!}');
    }
  });
  
  $('.su_course_add_quiz_cancel').click(function(){
    $(this).parents('.su_course_add_quiz_content').hide();
    $('.add_quiz_lecture_part').show();
    $('.su_course_add_quiz_textbox').removeClass('error');
  });  

  
  
  $(document).on('click','.resdelete',function () { 
    $(this).text('Deleting...');
    var _token=$('[name="_token"]').val();
    var lid = $(this).data('lid');
    var rid = $(this).data('rid');
    $.ajax ({
      type: "POST",
      url: $('[name="courselectureres"]').val(),
      data: "&courseid="+$('[name="course_id"]').val()+"&lid="+lid+"&rid="+rid+"&_token="+_token,
      success: function (msg)
      {
        $('#resources'+lid+'_'+rid).remove();
        location.reload(true);
      }
    });
  });
  
  $(document).on('click','.addcontents',function () { 
    $(this).parent('div').children('.addcontents').hide();
    $(this).parent('div').children('.adddescription').hide();
    $(this).parent('div').children('.closeheader').children('.closecontents').show();
    $(this).parent('div').children('.closeheader').children('span.closetext').text('Select Content Type');
    $(this).parent('div').children('.closeheader').show();
    var cid = $(this).data('blockid');
    if ($('#wholeblock-'+cid).is(':visible')) { 
      $("#wholeblock-"+cid).hide(); 
    } 
    if ($("#wholeblock-"+cid).is(':visible')) { 
      $("#wholeblock-"+cid).hide();
    } else {
      $("#wholeblock-"+cid).show();
    }
    $('#contentpopshow'+cid).hide();
  });

  $(document).on('click','.closecontents',function () { 
    var cid = $(this).data('blockid');
    check_process = $('#probar_status_'+cid).val(); 
    if(check_process==1){
      alert("Please wait untill the process complete.");
      return false;
    }
    if($('#contentpopshow'+cid).hasClass('hideit')){
      $(this).parent('div').parent('div').children('.addcontents').show();
    }
    if($('#adddescblock-'+cid).hasClass('hideit')){
      $(this).parent('div').parent('div').children('.adddescription').show();
    }
    $(this).parent('div').parent('div').children('.closeheader').children('.closecontents').hide();
    $(this).parent('div').parent('div').children('.closeheader').children('span.closetext').text('');
    $(this).parent('div').parent('div').children('.closeheader').hide();
    $("#adddescblock-"+cid).css('display', 'none');
    $(this).parent('div').parent('div').children('.adddescription').show();
    
    $("#wholeblock-"+cid).hide();
    if($('#contentpopshow'+cid).hasClass("hideit")) {
      $('#contentpopshow'+cid).hide();
      $('#videoresponse'+cid).hide();
      $('#wholevideos'+cid).show();
    } else {
      $('#contentpopshow'+cid).show();
      $('#videoresponse'+cid).show();
      $('#wholevideos'+cid).hide();
    }
    $('#cccontainer'+cid).hide();
  });
  $(document).on('click','.su_course_add_lecture_desc_cancel',function () { 
    tinyMCE.activeEditor.setContent("");
    var cid = $(this).attr('data-blockid');
    if($('#contentpopshow'+cid).hasClass('hideit')){
      $('#lecture_add_content'+cid).children('.addcontents').show();
    } 
    if($('#adddescblock-'+cid).hasClass('hideit')){
      $('#lecture_add_content'+cid).children('.adddescription').show();
    } 
    $('#lecture_add_content'+cid).children('.closeheader').children('.closecontents').hide();
    $('#lecture_add_content'+cid).children('.closeheader').children('span.closetext').text('');
    $('#lecture_add_content'+cid).children('.closeheader').hide();
    
    if($('#adddescblock-'+cid).hasClass("hideit")) {
      $("#adddescblock-"+cid).hide();
      $("#descblock-"+cid).addClass('hideit');
      $("#editblock-"+cid).removeClass('hideit');
      $("#editblockfooter-"+cid).removeClass('hideit');
    } else {
      $("#adddescblock-"+cid).removeClass('editing');
      $('#descblock'+cid).removeClass('hideit');
      $('#editblock'+cid).addClass('hideit');
      $('#editblockfooter'+cid).addClass('hideit');
    }
    
    $("#wholeblock-"+cid).hide();
    if($('#contentpopshow'+cid).hasClass("hideit")) {
      $('#contentpopshow'+cid).hide();
      $('#videoresponse'+cid).hide();
      $('#wholevideos'+cid).show();
    } else {
      $('#contentpopshow'+cid).show();
      $('#videoresponse'+cid).show();
      $('#wholevideos'+cid).hide();
    }
    $('#cccontainer'+cid).hide();
  });

  $(document).on('click','.canceldesctext',function () { 
    tinyMCE.activeEditor.setContent("");
    var cid = $(this).attr('data-lid');
    if($('#contentpopshow'+cid).hasClass('hideit')){
      $('#lecture_add_content'+cid).children('.addcontents').show();
    }
    if($('#adddescblock-'+cid).hasClass('hideit')){
      $('#lecture_add_content'+cid).children('.adddescription').show();
    }
    $('#lecture_add_content'+cid).children('.closeheader').children('.closecontents').hide();
    $('#lecture_add_content'+cid).children('.closeheader').children('span.closetext').text('');
    $('#lecture_add_content'+cid).children('.closeheader').hide();
            
    if($('#adddescblock-'+cid).hasClass("hideit")) {
      $("#adddescblock-"+cid).hide();
      $("#descblock-"+cid).removeClass('hideit');
    } else {
      $("#adddescblock-"+cid).show();
      $("#descblock-"+cid).addClass('hideit');
    }
    
    $("#wholeblock-"+cid).hide();
    if($('#contentpopshow'+cid).hasClass("hideit")) {
      $('#contentpopshow'+cid).hide();
      $('#videoresponse'+cid).hide();
      $('#wholevideos'+cid).show();
    } else {
      $('#contentpopshow'+cid).show();
      $('#videoresponse'+cid).show();
      $('#wholevideos'+cid).hide();
    }
    $('#cccontainer'+cid).hide();
  });
  
  $(document).on('click','.adddescription',function () { 
    $(this).parent('div').children('.addcontents').hide();
    $(this).parent('div').children('.adddescription').hide();
    $(this).parent('div').children('.closeheader').children('.closecontents').show();
    $(this).parent('div').children('.closeheader').children('span.closetext').text('Description');
    $(this).parent('div').children('.closeheader').show();
    var cid = $(this).data('blockid');
    $('#contentpopshow'+cid).hide();
    if ($('#adddescblock-'+cid).is(':visible')) { 
      $("#adddescblock-"+cid).hide(); 
    } 
    if ($("#adddescblock-"+cid).is(':visible')) { 
      $("#adddescblock-"+cid).hide();
    } else {
      $("#adddescblock-"+cid).show(); 

    } 
  });

  $(document).on('click','.su_course_add_lecture_desc_submit',function(){
    var lid = $(this).data('lid');
    // alert(lid);
    var text = $.trim(tinyClean(tinyMCE.get('lecturedesc-'+lid).getContent()));
    var submitButton = $(this);
    if(text != '') {
      var courselecturedesc =$('[name="courselecturedesc"]').val();
      var _token =$('[name="_token"]').val();
      submitButton.val('Please wait...');
      $.ajax ({
        type: "POST",
        url: courselecturedesc,
        data: {
          courseid: $('[name="course_id"]').val(),
          lecturedescription: text,
          lid: lid,
          _token: _token,
        },
        success: function (msg)
        { 
          if($('#contentpopshow'+lid).hasClass("hideit")) {
            $('#contentpopshow'+lid).hide();
            $('#videoresponse'+lid).hide();
            $('#wholevideos'+lid).show();
            $("#lecture_add_content"+lid).find('.addcontents').show();
          } else {
            $('#contentpopshow'+lid).show();
            $('#videoresponse'+lid).show();
            $('#wholevideos'+lid).hide();
          }
          $('#descriptions'+lid).html(text);
          // $('#getdbdescription'+lid).val(text);
          $('#descblock'+lid).removeClass('hideit');
          $("#adddescblock-"+lid).removeClass('editing');
          $("#adddescblock-"+lid).removeClass('hideit');
          $('#editblock'+lid).addClass('hideit');
          $('#editblockfooter'+lid).addClass('hideit');
          $('#lecture_add_content'+lid).find('.closeheader .closecontents').hide();
          $('#lecture_add_content'+lid).find('.closeheader span.closetext').text('');
          $('#lecture_add_content'+lid).find('.closeheader').hide();
          $('.su_course_add_lecture_desc_content').hide();
          submitButton.val('save');

          location.reload(true);
        },
        error: function (error) {
          // Change the button text back to "Save" in case of an error
          submitButton.val('save');
        },
      });
    } else {
      alert('{!! Lang::get("Add some description to save.") !!}');
    }
  });
  $(document).on('click','.publishcontent',function(){
    var lid = $(this).data('blockid');
    var courselecturepublish =$('[name="courselecturepublish"]').val();
    var _token =$('[name="_token"]').val();
    $(this).attr('name','lecture_unpublish_content');
    $(this).val('Unpublish');
    $(this).removeClass('publishcontent');
    $(this).addClass('unpublishcontent');
    $(this).removeClass('btn-warning');
    $(this).addClass('btn-danger');
    $.ajax ({
      type: "POST",
      url: courselecturepublish,
      data: "courseid="+$('[name="course_id"]').val()+"&publish=1&lid="+lid+"&_token="+_token,
      success: function (msg)
      {
        $('.lecture-'+lid).find('.su_course_lecture_label').removeClass('su_orange_curr_block');
        $('.lecture-'+lid).find('.su_course_lecture_label').addClass('su_green_curr_block');
        location.reload(true);
      }
    });
  });

  $(document).on('click','.unpublishcontent',function(){
    var lid = $(this).data('blockid');
    var courselecturepublish =$('[name="courselecturepublish"]').val();
    var _token =$('[name="_token"]').val();
    $(this).attr('name','lecture_publish_content');
    $(this).val('Publish');
    $(this).removeClass('unpublishcontent');
    $(this).addClass('publishcontent');
    $(this).removeClass('btn-danger');
    $(this).addClass('btn-warning');
    $.ajax ({
      type: "POST",
      url: courselecturepublish,
      data: "courseid="+$('[name="course_id"]').val()+"&publish=0&lid="+lid+"&_token="+_token,
      success: function (msg)
      {
        $('.lecture-'+lid).find('.su_course_lecture_label').removeClass('su_green_curr_block');
        $('.lecture-'+lid).find('.su_course_lecture_label').addClass('su_orange_curr_block');
        location.reload(true);
      }
    });
  });

  $(document).on('click','.publishcontentquiz',function(){
    var lid = $(this).data('blockid');
    var courselecturepublish =$('[name="courselecturepublish"]').val();
    var _token =$('[name="_token"]').val();
    $(this).attr('name','lecture_unpublish_content_quiz');
    $(this).val('Unpublish');
    $(this).removeClass('publishcontentquiz');
    $(this).addClass('unpublishcontentquiz');
    $(this).removeClass('btn-warning');
    $(this).addClass('btn-danger');
    $.ajax ({
      type: "POST",
      url: courselecturepublish,
      data: "courseid="+$('[name="course_id"]').val()+"&publish=1&lid="+lid+"&_token="+_token,
      success: function (msg)
      {
        $('.quiz-'+lid).find('.su_course_quiz_label').removeClass('su_lgray_curr_block');
        $('.quiz-'+lid).find('.su_course_quiz_label').addClass('su_green_curr_block');
        location.reload(true);
      }
    });
  });

  $(document).on('click','.unpublishcontentquiz',function(){
    var lid = $(this).data('blockid');
    var courselecturepublish =$('[name="courselecturepublish"]').val();
    var _token =$('[name="_token"]').val();
    $(this).attr('name','lecture_publish_content_quiz');
    $(this).val('Publish');
    $(this).removeClass('unpublishcontentquiz');
    $(this).addClass('publishcontentquiz');
    $(this).removeClass('btn-danger');
    $(this).addClass('btn-warning');
    $.ajax ({
      type: "POST",
      url: courselecturepublish,
      data: "courseid="+$('[name="course_id"]').val()+"&publish=0&lid="+lid+"&_token="+_token,
      success: function (msg)
      {
        $('.quiz-'+lid).find('.su_course_quiz_label').removeClass('su_green_curr_block');
        $('.quiz-'+lid).find('.su_course_quiz_label').addClass('su_lgray_curr_block');
        location.reload(true);
      }
    });
  });

  $(document).on('click','.editdescription',function(){
    var lid = $(this).data('lid');
    var getdescr = $('#descriptions'+lid).html();
    $("#adddescblock-"+lid).addClass('editing');
    $('#descblock'+lid).addClass('hideit');
    $('#editblock'+lid).removeClass('hideit');
    $('#editblockfooter'+lid).removeClass('hideit');
    tinyMCE.get('lecturedesc-'+lid).setContent(getdescr);
  });

  $(document).on('click','.lmedia-video',function(){
    var mid = $(this).data('lid');
    var attr = $(this).attr('alt');
    // alert(attr);
    // alert(mid);
    if(attr=='video'){
      $('#externalrestab'+mid).removeClass('current');
      $('#externalres'+mid).removeClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#fromlibrarytab'+mid).removeClass('current');
      $('#upfile'+mid).addClass('current');
      $('#upfiletab'+mid).addClass('current');
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholeblock-"+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#videosfiles-'+mid).show();
      $('#audiofiles-'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#lecture_add_content'+mid).find('.closeheader span.closetext').text('Add Video');
      $('#cctabs'+mid).show();
      
      $('#cccontainer'+mid).show();
      $('#upfile'+mid).addClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#cvideofiles'+mid).show();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
    }

  });

  $(document).on('click','.lmedia-audio',function(){
    var mid = $(this).data('lid');
    var attr = $(this).attr('alt');
    // alert(attr);
    // alert(mid);
    if(attr=='audio'){
      $('#externalrestab'+mid).removeClass('current');
      $('#externalres'+mid).removeClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#fromlibrarytab'+mid).removeClass('current');
      $('#upfile'+mid).addClass('current');
      $('#upfiletab'+mid).addClass('current');
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholeblock-"+mid).hide();
      $('#audiofiles-'+mid).show();
      $('#videosfiles-'+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#lecture_add_content'+mid).find('.closeheader span.closetext').text('Add Audio');
      $('#cctabs'+mid).show();
      
      $('#cccontainer'+mid).show();
      $('#upfile'+mid).addClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).show();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
    }

  });

  $(document).on('click','.lmedia-presentation',function(){
    var mid = $(this).data('lid');
    var attr = $(this).attr('alt');
    // alert(attr);
    // alert(mid);
    if(attr=='presentation'){
      $('#externalrestab'+mid).removeClass('current');
      $('#externalres'+mid).removeClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#fromlibrarytab'+mid).removeClass('current');
      $('#upfile'+mid).addClass('current');
      $('#upfiletab'+mid).addClass('current');
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholeblock-"+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#prefiles-'+mid).show();
      $('#docfiles-'+mid).hide();
      $('#audiofiles-'+mid).hide();
      $('#videosfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#lecture_add_content'+mid).find('.closeheader span.closetext').text('Add Presentation');
      $('#cctabs'+mid).show();
      
      $('#cccontainer'+mid).show();
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).show();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
    }

  });

  $(document).on('click','.lmedia-file',function(){
    var mid = $(this).data('lid');
    var attr = $(this).attr('alt');
    // alert(attr);
    // alert(mid);
    if(attr=='file'){
      $('#externalrestab'+mid).removeClass('current');
      $('#externalres'+mid).removeClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#fromlibrarytab'+mid).removeClass('current');
      $('#upfile'+mid).addClass('current');
      $('#upfiletab'+mid).addClass('current');
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholeblock-"+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).show();
      $('#audiofiles-'+mid).hide();
      $('#videosfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#lecture_add_content'+mid).find('.closeheader span.closetext').text('Add Document');
      $('#cctabs'+mid).show();
      
      $('#cccontainer'+mid).show();
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).show();
      $('#cresfiles'+mid).hide();
    }

  });

  $(document).on('click','.lmedia-text',function(){
    var mid = $(this).data('lid');
    var attr = $(this).attr('alt');
    // alert(attr);
    // alert(mid);
    if(attr=='text'){
      $('#externalrestab'+mid).removeClass('current');
      $('#externalres'+mid).removeClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#fromlibrarytab'+mid).removeClass('current');
      $('#upfile'+mid).addClass('current');
      $('#upfiletab'+mid).addClass('current');
      $('#contentpopshow'+mid).show();
      $('#textdescfiles-'+mid).show();
      $('#allbar'+mid).hide();
      $("#wholeblock-"+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).hide();
      $('#audiofiles-'+mid).hide();
      $('#videosfiles-'+mid).hide();
      $('#lecture_add_content'+mid).find('.closeheader span.closetext').text('Add Text');
      $('#cctabs'+mid).hide();
      
      $('#cccontainer'+mid).show();
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
    }

  });

  $(document).on('click','.addresource',function(){
    var mid = $(this).data('blockid');
    var attr = $(this).data('alt');
    // alert(attr);
    // alert(mid);
    if(attr=='resource'){
      $('#externalrestab'+mid).show();
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholeblock-"+mid).hide();
      $("#wholevideos"+mid).show();
      $('#resfiles-'+mid).show();
      $('#videoresponse'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).hide();
      $('#audiofiles-'+mid).hide();
      $('#videosfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $("#lecture_add_content"+mid).find('.adddescription').hide();
      $("#lecture_add_content"+mid).find('.closeheader .closecontents').show();
      $("#lecture_add_content"+mid).find('.closeheader span.closetext').text("{!! Lang::get('curriculum.Add_Resource') !!}");
      $("#lecture_add_content"+mid).find('.closeheader').show();
      
      $('#cccontainer'+mid).show();
      $('#upfile'+mid).addClass('current');
      $('#fromlibrary'+mid).removeClass('current');
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).show();
    }

  });
  

  $(document).on('click','.editlectcontent',function(){
    var mid = $(this).data('blockid');
    var attr = $(this).data('alt');
    $('#cccontainer'+mid).show();
    $('#externalrestab'+mid).removeClass('current');
    $('#externalres'+mid).removeClass('current');
    $('#fromlibrary'+mid).removeClass('current');
    $('#fromlibrarytab'+mid).removeClass('current');
    $('#upfiletab'+mid).addClass('current');
    $('#upfile'+mid).addClass('current');
    // alert(attr);
    // alert(mid);
    if(attr=='video'){
      
      $('#externalrestab'+mid).hide();
      $("#wholeblock-"+mid).hide();
      $("#videoresponse"+mid).hide();
      $("#lecture_add_content"+mid).find('.adddescription').hide();
      $("#lecture_add_content"+mid).find('.closecontents').show();
      $("#lecture_add_content"+mid).find('.closeheader .closecontents').show();
      $("#lecture_add_content"+mid).find('.closeheader span.closetext').text('Edit Video');
      $("#lecture_add_content"+mid).find('.closeheader').show();
      
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholevideos"+mid).removeClass('hideit');
      $("#wholevideos"+mid).show();
      $('#videosfiles-'+mid).show();
      $('#audiofiles-'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#cctabs'+mid).show();
      
      $('#cvideofiles'+mid).show();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
      
    } else if(attr=='audio'){
      
      $('#externalrestab'+mid).hide();
      $("#wholeblock-"+mid).hide();
      $("#videoresponse"+mid).hide();
      $("#lecture_add_content"+mid).find('.adddescription').hide();
      $("#lecture_add_content"+mid).find('.closeheader .closecontents').show();
      $("#lecture_add_content"+mid).find('.closeheader span.closetext').text('Edit Audio');
      $("#lecture_add_content"+mid).find('.closeheader').show();
      
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholevideos"+mid).removeClass('hideit');
      $("#wholevideos"+mid).show();
      $('#audiofiles-'+mid).show();
      $('#videosfiles-'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#cctabs'+mid).show();
      
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).show();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
      
    } else if(attr=='presentation'){
      
      $('#externalrestab'+mid).hide();
      $("#wholeblock-"+mid).hide();
      $("#videoresponse"+mid).hide();
      $("#lecture_add_content"+mid).find('.adddescription').hide();
      $("#lecture_add_content"+mid).find('.closeheader .closecontents').show();
      $("#lecture_add_content"+mid).find('.closeheader span.closetext').text('Edit Document');
      $("#lecture_add_content"+mid).find('.closeheader').show();
      
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholevideos"+mid).removeClass('hideit');
      $("#wholevideos"+mid).show();
      $('#prefiles-'+mid).show();
      $('#docfiles-'+mid).hide();
      $('#audiofiles-'+mid).hide();
      $('#videosfiles-'+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#cctabs'+mid).show();
      
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).show();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
      
    } else if(attr=='file'){
      
      $('#externalrestab'+mid).hide();
      $("#wholeblock-"+mid).hide();
      $("#videoresponse"+mid).hide();
      $("#lecture_add_content"+mid).find('.adddescription').hide();
      $("#lecture_add_content"+mid).find('.closeheader .closecontents').show();
      $("#lecture_add_content"+mid).find('.closeheader span.closetext').text('Edit Document');
      $("#lecture_add_content"+mid).find('.closeheader').show();
      
      $('#contentpopshow'+mid).show();
      $('#allbar'+mid).show();
      $("#wholevideos"+mid).removeClass('hideit');
      $("#wholevideos"+mid).show();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).show();
      $('#audiofiles-'+mid).hide();
      $('#videosfiles-'+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#textdescfiles-'+mid).hide();
      $('#cctabs'+mid).show();
      
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).show();
      $('#cresfiles'+mid).hide();
      
    } else if(attr=='text'){
    
      var getltext = $('#lecture_contenttext'+mid).html();
      tinyMCE.get('textdesc-'+mid).setContent(getltext);
      
      $('#externalrestab'+mid).hide();
      $("#wholeblock-"+mid).hide();
      $("#videoresponse"+mid).hide();
      $("#lecture_add_content"+mid).find('.adddescription').hide();
      $("#lecture_add_content"+mid).find('.closeheader .closecontents').show();
      $("#lecture_add_content"+mid).find('.closeheader span.closetext').text('Edit Text');
      $("#lecture_add_content"+mid).find('.closeheader').show();
      
      $('#contentpopshow'+mid).show();
      $("#wholevideos"+mid).removeClass('hideit');
      $("#wholevideos"+mid).show();
      $('#textdescfiles-'+mid).show();
      $('#allbar'+mid).hide();
      $('#prefiles-'+mid).hide();
      $('#docfiles-'+mid).hide();
      $('#audiofiles-'+mid).hide();
      $('#resfiles-'+mid).hide();
      $('#videosfiles-'+mid).hide();
      $('#cctabs'+mid).hide();
      
      $('#cvideofiles'+mid).hide();
      $('#caudiofiles'+mid).hide();
      $('#cprefiles'+mid).hide();
      $('#cdocfiles'+mid).hide();
      $('#cresfiles'+mid).hide();
    }

  });
  
  $(document).on('click','.updatelibcontent',function(){
    var lid = $(this).attr('data-lid');
    var lib = $(this).attr('data-lib');
    var alt = $(this).attr('data-alt');
    var type = $(this).attr('data-type');
    var courseselectlibrary =$('[name="courseselectlibrary"]').val();
    var _token =$('[name="_token"]').val();
    $.ajax ({
      type: "POST",
      url: courseselectlibrary,
      data: "courseid="+$('[name="course_id"]').val()+"&lid="+lid+"&lib="+lib+"&type="+alt+"&_token="+_token,
      success: function (data)
      { var return_data = $.parseJSON( data );
        if(return_data.status='true'){
          $("#contentpopshow"+lid).removeClass('hideit');
          $("#cccontainer"+lid).hide();
          $("#videoresponse"+lid).text("");
          $("#wholevideos"+lid).hide();
          $('#videoresponse'+lid).show();
          if($('#adddescblock-'+lid).hasClass('hideit')){
            $("#lecture_add_content"+lid).find('.adddescription').show();
          }
          $('#lecture_add_content'+lid).find('.closeheader .closecontents').hide();
          $('#lecture_add_content'+lid).find('.closeheader span.closetext').text('');
          $('#lecture_add_content'+lid).find('.closeheader').hide();
          $('.lecture-'+lid).find('.su_course_lecture_label').removeClass('su_lgray_curr_block');
          $('.lecture-'+lid).find('.su_course_lecture_label').removeClass('su_green_curr_block');
          $('.lecture-'+lid).find('.su_course_lecture_label').addClass('su_orange_curr_block');
          if(type == 'video') {
            if(return_data.file_link == ''){
              var videopart = '{!! Lang::get("curriculum.video_message")!!}';
            } else {
              var videopart = '<video class="video-js vjs-default-skin" controls preload="auto" data-setup="{}"><source src="'+return_data.file_link+'" type="video/webm" id="videosource"></video>';
            }
            $("#videoresponse"+lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-'+type+'"><div class="lecture_title"><p>'+return_data.file_title+'</p><p>'+return_data.duration+'</p><p><span class="cclickable vid_preview text-default" data-id="'+lid+'"><i class="fa fa-play"></i> Video Preview</span></p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+lid+'" data-alt="'+type+'"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+lid+'"></div></div><div class="media_preview" id="video_preview'+lid+'"> '+videopart+' </div></div></div>');
          } else if(type == 'audio') {
            if(return_data.file_type!='mp3'){
              var audiopart = '{!! Lang::get("curriculum.audio_message") !!}';
            } else {
              var audiopart = '<audio controls><source src="'+return_data.file_link+'" type="audio/mpeg">Your browser does not support the audio element.</audio>';
            }
            $("#videoresponse"+lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-'+type+'"><div class="lecture_title"><p>'+return_data.file_title+'</p><p>'+return_data.duration+'</p><p><span class="cclickable aud_preview text-default" data-id="'+lid+'"><i class="fa fa-play"></i> Audio Preview</span></p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+lid+'" data-alt="'+type+'"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+lid+'"></div></div><div class="media_preview" id="audio_preview'+lid+'">'+audiopart+'</div></div></div>');
          } else {
            $("#videoresponse"+lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-'+type+'"><div class="lecture_title"><p>'+return_data.file_title+'</p><p>'+return_data.duration+'</p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+lid+'" data-alt="'+type+'"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+lid+'"></div></div></div></div>');
          }
          location.reload(true);
        }else{

        }
      }
    });
  });
  
  $(document).on('click','.updaterescontent',function(){
    var lid = $(this).attr('data-lid');
    var lib = $(this).attr('data-lib');
    var file_data = $(this).text();
    var courseselectlibraryres =$('[name="courseselectlibraryres"]').val();
    var _token =$('[name="_token"]').val();
    $.ajax ({
      type: "POST",
      url: courseselectlibraryres,
      data: "courseid="+$('[name="course_id"]').val()+"&lid="+lid+"&lib="+lib+"&_token="+_token,
      success: function (data)
      { var return_data = $.parseJSON( data );
        if(return_data.status='true'){
          $("#cccontainer"+lid).hide();
          $("#resresponse"+lid).text("");
          $("#wholevideos"+lid).hide();
          $('#videoresponse'+lid).show();
          $("#lecture_add_content"+lid).find('.adddescription').hide();
          $("#lecture_add_content"+lid).find('.closecontents').show();
          $('#resourceblock'+lid).show();
          $('#resourceblock'+lid).find('.resourcefiles').append('<div id="resources'+lid+'_'+lib+'"><i class="fa fa-download"></i> '+file_data+' <div class="goright resdelete" data-lid="'+lid+'" data-rid="'+lib+'"><i class="goright fa fa-trash-o"></i></div></div>');
          location.reload(true);
        }else{

        }
      }
    });
  });
  
  $(document).on('click','.su_course_add_res_link_submit',function(){
    var lid = $(this).attr('data-lid');
    var title = $('#exres_title'+lid).val();
    title = $.trim(title);
    var link = $('#exres_link'+lid).val();
    link = $.trim(link);

    //check link url validation
    if(!checkURL(link)){
      alert('invalid url format.');
      $('#exres_link'+lid).focus();
      return false;
    }

    if(title != '' && link != ''){
      $(this).attr('disabled','disabled');
      var courseexternalres =$('[name="courseexternalres"]').val();
      var _token =$('[name="_token"]').val();
      $.ajax ({
        type: "POST",
        url: courseexternalres,
        data: "courseid="+$('[name="course_id"]').val()+"&lid="+lid+"&title="+title+"&link="+link+"&_token="+_token,
        success: function (data)
        { var return_data = $.parseJSON( data );
          $('.su_course_add_res_link_submit').removeAttr('disabled');
          if(return_data.status='true'){
            $("#cccontainer"+lid).hide();
            $("#resresponse"+lid).text("");
            $("#wholevideos"+lid).hide();
            $('#videoresponse'+lid).show();
            $("#lecture_add_content"+lid).find('.adddescription').hide();
            $("#lecture_add_content"+lid).find('.closecontents').show();
            $('#resourceblock'+lid).show();
            $('#resourceblock'+lid).find('.resourcefiles').append('<div id="resources'+lid+'_'+return_data.file_id+'"><i class="fa fa-external-link"></i> '+return_data.file_title +' <div class="goright resdelete" data-lid="'+lid+'" data-rid="'+return_data.file_id+'"><i class="goright fa fa-trash-o"></i></div></div>');
            $('#exres_title'+lid).val("");
            $('#exres_link'+lid).val("");
            location.reload(true);
          }else{
            
          }
        }
      });
    } else {
      alert('{!! Lang::get("curriculum.curriculum_empty")!!}');
    }
  });
  
  $(document).on('click','.vid_preview',function(){
    var lid = $(this).data('id');
    $("#video_preview"+lid).slideToggle();
  });
  
  $(document).on('click','.aud_preview',function(){
    var lid = $(this).data('id');
    $("#audio_preview"+lid).slideToggle();
  });
  
  $(document).on('click','.savedesctext',function(){
    var lid = $(this).data('lid');
    var text = $.trim(tinyClean(tinyMCE.get('textdesc-'+lid).getContent()));
    if(text != ''){
      var courselecturetext =$('[name="courselecturetext"]').val();
      var _token =$('[name="_token"]').val();
      $.ajax ({
        type: "POST",
        url: courselecturetext,
        data: "courseid="+$('[name="course_id"]').val()+"&lecturedescription="+text+"&lid="+lid+"&_token="+_token,
        success: function (data)
        { var return_data = $.parseJSON( data );
          if(return_data.status='true'){
            $("#contentpopshow"+lid).removeClass('hideit');
            $("#cccontainer"+lid).hide();
            $('#probar'+lid).css('width','0%');
            $("#videoresponse"+lid).text("");
            $("#wholevideos"+lid).hide();
            $('#videoresponse'+lid).show();
            if($('#adddescblock-'+lid).hasClass('hideit')){
              $("#lecture_add_content"+lid).find('.adddescription').show();
            } 
            $('#lecture_add_content'+lid).find('.closeheader .closecontents').hide();
            $('#lecture_add_content'+lid).find('.closeheader span.closetext').text('');
            $('#lecture_add_content'+lid).find('.closeheader').hide();
            $('.lecture-'+lid).find('.su_course_lecture_label').removeClass('su_lgray_curr_block');
            $('.lecture-'+lid).find('.su_course_lecture_label').removeClass('su_green_curr_block');
            $('.lecture-'+lid).find('.su_course_lecture_label').addClass('su_orange_curr_block');
            $("#videoresponse"+lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-text"><div class="lecture_title"><p>Text</p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+lid+'" data-alt="text"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+lid+'"></div></div><div class="clearfix"></div><div class="lecture_contenttext" id="lecture_contenttext'+lid+'"><p>'+text+'</p></div></div></div>');
          }else{

          }
        }
      });
    } else {
      alert('{!! Lang::get("curriculum.curriculum_text_empty") !!}');
    }
  });
  });
  

//filesuploadajax();

function filesuploadajax(){
  $('.videofiles').fileupload({
    autoUpload: true,
    acceptFileTypes: /(\.|\/)(mp4|avi|mov|flv)$/i,
    maxFileSize: 4096000000, // 4 GB
    progress: function (e, data) {
      
      $("#videoresponse"+data.lid).text("");
      $('#probar_status_'+data.lid).val(1);
      var percentage = parseInt(data.loaded / data.total * 100);
      $('#probar'+data.lid).css('width',percentage+'%');
      if(percentage == '100') {
        $('#probar'+data.lid).text('{!! Lang::get("curriculum.video_process")!!}');
      }
    },
    processfail: function (e, data) {
      file_name = data.files[data.index].name;
      $('#probar_status_'+data.lid).val(0);
      alert("{!! Lang::get('curriculum.lecture_video_file')!!}"); 
    },
    done: function(e, data){
      var return_data = $.parseJSON( data.result );
      if(return_data.status='true'){
        $("#contentpopshow"+data.lid).removeClass('hideit');
        $("#cccontainer"+data.lid).hide();
        $('#probar'+data.lid).css('width','0%');
        $("#videoresponse"+data.lid).text("");
        $("#wholevideos"+data.lid).hide();
        $('#videoresponse'+data.lid).show();
        if($('#adddescblock-'+data.lid).hasClass('hideit')){
          $("#lecture_add_content"+data.lid).find('.adddescription').show();
        } 
        $('#lecture_add_content'+data.lid).find('.closeheader .closecontents').hide();
        $('#lecture_add_content'+data.lid).find('.closeheader span.closetext').text('');
        $('#lecture_add_content'+data.lid).find('.closeheader').hide();
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_lgray_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_green_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').addClass('su_orange_curr_block');
        $("#videoresponse"+data.lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-video"><div class="lecture_title"><p>'+return_data.file_title+'</p><p>'+return_data.duration+'</p><p><span class="cclickable vid_preview text-default" data-id="'+data.lid+'"><i class="fa fa-play"></i> Video Preview</span></p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+data.lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+data.lid+'" data-alt="video"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+data.lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+data.lid+'"></div></div><div class="media_preview" id="video_preview'+data.lid+'"><video class="video-js vjs-default-skin video_p_'+data.lid+'" controls="" preload="auto" data-setup="{}"></video></div></div></div>');
        $('#probar_status_'+data.lid).val(0);
        //<video class="video-js vjs-default-skin" controls preload="auto" data-setup="{}"><source src="'+return_data.file_link+'" type="video/webm" id="videosource"></video>
      }else{
        
      }

    }
  });

  $('.audiofiles').fileupload({
    autoUpload: true,
    acceptFileTypes: /(\.|\/)(mp3|wav)$/i,
    maxFileSize: 1024000000, // 1 GB
    progress: function (e, data) {
      $("#videoresponse"+data.lid).text("");
      $('#probar_status_'+data.lid).val(1);
      var percentage = parseInt(data.loaded / data.total * 100);
      $('#probar'+data.lid).css('width',percentage+'%');
      if(percentage == '100') {
        $('#probar'+data.lid).text('{!! Lang::get("curriculum.audio_process")!!}');
      }
    },
    processfail: function (e, data) {
      file_name = data.files[data.index].name;
      $('#probar_status_'+data.lid).val(0);
      alert("{!! Lang::get('curriculum.lecture_audio_file')!!}");     
    },
    done: function(e, data){
      var return_data = $.parseJSON( data.result );
      if(return_data.status='true'){
        $("#contentpopshow"+data.lid).removeClass('hideit');
        $("#cccontainer"+data.lid).hide();
        $('#probar'+data.lid).css('width','0%');
        $("#videoresponse"+data.lid).text("");
        $("#wholevideos"+data.lid).hide();
        $('#videoresponse'+data.lid).show();
        if($('#adddescblock-'+data.lid).hasClass('hideit')){
          $("#lecture_add_content"+data.lid).find('.adddescription').show();
        } 
        $('#lecture_add_content'+data.lid).find('.closeheader .closecontents').hide();
        $('#lecture_add_content'+data.lid).find('.closeheader span.closetext').text('');
        $('#lecture_add_content'+data.lid).find('.closeheader').hide();
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_lgray_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_green_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').addClass('su_orange_curr_block');
        if(return_data.file_type!='mp3'){
          var audiopart = '{!! Lang::get("curriculum.audio_message")!!}';
        } else {
          var audiopart = '<audio controls><source src="'+return_data.file_link+'" type="audio/mpeg">Your browser does not support the audio element.</audio>';
        }
        $("#videoresponse"+data.lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-audio"><div class="lecture_title"><p>'+return_data.file_title+'</p><p>'+return_data.duration+'</p><p><span class="cclickable aud_preview text-default" data-id="'+data.lid+'"><i class="fa fa-play"></i> Audio Preview</span></p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+data.lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+data.lid+'" data-alt="audio"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+data.lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+data.lid+'"></div></div><div class="media_preview" id="audio_preview'+data.lid+'">'+audiopart+'</div></div></div>');
        $('#probar_status_'+data.lid).val(0);
      }else{
        
      }

    }
  });

  $('.prefiles').fileupload({
    autoUpload: true,
    acceptFileTypes: /(\.|\/)(pdf)$/i,
    maxFileSize: 1024000000, // 1 GB
    progress: function (e, data) {
      $("#videoresponse"+data.lid).text("");
      $('#probar_status_'+data.lid).val(1);
      var percentage = parseInt(data.loaded / data.total * 100);
      $('#probar'+data.lid).css('width',percentage+'%');
      if(percentage == '100') {
        $('#probar'+data.lid).text('{!! Lang::get("curriculum.lecture_file_process")!!}');
      }
    },
    processfail: function (e, data) {
      file_name = data.files[data.index].name;
      $('#probar_status_'+data.lid).val(0);
      alert("{!! Lang::get('curriculum.lecture_pdf_file')!!}");   
    },
    done: function(e, data){
      var return_data = $.parseJSON( data.result );
      if(return_data.status='true'){
        $("#contentpopshow"+data.lid).removeClass('hideit');
        $("#cccontainer"+data.lid).hide();
        $('#probar'+data.lid).css('width','0%');
        $("#videoresponse"+data.lid).text("");
        $("#wholevideos"+data.lid).hide();
        $('#videoresponse'+data.lid).show();
        if($('#adddescblock-'+data.lid).hasClass('hideit')){
          $("#lecture_add_content"+data.lid).find('.adddescription').show();
        } 
        $('#lecture_add_content'+data.lid).find('.closeheader .closecontents').hide();
        $('#lecture_add_content'+data.lid).find('.closeheader span.closetext').text('');
        $('#lecture_add_content'+data.lid).find('.closeheader').hide();
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_lgray_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_green_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').addClass('su_orange_curr_block');
        $("#videoresponse"+data.lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-presentation"><div class="lecture_title"><p>'+return_data.file_title+'</p><p>'+return_data.duration+'</p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+data.lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+data.lid+'" data-alt="presentation"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+data.lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+data.lid+'"></div></div></div></div>');
        $('#probar_status_'+data.lid).val(0);
      }else{

      }

    }
  });

  $('.docfiles').fileupload({
    autoUpload: true,
    acceptFileTypes: /(\.|\/)(pdf)$/i,
    maxFileSize: 1024000000, // 1 GB
    progress: function (e, data) {
      // alert(data.lid);
      $('#probar_status_'+data.lid).val(1);
      $("#videoresponse"+data.lid).text("");
      var percentage = parseInt(data.loaded / data.total * 100);
      $('#probar'+data.lid).css('width',percentage+'%');
      if(percentage == '100') {
        $('#probar'+data.lid).text('{!! Lang::get("curriculum.lecture_file_process")!!}');
      }
    },
    processfail: function (e, data) {
      $('#probar_status_'+data.lid).val(0);
      file_name = data.files[data.index].name;
      alert("{!! Lang::get('curriculum.lecture_pdf_file')!!}");     
    },
    done: function(e, data){
      var return_data = $.parseJSON( data.result );
      if(return_data.status='true'){
        $("#contentpopshow"+data.lid).removeClass('hideit');
        $("#cccontainer"+data.lid).hide();
        $('#probar'+data.lid).css('width','0%');
        $("#videoresponse"+data.lid).text("");
        $("#wholevideos"+data.lid).hide();
        $('#videoresponse'+data.lid).show();
        if($('#adddescblock-'+data.lid).hasClass('hideit')){
          $("#lecture_add_content"+data.lid).find('.adddescription').show();
        } 
        $('#lecture_add_content'+data.lid).find('.closeheader .closecontents').hide();
        $('#lecture_add_content'+data.lid).find('.closeheader span.closetext').text('');
        $('#lecture_add_content'+data.lid).find('.closeheader').hide();
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_lgray_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').removeClass('su_green_curr_block');
        $('.lecture-'+data.lid).find('.su_course_lecture_label').addClass('su_orange_curr_block');
        $("#videoresponse"+data.lid).append('<div class="lecture_main_content_first_block1"><div class="lc_details imagetype-file"><div class="lecture_title"><p>'+return_data.file_title+'</p><p>'+return_data.duration+'</p></div><div class="lecture_buttons"><div class="lecture_edit_content" id="lecture_edit_content'+data.lid+'"> <input type="button" name="lecture_edit_content" class="btn btn-default editlectcontent" value="{!! Lang::get("curriculum.Edit_Content") !!}" data-blockid="'+data.lid+'" data-alt="file"> <input type="button" name="lecture_resource_content" class="btn btn-info addresource" value="{!! Lang::get("curriculum.Add_Resource") !!}" data-blockid="'+data.lid+'" data-alt="resource"> <input type="button" name="lecture_publish_content" class="btn btn-warning publishcontent" value="{!! Lang::get("curriculum.Publish")!!}" data-blockid="'+data.lid+'"></div></div></div></div>');
        $('#probar_status_'+data.lid).val(0);
      }else{

      }

    }
  }); 

  $('.resfiles').fileupload({
    autoUpload: true,
    acceptFileTypes: /(\.|\/)(pdf|doc|docx)$/i,
    maxFileSize: 1024000000, // 1 GB
    progress: function (e, data) {
      // alert(data.lid);
      $('#probar_status_'+data.lid).val(1);
      $("#resresponse"+data.lid).text("");
      var percentage = parseInt(data.loaded / data.total * 100);
      $('#probar'+data.lid).css('width',percentage+'%');
      if(percentage == '100') {
        $('#probar'+data.lid).text('{!! Lang::get("curriculum.lecture_file_process")!!}');
      }
    },
    processfail: function (e, data) {
      $('#probar_status_'+data.lid).val(0);
      file_name = data.files[data.index].name;
      alert("{!! Lang::get('curriculum.lecture_file_not_allowed')!!}");   
  },
    done: function(e, data){
      var return_data = $.parseJSON( data.result );
      if(return_data.status='true'){
        $("#cccontainer"+data.lid).hide();
        $("#resresponse"+data.lid).text("");
        $('#probar'+data.lid).css('width','0%');
        $("#wholevideos"+data.lid).hide();
        $('#videoresponse'+data.lid).show();            
        $("#lecture_add_content"+data.lid).find('.adddescription').hide();
        $("#lecture_add_content"+data.lid).find('.closecontents').show();
        $('#resourceblock'+data.lid).show();
        $('#resourceblock'+data.lid).find('.resourcefiles').append('<div id="resources'+data.lid+'_'+return_data.file_id+'"><i class="fa fa-download"></i> '+return_data.file_title+' ('+return_data.file_size+') <div class="goright resdelete" data-lid="'+data.lid+'" data-rid="'+return_data.file_id+'"><i class="goright fa fa-trash-o"></i></div></div>');
        $('#probar_status_'+data.lid).val(0);
      }else{

      }

    }
  });
}


// // Delete Course Section


function deletesection(id) {
  var _token=$('[name="_token"]').val();
  $('.section-'+id).css('opacity', '0.5');
  $.ajax ({
    type: "POST",
    url: $('[name="coursesectiondel"]').val(),
    data: "&courseid="+$('[name="course_id"]').val()+"&sid="+id+"&_token="+_token,
    success: function (msg)
    {
      
      $('.section-'+id).remove();
      $('.parent-s-'+id).remove();
      var x=1;
      $('.su_course_curriculam_sortable .su_gray_curr').each(function(){  
        $(this).find('.serialno').text(x);
        $(this).find('.sectionpos').val(x);
        x++;
      });
      updatesorting();
      location.reload(true);
      //$('.su_course_add_section_content .col.col-lg-3 span').text($('.su_course_curriculam li.parentli').length+1);
    }
  });
}

// update course section

function updatesection(id) {
  $('.section-'+id).css('opacity','0.5');
  var section=$.trim($('.section-'+id+' .su_course_update_section_textbox').val());
  if(section != ''){
    if(section.length < 2)
    {
      alert('Please provide atleast 2 characters');
      return false;
    }
    var position=$('.section-'+id+' .sectionpos').val();
    var coursesection=$('[name="coursesection"]').val();
    var _token=$('[name="_token"]').val();
    $.ajax ({
      type: "POST",
      url: coursesection,
      data: "&courseid="+$('[name="course_id"]').val()+"&section="+section+"&sid="+id+"&position="+position+"&_token="+_token,
      success: function (msg)
      {
        $('.section-'+id).css('opacity','1');
        $('.section-'+id+' label.slqtitle').text(section);
        $('.section-'+id).removeClass('editon');
        //location.reload(true);
      }
    });
  } else {
    alert('{!! Lang::get("curriculum.curriculum_section_name") !!}');
  }
}

// Delete Course lecture

function deletelecture(id,sid) {
  var _token=$('[name="_token"]').val();
  $('.lecture-'+id).css('opacity','0.5');
  $.ajax ({
    type: "POST",
    url: $('[name="courselecturequizdel"]').val(),
    data: "&courseid="+$('[name="course_id"]').val()+"&lid="+id+"&_token="+_token,
    success: function (msg)
    {
      
      $('.lecture-'+id).remove();
      var x=1;
      $('.section-'+sid).nextUntil('.parentli', '.childli' ).each(function(){
        $(this).find('.serialno').text(x);
        x++;
      });
      var lq=1;
      $('.section-'+sid).nextUntil('.parentli', '.lq_sort' ).each(function(){
        $(this).find('.lecturepos').val(lq);
        lq++;
      });
      updatesorting();
      //location.reload(true);
      //$('.su_course_add_lecture_content .col.col-lg-3 span').text($('.su_course_curriculam li.childli').length+1);
    }
  });
}

// Delete Course quiz

function deletequiz(id,sid) {
  var _token=$('[name="_token"]').val();
  $('.quiz-'+id).css('opacity','0.5');
  $.ajax ({
    type: "POST",
    url: $('[name="courselecturequizdel"]').val(),
    data: "&courseid="+$('[name="course_id"]').val()+"&lid="+id+"&_token="+_token,
    success: function (msg)
    {
      
      $('.quiz-'+id).remove();
      var x=1;
      $('.section-'+sid).nextUntil('.parentli', '.quiz' ).each(function(){
        $(this).find('.serialno').text(x);
        x++;
      });
      var lq=1;
      $('.section-'+sid).nextUntil('.parentli', '.lq_sort_quiz' ).each(function(){
        $(this).find('.quizpos').val(lq);
        lq++;
      });
      updatesorting();
      location.reload(true);
      //$('.su_course_add_quiz_content .col.col-lg-3 span').text($('.su_course_curriculam li.childli').length+1);
    }
  });
}

// update course lecture

function updatelecture(id,sid) {
  $('.lecture-'+id).css('opacity','0.5');
  var lecture=$.trim($('.lecture-'+id+' .su_course_update_lecture_textbox').val());
  if(lecture != ''){
    if(lecture.length<=1)
    {
      alert('{!! Lang::get("curriculum.curriculum_lecture_ch_length")!!}');
      return false;
    }

    var position=$('.lecture-'+id+' .lecturepos').val();
    var courselecture=$('[name="courselecture"]').val();
    var _token=$('[name="_token"]').val();
    $.ajax ({
      type: "POST",
      url: courselecture,
      data: "&sectionid="+sid+"&courseid="+$('[name="course_id"]').val()+"&lecture="+lecture+"&lid="+id+"&position="+position+"&_token="+_token,
      success: function (msg)
      {
        $('.lecture-'+id).css('opacity','1');
        $('.lecture-'+id+' label.slqtitle').text(lecture);
        $('.lecture-'+id).removeClass('editon');
        //location.reload(true);
      }
    });
  } else {
    alert('{!! Lang::get("curriculum.curriculum_lecture_name")!!}');
  }
}

function updatesorting() {
  var x=1;
  var updatesection=[];
  var updatelecturequiz=[];
  var lq=1;
  var y=1;
  var l=1;
  
  var sec_id = '';
  // Adding roll numbers for section and lectures
  $('.su_course_curriculam_sortable ul li').each(function(){
  
    if($(this).hasClass('parentli')){
      sec_id = $(this).find('.sectionid').val();
      
      $(this).find('.serialno').text(x);
      $(this).find('.sectionpos').val(x);
      var section= $(this).find('label').text();
      updatesection.push({
        section: section,
        id: sec_id,
        position: x
      });
      x++;
    } else if($(this).hasClass('childli')){
      var oldsid=$(this).find('.lecturesectionid').val();
      $(this).find('.serialno').text(y);
      $(this).find('.lecturepos').val(lq);
      $(this).find('.lecturesectionid').val(sec_id);
      
      var lid=$(this).find('.lectureid').val();
      
      $('.lecture-'+lid).removeClass('parent-s-'+oldsid);
      $('.lecture-'+lid).addClass('parent-s-'+sec_id);
      $('.lecture-'+lid+' .deletelecture').attr('onclick','deletelecture('+lid+','+sec_id+')');
      $('.lecture-'+lid+' .updatelecture').attr('onclick','updatelecture('+lid+','+sec_id+')');
      
      updatelecturequiz.push({
        sectionid: sec_id,
        id: lid,
        position: lq
      }); 
      y++;
      lq++;
    } else if($(this).hasClass('quiz')){
      var oldsid=$(this).find('.quizsectionid').val();
        
      $(this).find('.serialno').text(l);
      $(this).find('.quizpos').val(lq);
      $(this).find('.quizsectionid').val(sec_id)
      
      var lid=$(this).find('.quizid').val();

      $('.quiz-'+lid).removeClass('parent-s-'+oldsid);
      $('.quiz-'+lid).addClass('parent-s-'+sec_id);
      $('.quiz-'+lid+' .deletequiz').attr('onclick','deletequiz('+lid+','+sec_id+')');
      $('.quiz-'+lid+' .updatequiz').attr('onclick','updatequiz('+lid+','+sec_id+')');
      updatelecturequiz.push({
        sectionid: sec_id,
        id: lid,
        position: lq
      }); 
      l++;
      lq++;
    } 
  });
  
  // update the section position to db
  $.ajax ({
    type: "POST",
    url: $('[name="coursecurriculumsort"]').val(),
    data:{sectiondata: updatesection,_token:$('[name="_token"]').val(),type:'section'},
    
  });
  
  // update the lecture position to db
  $.ajax ({
    type: "POST",
    url: $('[name="coursecurriculumsort"]').val(),
    data:{lecturequizdata: updatelecturequiz,_token:$('[name="_token"]').val(),type:'lecturequiz'},
  });
}

function tinyClean(value) {
  value = value.replace(/&nbsp;/ig, ' ');
  value = value.replace(/\s\s+/g, ' ');
  if(value == '<p><br></p>' || value == '<p> </p>' || value == '<p></p>') {
    value = '';
  }
  return value;
}

//check url validation
function checkURL(link){
  var regexp = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    return regexp.test(link); 
}

$('body').on('click','.cclickable',function(){

  if(!$(this).hasClass('updaterescontent')) 
  {
    var id = $(this).attr('data-lid');
    if(id==null)
    {
      id = $(this).attr('data-id');
    }

     $.ajax({
        url: '{!! \URL::to("admin/courses/video") !!}',
        data:{vid:id},
        method:'POST',
        success: function(result)
        {
        
              var storage_path = "{{ url('course/'.$course_id.'/') }}";
              var vi = '<source src="'+storage_path+'/'+result+'.mp4" type="video/mp4" id="videosource">';
            $('.video_p_'+id).html(vi);
            // location.reload(true);
          }
      });
  }

});

  $('body').on('click','.save-course-lesson-vimeo-url',function(){
    var elem = $(this).siblings('#course_lesson_vimeo_url').first();
    var input_link = elem.val();
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
  });
</script>
@endsection
