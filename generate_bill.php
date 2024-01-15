<!-- generate_bill.php -->
<?php
function generateBill($bookingId, $movieTitle, $category, $days, $timing, $price, $bookingDate, $location, $username)
{
    $billContent = "
        <div>
            <h2>Movie Ticket Bill</h2>
            <p><strong>Booking ID:</strong> $bookingId</p>
            <p><strong>Movie:</strong> $movieTitle - $category</p>
            <p><strong>Date and Time:</strong> $days - $timing</p>
            <p><strong>Price:</strong> $price</p>
            <p><strong>Booking Date:</strong> $bookingDate</p>
            <p><strong>Theater Location:</strong> $location</p>
            <p><strong>User:</strong> $username</p>
        </div>
    ";

    // Save the bill to a file or send it via email, etc.
    // You can customize this part based on your requirements.

    return $billContent;
}
?>
