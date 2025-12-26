<?php
session_start();
include '../config/db.php';

// Check if admin is already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password - check both hashed and plain text for backward compatibility
        $is_valid_password = password_verify($pass, $row['password']) || $pass === $row['password'];

        if ($is_valid_password) {
            // Check if user has admin role
            if ($row['role'] == 'admin') {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);

                // Check if password needs to be rehashed (if it's still in plain text)
                if ($pass === $row['password'] && substr($row['password'], 0, 1) !== '$') {
                    // Update the password to be hashed
                    $new_hashed_password = password_hash($pass, PASSWORD_DEFAULT);
                    $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
                    $update_stmt->bind_param("si", $new_hashed_password, $row['user_id']);
                    $update_stmt->execute();
                    $update_stmt->close();
                }

                $_SESSION['admin_id'] = $row['user_id'];
                $_SESSION['admin_name'] = $row['full_name'];
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $error = "คุณไม่มีสิทธิ์การเข้าถึงแบบผู้ดูแลระบบ!";
            }
        } else {
            $error = "Username หรือ Password ไม่ถูกต้อง!";
        }
    } else {
        $error = "Username หรือ Password ไม่ถูกต้อง!";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ADMIN ACCESS | RUNNER PRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@700&family=Kanit:wght@400&display=swap" rel="stylesheet">
    <style>
        body { background: #111; height: 100vh; display: flex; align-items: center; font-family: 'Kanit', sans-serif; }
        .login-card { background: white; padding: 50px; width: 100%; max-width: 450px; border-radius: 0; }
        .form-control { border-radius: 0; border: 1px solid #ddd; padding: 15px; }
        .btn-login { background: #111; color: white; border-radius: 0; padding: 15px; font-weight: 600; border: none; }
        .btn-login:hover { background: #333; }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="login-card shadow-lg">
        <div class="text-center mb-5">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a6/Logo_NIKE.svg" height="30" class="mb-3" alt="">
            <h3 style="font-family: 'Inter'; font-weight: 700;">ADMIN ACCESS</h3>
        </div>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="USERNAME" required>
            </div>
            <div class="mb-4">
                <input type="password" name="password" class="form-control" placeholder="PASSWORD" required>
            </div>
            <button type="submit" class="btn-login w-100 text-uppercase">Sign In</button>
        </form>
        <div class="mt-4 text-center">
            <a href="../index.php" class="text-muted small text-decoration-none">← Back to Store</a>
        </div>
    </div>
</div>

</body>
</html>