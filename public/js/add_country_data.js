$(document).on('click', '.addCountry', function () {
    var country_id = $(this).attr('country_id');
    var arabic_name = document.getElementById('arabic_name').value;
    console.log(arabic_name);
    alert(arabic_name);
    var is_added = 1;
    var event = $(this);
    alert(country_id);
    addData(event, country_id, arabic_name, is_added);

});

function addData(event, country_id, arabic_name, is_added) {
    let order = [];
    let token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        data: {
            id: country_id,
            is_added: is_added,
            arabic_name: arabic_name,
            order: order,
            _token: token
        },
        url: siteUrl + 'addCountry',

        success: function (data) {
            if (data.success) {

                console.log(data);
                console.log(" Added successfully");
                alert("Added successfully");
                toastr.success("success Added successfully");
                setTimeout(function () {
                    location.reload(1);
                }, 1000);
            } else {
                console.log("Error Occurred");
                alert("Error Occurred");
            }
        },
        error: function () {
            console.log("Error Occurred");
            alert("Error Occurred");
        },
    });
}