//right now it is not used in this project wait for future what will happen
<?php
include('connect.php');

if(!isset($_SESSION['uid'])){
  echo "<script> window.location.href='login.php';  </script>";
}

if(isset($_POST['ticketbook'])){
  $person     = $_POST['person'];
  $date       = $_POST['date'];
  $theaterid  = $_POST['theaterid'];

  $uid = $_SESSION['uid'];

  // Assuming you have a seat chart for the theater, you can fetch it from the database
  $sqlSeatChart = "SELECT * FROM seat_chart WHERE theaterid = ?";
  $stmtSeatChart = $conn->prepare($sqlSeatChart);
  $stmtSeatChart->bind_param("i", $theaterid);
  $stmtSeatChart->execute();
  $resultSeatChart = $stmtSeatChart->get_result();

  if ($resultSeatChart && $resultSeatChart->num_rows > 0) {
    $rowSeatChart = $resultSeatChart->fetch_assoc();
    // Assuming you have a seat chart column in the database
    $seatChart = json_decode($rowSeatChart['seat_chart'], true);
  } else {
    echo "Seat chart not found for this theater.";
    exit;
  }

  // Display seat chart here
  // You can use JavaScript and HTML to create an interactive seat selection interface based on $seatChart
  // For example, you can show available seats as buttons and let users select them

  // Example HTML/JavaScript (replace with your actual implementation)
  echo "
    <html lang='en'>
    <head>
        <!-- Include your head content here -->
    </head>
    <body>
        <h2>Select your seats</h2>
        <form action='seat_selection_process.php' method='post'>
            <input type='hidden' name='theaterid' value='$theaterid'>
            <input type='hidden' name='date' value='$date'>
            <input type='hidden' name='person' value='$person'>
            <div>";

  // Iterate through the seat chart and create buttons for available seats
  foreach ($seatChart as $row => $seats) {
    echo "<div>";
    foreach ($seats as $seat => $status) {
      if ($status == 'available') {
        echo "<button type='button' class='seat' onclick='selectSeat(this)'>$row$seat</button>";
      } else {
        echo "<button type='button' class='unavailable' disabled>$row$seat</button>";
      }
    }
    echo "</div>";
  }

  echo "</div>
        <button type='submit' class='btn btn-primary'>Confirm Booking</button>
        </form>
        <script>
            function selectSeat(seatButton) {
                // Implement logic to track selected seats using JavaScript
                // For example, change button color to indicate selection
                seatButton.style.backgroundColor = 'green';
                // Add hidden input fields to the form to send selected seats to the server
            }
        </script>
    </body>
    </html>";
} else {
  echo "Invalid request.";
  exit;
}
?>
