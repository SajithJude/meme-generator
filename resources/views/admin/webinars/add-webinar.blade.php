@extends('layouts.default')
@section('title')
Add Webinar
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
                    Add Webinar Plan
                </h3>
            </div>
            <div class="content-header-right col-md-8 col-12">
                <div class="breadcrumbs-top float-md-right">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Add Webinar Plan
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
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>


                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    @include('includes.error')

                                    <form method="post" enctype="multipart/form-data"
                                          action="{{route('saveWebinar')}}">
                                        @csrf
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="url">Enter Webinar URL</label>
                                                        <input step="any"
                                                               name="url"
                                                               type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="date">Select Date of Webinar</label>
                                                        <input step="any"
                                                               name="date"
                                                               type="datetime-local" class="form-control" required>
                                                    </div>
                                                </div>

                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="instructor_name">Enter Instructor Name</label>
                                                        <input step="any"
                                                               name="instructor_name"
                                                               type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="type">Please select Webinar Type</label>
                                                        <select class="select2 form-control" required name="type">
                                                            <option value="recorded">Recorded</option>
                                                            <option value="upcoming">Upcoming</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="title">Write Introduction (Max 200 Words)</label>
                                                        <textarea name="title" rows="4" cols="50"
                                                                  maxlength="200" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image">Add Image</label>
                                                        <input name="image" type="file" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-control-label">User Accessibility</label>
                                                    <div>
                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="inputBasicLocked" name="accessibility" value="1"/>
                                                            <label for="inputBasicLocked">Paid Users</label>
                                                        </div>
                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="inputBasicUnLocked" name="accessibility" value="0" checked/>
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
                                                    <a href="#"
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
