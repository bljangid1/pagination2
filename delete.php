<?php
include_once 'config.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "DELETE FROM `form_data` WHERE id = $id");

if ($query) {
    echo "

    <script>
    alert('Data Deleted Successfully');
    </script>

    ";
    header("Location: display.php");
    exit;
} else {A;
    echo "
     <script>
    alert('Data Deleted Successfully');
    </script>

    ";
    header("Location: display.php");
    exit;}
