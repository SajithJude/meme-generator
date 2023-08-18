@extends('layouts.default')
@section('title')
Add Subscription Plan
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
                    Add Subscription Plan
                </h3>
            </div>
            <div class="content-header-right col-md-8 col-12">
                <div class="breadcrumbs-top float-md-right">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Add Subscription Plan
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
                                    <a href="{{ route('subscription.list') }}" type="button"
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
                                          action="{{route('saveSubscription')}}">
                                        @csrf
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="stripe_product_id">Stripe Product Id</label>
                                                        <input step="any"
                                                               name="stripe_product_id"
                                                               type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="plan_name">Plan Name</label>
                                                        <input step="text"
                                                               name="plan_name"
                                                               type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="Status">Plan</label>
                                                        <select class="form-control" required="" name="plans">
                                                            <option value="monthly">Monthly</option>
                                                            <option value="halfyearly">Half Yearly</option>
                                                            <option value="yearly">Yearly</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="percentage">Discount Percentage</label>
                                                        <input step="any"
                                                               name="discount_percentage"
                                                               type="number" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="access">Does this plan has Access to All Courses?</label>
                                                        <select class="select2 form-control" required name="is_access_cource">
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="duration">Duration</label>
                                                        <input step="any"
                                                               name="duration"
                                                               type="number" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="feedback_video_count">Feedback Video Count</label>
                                                        <input step="any"
                                                               name="feedback_video_count"
                                                               type="number" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="access">Does this plan has Access to Webinars?</label>
                                                        <select class="select2 form-control" required name="webinar_access">
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="access">Does this plan has Access to Yoodli?</label>
                                                        <select class="select2 form-control" required name="yoodli_access">
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="price">Please enter price</label>
                                                        <input step="any"
                                                               name="price"
                                                               type="number" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="price">Enter no. of free booking credits</label>
                                                        <input step="1" min="0" value="2"
                                                               name="booking_credit"
                                                               type="number" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="price">Status</label>
                                                        <select name="status" id="status" class="select2 form-control" class="form-control">
                                                            <option value="1">Active</option>
                                                            <option value="0">In-Active</option>
                                                        </select>
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
