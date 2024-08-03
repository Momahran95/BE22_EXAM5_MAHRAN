<?php

$localhost = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "be22_exam5_animal_adoption_mahran";

// create connection
$connect = mysqli_connect($localhost, $username, $password, $dbname);

// check connection
if (!$connect) {
    die("Connection failed");
}

function cleanInput($input)
{
    $data = trim($input);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);

    return $data;
}
