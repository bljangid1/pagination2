<?php

$localhost = "localhost";
$username  = "root";
$password  = "";
$db        = "knoxed_test";

$conn = mysqli_connect($localhost, $username, $password, $db);

if (! $conn) {
    echo "ERROR: " . mysqli_error($conn);
}
