<?php
session_start();

# none users if they try to access the dashboard
if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}


if (isset($_SESSION["admin"])) {
    header("Location: ../admDashboard/dashboard.php");
    exit();
}

require_once "../components/db_connect.php";

$sql = "SELECT * FROM users WHERE id = " . $_SESSION["user"];
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
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
    <title>My profile</title>
</head>

<body>
    <?php require_once "../components/navbar.php" ?>
    <div class="container">
        <div class="mx-auto"><img id="propic" src="../photos/<?= $row['photo'] ?>" alt=""></div>
        <div class="d-flex justify-content-between">
            <h1><span class="text-success">Welcome!</span> <?= $row["first_name"] . " " . $row["last_name"] ?></h1>
            <lottie-player src="../admDashboard/Animation2.json" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></lottie-player>
        </div>
        <div>
            <p><span class="text-primary fw-bold">Email</span> : <?= $row['email'] ?></p>
            <p><span class="text-primary fw-bold">Phone Number</span> : <?= $row['phone_number'] ?></p>
            <p><span class="text-primary fw-bold">Address</span> : <?= $row['address'] ?></p>
        </div>
        <hr>
        <a href="../home.php" style='text-decoration:none;' class="btn btn-info text-light">Go to the main Page</a>
        <br>
    </div>
    <br>
    <?php require_once "../components/footer.php" ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>