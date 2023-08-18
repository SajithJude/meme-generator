@extends('layouts.default')
@section('title')
Edit Student
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
          Edit Student
        </h3>
      </div>
      <div class="content-header-right col-md-8 col-12">
        <div class="breadcrumbs-top float-md-right">
          <div class="breadcrumb-wrapper mr-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item active">
                Edit Student
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
                  <a href="{{ route('students.index') }}" type="button" class="btn btn-secondary btn-sm"><i
                      class="ft-arrow-left"></i>
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

                  <form method="post" enctype="multipart/form-data" action="{{ route('students.update', $data['id']) }}">
                    @csrf
                    @method('put')
                    <fieldset>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input name="first_name" type="text" class="form-control" value="{{ $data['first_name'] }}"
                              required>

                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input name="last_name" type="text" class="form-control" value="{{ $data['last_name'] }}"
                              required>
                            <input step="any" name="id" type="hidden" value="{{ $data['id'] }}">

                          </div>
                        </div>
                      </div>
                    </fieldset>

                    <fieldset>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" type="email" value="{{ $data['email'] }}" class="form-control" required
                              readonly>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="phone_number">Phone</label>
                            <input name="phone_number" type="phone" value="{{ $data['phone_number'] }}"
                              class="form-control" required>
                          </div>
                        </div>
                      </div>
                    </fieldset>

                    <fieldset>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="city">City</label>
                            <input value="{{ $data['city'] }}" name="city" type="text" class="form-control" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" value="{{ $data['status'] }}" class="form-control">
                              <option value="1" <?=($data['status']=='1' ) ? 'selected' : '' ; ?>>Active</option>
                              <option value="0" <?=($data['status']=='0' ) ? 'selected' : '' ; ?>>In-Active</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </fieldset>

                    <fieldset>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="booking_count">Available Booking Credits</label>
                            <input
                              value="{{ $data['available_booking_counts'] ? $data['available_booking_counts']['booking_count'] : 0 }}"
                              name="booking_count" step="1" min="0" type="number" class="form-control" required>
                          </div>
                        </div>
                      </div>
                    </fieldset>

                    <fieldset>
                      <br>
                      <div class="row">
                        <div class="col-md-6">
                          <a type="button" href="javascript:void(0)" data-method="get"
                            data-url="{{ route('students.destroy', $data['id']) }}"
                            class="btn btn-outline-danger btn-sm delete" data-redirect="{{ route('students.index') }}">
                            <i class="ft-trash"></i> Delete this user
                          </a>
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
<!-- BEGIN: Page JS-->
<script src="{{ asset('public/theme/app-assets/js/scripts/tables/datatables/datatable-styling.js') }}"
  type="text/javascript"></script>
<!-- END: Page JS-->
@endsection
