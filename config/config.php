<?php
$conn = mysqli_connect("localhost", "root", "", "race_db");
mysqli_set_charset($conn, "utf8mb4");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>