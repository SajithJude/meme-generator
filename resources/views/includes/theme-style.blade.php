<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css"
    href="{{ url('theme/app-assets/vendors/css/forms/toggle/switchery.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('theme/app-assets/vendors/css/vendors.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('theme/app-assets/vendors/css/extensions/toastr.css') }}">
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('theme/app-assets/css/bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('theme/app-assets/css/bootstrap-extended.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('theme/app-assets/css/colors.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('theme/app-assets/css/components.css') }}">
<!-- END: Theme CSS-->

<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('theme/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('theme/app-assets/css/core/colors/palette-gradient.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('theme/app-assets/css/plugins/extensions/toastr.css') }}">
<!-- END: Page url-->

<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('theme/assets/css/style.css') }}">
<!-- END: Custom CSS-->

<!-- BEGIN: icons CSS-->
<link rel="stylesheet" type="text/css"
    href="{{ url('theme/app-assets/fonts/simple-line-icons/style.min.css') }}">
<!-- END: icons CSS-->

<!-- BEGIN: wizard CSS-->
<link rel="stylesheet" type="text/css" href="{{ url('theme/app-assets/css/plugins/forms/wizard.css') }}">
<link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
<!-- END: wizard CSS-->
<style>
    * {
        scroll-behavior: smooth;
    }

    #DataTables_Table_0_filter,
    #DataTables_Table_1_filter {
        text-align: right
    }

    #DataTables_Table_0_filter label,
    #DataTables_Table_1_filter label {
        text-align: left
    }

    .dataTables_paginate ul {
        justify-content: flex-end
    }

    body.vertical-layout[data-color=bg-gradient-x-purple-blue] .content-wrapper-before, body.vertical-layout[data-color=bg-gradient-x-purple-blue] .navbar-container {
        background-image: linear-gradient(to right, #1c1c1c, #1c1c1c) !important;
    }

    .back-btn-dark {
        background-color: #1c1c1c;
    }
</style>
