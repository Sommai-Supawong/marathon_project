<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // ลบข้อมูลการลงทะเบียน (จะลบแค่ในตาราง REGISTRATION)
    $sql = "DELETE FROM REGISTRATION WHERE reg_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('ลบข้อมูลเรียบร้อยแล้ว'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>