@extends('layouts.default')
@section('title')
Subscription Orders
@endsection

@section('local-style')
<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css"
      href="{{ asset('/theme/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<!-- END: Vendor CSS-->
@endsection

@section('body')

<?php $page = (isset($_GET['page']) && $_GET['page'] != "")? $_GET['page'] :1;?>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12 mb-2">
                <h3 class="content-header-title">
                    Subscription Orders
                </h3>
            </div>
            <div class="content-header-right col-md-8 col-12">
                <div class="breadcrumbs-top float-md-right">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Subscription Orders
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
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered base-style " id="subscription_orders_table" style="width: 100%; display: table; white-space: nowrap;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Email</th>
                                                    <th>Plan</th>
                                                    <th>Plan Name</th>
                                                    <th>User</th>
                                                    <th>Price</th>
                                                    <th>status</th>
                                                    <th>Paid With</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    {{-- <th>Created Date</th> --}}
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>

                                        </table>
                                    </div>
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
    @include('admin.modals.subscription_orders_modal')
</div>

<!-- END: Content-->

@endsection

@section('local-script')
<!-- BEGIN: Page JS-->

<script>
    $(function() {
        $('#subscription_orders_table').DataTable({
            ajax: '{{ route("subscription-orders-datatable") }}',
            order: [[0, 'desc']],
            processing: true,
            serverSide: true,
            scrollX: false,
            autoWidth: true,
            columnDefs: [
                { width: 1, targets: 0 }
            ],
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'email', name: 'email'},
                {data: 'plan', name: 'plan'},
                {data: 'plan_name', name: 'plan_name'},
                {data: 'user', name: 'user'},
                {data: 'price', name: 'price', orderable: false, searchable: false},
                {data: 'status', name: 'status'},
                {data: 'paid_with', name: 'paid_with'},
                {data: 'subscription_start_date', name: 'subscription_start_date'},
                {data: 'subscription_end_date', name: 'subscription_end_date'},
                // {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            rowCallback: function(row, data) {
                $(row).attr('data-start-date', data.subscription_start_date);
                $(row).attr('data-end-date', data.subscription_end_date);
            }
        });

        $("#subscription_orders_table_wrapper div:first-child").addClass("align-items-baseline");
    });
</script>

<script>
    $(document).on('click', '.edit-subscription-order', function (e) { 
        e.preventDefault();
        let subscriptionOrderId = $(this).closest('tr').attr('id');
        let startDate = $(this).closest('tr').attr('data-start-date');
        let endDate = $(this).closest('tr').attr('data-end-date')
        let updateUrl = "{{ route('subscription-dates-update', ':subscriptionOrderId') }}";
        updateUrl = updateUrl.replace(':subscriptionOrderId', subscriptionOrderId);
        $('#subscriptionOrderModal #subscriptionOrderModalForm').attr('action', updateUrl);
        $('#subscriptionOrderModal #start_date').attr('value', startDate);
        $('#subscriptionOrderModal #end_date').attr('value', endDate);
        $('#subscriptionOrderModal').modal('show');
    });

    $(document).on('submit', '.update-subscription-order-data', function (e) { 
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
                $('#subscriptionOrderModal').modal('hide');
                $('#subscription_orders_table').DataTable().ajax.reload();
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
<!-- END: Page JS-->
@endsection
