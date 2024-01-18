<?php
include('../connect.php');

// Check if the user is not logged in
if(!isset($_SESSION['uid'])){
  // Redirect to the login page
  echo "<script> window.location.href='../login.php';  </script>";
  exit(); // Stop executing further code
}

// Check if the editbookingid is set in the URL
if(isset($_GET['editbookingid'])){
  $editBookingId = $_GET['editbookingid'];

  // Fetch the existing booking details from the database based on $editBookingId
  $editSql = "SELECT * FROM `booking` WHERE bookingid = '$editBookingId'";
  $editResult = mysqli_query($con, $editSql);

  if($editResult && mysqli_num_rows($editResult) > 0){
    $editData = mysqli_fetch_array($editResult);
  } else {
    // Handle error if the booking details are not found
    echo "<script> alert('Booking details not found for editing.'); </script>";
    // Redirect to the viewallbooking.php page or any other page as needed
    echo "<script> window.location.href='viewallbooking.php'; </script>";
    exit();
  }
} else {
  // If editbookingid is not set in the URL, redirect to the viewallbooking.php page
  echo "<script> window.location.href='viewallbooking.php'; </script>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
</head>
<body>

<?php include('header.php') ?>

<div class="container" style="margin-top:100px!important;">
  <h2>Edit Booking</h2>

  <form action="process_editbooking.php" method="post">
    <!-- Add input fields for the booking details you want to edit -->
    <input type="hidden" name="editbookingid" value="<?php echo $editBookingId; ?>">

    <label for="bookingdate">Booking Date:</label>
    <input type="date" name="bookingdate" value="<?php echo htmlspecialchars($editData['bookingdate'] ?? ''); ?>" class="form-control">

    <label for="person">Person:</label>
    <input type="text" name="person" value="<?php echo htmlspecialchars($editData['person'] ?? ''); ?>" class="form-control">

    <label for="userid">User ID:</label>
    <input type="text" name="userid" value="<?php echo htmlspecialchars($editData['userid'] ?? ''); ?>" class="form-control">

    <label for="seat">Seat:</label>
    <input type="text" name="seat" value="<?php echo htmlspecialchars($editData['seat'] ?? ''); ?>" class="form-control">

    <label for="status">Status:</label>
    <select name="status" class="form-control">
        <option value="0" <?php echo ($editData['status'] == 0) ? 'selected' : ''; ?>>Pending</option>
        <option value="1" <?php echo ($editData['status'] == 1) ? 'selected' : ''; ?>>Approved</option>
    </select>

    <!-- Add more input fields as needed -->

    <input type="submit" name="btnedit" value="Update Booking" class="btn btn-primary">
</form>



</div>

<?php include('footer.php') ?>

</body>
</html>
