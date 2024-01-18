<?php
include('connect.php');
include('generate_bill.php');

// Ensure that FPDF library is included with the correct path
require_once('./fpdf/fpdf.php'); // Adjust the path based on your project structure

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

            // Generate the bill
            $bill = generateBill($bookingDetails['bookingid'], $bookingDetails['title'], $bookingDetails['catname'], $bookingDetails['days'], $bookingDetails['timing'], $bookingDetails['price'], $bookingDetails['bookingdate'], $bookingDetails['location'], $bookingDetails['username']);

            // Create PDF using FPDF
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, 'Booking Bill', 0, 1, 'C');
            $pdf->Ln(10);
            $pdf->MultiCell(0, 10, $bill);

            // Display PDF on the webpage
            echo '<iframe src="data:application/pdf;base64,' . base64_encode($pdf->Output('S')) . '" width="100%" height="600px"></iframe>';

            // Add a download button
            echo '<a href="download.php?bookingid=' . $bookingid . '" target="_blank" download="Booking_Bill_' . $bookingid . '.pdf">Download Bill</a>';

            // Optionally, you can add further actions after generating the PDF if needed

        } else {
            echo "Error fetching booking details.";
        }
    } else {
        echo "Booking is not approved.";
    }
} else {
    echo "Invalid request.";
}
?>
