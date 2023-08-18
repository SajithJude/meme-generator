$(document).ready(function() {
  $('.start-membership').click(function() {
      var selectedPlan = $(this).val();
      $('#selected-plan').val(selectedPlan);
      $('#membership_plan').submit();
  });
});

function paymentPlanFunction() {
  alert('Please select a membership plan first!');
}