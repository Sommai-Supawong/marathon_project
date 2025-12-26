<?php
include 'config/db.php';
$reg_id = $_GET['id']; // รับ ID มาจากหน้า process_reg.php

$sql = "SELECT r.*, c.name as race_name, s.type as ship_type
        FROM registration r
        JOIN race_category c ON r.category_id = c.category_id
        JOIN shipping_option s ON r.shipping_id = s.shipping_id
        WHERE r.reg_id = $id";
$res = $conn->query($sql);
$data = $res->fetch_assoc();
// เพิ่มการรับค่าใหม่
$citizen_id = $conn->real_escape_string($_POST['citizen_id']);
$email = $conn->real_escape_string($_POST['email']);
$address = $conn->real_escape_string($_POST['address']);
$is_disabled = isset($_POST['is_disabled']) ? 1 : 0; // แปลง checkbox เป็น 0 หรือ 1

// แก้ไขคำสั่ง INSERT ในตาราง runner ให้มีคอลัมน์เหล่านี้
$sql_runner = "INSERT INTO runner (first_name, last_name, date_of_birth, gender, phone, citizen_id, email, address, is_disabled)
               VALUES ('$fname', '$lname', '$dob', '$gender', '$phone', '$citizen_id', '$email', '$address', '$is_disabled')";
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Registration Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5 text-center">
        <div class="card shadow-lg mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h2 class="text-success mb-4">สมัครสำเร็จ!</h2>
                <p>เลขที่ใบสมัครของคุณคือ: <strong>#<?php echo $data['reg_id']; ?></strong></p>
                <div class="bg-dark text-white p-3 mb-4 rounded">
                    <h3>BIB: <?php echo $data['bib_number'] ?? 'รอการตรวจสอบ'; ?></h3>
                    <p class="mb-0">ประเภท: <?php echo $data['race_name']; ?></p>
                </div>
                <p>สถานะ: <span class="badge bg-warning text-dark"><?php echo $data['status']; ?></span></p>
                <hr>
                <p class="text-muted small">กรุณาชำระเงินและแจ้งหลักฐานภายใน 24 ชม.</p>
                <a href="index.php" class="btn btn-outline-primary">กลับหน้าแรก</a>
            </div>
        </div>
    </div>
</body>
</html>