<!-- generate_bill.php -->
<?php
function generateBill($bookingId, $movieTitle, $category, $days, $timing, $price, $bookingDate, $location, $username)
{
    $billContent = "
            Movie Ticket Bill
            Booking ID: $bookingId
            Movie: $movieTitle - $category
            Date and Time: $days - $timing
            Price: $price
            Booking Date: $bookingDate
            Theater Location: $location
            User: $username
        
    ";

    // Save the bill to a file or send it via email, etc.
    // You can customize this part based on your requirements.

    return $billContent;
}
?>
