<?php 
include('../connect.php');

if(!isset($_SESSION['uid'])){
  echo "<script> window.location.href='../login.php';  </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theater</title>
</head>
<body>

<?php include('header.php')  ?>

<div class="container">

<div class="row">
  <div class="col-lg-6">
    <!-- Add/Edit Theater Form -->
    <form action="theater.php" method="post" enctype="multipart/form-data">
      <?php
        // If editid is present in the URL, fetch theater data for editing
        if(isset($_GET['editid'])){
          $editid = $_GET['editid'];
          $edit_sql = "SELECT * FROM `theater` WHERE `theaterid` = '$editid'";
          $edit_res = mysqli_query($con, $edit_sql);
          $edit_data = mysqli_fetch_array($edit_res);
      ?>
          <input type="hidden" name="editid" value="<?= $edit_data['theaterid'] ?>">
      <?php } ?>
      
      <div class="form-group mb-4">
         <input type="text" class="form-control" name="theater_name" value="<?= isset($edit_data) ? $edit_data['theater_name'] : '' ?>" >
      </div>

      <div class="form-group mb-4">
         <select name="movieid" class="form-control">
          <option value="">Select Movies</option>
          <?php
            $sql = "SELECT * FROM `movies`";
            $res  = mysqli_query($con, $sql);
            if(mysqli_num_rows($res) > 0){
              while($data = mysqli_fetch_array($res)){
                $selected = (isset($edit_data) && $edit_data['movieid'] == $data['movieid']) ? 'selected' : '';
          ?>
                <option value="<?= $data['movieid'] ?>" <?= $selected ?>> <?= $data['title'] ?> </option>
          <?php   
              }
            } else {
          ?>
              <option value="" disabled>No Movies found</option>
          <?php
            }  
          ?> 
         </select>
      </div>

      <div class="form-group mb-4">
        <input type="time" class="form-control" name="timing" value="<?= isset($edit_data) ? $edit_data['timing'] : '' ?>">
      </div>

      <div class="form-group mb-4">
        <input type="text" class="form-control" name="days" value="<?= isset($edit_data) ? $edit_data['days'] : '' ?>" placeholder="enter days">
      </div>

      <div class="form-group mb-4">
        <input type="date" class="form-control" name="date" value="<?= isset($edit_data) ? $edit_data['date'] : '' ?>">
      </div>

      <div class="form-group mb-4">
        <input type="number" class="form-control" name="price" value="<?= isset($edit_data) ? $edit_data['price'] : '' ?>" placeholder="enter price">
      </div>

      <div class="form-group mb-4">
        <input type="text" class="form-control" name="location" value="<?= isset($edit_data) ? $edit_data['location'] : '' ?>" placeholder="enter location">
      </div>

      <div class="form-group ">
        <?php
          if(isset($edit_data)){
        ?>
            <input type="submit" class="btn btn-primary" value="Update Theater" name="update">
        <?php
          } else {
        ?>
            <input type="submit" class="btn btn-primary" value="Add Theater" name="add">
        <?php
          }
        ?>
      </div>
    </form>
  </div>

  <div class="col-lg-6">
    <!-- Display Theaters Table -->
     <table class="table">
      <tr>
        <th>#</th>
        <th>Theater</th>
        <th>Movie</th>
        <th>Category</th>
        <th>Date</th>
        <th>Days/Time</th>
        <th>Ticket</th>
        <th>Location</th>
        <th>Action</th>
      </tr>
      
      <?php
      $sql = "SELECT theater.*, movies.title, categories.catname
      from theater
      inner join movies on movies.movieid = theater.movieid
      inner join categories on categories.catid = movies.catid";
      $res  = mysqli_query($con, $sql);
      if(mysqli_num_rows($res) > 0){
        while($data = mysqli_fetch_array($res)){
          ?>
          <tr>
            <td><?= $data['theaterid'] ?></td>
            <td><?= $data['theater_name'] ?></td>
            <td><?= $data['title'] ?></td>
            <td><?= $data['catname'] ?></td>
            <td><?= $data['date'] ?></td>
            <td><?= $data['days'] ?> - <?= $data['timing'] ?></td>
            <td><?= $data['price'] ?></td>
            <td><?= $data['location'] ?></td>
            <td>
              <a href="theater.php?editid=<?= $data['theaterid'] ?>" class="btn btn-primary"> Edit</a>
              <a href="theater.php?deleteid=<?= $data['theaterid'] ?>" class="btn btn-danger"> Delete</a>
            </td>
          </tr>
       <?php
        }
      } else {
        echo '<tr><td colspan="9">No theaters found</td></tr>';
      }
      ?>
     </table>
  </div>
</div>

</div>

<?php include('footer.php')  ?>

</body>
</html>

<?php
// Add Theater Logic
if(isset($_POST['add'])){
  $movieid = $_POST['movieid'];
  $theater_name = $_POST['theater_name'];
  $days = $_POST['days'];
  $timing = $_POST['timing'];
  $price = $_POST['price'];
  $date = $_POST['date'];
  $location = $_POST['location'];

  $sql = "INSERT INTO `theater`(`theater_name`,`timing`, `days`, `date`, `price`, `location`, `movieid`) VALUES ('$theater_name','$timing','$days','$date','$price','$location','$movieid')";

  if(mysqli_query($con, $sql)){
    echo "<script> alert('Theater added')</script>";
    echo "<script> window.location.href='theater.php' </script>";
  } else {
    echo "<script> alert('Theater not added')</script>";
  }
}

// Update Theater Logic
if(isset($_POST['update'])){
  $editid = $_POST['editid'];
  $movieid = $_POST['movieid'];
  $theater_name = $_POST['theater_name'];
  $days = $_POST['days'];
  $timing = $_POST['timing'];
  $price = $_POST['price'];
  $date = $_POST['date'];
  $location = $_POST['location'];

  $update_sql = "UPDATE `theater` SET `theater_name`='$theater_name',`timing`='$timing',`days`='$days',`date`='$date',`price`='$price',`location`='$location',`movieid`='$movieid' WHERE `theaterid`='$editid'";

  if(mysqli_query($con, $update_sql)){
    echo "<script> alert('Theater updated')</script>";
    echo "<script> window.location.href='theater.php' </script>";
  } else {
    echo "<script> alert('Theater not updated')</script>";
  }
}

// Delete Theater Logic
if(isset($_GET['deleteid'])){
  $deleteid = $_GET['deleteid'];
  $delete_sql = "DELETE FROM `theater` WHERE `theaterid`='$deleteid'";
  
  if(mysqli_query($con, $delete_sql)){
    echo "<script> alert('Theater deleted')</script>";
    echo "<script> window.location.href='theater.php' </script>";
  } else {
    echo "<script> alert('Theater not deleted')</script>";
  }
}
?>
