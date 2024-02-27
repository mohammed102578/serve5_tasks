<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Payment</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #responseError {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <h1>Enter Payment Amount</h1>
    <form id="paymentForm">
        @csrf
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" required>
        <button type="submit">Pay with PayPal</button>
        <div id="responseError"></div>
    </form>

    <script>
        $(document).ready(function() {
            $('#paymentForm').submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ route('process.payment') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Redirect to paypal  successful payment
                        window.location.href = response.data.paypal_link;
                    },
                    error: function(xhr, status, error) {
                        $('#responseError').html('someThing Went Wrong');
                    }
                });
            });
        });
    </script>
</body>

</html>