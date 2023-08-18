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

  $("input[name='phone_number']").on('keyup', function () {
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

  $("input[name='city']").on('keyup', function () {
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


  $( ".loginBtn" ).on("click", function( event ) {
    event.preventDefault();

    $(".emailError").hide();
    $(".passwordError").hide();
    
    var errors = 0;
    var email =  $("input[name='email']");
    var password =  $("input[name='password']");

    if(email.val() == ''){
        errors+=1;
        $(".emailError").show();

        email.css('border-color', 'red');
        email.css('border-style', 'solid');
        email.css('border-width', '1px');

    }

    if(password.val() == '') {
        errors+=1;
        $(".passwordError").show();

        password.css('border-color', 'red');
        password.css('border-style', 'solid');
        password.css('border-width', '1px');

    }
    
    
    if(errors==0){

      $('div.loaderImage').show();
      $("#loginForm").submit();
    }

  
  
  });

  $( ".registerBtn" ).on("click", function( event ) {
    event.preventDefault();

    $(".firstNameError").hide();
    $(".lastNameError").hide();
    $(".phoneNumberError").hide();
    $(".emailError").hide();
    $(".passwordError").hide();
    $(".cpasswordError").hide();
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
    if(phone_number.val() == ''){
        errors+=1;
        $(".phoneNumberError").show();

        phone_number.css('border-color', 'red');
        phone_number.css('border-style', 'solid');
        phone_number.css('border-width', '1px');
    }
    if(email.val() == ''){
        errors+=1;
        $(".emailError").show();

        email.css('border-color', 'red');
        email.css('border-style', 'solid');
        email.css('border-width', '1px');
    }
    if(password.val() == '') {
        errors+=1;
        $(".passwordError").show();

        password.css('border-color', 'red');
        password.css('border-style', 'solid');
        password.css('border-width', '1px');
    }
    if(password_confirmation.val() == '') {
        errors+=1;
        $(".cpasswordError").show();

        password_confirmation.css('border-color', 'red');
        password_confirmation.css('border-style', 'solid');
        password_confirmation.css('border-width', '1px');
    }
    if(city.val() == '') {
        errors+=1;
        $(".cityError").show();

        city.css('border-color', 'red');
        city.css('border-style', 'solid');
        city.css('border-width', '1px');
    }
    
    
    if(errors==0){
      $('div.loaderImage').show();
      $("#registerForm").submit();
    }

  
  
  });
  
</script>