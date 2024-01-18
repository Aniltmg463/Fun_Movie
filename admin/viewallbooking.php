<?php 
include('../connect.php');

if(!isset($_SESSION['uid'])){
  echo "<script> window.location.href='../login.php';  </script>";
  exit(); // Stop executing further code
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
</head>
<body>

<?php include('header.php') ?>

<div class="container" style="margin-top:100px!important;">
  <form action="viewallbooking.php" method="post">
    <div class="row">
      <div class="col-lg-3">
        <input type="date" name="start" class="form-control">
      </div>
      <div class="col-lg-3">
        <input type="date" name="end" class="form-control">
      </div>
      <div class="col-lg-3">
         <select name="status" id="" class="form-control">
          <option value="">Select Status</option>
          <option value="0">Pending</option>
          <option value="1">Approve</option>
         </select>
      </div>
      <div class="col-lg-3">
        <input type="submit" name="btnsearch" value="Search" class="btn btn-success">
      </div>
    </div>
  </form>
</div>

<div class="container">
   
  <div class="row mt-5">
    <div class="col-lg-12">
      <table class="table">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Category</th>
          <th>Date</th>
          <th>Days/Time</th>
          <th>Ticket</th>
          <th>Location</th>
          <th>User</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
        
        <?php
        if(isset($_POST['btnsearch'])){
          $start  = $_POST['start'];
          $end    = $_POST['end'];
          $status = $_POST['status'];
  
          $total_sale = 0;
  
          $sql = "SELECT booking.bookingid, booking.bookingdate, booking.person, theater.theater_name, theater.timing, theater.days, theater.price, theater.location, movies.title, categories.catname, users.name as 'username',
          booking.status
          FROM booking
          INNER JOIN theater ON theater.theaterid = booking.theaterid
          INNER JOIN users ON users.userid = booking.userid
          INNER JOIN movies ON movies.movieid = theater.movieid
          INNER JOIN categories ON categories.catid = movies.catid
          WHERE booking.bookingdate BETWEEN '$start' AND '$end' AND booking.status = '$status'";
          $res  = mysqli_query($con, $sql);
          if(mysqli_num_rows($res) > 0){
            while($data = mysqli_fetch_array($res)){
              $total_sale = $total_sale + $data['price'];
  
              ?>
              <tr>
                <td><?= $data['bookingid'] ?></td>
                <td><?= $data['theater_name'] ?></td>
                <td><?= $data['title'] ?> - <?= $data['catname'] ?></td>
                <td><?= $data['bookingdate'] ?></td>
                <td><?= $data['days'] ?> - <?= $data['timing'] ?></td>       
                <td><?= $data['price'] ?></td>
                <td><?= $data['location'] ?></td>
                <td><?= $data['username'] ?></td>
         
                <td>
                  <?php
                  if($data['status'] == 0){
                    echo "<a href='#' class='btn btn-warning' > Pending </a>";
                  }else{
                    echo "<a href='#' class='btn btn-success' > Approved </a>";
                  }
                  ?>
                </td>
               
                <td>
                  <?php
                  if($data['status'] == 1){
                    echo "<button type='button' class='btn btn-light' disabled> Completed </button>";
                  }else{
                    echo "<a href='viewallbooking.php?bookingid=".$data['bookingid']."' class='btn btn-primary'> Approve</a>";
                    echo "<a href='viewallbooking.php?deletebookingid=".$data['bookingid']."' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this booking?\")'> Delete</a>";
                  }
                  ?>
                </td>
              </tr>
              <?php
            }
            echo "<tr> <td>Total Sale: <strong> Rs.".$total_sale." </strong></td> </tr>";
          }
        }else{
          $sql = "SELECT booking.bookingid, booking.bookingdate, booking.person, theater.theater_name, theater.timing, theater.days, theater.price, theater.location, movies.title, categories.catname, users.name as 'username',
          booking.status
          FROM booking
          INNER JOIN theater ON theater.theaterid = booking.theaterid
          INNER JOIN users ON users.userid = booking.userid
          INNER JOIN movies ON movies.movieid = theater.movieid
          INNER JOIN categories ON categories.catid = movies.catid";
          $res  = mysqli_query($con, $sql);
          if(mysqli_num_rows($res) > 0){
            while($data = mysqli_fetch_array($res)){
              ?>
              <tr>
                <td><?= $data['bookingid'] ?></td>
                <td><?= $data['theater_name'] ?></td>
                <td><?= $data['title'] ?> - <?= $data['catname'] ?></td>
                <td><?= $data['bookingdate'] ?></td>
                <td><?= $data['days'] ?> - <?= $data['timing'] ?></td>       
                <td><?= $data['price'] ?></td>
                <td><?= $data['location'] ?></td>
                <td><?= $data['username'] ?></td>
                <td>
                  <?php
                  if($data['status'] == 0){
                    echo "<a href='#' class='btn btn-warning' > Pending </a>";
                  }else{
                    echo "<a href='#' class='btn btn-success' > Approved </a>";
                  }
                  ?>
                </td>
                <td>
                  <?php
                  if($data['status'] == 1){
                    echo "<button type='button' class='btn btn-light' disabled> Completed </button>";
                    echo "<a href='viewallbooking.php?editbookingid=".$data['bookingid']."' class='btn btn-warning'> Edit</a>";
                    echo "<a href='viewallbooking.php?deletebookingid=".$data['bookingid']."' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this booking?\")'> Delete</a>";
                  }else{
                    echo "<a href='viewallbooking.php?bookingid=".$data['bookingid']."' class='btn btn-primary'> Approve</a>";
                    echo "<a href='viewallbooking.php?editbookingid=".$data['bookingid']."' class='btn btn-warning'> Edit</a>";
                    echo "<a href='viewallbooking.php?deletebookingid=".$data['bookingid']."' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this booking?\")'> Delete</a>";
                  }
                  ?>
                </td>
              </tr>
              <?php
            }
          }else{
            echo 'No booking found';
          }
        }
        ?>
      </table>
    </div>
  </div>
</div>

<?php include('footer.php') ?>

</body>
</html>

<?php
if(isset($_GET['bookingid'])){
  $bookingid  = $_GET['bookingid'];
  $sql = "UPDATE `booking` SET `status`= 1 WHERE bookingid = '$bookingid'";
  if(mysqli_query($con,$sql)){
    echo "<script> alert('Booking approved successfully!!') </script>";
    echo "<script> window.location.href='viewallbooking.php';  </script>";
  }else{
    echo "<script> alert('Not approved successfully!!') </script>";
  }
}


if(isset($_GET['editbookingid'])){
  $editBookingId = $_GET['editbookingid'];

  // Fetch the existing booking details from the database based on $editBookingId
  $editSql = "SELECT * FROM `booking` WHERE bookingid = '$editBookingId'";
  $editResult = mysqli_query($con, $editSql);

  if($editResult && mysqli_num_rows($editResult) > 0){
    $editData = mysqli_fetch_array($editResult);

    // Assuming you have an editbooking.php page for handling edits
    // You can pass the booking details as URL parameters
    $editUrl = "editbooking.php?editbookingid=".$editBookingId."&name=".$editData['name']."&other_field=".$editData['other_field'];

    // Redirect to the editbooking.php page with the booking details
    echo "<script> window.location.href='$editUrl'; </script>";
  } else {
    // Handle error if the booking details are not found
    echo "<script> alert('Booking details not found for editing.'); </script>";
  }
}



if(isset($_GET['deletebookingid'])){
  $deleteBookingId = $_GET['deletebookingid'];
  $deleteSql = "DELETE FROM `booking` WHERE bookingid = '$deleteBookingId'";
  if(mysqli_query($con, $deleteSql)){
    echo "<script> alert('Booking deleted successfully!!') </script>";
    echo "<script> window.location.href='viewallbooking.php';  </script>";
  }else{
    echo "<script> alert('Failed to delete booking!!') </script>";
  }
}
?>
