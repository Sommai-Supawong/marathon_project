<?php session_start(); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>SIGN IN | RUNNER PRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@700;800&family=Kanit:wght@400&display=swap" rel="stylesheet">
    <style>
        /* CSS เดิมของคุณหมายคงไว้ทั้งหมด */
        body { background: #fff; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; font-family: 'Kanit', sans-serif; }
        .login-card { width: 100%; max-width: 400px; padding: 40px; }
        .nike-input { border: 1px solid #e5e5e5; padding: 16px; margin-bottom: 15px; width: 100%; border-radius: 4px; }
        .btn-nike { background: #111; color: white; width: 100%; padding: 16px; border: none; font-weight: 600; text-transform: uppercase; border-radius: 30px; transition: 0.3s; cursor: pointer; }
        .btn-nike:hover { background: #444; }
        h2 { font-family: 'Inter'; font-weight: 800; letter-spacing: -1px; line-height: 1.1; margin-top: 20px; }
        .logo-wrapper img { height: 40px; width: auto; display: block; margin: 0 auto 25px auto; transition: 0.3s; }
        .logo-wrapper img:hover { transform: scale(1.1); }
    </style>
</head>
<body>

    <?php if (isset($_GET['logout']) && $_GET['logout'] == 'success'): ?>
        <div class="alert alert-dark text-center small mb-4 w-100" style="max-width:400px; border-radius: 0; background: #f5f5f5; border: none;">
            YOU HAVE BEEN SUCCESSFULLY LOGGED OUT.
        </div>
    <?php endif; ?>

    <div class="login-card text-center">
        <div class="mb-5">
            <a class="logo-wrapper" href="index.php">
                <img src="assets/logo.png" alt="Logo">
            </a>
            <h2 class="mb-4">YOUR ACCOUNT FOR EVERYTHING RUNNING.</h2>
        </div>

        <form action="login_process.php" method="POST" class="text-start">
            <input type="text" name="username" class="nike-input" placeholder="Username" required>
            <input type="password" name="password" class="nike-input" placeholder="Password" required>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="text-danger small mb-3 text-center">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn-nike">Sign In</button>
        </form>
    </div>

</body>
</html>