<?php
include 'config/db.php'; // เรียกไฟล์เชื่อมต่อที่คุณเขียนไว้

if ($conn->connect_error) {
    echo "<h1 style='color:red;'>❌ เชื่อมต่อล้มเหลว: " . $conn->connect_error . "</h1>";
} else {
    echo "<h1 style='color:green;'>✅ ยินดีด้วย! เชื่อมต่อฐานข้อมูลสำเร็จแล้ว</h1>";
    echo "Charset ปัจจุบัน: " . $conn->character_set_name();
}
?>