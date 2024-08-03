<?php
require_once("..\components\db_connect.php");
session_start();
if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
  header("Location: ../login.php");
  exit();
}
$layout = "";
$sql = "SELECT * FROM `animals` WHERE `pet_id` = {$_GET['id']}";
$result = mysqli_query($connect, $sql);
$value = mysqli_fetch_assoc($result);
$layout .= "<div>
        <div class='card'>
  <img src='../photos/{$value['photo']}' height='500px;' class='card-img-top' alt='...'>
  <div class='card-body'>
    <h5 class='card-title'>{$value['name']}</h5>
    <p class='card-text'><span class='text-info'>Description</span> : {$value['description']}</p>
    <p class='card-text'><span class='text-info'>Breed</span> : {$value['breed']}</p>
  <ul class='list-group list-group-flush'>
    <li class='list-group-item'><span class='text-info'>Age</span> : {$value['age']} Years Old</li>
    <li class='list-group-item'><span class='text-info'>Location</span> : <i class='fa-solid fa-location-dot'></i> {$value['location']}</li>
    <li class='list-group-item'><span class='text-info'>Size</span> : {$value['size']}</li>";

if ($value['vaccine'] == 'vaccinated') {
  $layout .= "<li class='list-group-item'><span class='text-info'>Vaccine</span> : <span class='text-success'>{$value['vaccine']}</span></li>";
} else {
  $layout .= "<li class='list-group-item'><span class='text-info'>Vaccine</span> : <span class='text-danger'>{$value['vaccine']}</span></li>";
}

if ($value['status'] == 'available') {
  $layout .= "<li class='list-group-item'><span class='text-info'>Status</span> : <span class='text-success'>{$value['status']}</span></li>";
} else {
  $layout .= "<li class='list-group-item'><span class='text-info'>Status</span> : <span class='text-danger'>{$value['status']}</span></li>";
}

$layout .= "</ul>
  <div class='card-body'>
    <a href='../home.php' style='text-decoration:none;' class='btn btn-info'>Back</a>
  </div>
</div>
                    </div>";

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
  <title>Details</title>
</head>

<body>

  <?php require_once "../components/navbar.php" ?>

  <div class="container">





    <div class="d-flex">
      <p class="mx-auto"><lottie-player src="Animation3.json" background="transparent" speed="1" style="width: 500px; height: 400px;" loop autoplay></lottie-player></p>
      <p class="mx-auto"><lottie-player src="Animation4.json" background="transparent" speed="1" style="width: 500px; height: 400px;" loop autoplay></lottie-player></p>
    </div>
    <br>
    <div class="mx-auto" style="width: 50vw;"><?= $layout ?></div>
    <br>




  </div>

  <?php require_once "../components/footer.php" ?>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>