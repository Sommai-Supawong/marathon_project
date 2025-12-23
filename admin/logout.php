<?php
session_start();

// 1. ล้างค่าตัวแปร Session ทั้งหมด
$_SESSION = array();

// 2. ลบ Session Cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. ทำลาย Session
session_destroy();

// 4. แก้ไขบรรทัดนี้: เติม ../ เพื่อถอยออกไปหา login.php ที่อยู่ข้างนอกโฟลเดอร์ admin
header("Location: ../login.php?logout=success");
exit();
?>