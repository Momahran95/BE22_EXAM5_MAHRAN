<?php
session_start();

# if a user try to access this page
if (isset($_SESSION["user"])) {
    header("Location: ../home.php");
    exit();
}

# if an admin try to access this page
if (isset($_SESSION["admin"])) {
    header("Location: ..\admDashboard\dashboard.php");
    exit();
}

require_once "../components/db_connect.php";

# taking values from html inputs
# simple validation and clean the value
# run a query to check if user credintials are correct
$error = false;
$email = $emailError = $passError = "";

if (isset($_POST["login-btn"])) {
    $email = cleanInput($_POST["email"]);
    $password = cleanInput($_POST["password"]);

    if (empty($email)) {
        $error = true;
        $emailError = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Not a valid email!";
    }


    if (empty($password)) {
        $error = true;
        $passError = "Password is required!";
    }

    if (!$error) { # $error == false
        $password = hash("sha256", $password);

        $sql = "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) == 1) {
            # you can login 
            # we need to check if the whoever logged in is a user or adm 
            if ($row["status"] == "adm") {
                # send you to the dashboard
                $_SESSION["admin"] = $row["id"];
                header("Location: ../admDashboard/dashboard.php");
            } else {
                # send you to the home page
                $_SESSION["user"] = $row["id"];
                header("Location: ../home.php");
            }
        } else {
            echo "<div id='alert'>Invalid email or password. Please try again.</div>";
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h5>Sign into your account</h5>
                    <p>Enter your username and password to login</p>
                </div>

                <form class="form" method="POST">
                    <div class="input-group">
                        <input type="email" name="email" class="input" value="<?= $email ?>" required>
                        <label class="label">Email</label>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" id="password" class="input" required>
                        <label class="label">Password</label>
                    </div>

                    <div class="login-options">
                        <div>
                            <input type="checkbox" name="rememberme" id="rememberme" class="rememberme">
                            <label for="rememberme">Remember me?</label>
                        </div>

                        <div>
                            <a href="#" class="forgot_password">Forgot password?</a>
                        </div>
                    </div>

                    <button type="submit" name="login-btn">Sign in</button>
                </form>

                <div>
                    <p>Don't have an account? <a href="register.php">Sign up</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>