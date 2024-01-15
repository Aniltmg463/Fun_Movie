<?php
include('connect.php');
include('generate_bill.php');

if(isset($_GET['bookingid'])){
    $bookingid = $_GET['bookingid'];

    // Check if the booking exists and is approved
    $checkBookingQuery = "SELECT * FROM booking WHERE bookingid = '$bookingid' AND status = 1";
    $checkBookingResult = mysqli_query($con, $checkBookingQuery);

    if(mysqli_num_rows($checkBookingResult) > 0){
        // Fetch booking details for generating the bill
        $bookingDetailsQuery = "SELECT booking.bookingid, booking.bookingdate, booking.person, theater.theater_name, theater.timing, theater.days, theater.price, theater.location, movies.title, categories.catname, users.name AS 'username'
                                FROM booking
                                INNER JOIN theater ON theater.theaterid = booking.theaterid
                                INNER JOIN users ON users.userid = booking.userid
                                INNER JOIN movies ON movies.movieid = theater.movieid
                                INNER JOIN categories ON categories.catid = movies.catid 
                                WHERE booking.bookingid = '$bookingid'";
        $bookingDetailsResult = mysqli_query($con, $bookingDetailsQuery);

        if(mysqli_num_rows($bookingDetailsResult) > 0){
            $bookingDetails = mysqli_fetch_assoc($bookingDetailsResult);

            // Generate and display the bill
            $bill = generateBill($bookingDetails['bookingid'], $bookingDetails['title'], $bookingDetails['catname'], $bookingDetails['days'], $bookingDetails['timing'], $bookingDetails['price'], $bookingDetails['bookingdate'], $bookingDetails['location'], $bookingDetails['username']);
            echo $bill;

            // You can add any additional actions after generating the bill if needed
        } else {
            echo "Error fetching booking details.";
        }
    } else {
        echo "Invalid booking ID or booking is not approved.";
    }
} else {
    echo "Invalid request.";
}
?>
