<?php
require_once("..\components\db_connect.php");
require_once('..\components\file_upload.php');
session_start();
if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: ../user/login.php");
    exit();
}
if (isset($_SESSION["user"])) {
    header("Location : ../home.php");
    exit();
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $photo = fileUpload($_FILES['photo']);
    $description = $_POST['description'];
    $age = $_POST['age'];
    $location = $_POST['location'];
    $vaccine = $_POST['vaccine'];
    $status = $_POST['status'];
    $size = $_POST['size'];


    // $photo = $_POST['photo'];

    $sql = "INSERT INTO `animals`(`name`, `photo`, `location`, `description`, `size`, `age`, `vaccine`, `breed`, `status`) VALUES ('{$name}','{$photo[0]}','{$location}','{$description}','{$size}','{$age}','{$vaccine}','{$breed}','{$status}')";

    $result = mysqli_query($connect, $sql);
    if ($result) {
        echo "<div class='alert alert-success alert-dismissible fade show mx-auto' role='alert'>
  <strong>Success! Your product has been crafted and added to our collection. You'll be whisked back to the home page shortly. Sit tight, and get ready to explore more!</strong><button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  {$photo[1]}
</div>";
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show mx-auto' role='alert'>
  <strong>Oops! Something went wrong, and your product couldn't be created this time. Please try again, or reach out for assistance. You'll be redirected to the home page in a few seconds.</strong> <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
    header("refresh: 2; url = dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="../style.css">
    <title>Add new Animal</title>
</head>

<body>
    <?php require_once "../components/navbar.php" ?>

    <div class="container">
        <h1 style="color: #37546f;">Add a new Pet</h1>
        <div class="mx-auto">
            <form method="post" enctype="multipart/form-data">
                <input type="text" placeholder="Name" class="form-control mt-3" name="name">
                <input type="text" placeholder="Breed" class="form-control mt-3" name="breed">
                <input type="number" placeholder="Age" class="form-control mt-3" name="age">
                <input type="text" placeholder="Description" class="form-control mt-3" name="description">
                <select name="vaccine" class="form-control mt-3">
                    <option value="" disabled selected>Vaccine</option>
                    <option value="vaccinated">Vaccinated</option>
                    <option value="not vaccinated">Not vaccinated</option>
                </select>
                <input type="text" placeholder="Location" class="form-control mt-3" name="location">
                <select name="status" class="form-control mt-3">
                    <option value="" disabled selected>Pet's Status</option>
                    <option value="available">Available</option>
                    <option value="adopted">Adopted</option>
                </select>
                <select name="size" class="form-control mt-3">
                    <option value="" disabled selected>Size</option>
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>
                <input type="file" placeholder="Pet's Photo" class="form-control mt-3" name="photo">
                <input type="submit" class="button mt-3" name="submit" value="Add Pet">
            </form>
        </div>
    </div>
    <br>


    <?php require_once "../components/footer.php" ?>

</body>

</html>