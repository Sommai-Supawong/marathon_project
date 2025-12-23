<?php
session_start();
include 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM USERS WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password - check both hashed and plain text for backward compatibility
        $is_valid_password = password_verify($pass, $row['password']) || $pass === $row['password'];

        if ($is_valid_password) {
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);

            // เก็บข้อมูลใน Session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['role'] = $row['role'];

            // ✨ เพิ่มบรรทัดนี้: เก็บ ID ของนักวิ่งไว้เรียกดูข้อมูลส่วนตัว
            $_SESSION['runner_id'] = $row['runner_id'];

            // Check if password needs to be rehashed (if it's still in plain text)
            if ($pass === $row['password'] && substr($row['password'], 0, 1) !== '$') {
                // Update the password to be hashed
                $new_hashed_password = password_hash($pass, PASSWORD_DEFAULT);
                $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
                $update_stmt->bind_param("si", $new_hashed_password, $row['user_id']);
                $update_stmt->execute();
                $update_stmt->close();
            }

            // คัดกรองระหว่าง Admin และ User
            if ($row['role'] == 'admin') {
                // Set admin session variables for admin dashboard
                $_SESSION['admin_id'] = $row['user_id'];
                $_SESSION['admin_name'] = $row['full_name'];
                header("Location: admin/admin_dashboard.php");
            } else {
                // ส่งไปหน้าหลัก หรือหน้าโปรไฟล์ส่วนตัว
                header("Location: index.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "ข้อมูลการเข้าสู่ระบบไม่ถูกต้อง";
            header("Location: login_form.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "ข้อมูลการเข้าสู่ระบบไม่ถูกต้อง";
        header("Location: login_form.php");
        exit();
    }
}
?>