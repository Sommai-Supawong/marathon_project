<?php
session_start();
include 'config/db.php';

// 1. ตรวจสอบการเข้าถึง: ถ้าไม่มี user_id ให้เด้งไปหน้า login_form
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

// ป้องกันกรณีไม่มี runner_id ใน session
$runner_id = isset($_SESSION['runner_id']) ? $_SESSION['runner_id'] : $_SESSION['user_id'];

// 2. ดึงข้อมูลแบบละเอียด โดยใช้ Prepared Statement (ปลอดภัยกว่า)
$sql = "SELECT r.*, reg.bib_number, reg.status, reg.shirt_size, reg.reg_date,
               cat.name as race_name, cat.distance_km,
               s.type as ship_type, s.cost as ship_cost
        FROM runner r
        LEFT JOIN registration reg ON r.runner_id = reg.runner_id
        LEFT JOIN race_category cat ON reg.category_id = cat.category_id
        LEFT JOIN shipping_option s ON reg.shipping_id = s.shipping_id
        WHERE r.runner_id = ? LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $runner_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// กรณีฉุกเฉิน: ถ้าหาข้อมูลนักวิ่งไม่เจอในตาราง runner
if (!$user) {
    // ล้าง session และส่งกลับไปหน้า login เพื่อป้องกัน loop
    session_destroy();
    echo "<script>alert('ไม่พบข้อมูลนักวิ่งในระบบ'); window.location='login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY PROFILE | RUNNER PRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@700;800&family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --nike-black: #111; --nike-gray: #f5f5f5; }
        body { font-family: 'Kanit', sans-serif; background-color: #ffffff; color: var(--nike-black); }
        
        .profile-container { max-width: 900px; margin: 0 auto; padding: 40px 20px; }
        .back-link { text-decoration: none; color: #888; font-weight: 600; font-size: 0.85rem; transition: 0.3s; }
        .back-link:hover { color: var(--nike-black); }

        /* BIB Card */
        .bib-card { 
            background: #fff; 
            border: 2px solid var(--nike-black); 
            padding: 40px; 
            position: relative; 
            overflow: hidden;
            margin-bottom: 40px;
        }
        .bib-header { font-family: 'Inter'; font-weight: 800; font-size: 1.2rem; text-transform: uppercase; border-bottom: 4px solid var(--nike-black); display: inline-block; margin-bottom: 20px; }
        .bib-number { font-family: 'Inter'; font-size: clamp(4rem, 15vw, 8rem); font-weight: 800; line-height: 1; letter-spacing: -5px; margin: 10px 0; }
        
        /* Status Badges */
        .status-pill { padding: 6px 16px; border-radius: 50px; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; }
        .status-paid { background: #000; color: #fff; }
        .status-pending { background: #ffea00; color: #000; }

        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; margin-top: 40px; }
        .info-item label { display: block; font-size: 0.7rem; font-weight: 600; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
        .info-item span { font-size: 1.1rem; font-weight: 600; }

        .btn-action { 
            border: 1px solid var(--nike-black); 
            background: none; padding: 12px 25px; 
            border-radius: 0; font-weight: 600; 
            text-transform: uppercase; font-size: 0.8rem;
            transition: 0.3s; text-decoration: none; color: var(--nike-black);
            display: inline-block;
        }
        .btn-action:hover { background: var(--nike-black); color: #fff; }
    </style>
</head>
<body>

<div class="profile-container">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <a href="index.php" class="back-link">← BACK TO HOME</a>
        <div>
            <span class="small fw-bold text-uppercase">Member: <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h1 class="fw-bold mb-4" style="font-family: 'Inter'; font-weight: 800;">PLAYER PROFILE.</h1>
            
            <div class="bib-card">
                <div class="bib-header">NPRU MARATHON 2025</div>
                
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="bib-number">
                            <?php echo $user['bib_number'] ?: 'P-WAIT'; ?>
                        </div>
                        <h2 class="fw-bold text-uppercase mb-0">
                            <?php echo htmlspecialchars($user['first_name'] . " " . $user['last_name']); ?>
                        </h2>
                    </div>
                    <div class="col-md-4 text-md-end mt-4 mt-md-0">
                        <div class="mb-2">
                            <label class="d-block small text-muted text-uppercase fw-bold">Race Category</label>
                            <span class="h4 fw-bold"><?php echo $user['race_name'] ?: 'Not Registered'; ?></span>
                        </div>
                        <div>
                            <?php if($user['status'] == 'Paid'): ?>
                                <span class="status-pill status-paid">CONFIRMED</span>
                            <?php else: ?>
                                <span class="status-pill status-pending">PENDING PAYMENT</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-grid border-top pt-5">
                <div class="info-item">
                    <label>Registration ID</label>
                    <span>#<?php echo str_pad($user['runner_id'], 5, '0', STR_PAD_LEFT); ?></span>
                </div>
                <div class="info-item">
                    <label>Identity Number</label>
                    <span><?php echo htmlspecialchars($user['citizen_id']); ?></span>
                </div>
                <div class="info-item">
                    <label>Email Address</label>
                    <span><?php echo htmlspecialchars($user['email']); ?></span>
                </div>
                <div class="info-item">
                    <label>Date of Birth</label>
                    <span><?php echo ($user['date_of_birth']) ? date('d F Y', strtotime($user['date_of_birth'])) : '-'; ?></span>
                </div>
                <div class="info-item">
                    <label>Shirt Size</label>
                    <span>SIZE <?php echo $user['shirt_size'] ?: '-'; ?></span>
                </div>
                <div class="info-item">
                    <label>Shipping Method</label>
                    <span><?php echo $user['ship_type'] ?: 'N/A'; ?></span>
                </div>
            </div>

            <div class="mt-5 pt-4 d-flex flex-wrap gap-3 border-top">
                <?php if($user['status'] !== 'Paid'): ?>
                    <a href="payment.php" class="btn btn-dark rounded-0 px-4 py-3 fw-bold text-uppercase" style="font-size: 0.8rem;">
                        Inform Payment (แจ้งชำระเงิน)
                    </a>
                <?php endif; ?>
                <a href="edit_profile.php" class="btn btn-action">Edit Profile</a>
                <a href="logout.php" class="btn btn-action border-danger text-danger">Sign Out</a>
            </div>

        </div>
    </div>
</div>
</body>
</html>