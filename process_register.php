<?php
session_start();
include 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. รับค่าและป้องกัน SQL Injection
    $fname       = $conn->real_escape_string($_POST['first_name']);
    $lname       = $conn->real_escape_string($_POST['last_name']);
    $dob         = $_POST['date_of_birth'];
    $gender      = $_POST['gender'];
    $phone       = $conn->real_escape_string($_POST['phone']);
    $citizen_id  = $conn->real_escape_string($_POST['citizen_id']);
    $email       = $conn->real_escape_string($_POST['email']);
    $address     = $conn->real_escape_string($_POST['address']);
    $is_disabled = isset($_POST['is_disabled']) ? 1 : 0;
    
    $cat_id      = $_POST['category_id'];
    $ship_id     = $_POST['shipping_id'];
    $shirt_size  = $_POST['shirt_size'];

    // 2. บันทึกข้อมูลลงตาราง RUNNER
    $sql_runner = "INSERT INTO RUNNER (first_name, last_name, date_of_birth, gender, phone, citizen_id, email, address, is_disabled) 
                   VALUES ('$fname', '$lname', '$dob', '$gender', '$phone', '$citizen_id', '$email', '$address', '$is_disabled')";

    if ($conn->query($sql_runner)) {
        $runner_id = $conn->insert_id; // ได้ ID ล่าสุดของนักวิ่ง

        // 3. สร้างเลข BIB แบบสุ่ม (เช่น R-0001)
        $bib_number = "R-" . str_pad($runner_id, 4, "0", STR_PAD_LEFT);

        // 4. บันทึกข้อมูลลงตาราง REGISTRATION
        $sql_reg = "INSERT INTO REGISTRATION (runner_id, category_id, shipping_id, reg_date, shirt_size, bib_number, status) 
                    VALUES ('$runner_id', '$cat_id', '$ship_id', NOW(), '$shirt_size', '$bib_number', 'Pending')";

        if ($conn->query($sql_reg)) {
            $reg_id = $conn->insert_id;
            // สมัครสำเร็จ! ส่งไปหน้าสรุปผล
            header("Location: summary.php?id=$reg_id");
            exit();
        } else {
            echo "เกิดข้อผิดพลาดในการบันทึกการสมัคร: " . $conn->error;
        }
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลนักวิ่ง: " . $conn->error;
    }
} else {
    header("Location: register.php");
    exit();
}
?>