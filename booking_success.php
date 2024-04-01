<!DOCTYPE html>
<html>
<head>
    <title>Booking Success</title>
    <link rel="stylesheet" href="booking_success.css">
</head>
<body>
    <div class="success-message">
        <h1>Booking Successful!</h1>
        <p>Your seats have been successfully booked.</p>
        <p>Thank you for choosing our service.</p>
        <a href="index.php">Go to Dashboard</a>
        <!-- Pay with Cash button and payment code -->
        <form action="cash_payment.php" method="post">
            <input type="hidden" name="booking_id" value="123456"> <!-- Replace "123456" with the actual booking ID -->
            <button type="submit">Pay with Cash</button>
            <button type="button" onclick="window.location.href='payment/index.php';" style="margin-left: 20px;">Esewa</button>
        </form>
    </div>
</body>
</html>
