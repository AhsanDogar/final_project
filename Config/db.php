<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "final_project_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
