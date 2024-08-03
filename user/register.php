<?php

session_start();

# if a user try to access this page
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit();
}

# if an admin try to access this page
if (isset($_SESSION["admin"])) {
    header("Location: admDashboard/dashboard.php");
    exit();
}


require_once "../components/db_connect.php";
require_once "../components/file_upload.php";

$error = false;
$border = "";
$fname = $lname = $address = $email = $password = $photo = $phone =  '';
$fnameError = $lnameError = $dateError = $emailError = $passError = $picError = $rpassError = $phoneError = $addressError = '';



if (isset($_POST['btn-signup'])) {

    $fname = cleanInput($_POST["first_name"]);

    $lname = cleanInput($_POST["last_name"]);

    $address = cleanInput($_POST["address"]);

    $phone = cleanInput($_POST["phone_number"]);

    $email = cleanInput($_POST["email"]);

    $password = cleanInput($_POST["password"]);
    $rpassword = cleanInput($_POST["rpassword"]);

    $photo = fileUpload($_FILES['photo']);

    # validation 
    # first name validation - can't be empty

    if (empty($fname)) {
        $error = true;
        $border = "border border-danger";
        $fnameError = "first name can't be empty!";
    } elseif (strlen($fname) < 3) {
        $error = true;
        $border = "border border-danger";
        $fnameError = "first name can't be less than 2 chars";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fname)) {
        $error = true;
        $border = "border border-danger";
        $fnameError = "first name must contain only letters and spaces!";
    }

    if (empty($lname)) {
        $error = true;
        $border = "border border-danger";
        $lnameError = "last name can't be empty!";
    } elseif (strlen($lname) < 3) {
        $error = true;
        $border = "border border-danger";
        $lnameError = "last name can't be less than 2 chars";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $lname)) {
        $error = true;
        $border = "border border-danger";
        $lnameError = "last name must contain only letters and spaces!";
    }


    if (empty($email)) {
        $error = true;
        $border = "border border-danger";
        $emailError = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  # jhfgk@jgj.aj
        $error = true;
        $border = "border border-danger";
        $emailError = "Please type a valid email!";
    } else {
        $searchIfEmailExists = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($connect, $searchIfEmailExists);
        if (mysqli_num_rows($result) != 0) {
            $error = true;
            $border = "border border-danger";
            $emailError = "Email already exists!";
        }
    }
    if (empty($phone)) {
        $error = true;
        $border = "border border-danger";
        $phoneError = "phone number can't be empty!";
    } elseif (strlen($phone) < 11) {
        $error = true;
        $border = "border border-danger";
        $phoneError = "phone number can't be less than 11 numbers";
    }

    if (empty($password)) {
        $error = true;
        $border = "border border-danger";
        $passError = "Password can't be empty!";
    } elseif (strlen($password) < 6) {
        $error = true;
        $border = "border border-danger";
        $passError = "Password can't be less than 6 Chars";
    }

    if (empty($rpassword)) {
        $error = true;
        $border = "border border-danger";
        $rpassError = "Repeat password can't be empty!";
    } elseif ($password != $rpassword) {
        $error = true;
        $border = "border border-danger";
        $rpassError = "Passwords doesn't match!";
    }
    if (empty($address)) {
        $error = true;
        $border = "border border-danger";
        $addressError = "Address can't be empty!";
    } elseif (strlen($address) < 6) {
        $error = true;
        $border = "border border-danger";
        $addressError = "Address can't be less than 6 Chars";
    }


    if (!$error) {
        $password = hash('sha256', $password);
        $sql = "INSERT INTO `users`( `first_name`, `last_name`, `email`, `phone_number`, `address`, `photo`, `password`) VALUES ('{$fname}','{$lname}','{$email}','{$phone}','{$address}','{$photo[0]}','{$password}')";


        $result = mysqli_query($connect, $sql);

        if ($result) {
            echo "<div class='alert alert-success' role='alert'>
                    <h4 class='alert-heading'>Registered Successfully!</h4>
                    <p>Aww yeah, you successfully created a new account on our website!<br> enjoy it while it is free! ;)</p>
                    <hr>
                    <p class='mb-0'>$photo[1]</p>
                  </div>";

            $fname = $lname = $email = "";
        } else {
            echo "<div class='alert alert-danger' role='alert'>
            <h3>Something went wrong, please try again later!</h3>
          </div>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="container my-5">

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" method="POST" class="w-50 mx-auto">
            <h2 class="mb-3">Registration Form
            </h2>
            <div class="mb-3">
                <label for="name">First name</label>
                <input type="text" class="form-control <?= $fnameError ? $border : "" ?>" id="name" name="first_name" value="<?= $fname ?>">
                <p class="text-danger"><?= $fnameError ?></p>
            </div>
            <div class="mb-3">
                <label for="lastName">Last name</label>
                <input type="text" class="form-control <?= $lnameError ? $border : ""  ?>" id="lastName" name="last_name" value="<?= $lname ?>">
                <p class="text-danger"><?= $lnameError ?></p>
            </div>
            <div class="mb-3">
                <label for="photo">photo</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control <?= $emailError ? $border : ""  ?>" id="email" name="email" value="<?= $email ?>">
                <p class="text-danger"><?= $emailError ?></p>
            </div>
            <div class="mb-3">
                <label for="phone">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone_number" value="<?= $phone ?>">
                <p class="text-danger"><?= $phoneError ?></p>
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control <?= $passError ? $border : ""  ?>" id="password" name="password">
                <p class="text-danger"><?= $passError ?></p>
            </div>
            <div class="mb-3">
                <label for="rpassword">Repeat your Password</label>
                <input type="password" class="form-control <?= $rpassError ? $border : ""  ?>" id="rpassword" name="rpassword">
                <p class="text-danger"><?= $rpassError ?></p>
            </div>
            <div class="mb-3">
                <label for="address">Address</label>
                <input type="text" class="form-control <?= $addressError ? $border : ""  ?>" id="address" name="address" value="<?= $address ?>">
                <p class="text-danger"><?= $addressError ?></p>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-success" name="btn-signup">Register</button>
            </div>
            <div><a href="login.php">You are already a User?</a></div>
        </form>
    </div>
</body>

</html>