<?php
session_start();
include 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // ป้องกัน SQL Injection
    $user = mysqli_real_escape_string($conn, $user);
    $pass = mysqli_real_escape_string($conn, $pass);

    $sql = "SELECT * FROM USERS WHERE username = '$user' AND password = '$pass' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // เก็บข้อมูลใน Session
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['full_name'] = $row['full_name'];
        $_SESSION['role'] = $row['role'];

        // คัดกรองระหว่าง Admin และ User
        if ($row['role'] == 'admin') {
            header("Location: admin/admin_dashboard.php");
        } else {
            // ส่งไปหน้าประวัติการวิ่ง หรือหน้าหลัก
            header("Location: index.php");
        }
        exit();

    } else {
        $_SESSION['error'] = "ข้อมูลการเข้าสู่ระบบไม่ถูกต้อง";
        header("Location: login.php");
        exit();
    }
}
?>