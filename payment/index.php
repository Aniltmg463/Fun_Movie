<?php
include 'setting.php';

?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Movie Ticket Booking</title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
    

    <div class="card" style="width:400px">
    <img src="abc.JPG" alt="Thulo IMS" class="card-img-top">
    <div class="card-body">
    <div class="card-title">
    Purchase Online Movie Tickets
    </div>
    <div class="card-text">You can use this esewa wallet to purchase in Nepal </div>
    <form action=<?php echo $epay_url?> method="POST">
    <input value="1000" name="tAmt" type="hidden">
    <input value="900" name="amt" type="hidden">
    <input value="50" name="txAmt" type="hidden">
    <input value="20" name="psc" type="hidden">
    <input value="30" name="pdc" type="hidden">
    <input value=<?php echo $merchant_code?>  name="scd" type="hidden">
    <input value="<?php echo $pid?>" name="pid" type="hidden">
    <input value=<?php echo $successurl?> type="hidden" name="su">
    <input value=<?php echo $failedurl?> type="hidden" name="fu">
    <input value="Pay with Esewa Rs 500" type="submit" class="btn btn-primary">
    </form>
    </div>
    </div>



    <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>