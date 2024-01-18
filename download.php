<?php
if(isset($_GET['bookingid'])){
    $bookingid = $_GET['bookingid'];

    // Output PDF to the browser for download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="Booking_Bill_' . $bookingid . '.pdf"');

    // Include the FPDF library and generate the bill
    require_once('./fpdf/fpdf.php'); // Adjust the path based on your project structure
    include('generate_bill.php');

    // Generate the bill
    $bill = generateBillForDownload($bookingid); // Adjust function name as needed

    // Create PDF using FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Booking Bill', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->MultiCell(0, 10, $bill);

    echo $pdf->Output('S'); // Output as string for download
} else {
    echo "Invalid request.";
}
?>
