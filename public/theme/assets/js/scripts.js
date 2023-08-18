(function (window, undefined) {
    'use strict';

    /*
     NOTE:
     ------
     PLACE HERE YOUR OWN JAVASCRIPT CODE IF NEEDED
     WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR JAVASCRIPT CODE PLEASE CONSIDER WRITING YOUR SCRIPT HERE.  */

    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });
    // let multi_select_dropdown = new Choices('.multi_select_dropdown', {
    //     removeItemButton: true,
    // });

    function ajaxCall(url, type, data = {}) {
        $.ajax({
            url: url,
            type: type,
            data: data,
            success: function (data) {
                if (data.status) {
                    toastr.success(data.message, 'Alert Message');
                    $("#boat_type_modal").modal('hide')
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else {
                    toastr.error(data.message, 'Alert Message');

                }

            }
        });

    }

    $(document).on('click', ".deleteBoatType", function () {
        var boat_type_uuid = $(this).attr('data-uuid');
        $("#boat_type_modal").modal('show').attr('data-uuid', boat_type_uuid);
    });

    $(document).on('click', "#yesDeleteBoatType", function () {
        var boat_type_uuid = $("#boat_type_modal").attr('data-uuid');
        $.ajax({
            url: siteUrl + 'boatTypes/' + boat_type_uuid,
            type: 'DELETE',
            success: function (data) {
                if (data.status) {
                    toastr.success(data.message, 'Boat Type');
                    $("#boat_type_modal").modal('hide')
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else {
                    toastr.error(data.message, 'Boat Type');

                }

            }
        });
    });

    function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#boat_type_picture_preview').attr('src', e.target.result).removeClass('hidden');
            }

            reader.readAsDataURL(input.files[0]);
            $("#" + id).removeClass('hidden');
        }
    }

    // for image preview
    /*** Sub Category Related Code ***/
    $(document).on('change', "#boat_type_picture", function () {
        readURL(this, 'delete_boat_type_picture');
    });

    $(document).on('click', "#delete_boat_type_picture", function () {
        $('#boat_type_picture').val('');
        $('#boat_type_picture_preview').attr('src', '').addClass('hidden');
        $(this).addClass('hidden');

    });

    $(document).on('click', ".cancelClick", function () {
        $('#picture_preview').attr('src', '');
        $("#deleteCategoryPicture").addClass('hidden');
    });


    //reported post

    $(document).on('click', ".reported_post", function () {
        var reported_post_uuid = $(this).attr('data-uuid');
        var type = $(this).attr('data-type');
        var modalBtnText = $(this).attr('data-modalBtnText');
        $("#reported_post_modal").modal('show').attr('data-uuid', reported_post_uuid);
        $("#reported_post_modal").modal('show').attr('data-type', type);
        $("#reported_post_modal").find('#yes_block_reported_post').text(modalBtnText);
    });

    $(document).on('click', "#yes_block_reported_post", function () {
        var reported_post_uuid = $("#reported_post_modal").attr('data-uuid');
        var type = $("#reported_post_modal").attr('data-type');
        var reason = $("#reported_post_reason_for_block").val();

        $.ajax({
            url: siteUrl + 'stories/reported/' + reported_post_uuid,
            type: 'PUT',
            data: {
                reason,
                type
            },
            success: function (data) {
                if (data.status) {
                    toastr.success(data.message, 'Boat Type');
                    $("#boat_type_modal").modal('hide')
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else {
                    toastr.error(data.message, 'Boat Type');

                }

            }
        });
    });
    // Wizard tabs with icons setup
    $(".boat-detail-tab-steps").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        enableAllSteps: true,
        // enableFinishButton:false,
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: 'Update'
        },

        onFinished: function (event, currentIndex) {
            let url = siteUrl + 'boat/' + $('#form_wizard_boat_uuid').val()
            let is_approved = $('#form_wizard_boat_action_type').val()
            is_approved = is_approved == 1 ? 0 : 1
            ajaxCall(url, 'PUT', {
                is_approved
            })
        }
    });

    $(document).on('click', ".commonModal", function () {
        var uuid = $(this).attr('data-uuid');
        $("#common_modal").modal('show').attr('data-uuid', uuid);
    });
    $(document).on('click', "#delete_boat_default_service", function () {
        let uuid = $("#common_modal").attr('data-uuid');
        let url = siteUrl + 'boatServices/' + uuid
        ajaxCall(url, 'DELETE', {})

    });

    $(document).on('click', "#delete_boat_required_document", function () {
        let uuid = $("#common_modal").attr('data-uuid');
        let url = siteUrl + 'requiredDocuments/' + uuid
        ajaxCall(url, 'DELETE', {})

    });

    //update product
    $(document).on('click', "#step_1_update", function () {
        const boat_type_id = $('#boat_type_id').val()
        // let data={
        //     boat_type_id:boat_type_id
        // }
        let url = siteUrl + 'boat/' + $('#form_wizard_boat_uuid').val()
        ajaxCall(url, 'PUT', {
            boat_type_id
        });
    });

    $(document).on('click', ".delete_boat_custom_service_btn", function () {
        let boat_uuid = $(this).attr('data-boat-uuid');
        let service_uuid = $(this).attr('data-boat-service-uuid');

        $("#common_modal").modal('show').attr('data-boat-uuid', boat_uuid)
                .attr('data-boat-service-uuid', service_uuid);
    });

    $(document).on('click', "#delete_boat_custom_service_modal", function () {
        let boat_uuid = $("#common_modal").attr('data-boat-uuid');
        let service_uuid = $("#common_modal").attr('data-boat-service-uuid');
        let url = siteUrl + 'boat/serviceDelete/' + service_uuid + '/' + boat_uuid
        ajaxCall(url, 'DELETE')

    });
    $(document).on('click', ".reported_boat", function () {
        var boat_uuid = $(this).attr('data-uuid');
        var type = $(this).attr('data-type');
        var modalBtnText = $(this).attr('data-modalBtnText');
        $("#reported_boat_modal").modal('show').attr('data-uuid', boat_uuid);
        $("#reported_boat_modal").modal('show').attr('data-type', type);
        $("#reported_boat_modal").find('#yes_block_reported_post').text(modalBtnText);
    });

    $(document).on('click', "#yes_block_boat", function () {
        var report_uuid = $("#reported_boat_modal").attr('data-uuid');
        var type = $("#reported_boat_modal").attr('data-type');
        var reason = $("#reported_boat_reason_for_block").val();

        $.ajax({
            url: siteUrl + 'boats/reported/' + report_uuid,
            type: 'PUT',
            data: {
                reason,
                type
            },
            success: function (data) {
                if (data.status) {
                    toastr.success(data.message, 'Boat Type');
                    $("#boat_type_modal").modal('hide')
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else {
                    toastr.error(data.message, 'Boat Type');

                }

            }
        });
    });


})(window);
