<?php
session_start();
// If user is already logged in, redirect to appropriate page
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/admin_dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN IN | RUNNER PRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@700&family=Kanit:wght@400&display=swap" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            font-family: 'Kanit', sans-serif; 
        }
        .login-card { 
            background: white; 
            padding: 50px; 
            width: 100%; 
            max-width: 450px; 
            border-radius: 8px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .form-control { 
            border-radius: 8px; 
            border: 1px solid #ddd; 
            padding: 12px 15px; 
        }
        .btn-login { 
            background: #111; 
            color: white; 
            border-radius: 8px; 
            padding: 12px; 
            font-weight: 600; 
            border: none; 
            width: 100%;
            text-transform: uppercase;
        }
        .btn-login:hover { 
            background: #333; 
            color: white; 
        }
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="login-card shadow-lg">
            <div class="text-center mb-5">
                <h3 style="font-family: 'Inter'; font-weight: 700; color: #111;">SIGN IN</h3>
                <p class="text-muted">เข้าสู่ระบบด้วยเลขบัตรประชาชนของคุณ</p>
            </div>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($_SESSION['error']); ?>
                    <?php unset($_SESSION['error']); // Clear the error message ?>
                </div>
            <?php endif; ?>
            
            <form action="login_process.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label fw-bold">เลขบัตรประชาชน</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="กรุณากรอกเลขบัตรประชาชน 13 หลัก" required maxlength="13" autocomplete="username">
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label fw-bold">รหัสผ่าน</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="กรุณากรอกรหัสผ่าน" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn-login">เข้าสู่ระบบ</button>
            </form>
            
            <div class="mt-4 text-center">
                <p class="small text-muted">ยังไม่มีบัญชี? <a href="register.php" class="text-decoration-none">สมัครสมาชิก</a></p>
                <a href="index.php" class="text-muted small text-decoration-none">← กลับไปหน้าหลัก</a>
            </div>
        </div>
    </div>
</body>
</html>