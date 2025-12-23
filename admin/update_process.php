<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg_id = $_POST['reg_id'];
    $bib = $_POST['bib_number'];
    $status = $_POST['status'];

    $sql = "UPDATE REGISTRATION SET 
            bib_number = '$bib', 
            status = '$status' 
            WHERE reg_id = $reg_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('อัปเดตข้อมูลสำเร็จ'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>