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
    <title>Dashboard</title>
</head>
<body>

<?php include('header.php'); ?>

<div class="container text-center">
    <h4>Welcome to Admin dashboard!!</h4>

    <div class="row">

        <div class="col-lg-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <h5>CATEGORIES</h5>
                        <?php
                            $sql = "SELECT COUNT(catid) AS 'category' FROM `categories`";
                            $res  = mysqli_query($con, $sql);
                            $catdata = mysqli_fetch_array($res);
                        ?>
                        <h6><?=$catdata['category']?></h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <h5>MOVIES</h5>
                        <?php
                            $sql = "SELECT COUNT(movieid) AS 'total_movies' FROM `movies`";
                            $res  = mysqli_query($con, $sql);
                            $moviedata = mysqli_fetch_array($res);
                        ?>
                        <h6><?=$moviedata['total_movies']?></h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <h5>THEATER</h5>
                        <?php
                            $sql = "SELECT COUNT(theaterid) AS 'total_theater' FROM `theater`";
                            $res  = mysqli_query($con, $sql);
                            $theaterdata = mysqli_fetch_array($res);
                        ?>
                        <h6><?=$theaterdata['total_theater']?></h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <h5>BOOKING</h5>
                        <?php
                            $sql = "SELECT COUNT(bookingid) AS 'total_booking' FROM `booking`";
                            $res  = mysqli_query($con, $sql);
                            $bookingdata = mysqli_fetch_array($res);
                        ?>
                        <h6><?=$bookingdata['total_booking']?></h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <h5>USERS</h5>
                        <?php
                            $sql = "SELECT COUNT(userid) AS 'total_users' FROM `users` WHERE roteype = 2";
                            $res  = mysqli_query($con, $sql);
                            $userdata = mysqli_fetch_array($res);
                        ?>
                        <h6><?=$userdata['total_users']?></h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <h5>SALES</h5>
                        <?php
                            $sql = "SELECT SUM(theater.price) AS 'total_sale' 
                                    FROM theater
                                    INNER JOIN booking ON theater.movieid = booking.movie_id";
                            $res  = mysqli_query($con, $sql);
                            $salesdata = mysqli_fetch_array($res);
                        ?>
                        <h6><?=$salesdata['total_sale']?></h6>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php include('footer.php'); ?>

</body>
</html>
