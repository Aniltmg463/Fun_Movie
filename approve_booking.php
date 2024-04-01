<?php
include('connect.php');
include('generate_bill.php');

// Ensure that FPDF library is included with the correct path
require_once('./fpdf/fpdf.php'); // Adjust the path based on your project structure

if(isset($_GET['bookingid'])){
    $bookingid = $_GET['bookingid'];

    // Check if the booking exists and is approved
    $checkBookingQuery = "SELECT * FROM booking WHERE bookingid = '$bookingid' AND status = 'Approved'";
    $checkBookingResult = mysqli_query($con, $checkBookingQuery);

    if(mysqli_num_rows($checkBookingResult) > 0){
        // Fetch booking details for generating the bill
        $bookingDetailsQuery = "SELECT booking.bookingid, booking.booking_date, booking.show_date, booking.show_time, booking.total_price, theater.theater_name, theater.timing, theater.days, theater.price, theater.location, movies.title, categories.catname, users.name AS 'username'
                                FROM booking
                                INNER JOIN theater ON theater.movieid = booking.movie_id
                                INNER JOIN users ON users.userid = booking.user_id
                                INNER JOIN movies ON movies.movieid = booking.movie_id
                                INNER JOIN categories ON categories.catid = movies.catid 
                                WHERE booking.bookingid = '$bookingid'";
        $bookingDetailsResult = mysqli_query($con, $bookingDetailsQuery);

        if(mysqli_num_rows($bookingDetailsResult) > 0){
            $bookingDetails = mysqli_fetch_assoc($bookingDetailsResult);

            // Generate the bill
            $bill = generateBill($bookingDetails['bookingid'], $bookingDetails['title'], $bookingDetails['catname'], $bookingDetails['days'], $bookingDetails['timing'], $bookingDetails['price'], $bookingDetails['booking_date'], $bookingDetails['location'], $bookingDetails['username']);

            // Create PDF using FPDF
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, 'Booking Bill', 0, 1, 'C');
            $pdf->Ln(10);
            $pdf->MultiCell(0, 10, $bill);

            // Output PDF to a temporary file
            $tempFilePath = tempnam(sys_get_temp_dir(), 'booking_bill_');
            $pdf->Output($tempFilePath, 'F');

            // Provide the file for download
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="Booking_Bill_' . $bookingid . '.pdf"');
            header('Content-Length: ' . filesize($tempFilePath));
            readfile($tempFilePath);

            // Delete temporary file
            unlink($tempFilePath);
            exit();
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
