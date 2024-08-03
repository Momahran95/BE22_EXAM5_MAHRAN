<?php
session_start();

# none users if they try to access the dashboard
if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: ../user/login.php");
    exit();
}

# if a user try to access this page
if (isset($_SESSION["user"])) {
    header("Location: ../home.php");
    exit();
}

require_once "../components/db_connect.php";

$sql = "SELECT * FROM users WHERE id = " . $_SESSION["admin"];
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);


$AnimalSql = "SELECT * FROM `animals`";
$resultPet = mysqli_query($connect, $AnimalSql);
$rows = mysqli_fetch_all($resultPet, MYSQLI_ASSOC);

$layout = "";
$layout_section = "";
if (mysqli_num_rows($resultPet) == 0) {
    $layout .= "<div class='alert alert-danger alert-dismissible fade show mx-auto' role='alert'>
  <strong>Uh-oh! It looks like our search elves couldn't find any results for your query.</strong> Double-check your spelling or try different keywords, and we'll keep searching the enchanted archives for you!
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
} else {
    foreach ($rows as $key => $value) {
        $layout .= "<div class='my-3'>
            <div class='card'>
                <img src='../photos/{$value['photo']}' height='300px' class='card-img-top' alt='...'>
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
                        <a href='update.php?id={$value['pet_id']}' style='text-decoration:none;' class='btn btn-warning'>Update</a>
                        <a href='delete.php?id={$value['pet_id']}' style='text-decoration:none;' class='btn btn-danger'>Delete</a>
                    </div>
                </div>
            </div>
        </div>";
    }
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
    <title>Megapet</title>
</head>

<body>
    <?php require_once "../components/navbar.php" ?>
    <div class="container">
        <div class="mx-auto"><img id="propic" src="../photos/<?= $row['photo'] ?>" alt=""></div>
        <div class="d-flex justify-content-between">
            <h1><span class="text-success">Welcome!</span> <?= $row["first_name"] . " " . $row["last_name"] ?></h1>
            <lottie-player src="Animation2.json" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></lottie-player>
        </div>
        <div>
            <p><span class="text-primary fw-bold">Email</span> : <?= $row['email'] ?></p>
            <p><span class="text-primary fw-bold">Phone Number</span> : <?= $row['phone_number'] ?></p>
            <p><span class="text-primary fw-bold">Address</span> : <?= $row['address'] ?></p>
        </div>
        <hr>
    </div>
    <div class="container">

        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-xs-1">

            <?= $layout ?>

        </div>
    </div>

    <?php require_once "../components/footer.php" ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>