<script>
    $( ".contactTab" ).on("click", function( event ) {
        event.preventDefault();

        $("#myTabContent .contactTabPane").addClass("fade");
        $("#myTabContent .contactTabPane").addClass("show");
        $("#myTabContent .contactTabPane").addClass("active");


        $("#myTabContent .aboutTabPane").removeClass("show");
        $("#myTabContent .aboutTabPane").removeClass("active");

 
    });

    $( ".aboutTab" ).on("click", function( event ) {
        event.preventDefault();


        $("#myTabContent .contactTabPane").removeClass("show");
        $("#myTabContent .contactTabPane").removeClass("active");


        $("#myTabContent .aboutTabPane").addClass("fade");
        $("#myTabContent .aboutTabPane").addClass("show");
        $("#myTabContent .aboutTabPane").addClass("active");

 
    });
</script>


  
<script type="text/javascript">
    // $( "form" ).on( "submit", function( event ) {
    //   $('div.loaderImage').show();
    // });
  
    $("input[name='first_name']").on('keyup', function () {
      if ($(this).val().length > 0) {
        $(this).css('border-color', 'black');
        $(this).css('border-style', 'solid');
        $(this).css('border-width', '1px');
      }
      else {
        $(this).css('border-color', 'red');
        $(this).css('border-style', 'solid');
        $(this).css('border-width', '1px');
      }
    });
  
    $("input[name='last_name']").on('keyup', function () {
      if ($(this).val().length > 0) {
        $(this).css('border-color', 'black');
        $(this).css('border-style', 'solid');
        $(this).css('border-width', '1px');
      }
      else {
        $(this).css('border-color', 'red');
        $(this).css('border-style', 'solid');
        $(this).css('border-width', '1px');
      }
    });
  
    // $("input[name='phone_number']").on('keyup', function () {
    //   if ($(this).val().length > 0) {
    //     $(this).css('border-color', 'black');
    //     $(this).css('border-style', 'solid');
    //     $(this).css('border-width', '1px');
    //   }
    //   else {
    //     $(this).css('border-color', 'red');
    //     $(this).css('border-style', 'solid');
    //     $(this).css('border-width', '1px');
    //   }
    // });
  
    $("input[name='email']").on('keyup', function () {
      if ($(this).val().length > 0) {
        $(this).css('border-color', 'black');
        $(this).css('border-style', 'solid');
        $(this).css('border-width', '1px');
      }
      else {
        $(this).css('border-color', 'red');
        $(this).css('border-style', 'solid');
        $(this).css('border-width', '1px');
      }
    });
  
    $("input[name='password']").on('keyup', function () {
      if ($(this).val().length > 0) {
        $(this).css('border-color', 'black');
        $(this).css('border-style', 'solid');
        $(this).css('border-width', '1px');
      }
      else {
        $(this).css('border-color', 'red');
        $(this).css('border-style', 'solid');
        $(this).css('border-width', '1px');
      }
    });
  
    $("input[name='password_confirmation']").on('keyup', function () {
      if ($(this).val().length > 0) {
        $(this).css('border-color', 'black');
        $(this).css('border-style', 'solid');
        $(this).css('border-width', '1px');
      }
      else {
        $(this).css('border-color', 'red');
        $(this).css('border-style', 'solid');
        $(this).css('border-width', '1px');
      }
    });
  
    // $("input[name='city']").on('keyup', function () {
    //   if ($(this).val().length > 0) {
    //     $(this).css('border-color', 'black');
    //     $(this).css('border-style', 'solid');
    //     $(this).css('border-width', '1px');
    //   }
    //   else {
    //     $(this).css('border-color', 'red');
    //     $(this).css('border-style', 'solid');
    //     $(this).css('border-width', '1px');
    //   }
    // });
  

    $( ".saveDetailsBtn" ).on("click", function( event ) {
      event.preventDefault();
  
      $(".firstNameError").hide();
      $(".lastNameError").hide();
      $(".phoneNumberError").hide();
      $(".emailError").hide();
      $(".passwordError").hide();
      $(".cpasswordError").hide();
      $(".mpasswordError").hide();
      $(".cityError").hide();
     
      
      var errors = 0;
      
      var first_name =  $("input[name='first_name']");
      var last_name =  $("input[name='last_name']");
      var phone_number =  $("input[name='phone_number']");
      var email =  $("input[name='email']");
      var password =  $("input[name='password']");
      var password_confirmation =  $("input[name='password_confirmation']");
      var city =  $("input[name='city']");
      
  
      if(first_name.val() == ''){
          errors+=1;
          $(".firstNameError").show();
  
          first_name.css('border-color', 'red');
          first_name.css('border-style', 'solid');
          first_name.css('border-width', '1px');
  
      }
      if(last_name.val() == ''){
          errors+=1;
          $(".lastNameError").show();
  
          last_name.css('border-color', 'red');
          last_name.css('border-style', 'solid');
          last_name.css('border-width', '1px');
      }
      // if(phone_number.val() == ''){
      //     errors+=1;
      //     $(".phoneNumberError").show();
  
      //     phone_number.css('border-color', 'red');
      //     phone_number.css('border-style', 'solid');
      //     phone_number.css('border-width', '1px');
      // }
      if(email.val() == ''){
          errors+=1;
          $(".emailError").show();
  
          email.css('border-color', 'red');
          email.css('border-style', 'solid');
          email.css('border-width', '1px');
      }

      if(password.val() != '') {

        if(password_confirmation.val() == '') {

          errors+=1;
          $(".mpasswordError").show();


          password.css('border-color', 'red');
          password.css('border-style', 'solid');
          password.css('border-width', '1px');

          password_confirmation.css('border-color', 'red');
          password_confirmation.css('border-style', 'solid');
          password_confirmation.css('border-width', '1px');

        }
        else if(password.val() != password_confirmation.val() ){

          errors+=1;
          $(".mpasswordError").show();


          password.css('border-color', 'red');
          password.css('border-style', 'solid');
          password.css('border-width', '1px');

          password_confirmation.css('border-color', 'red');
          password_confirmation.css('border-style', 'solid');
          password_confirmation.css('border-width', '1px');

        }

      }

      if(password_confirmation.val() != '') {

        if(password.val() == '') {

          errors+=1;
          $(".mpasswordError").show();


          password.css('border-color', 'red');
          password.css('border-style', 'solid');
          password.css('border-width', '1px');

          password_confirmation.css('border-color', 'red');
          password_confirmation.css('border-style', 'solid');
          password_confirmation.css('border-width', '1px');

        }
        else if(password.val() != password_confirmation.val() ){

          errors+=1;
          $(".mpasswordError").show();


          password.css('border-color', 'red');
          password.css('border-style', 'solid');
          password.css('border-width', '1px');

          password_confirmation.css('border-color', 'red');
          password_confirmation.css('border-style', 'solid');
          password_confirmation.css('border-width', '1px');

        }

      }

      // if(city.val() == '') {
      //     errors+=1;
      //     $(".cityError").show();
  
      //     city.css('border-color', 'red');
      //     city.css('border-style', 'solid');
      //     city.css('border-width', '1px');
      // }
      
      
      if(errors==0){
        $('div.loaderImage').show();
        $("#editProfileForm").submit();
      }
  
    
    
    });

    $('#upload-pimage').click(function(e) {
            e.preventDefault();
            
            elem = $(this);
            //logoctrl = elem.closest('.custom-file').find('.logo');
            logoctrl = $('.custom-file-input');
            
            //console.log('Element');
            //console.log(logoctrl[0].files[0];);
            //console.log(logoctrl.val());
            //return;

            if (logoctrl.val()) {
                let formData = new FormData();
                let file = logoctrl[0].files[0];
                
                formData.append('image', file);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: formData,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType

                    url: 'profileImage',
                    success: function(response) {
                        var response = JSON.parse(response);
                        if (response.success) {

                           console.log(response);
                            return;
                            alert('File uploaded successfully');
                            var controllername = document.getElementById('main-content').getAttribute("ng-controller")
                            var scope = angular.element(document.querySelector('[ng-controller="' + controllername + '"]')).scope();
                          
                            scope.$apply(function() {
                                switch (controllername) {
                                    case "hotelCtrl":
                                    scope.hotel.Thumbnail = response.payload;
                                    break;
                                }
                            })

                        }
                    },
                    error: function(response) {
                      alert(response.responseJSON.errors.image[0]);
                   
                    }
                })

            } else {
                alert('Please select a file to upload');
              
            }

        });
    
    
</script>


<script type="text/javascript">

  function changeImage(input) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        //$('.image_outer').attr('src', e.target.result).width(150).height(200);
        $(".image_outer").css("background-image", "url(" + e.target.result  +")").width(150).height(200);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }



</script>
<script type="text/javascript">
  
  $("form" ).on( "submit", function( event ) {    
    $('div.loaderImage').show();
    });

 // $('button').on('click',function(){
 //        $('div.loaderImage').show();

 //    })

  
</script>