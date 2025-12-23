<?php
session_start();
include 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. รับค่าจากฟอร์ม (ป้องกัน SQL Injection)
    $fname       = $conn->real_escape_string($_POST['first_name']);
    $lname       = $conn->real_escape_string($_POST['last_name']);
    $dob         = $_POST['date_of_birth'];
    $gender      = $_POST['gender'];
    $citizen_id  = $conn->real_escape_string($_POST['citizen_id']); // ใช้เป็น Username
    $email       = $conn->real_escape_string($_POST['email']);
    $address     = $conn->real_escape_string($_POST['address']);
    $password    = password_hash($_POST['reg_password'], PASSWORD_DEFAULT); // Hash the password
    
    $cat_id      = $_POST['category_id'];
    $ship_id     = $_POST['shipping_id'];
    $shirt_size  = $_POST['shirt_size'];
    $is_disabled = isset($_POST['is_disabled']) ? 1 : 0;

    // --- เริ่มกระบวนการ Transaction (บันทึกต่อเนื่อง) ---

    // STEP 1: บันทึกลงตาราง RUNNER
    $sql1 = "INSERT INTO RUNNER (first_name, last_name, date_of_birth, gender, citizen_id, email, address, is_disabled)
             VALUES ('$fname', '$lname', '$dob', '$gender', '$citizen_id', '$email', '$address', '$is_disabled')";

    if ($conn->query($sql1)) {
        $runner_id = $conn->insert_id; // เก็บ ID ที่เพิ่งได้มา

        // STEP 2: สร้างบัญชีผู้ใช้ในตาราง USERS
        $full_name = $fname . " " . $lname;
        $stmt2 = $conn->prepare("INSERT INTO USERS (runner_id, username, password, role, full_name) VALUES (?, ?, ?, 'user', ?)");
        $stmt2->bind_param("isss", $runner_id, $citizen_id, $password, $full_name);

        if ($stmt2->execute()) {

            // STEP 3: สร้างรายการสมัครในตาราง REGISTRATION
            $bib_number = "R-" . str_pad($runner_id, 4, "0", STR_PAD_LEFT);
            $stmt3 = $conn->prepare("INSERT INTO REGISTRATION (runner_id, category_id, shipping_id, reg_date, shirt_size, bib_number, status) VALUES (?, ?, ?, NOW(), ?, ?, 'Pending')");
            $stmt3->bind_param("iiiss", $runner_id, $cat_id, $ship_id, $shirt_size, $bib_number);

            if ($stmt3->execute()) {
                $reg_id = $conn->insert_id;
                // ✅ สำเร็จทั้งหมด! ส่งไปหน้าสรุปผล
                header("Location: summary.php?id=$reg_id");
                exit();
            } else {
                echo "Error STEP 3: " . $conn->error;
            }
            $stmt3->close();
        } else {
            echo "Error STEP 2 (สร้าง Account ล้มเหลว): " . $conn->error;
        }
        $stmt2->close();
    } else {
        echo "Error STEP 1: " . $conn->error;
    }
}
?>