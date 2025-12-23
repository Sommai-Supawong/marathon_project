<?php
include 'config.php';

// 1. บันทึกข้อมูลนักวิ่งก่อน
$sql_runner = "INSERT INTO RUNNER (first_name, last_name, date_of_birth, gender) 
               VALUES ('{$_POST['fname']}', '{$_POST['lname']}', '{$_POST['dob']}', '{$_POST['gender']}')";

if (mysqli_query($conn, $sql_runner)) {
    $last_runner_id = mysqli_insert_id($conn); // ดึง ID ล่าสุดที่เพิ่งบันทึกไป

    // 2. บันทึกลงตารางลงทะเบียน โดยใช้ $last_runner_id ที่ได้มา
    $sql_reg = "INSERT INTO REGISTRATION (runner_id, category_id, reg_date, status) 
                VALUES ('$last_runner_id', '{$_POST['category_id']}', NOW(), 'Pending')";
    mysqli_query($conn, $sql_reg);

    echo "ลงทะเบียนสำเร็จ! กรุณาชำระเงิน";
}
?>