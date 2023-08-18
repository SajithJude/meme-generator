@extends('layouts.default')
@section('title')
Default Learning Path
@endsection

@section('local-style')
<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css"
  href="{{ asset('/theme/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<!-- END: Vendor CSS-->
<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  /* display: none; <- Crashes Chrome on hover */
  -webkit-appearance: none;
  margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}

input[type=number] {
  -moz-appearance:textfield; /* Firefox */
}
</style>
@endsection

@section('body')

<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-wrapper-before"></div>
    <div class="content-header row">
      <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">
          Default Learning Path
        </h3>
      </div>
      <div class="content-header-right col-md-8 col-12">
        <div class="breadcrumbs-top float-md-right">
          <div class="breadcrumb-wrapper mr-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item active">
                Default Learning Path
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
                  </ul>
                </div>
              </div>


              <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                  @include('includes.error')

                  <form method="post" id="default-learning-paths-form"
                    action="{{ route('default_learning_path.update', $user->id) }}">
                    @csrf

                    <div class="row pl-2 pr-2 mb-1" style="font-size: 14px; font-weight: 700; color; black;">
                      <div class="col-md-8">Course Name</div>
                      <div class="col-md-4 text-center">Opens On</div>
                    </div>
                    <hr class="pl-2 pr-2">

                    @foreach ($courses as $course)
                    <div class="row pl-2 pr-2 mb-1" style="font-size: 14px; font-weight: 600;">
                      <div class="col-md-8">
                        {{ $course->course_title }}
                      </div>
                      <div class="col-md-4 text-center">
                        <input class="text-center form-control m-auto" type="number" name="default_learning_path[{{ $course->id }}][opens_on]"
                          id="default_learning_path_{{ $course->id }}_opens_on" min="1" value="{{ $course->defaultLearningPath?->opens_on }}"
                          style="width: 70px;">
                        <input type="hidden" name="default_learning_path[{{ $course->id }}][course_id]"
                          id="default_learning_path_{{ $course->id }}_course_id" value="{{ $course->id }}">
                        <input type="hidden" name="default_learning_path[{{ $course->id }}][id]"
                          id="default_learning_path_{{ $course->id }}_id" value="{{ $course->defaultLearningPath?->id }}">
                      </div>
                    </div>
                    @endforeach

                    <fieldset>
                      <div class="row">
                        <div class="col-md-12 text-right">
                          <button type="submit" class="btn btn-sm btn-info">
                            <i class="ft-feather"></i> Save
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
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<!-- END: Page JS-->
@endsection
