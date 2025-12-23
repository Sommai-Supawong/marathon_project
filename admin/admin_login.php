<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<?php
session_start();
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM USERS WHERE username = '$user' AND password = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['admin_id'] = $row['user_id'];
        $_SESSION['admin_name'] = $row['full_name'];
        header("Location: admin_dashboard.php");
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
        <form action="login_process.php" method="POST">
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