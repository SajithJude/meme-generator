<!-- BEGIN: Vendor JS-->
<script src="{{ url('theme/app-assets/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->


<!-- BEGIN: switchery JS-->
<script src="{{ url('theme/app-assets/vendors/js/forms/toggle/switchery.min.js') }}"></script>
<!-- BEGIN switchery JS-->


<!-- BEGIN: jquery steps JS-->
<script src="{{ url('theme/app-assets/vendors/js/extensions/jquery.steps.min.js') }}"></script>
<!-- BEGIN jquery steps JS-->


<!-- BEGIN: moment-with-locales JS-->
<script src="{{ url('theme/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js') }}"></script>
<!-- BEGIN moment-with-locales JS-->


<!-- BEGIN: daterangepicker JS-->
<script src="{{ url('theme/app-assets/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>
<!-- BEGIN daterangepicker JS-->


<!-- BEGIN: jquery.validate JS-->
<script src="{{ url('theme/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<!-- BEGIN jquery.validate JS-->


<!-- BEGIN: Page Vendor JS-->
<script src="{{ url('theme/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"
type="text/javascript"></script>
<!-- END: Page Vendor JS-->
<script src="{{ url('theme/app-assets/vendors/js/extensions/toastr.min.js') }}" type="text/javascript">
</script>


<!-- BEGIN: Theme JS-->
<script src="{{ url('theme/app-assets/js/core/app-menu.min.js') }}" type="text/javascript"></script>
<script src="{{ url('theme/app-assets/js/core/app.min.js') }}" type="text/javascript"></script>
<script src="{{ url('theme/app-assets/js/scripts/customizer.min.js') }}" type="text/javascript"></script>
<script src="{{ url('theme/app-assets/vendors/js/jquery.sharrre.js') }}" type="text/javascript"></script>
<script src="{{ url('theme/app-assets/js/scripts/forms/validation/form-validation.js') }}" type="text/javascript"></script>
{{-- <script src="{{ url('theme/app-assets/js/core/app-menu.js') }}" type="text/javascript"></script> --}}
<script src="{{ url('theme/app-assets/js/core/app.js') }}" type="text/javascript"></script>
<script src="{{ url('theme/app-assets/js/scripts/extensions/toastr.js') }}" type="text/javascript"></script>
<script src="{{ url('theme/app-assets/js/scripts/forms/wizard-steps.js') }}" type="text/javascript"></script>
<script src="{{ url('theme/app-assets/js/scripts/tooltip/tooltip.min.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="{{ asset('backend/vendor/croppie/croppie.min.js?v4.0.2') }}"></script>
<!-- END: Theme JS-->

<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

<script>
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
</script>
<script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

<!-- BEGIN: Custom Js-->
<script src="{{ url('theme/assets/js/scripts.js') }}" type="text/javascript"></script>

<!-- BEGIN: Page JS-->
