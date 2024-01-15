<?php
include('../connect.php');

if (!isset($_SESSION['uid'])) {
    echo "<script> window.location.href='../login.php';  </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>
</head>
<body>

<?php include('header.php')  ?>

<div class="container">

    <div class="row">
        <div class="col-lg-6">
            <?php
            // Check if editid is set
            if(isset($_GET['editid'])){
                $editid = $_GET['editid'];
                $edit_sql = "SELECT * FROM `movies` WHERE movieid = '$editid'";
                $edit_res = mysqli_query($con, $edit_sql);
                $edit_data = mysqli_fetch_assoc($edit_res);
                ?>
                <form action="movies.php" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="editid" value="<?= $edit_data['movieid'] ?>">

                    <div class="form-group mb-4">
                        <select name="catid" class="form-control">
                            <option value="">Select Category</option>
                            <?php
                            $cat_sql = "SELECT * FROM `categories`";
                            $cat_res = mysqli_query($con, $cat_sql);
                            while ($cat_data = mysqli_fetch_array($cat_res)) {
                                $selected = ($cat_data['catid'] == $edit_data['catid']) ? "selected" : "";
                                echo "<option value='{$cat_data['catid']}' {$selected}>{$cat_data['catname']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <input type="text" class="form-control" name="title" value="<?= $edit_data['title'] ?>" placeholder="enter title">
                    </div>

                    <div class="form-group mb-4">
                        <input type="text" class="form-control" name="description" value="<?= $edit_data['description'] ?>" placeholder="enter description">
                    </div>

                    <div class="form-group mb-4">
                        <input type="date" class="form-control" name="releasedate" value="<?= $edit_data['releasedate'] ?>">
                    </div>

                    <div class="form-group mb-4">
                        Poster:
                        <input type="file" class="form-control" name="image">
                    </div>

                    <div class="form-group mb-4">
                        Trailer:
                        <input type="file" class="form-control" name="trailer">
                    </div>

                    <div class="form-group mb-4">
                        Video:
                        <input type="file" class="form-control" name="movie">
                    </div>

                    <div class="form-group ">
                        <input type="submit" class="btn btn-info" value="Update" name="update">
                    </div>
                </form>
            <?php } else { ?>
                <form action="movies.php" method="post" enctype="multipart/form-data">

                    <div class="form-group mb-4">
                        <select name="catid" class="form-control">
                            <option value="">Select Category</option>
                            <?php
                            $cat_sql = "SELECT * FROM `categories`";
                            $cat_res = mysqli_query($con, $cat_sql);
                            while ($cat_data = mysqli_fetch_array($cat_res)) {
                                echo "<option value='{$cat_data['catid']}'>{$cat_data['catname']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <input type="text" class="form-control" name="title" placeholder="enter title">
                    </div>

                    <div class="form-group mb-4">
                        <input type="text" class="form-control" name="description" placeholder="enter description">
                    </div>

                    <div class="form-group mb-4">
                        <input type="date" class="form-control" name="releasedate">
                    </div>

                    <div class="form-group mb-4">
                        Poster:
                        <input type="file" class="form-control" name="image">
                    </div>

                    <div class="form-group mb-4">
                        Trailer:
                        <input type="file" class="form-control" name="trailer">
                    </div>

                    <div class="form-group mb-4">
                        Video:
                        <input type="file" class="form-control" name="movie">
                    </div>

                    <div class="form-group ">
                        <input type="submit" class="btn btn-success" value="Add" name="add">
                    </div>
                </form>
            <?php } ?>
        </div>
        <div class="col-lg-6">
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Poster</th>
                    <th>Action</th>
                </tr>

                <?php
                $sql = "SELECT movies.*, categories.catname
                        FROM movies
                        INNER JOIN categories ON categories.catid = movies.catid";
                $res = mysqli_query($con, $sql);
                if (mysqli_num_rows($res) > 0) {
                    while ($data = mysqli_fetch_array($res)) {
                        ?>

                        <tr>
                            <td><?= $data['movieid'] ?></td>
                            <td><?= $data['title'] ?></td>
                            <td><?= $data['catname'] ?></td>

                            <td> <img src="uploads/<?= $data['image'] ?>" height="50" width="50" alt=""> </td>
                            <td>
                                <a href="movies.php?editid=<?= $data['movieid'] ?>" class="btn btn-primary"> Edit</a>
                                <form action="movies.php" method="post" style="display: inline-block;">
                                    <input type="hidden" name="deleteid" value="<?= $data['movieid'] ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    echo 'No movies found';
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
//include('../connect.php');

if (!isset($_SESSION['uid'])) {
    echo "<script> window.location.href='../login.php';  </script>";
}

// Add Movie
if (isset($_POST['add'])) {
    $catid = $_POST['catid'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $releasedate = $_POST['releasedate'];

    $image = $_FILES['image']['name'];
    $tmp_image = $_FILES['image']['tmp_name'];

    $trailer = $_FILES['trailer']['name'];
    $tmp_trailer = $_FILES['trailer']['tmp_name'];

    $movie = $_FILES['movie']['name'];
    $tmp_movie = $_FILES['movie']['tmp_name'];

    move_uploaded_file($tmp_image, "uploads/$image");
    move_uploaded_file($tmp_trailer, "uploads/$trailer");
    move_uploaded_file($tmp_movie, "uploads/$movie");

    $sql = "INSERT INTO `movies`(`title`, `description`, `releasedate`, `image`, `trailer`, `movie`,  `catid`) 
          VALUES ('$title','$description','$releasedate','$image','$trailer','$movie','$catid')";

    if (mysqli_query($con, $sql)) {
        echo "<script> alert('Movie added successfully')</script>";
        echo "<script> window.location.href='movies.php' </script>";
    } else {
        echo "<script> alert('Failed to add movie')</script>";
    }
}

// Update Movie
if (isset($_POST['update'])) {
    $editid = $_POST['editid'];
    $catid = $_POST['catid'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $releasedate = $_POST['releasedate'];

    $image = $_FILES['image']['name'];
    $tmp_image = $_FILES['image']['tmp_name'];

    $trailer = $_FILES['trailer']['name'];
    $tmp_trailer = $_FILES['trailer']['tmp_name'];

    $movie = $_FILES['movie']['name'];
    $tmp_movie = $_FILES['movie']['tmp_name'];

    // Check if a new image is provided
    if (!empty($image)) {
        move_uploaded_file($tmp_image, "uploads/$image");
    }

    // Check if a new trailer is provided
    if (!empty($trailer)) {
        move_uploaded_file($tmp_trailer, "uploads/$trailer");
    }

    // Check if a new movie is provided
    if (!empty($movie)) {
        move_uploaded_file($tmp_movie, "uploads/$movie");
    }

    $update_sql = "UPDATE `movies` SET 
                   `catid`='$catid', 
                   `title`='$title', 
                   `description`='$description', 
                   `releasedate`='$releasedate', 
                   `image`=COALESCE('$image', `image`), 
                   `trailer`=COALESCE('$trailer', `trailer`), 
                   `movie`=COALESCE('$movie', `movie`) 
                   WHERE `movieid`='$editid'";

    if (mysqli_query($con, $update_sql)) {
        echo "<script> alert('Movie updated successfully')</script>";
        echo "<script> window.location.href='movies.php' </script>";
    } else {
        echo "<script> alert('Failed to update movie')</script>";
    }
}

// Delete Movie
if (isset($_POST['deleteid'])) {
    $deleteid = $_POST['deleteid'];
    $delete_sql = "DELETE FROM `movies` WHERE movieid = '$deleteid'";

    if (mysqli_query($con, $delete_sql)) {
        echo "<script> alert('Movie deleted successfully')</script>";
        echo "<script> window.location.href='movies.php' </script>";
    } else {
        echo "<script> alert('Failed to delete movie')</script>";
    }
}
?>
