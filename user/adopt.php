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
$user_id = $_SESSION["user"];
$pet_id = $_GET['id'];

$sql = "SELECT * FROM `animals` WHERE `pet_id` = {$pet_id}";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<div class='alert alert-danger alert-dismissible fade show mx-auto' role='alert'>
        <strong>Error! Pet not found.</strong>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    header("refresh: 2; url = ../home.php");
    exit();
}

if ($row['status'] == 'adopted') {
    echo "<div class='alert alert-warning alert-dismissible fade show mx-auto' role='alert'>
        <strong>This pet has already been adopted.</strong>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    header("refresh: 2; url = ../home.php");
    exit();
}

if (isset($_POST['submit'])) {
    $sqlUpdate = "UPDATE `animals` SET `status` = 'adopted' WHERE `pet_id` = {$pet_id}";
    $resultUpdate = mysqli_query($connect, $sqlUpdate);

    if ($resultUpdate) {
        $NEWSql = "INSERT INTO `pet_adoption` (`user_id`, `pet_id`, `adopted_at`) VALUES ({$user_id}, {$pet_id}, NOW())";
        $NEWresult = mysqli_query($connect, $NEWSql);

        if ($NEWresult) {
            echo "<div class='alert alert-success alert-dismissible fade show mx-auto' role='alert'>
                <strong>Congratulations! You've successfully adopted the pet.</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
            header("refresh: 2; url = ../home.php");
            exit();
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show mx-auto' role='alert'>
                <strong>Error! Adoption didn't go through, try again later!</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show mx-auto' role='alert'>
            <strong>Error! Could not update pet status.</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
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
    <title>Adopt Pet</title>
</head>

<body>
    <?php require_once "../components/navbar.php"; ?>

    <div class="container">
        <h1>Adopt <?= $row['name'] ?></h1>
        <div class="mx-auto">
            <form method="post">
                <div class="mx-auto"><img id="propic" src="../photos/<?= $row['photo'] ?>" alt=""></div>
                <p>Are you sure you want to adopt <?= $row['name'] ?>?</p>
                <button type="submit" name="submit" class="btn btn-success">Confirm Adoption</button>
                <a href="../home.php" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>

    <?php require_once "../components/footer.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>