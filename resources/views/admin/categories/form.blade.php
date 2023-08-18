@extends('layouts.default')
@section('title')
Add Category
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
                    Edit Category
                </h3>
            </div>
            <div class="content-header-right col-md-8 col-12">
                <div class="breadcrumbs-top float-md-right">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Edit Category
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
                                    <a href="{{ route('admin.categories') }}" type="button"
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

                                    <form method="POST" action="{{ route('admin.saveCategory') }}" id="categoryForm">
                                      {{ csrf_field() }}
                                      <input type="hidden" name="category_id" value="{{ $category->id }}">
                                      <div class="row">
                                      
                                        <div class="form-group col-md-4">
                                          <label class="form-control-label">Category Name <span class="required">*</span></label>
                                          <input type="text" class="form-control" name="name" 
                                            placeholder="First Name" value="{{ $category->name }}" />
                                            @if ($errors->has('name'))
                                                <label class="error" for="name">{{ $errors->first('name') }}</label>
                                            @endif
                                        </div>
                                
                                        <div class="form-group col-md-4">
                                          <label class="form-control-label">Icon Class <span class="required">*</span></label>
                                          <input type="text" class="form-control" name="icon_class" 
                                            placeholder="Icon Class" value="{{ $category->icon_class }}" />
                                            @if ($errors->has('icon_class'))
                                                <label class="error" for="name">{{ $errors->first('icon_class') }}</label>
                                            @endif
                                          <span>Example:fa-user | Use <a href="https://fontawesome.com/icons?d=gallery" target="_blank">Font Awesome</a> icons</span>
                                        </div>
                                      
                                        
                                      <div class="form-group col-md-4">
                                        <label class="form-control-label">Status</label>
                                        <div>
                                          <div class="radio-custom radio-default radio-inline">
                                            <input type="radio" id="inputBasicActive" name="is_active" value="1" @if($category->is_active) checked @endif />
                                            <label for="inputBasicActive">Active</label>
                                          </div>
                                          <div class="radio-custom radio-default radio-inline">
                                            <input type="radio" id="inputBasicInactive" name="is_active" value="0" @if(!$category->is_active) checked @endif/>
                                            <label for="inputBasicInactive">Inactive</label>
                                          </div>
                                        </div>
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

<!-- END: Content-->
@endsection

@section('local-script')
<!-- BEGIN: Page JS-->
<script src="{{ asset('public/theme/app-assets/js/scripts/tables/datatables/datatable-styling.js') }}"
type="text/javascript"></script>
<!-- END: Page JS-->
@endsection



















