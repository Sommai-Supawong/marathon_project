<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUNNER PRO | JUST RUN IT.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@800&family=Kanit:wght@300;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --nike-black: #111;
        }

        body {
            font-family: 'Kanit', sans-serif;
            color: var(--nike-black);
        }

        h1 {
            font-family: 'Inter', sans-serif;
            font-weight: 800;
            font-size: 5rem;
            line-height: 0.9;
            letter-spacing: -2px;
        }

        .navbar {
            padding: 1.5rem 2rem;
            background: white;
            border-bottom: 1px solid #eee;
        }

        .hero-section {
            padding: 100px 0;
            background: #fff;
        }

        .hero-image {
            width: 100%;
            border-radius: 0;
            object-fit: cover;
            height: 500px;
        }

        .btn-nike {
            background: var(--nike-black);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-transform: uppercase;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-nike:hover {
            background: #444;
            color: white;
        }

        .navbar-brand img {
            height: 35px;
            /* ปรับความสูงตามความเหมาะสมของโลโก้คุณ */
            width: auto;
            /* ให้ความกว้างปรับตามสัดส่วนภาพ */
            display: block;
            transition: transform 0.3s ease;
        }

        .navbar-brand img:hover {
            transform: scale(1.05);
            /* เพิ่มลูกเล่นเวลาเอาเมาส์ไปวาง */
        }
    </style>
</head>

<body>

    <nav class="navbar sticky-top shadow-sm">
        <div class="container-fluid px-md-5">
            <a class="navbar-brand" href="index.php">
                <img src="assets/logo.png" height="30" alt="Runner Pro Logo" style="object-fit: contain;">
            </a>
            <div class="ms-auto d-flex align-items-center">
                <a href="register.php" class="text-decoration-none text-dark fw-bold me-4"
                    style="font-size: 0.85rem; letter-spacing: 0.5px;">REGISTER</a>

                <a href="login.php" class="btn-nike" style="font-size: 0.85rem; padding: 8px 24px;">SIGN IN</a>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container text-center">
            <h1 class="mb-4">WIN FROM<br>WITHIN.</h1>
            <p class="lead mb-5 text-secondary">ท้าทายขีดจำกัดของคุณในงาน Nakhon Pathom Marathon 2025</p>
            <div class="row g-0">
                <div class="col-12">
                    <img src="https://images.unsplash.com/photo-1530143311094-34d807799e8f?auto=format&fit=crop&q=80&w=2000"
                        class="hero-image mb-5" alt="Runner">
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-4">
                    <h3 class="fw-bold">42.195 KM</h3>
                    <p class="text-muted">FULL MARATHON</p>
                </div>
                <div class="col-md-4">
                    <h3 class="fw-bold">21.1 KM</h3>
                    <p class="text-muted">HALF MARATHON</p>
                </div>
                <div class="col-md-4">
                    <h3 class="fw-bold">10.5 KM</h3>
                    <p class="text-muted">MINI MARATHON</p>
                </div>
            </div>
        </div>
    </section>
    <footer class="bg-white py-5 border-top mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-4 mb-md-0">
                    <img src="assets/logo.png" height="20" class="mb-3" alt="Footer Logo">
                    <p class="small text-muted mb-0">© 2025 RUNNER PRO. POWERED BY SOFTWARE ENGINEERING NPRU.</p>
                </div>

                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-unstyled d-flex justify-content-center justify-content-md-end gap-4 mb-0">
                        <li><a href="index.php"
                                class="text-dark text-decoration-none small fw-bold text-uppercase">Home</a></li>
                        <li><a href="register.php"
                                class="text-dark text-decoration-none small fw-bold text-uppercase">Register</a></li>
                        <li><a href="admin/logout.php">Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>