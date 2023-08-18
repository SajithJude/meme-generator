@extends('layouts.default')

@section('title')
    Add Student
@endsection

@section('body')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12 mb-2">
                <h3 class="content-header-title">Add Student</h3>
            </div>
            <div class="content-header-right col-md-8 col-12">
                <div class="breadcrumbs-top float-md-right">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Add Student</li>
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
                                    <a href="{{ route('students.index') }}" type="button" class="btn btn-secondary btn-sm">
                                        <i class="ft-arrow-left"></i> Back
                                    </a>
                                </h4>
                                <a class="heading-elements-toggle">
                                    <i class="la la-ellipsis-v font-medium-3"></i>
                                </a>
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
                                    <form method="post" enctype="multipart/form-data" action="{{ route('students.store') }}" id="add_new_student_form">
                                        @csrf
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="first_name">First Name</label>
                                                        <input name="first_name" type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="last_name">Last Name</label>
                                                        <input name="last_name" type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input name="email" type="email" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone_number">Phone</label>
                                                        <input name="phone_number" type="phone" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="city">City</label>
                                                        <input name="city" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="status">Status</label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option value="1" selected>Active</option>
                                                            <option value="0">In-Active</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="selected_plan">Select Plan</label>
                                                        <select name="selected_plan" id="selected_plan" class="form-control">
                                                            <option value="" selected disabled>--Select Plan--</option>
                                                            @foreach ($plans as $plan)
                                                                <option value="{{ $plan->id }}" data-plan="{{ $plan->plans }}" data-price="{{ $plan->price }}">{{ isset($plan->plan_name) ? $plan->plan_name : 'N/A' }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fee_price">Fee Price</label>
                                                        <input name="fee_price" step="1" id="fee_price" min="0" type="number" class="form-control" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="start_date">Subscription Start Date</label>
                                                        <input name="start_date" type="date" class="form-control" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="end_date">Subscription End Date</label>
                                                        <input name="end_date" id="end_date" type="date" class="form-control" min="{{ date('Y-m-d', strtotime(' +1 day')) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="booking_count">Free Booking Credits</label>
                                                        <input name="booking_count" step="1" min="0" type="number" class="form-control" value="2">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <a href="#" class="btn btn-sm btn-secondary mr-1" onclick="location.reload();">
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
    <script>
        $(document).on('change', '#selected_plan', function() {
            let val = $(this).find(':selected').data('plan');
            let price = $(this).find(':selected').data('price');
            var currentDate = new Date();
            currentDate.setMonth(currentDate.getMonth() + 1);
            if (val === 'halfyearly') {
                currentDate.setMonth(currentDate.getMonth() + 5);
            } else if (val === 'yearly') {
                currentDate.setMonth(currentDate.getMonth() + 11);
            }
            var formattedDate = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1).toString().padStart(2, '0') + '-' + currentDate.getDate().toString().padStart(2, '0');
            $('#fee_price').val(price);
            $('#end_date').val(formattedDate);
        });
        $(document).on('submit', '#add_new_student_form', function (e) { 
            e.preventDefault();
            var action = $(this).attr('action');
            var data = new FormData(this);
            window.swal.fire({
                title: "",
                text: "Please wait...",
                showConfirmButton: false,
                backdrop: true
            });
            $.ajax({
                type: "POST",
                url: action,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    window.swal.close();
                    window.toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    window.location.href = '{{ route('students.index') }}';
                },
                error: function(error) {
                    window.swal.close();
                    window.toast.fire({
                        icon: 'error',
                        title: error.responseJSON.message
                    });
                }
            });
        });
    </script>
@endsection