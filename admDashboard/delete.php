<?php
require_once("..\components\db_connect.php");
session_start();
if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: ../user/login.php");
    exit();
}
if (isset($_SESSION["user"])) {
    header("Location : ../home.php");
    exit();
}
$sql = "SELECT * FROM `animals` WHERE `pet_id` = {$_GET['id']}";

$result = mysqli_query($connect, $sql);

$row = mysqli_fetch_assoc($result);

if ($row['photo'] != "dog.jpg") {
    unlink("../photos/{$row["photo"]}");
}

$sqlDELETE = "DELETE FROM `animals` WHERE `pet_id` = {$_GET['id']}";
mysqli_query($connect, $sqlDELETE);

header("Location: dashboard.php");
