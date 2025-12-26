<?php
session_start();
include 'config/db.php';

// 1. เช็คสิทธิ์: ถ้าไม่ได้ล็อกอิน ให้เด้งไปหน้า login_form
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

$runner_id = $_SESSION['runner_id'];

// 2. Query ดึงข้อมูลนักวิ่ง + ข้อมูลการสมัคร (JOIN 4 ตาราง)
$sql = "SELECT r.*, reg.bib_number, reg.status, reg.shirt_size, cat.name as race_name, cat.distance_km, s.type as ship_type
        FROM runner r
        LEFT JOIN registration reg ON r.runner_id = reg.runner_id
        LEFT JOIN race_category cat ON reg.category_id = cat.category_id
        LEFT JOIN shipping_option s ON reg.shipping_id = s.shipping_id
        WHERE r.runner_id = '$runner_id' LIMIT 1";

$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>MY PROFILE | RUNNER PRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@800&family=Kanit:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root { --nike-black: #111; --bg-gray: #f4f4f4; }
        body { font-family: 'Kanit', sans-serif; background: var(--bg-gray); }
        .bib-card { background: white; border-top: 10px solid var(--nike-black); padding: 40px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .bib-number { font-family: 'Inter'; font-size: 5rem; font-weight: 800; letter-spacing: -2px; line-height: 1; margin: 20px 0; }
        .race-tag { background: var(--nike-black); color: white; padding: 5px 15px; text-transform: uppercase; font-weight: 800; font-family: 'Inter'; font-size: 0.9rem; }
        .status-badge { padding: 8px 20px; border-radius: 50px; font-weight: 600; font-size: 0.8rem; }
        .badge-paid { background: #e6fcf5; color: #0ca678; }
        .badge-pending { background: #fff4e6; color: #f76707; }
        .info-label { color: #888; font-size: 0.75rem; text-transform: uppercase; font-weight: 600; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="index.php" class="text-dark text-decoration-none fw-bold">← BACK</a>
                <a href="logout.php" class="text-danger text-decoration-none small fw-bold">LOGOUT</a>
            </div>

            <div class="bib-card mb-4">
                <span class="race-tag"><?php echo $user['race_name'] ?: 'No Registration'; ?></span>
                <div class="bib-number"><?php echo $user['bib_number'] ?: '----'; ?></div>
                <h4 class="fw-bold"><?php echo strtoupper($user['first_name'] . " " . $user['last_name']); ?></h4>
                <div class="mt-3">
                    <?php if($user['status'] == 'Paid'): ?>
                        <span class="status-badge badge-paid">PAYMENT CONFIRMED</span>
                    <?php else: ?>
                        <span class="status-badge badge-pending">PENDING PAYMENT</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white p-4 shadow-sm">
                <h5 class="fw-bold mb-4 border-bottom pb-2">PERSONAL DETAILS</h5>
                <div class="row g-4">
                    <div class="col-6">
                        <div class="info-label">Distance</div>
                        <div class="fw-bold"><?php echo $user['distance_km'] ?: '-'; ?> KM</div>
                    </div>
                    <div class="col-6">
                        <div class="info-label">Shirt Size</div>
                        <div class="fw-bold"><?php echo $user['shirt_size'] ?: '-'; ?></div>
                    </div>
                    <div class="col-6">
                        <div class="info-label">ID Number</div>
                        <div class="fw-bold"><?php echo $user['citizen_id']; ?></div>
                    </div>
                    <div class="col-6">
                        <div class="info-label">Shipping</div>
                        <div class="fw-bold"><?php echo $user['ship_type'] ?: 'N/A'; ?></div>
                    </div>
                </div>
                
                <?php if($user['status'] !== 'Paid'): ?>
                    <div class="mt-5 p-3 bg-light text-center border">
                        <p class="small mb-2 text-muted">กรุณาชำระเงินเพื่อรับเลข BIB และอุปกรณ์การแข่งขัน</p>
                        <button class="btn btn-dark w-100 rounded-0 fw-bold">HOW TO PAY</button>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

</body>
</html>