@extends('layouts.default')
@section('title')
    {{' Settings' }}
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
                        {{ ' Settings' }}
                    </h3>
                </div>
                <div class="content-header-right col-md-8 col-12">
                    <div class="breadcrumbs-top float-md-right">
                        <div class="breadcrumb-wrapper mr-1">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    {{  ' Settings' }}
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
                                        <div class="table-responsive">
                                            {{ $dataTable->table(['class' => 'table table-striped table-bordered base-style ', 'style' => 'width: 100%']) }}
                                        </div>
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
    @include('admin.modals.settings_modal')
    <!-- END: Content-->
@endsection

@section('local-script')
    {{ $dataTable->scripts() }}

    <script>
        $(document).on('click', '.edit-settings', function (e) { 
            e.preventDefault();
            let settingId = $(this).closest('tr').attr('id');
            let url = "{{ route('settings.edit', ':settingId') }}";
            url = url.replace(':settingId', settingId);
            //console.log(url);
            $.getJSON(url, function(setting) {
                if(setting.status == true) {
                    let updateUrl = "{{ route('settings.update', ':settingId') }}";
                    updateUrl = updateUrl.replace(':settingId', settingId);
                    $('#settingsModal #modalTitle').html("Edit "+ setting.data.title);
                    $('#settingsModal #settingsModalForm').attr('action', updateUrl);
                    $('#settingsModal #title').val(setting.data.title);
                    $('#settingsModal #value').val(setting.data.value);
                    $('#settingsModal').modal('show');
                } else {
                    window.toast.fire({
                        icon: 'error',
                        title: error.response.data.message
                    });
                }
            });
        });

        $(document).on('submit', '.save-settings', function (e) { 
            e.preventDefault();
            var action = $(this).attr('action');
            var data = new FormData(this);
            $.ajax({
                type: "POST",
                url: action,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#settingsModal').modal('hide');
                    $('#settings_table').DataTable().ajax.reload();
                    window.toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                },
                error: function(error) {
                    window.toast.fire({
                        icon: 'error',
                        title: error.responseJSON.message
                    });
                }
            });
        });
    </script>
@endsection
