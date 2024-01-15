<?php 
include('connect.php');

if(!isset($_SESSION['uid'])){
    echo "<script> window.location.href='login.php';  </script>";
}

include('generate_bill.php'); // Include the bill generator

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content remains unchanged -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Booking</title>
</head>
<body>

<?php include('header.php')  ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <table class="table">
                <!-- Table headers remain unchanged -->
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
      </tr>

                <?php
                $uid = $_SESSION['uid'];

                $sql = "SELECT booking.bookingid, booking.bookingdate, booking.person, theater.theater_name, theater.timing, theater.days, theater.price, theater.location, movies.title, categories.catname, users.name AS 'username', booking.status
                        FROM booking
                        INNER JOIN theater ON theater.theaterid = booking.theaterid
                        INNER JOIN users ON users.userid = booking.userid
                        INNER JOIN movies ON movies.movieid = theater.movieid
                        INNER JOIN categories ON categories.catid = movies.catid 
                        WHERE booking.userid = '$uid'";
                
                $res = mysqli_query($con, $sql);

                if(mysqli_num_rows($res) > 0){
                    while($data = mysqli_fetch_array($res)){
                        ?>

                        <tr>
                            <!-- Table data remains unchanged -->  
                            <td><?= $data['bookingid'] ?></td>
            <td><?= $data['theater_name'] ?></td>
            <td><?= $data['title'] ?> - <?= $data['catname'] ?></td>
            <td><?= $data['days'] ?> - <?= $data['timing'] ?></td>       
            <td><?= $data['price'] ?></td>
            <td><?= $data['bookingdate'] ?></td>
            <td><?= $data['location'] ?></td>
            <td><?= $data['username'] ?></td>

                            <td>
                                <?php
                                if($data['status'] == 0){
                                    echo "<a href='#' class='btn btn-warning' > Pending </a>";
                                } else {
                                    echo "<a href='#' class='btn btn-success' > Approved </a>";

                                    // Generate and display the bill
                                    $bill = generateBill($data['bookingid'], $data['title'], $data['catname'], $data['days'], $data['timing'], $data['price'], $data['bookingdate'], $data['location'], $data['username']);
                                    echo $bill;
                                }
                                ?>
                            </td>
                        </tr>

                    <?php
                    }
                } else {
                    echo 'No booking found';
                }
                ?>
            </table>
        </div>
    </div>
</div>

<?php include('footer.php') ?>

</body>
</html>
