<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
</head>
<body>
    <form id="stripe-checkout-success-form" action="{{ route('meeting.stripe.checkout.success') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="session_id" value="{{ request()->get('session_id') }}">
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("stripe-checkout-success-form").submit();
        });
    </script>
</body>
</html>
