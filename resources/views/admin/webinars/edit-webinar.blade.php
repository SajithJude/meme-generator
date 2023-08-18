@extends('layouts.default')
@section('title')
Edit Webinar Detail
@endsection

@section('local-style')
<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css"
      href="{{ asset('/theme/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<!-- END: Vendor CSS-->
@endsection

@section('body')

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12 mb-2">
                <h3 class="content-header-title">
                    Edit Webinar Detail
                </h3>
            </div>
            <div class="content-header-right col-md-8 col-12">
                <div class="breadcrumbs-top float-md-right">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Edit Webinar Detail
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
                                <h4 class="card-title">
                                    <a href="{{ route('webinar.list') }}" type="button"
                                       class="btn btn-secondary btn-sm"><i class="ft-arrow-left"></i>
                                        Back
                                    </a>
                                </h4>
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

                                    <form method="post" enctype="multipart/form-data"
                                          action="{{route('updateWebinar')}}">
                                        @csrf
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="url">Webinar URL</label>
                                                        <input step="any"
                                                               name="url"
                                                               type="text" class="form-control" value="{{$data['video_url']}}" required>
                                                        <input step="any" name="id" type="hidden" value="{{$data['id']}}">

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="duration">Date</label>
                                                        <input step="any"
                                                               name="date"
                                                               type="datetime-local" value="{{$data['date']}}" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="instructor">Instructor Name</label>
                                                        <input step="any"
                                                               name="instructor_name"
                                                               type="text" class="form-control" value="{{$data['instructor']}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="access">Webinar Type</label>
                                                        <select name="type" id="type" class="select2 form-control" value="{{$data['type']}}" class="form-control">
                                                            <option  value="upcoming" <?= ($data['type'] == 'upcoming') ? 'selected' : ''; ?>>Upcoming</option>
                                                            <option  value="recorded" <?= ($data['type'] == 'recorded') ? 'selected' : ''; ?>>Recorded</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="url">Introduction (Max 200 Words)</label>
                                                        <textarea step="any"
                                                                  name="title"
                                                                  rows="5" class="form-control" required>{{$data['title']}}</textarea>

                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image">Change Image</label>
                                                        @if(!empty($data['image']))
                                                            <div class="image-clean">
                                                                <img style="max-height: 100px; max-width: 100px; margin-bottom: 2px;" src="{{ asset('assets/img/'.$data['image']) }}">
                                                            </div>
                                                        @endif
                                                        <input name="image" type="file" class="form-control" accept="image/*">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-control-label">User Accessibility</label>
                                                    <div>
                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="inputBasicLocked" name="accessibility" value="1" @if($data['accessibility'] == 1) checked @endif/>
                                                            <label for="inputBasicLocked">Paid Users</label>
                                                        </div>
                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="inputBasicUnLocked" name="accessibility" value="0" @if($data['accessibility'] == 0) checked @endif/>
                                                            <label for="inputBasicUnLocked">Free Users</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-6 offset-6 text-right">
                                                    <a href="javascript:void(0)"
                                                       class="btn btn-sm btn-secondary mr-1" onclick="location.reload();">
                                                        <i class="ft-rotate-ccw"></i> Cancel
                                                    </a>
                                                    <button type="submit" class="btn btn-sm btn-info">
                                                        <i class="ft-feather"></i> Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </fieldset>
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

<!-- END: Content-->
@endsection

@section('local-script')
<!-- BEGIN: Page JS-->
<script src="{{ asset('public/theme/app-assets/js/scripts/tables/datatables/datatable-styling.js') }}"
type="text/javascript"></script>
<!-- END: Page JS-->
@endsection
