<?php
session_start();
include 'config/db.php';

// เตรียมข้อมูลสำหรับ User ที่ล็อกอินแล้ว
$user_bib = "";
$reg_status = "";

// ตรวจสอบว่าใช้ Session ชื่ออะไร (สมมติใช้ user_id ตามที่คุณเช็คใน HTML)
if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];

    // ใช้ Prepared Statement เพื่อความปลอดภัย
    $stmt = $conn->prepare("SELECT bib_number, status FROM registration WHERE runner_id = ? LIMIT 1");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows > 0) {
        $data = $res->fetch_assoc();
        $user_bib = $data['bib_number'];
        $reg_status = $data['status'];
    }
    $stmt->close();
}

// ดึงข้อมูลตารางผู้สมัคร (แสดงทั้งหมด)
$sql = "SELECT reg.reg_id, run.first_name, run.last_name, cat.name AS race_name,
               cat.distance_km, reg.status, reg.bib_number
        FROM registration reg
        JOIN runner run ON reg.runner_id = run.runner_id
        JOIN race_category cat ON reg.category_id = cat.category_id
        ORDER BY reg.reg_id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUNNER PRO | JUST RUN IT.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@800&family=Kanit:wght@300;600&display=swap" rel="stylesheet">
    <style>
        :root { --nike-black: #111; }
        body { font-family: 'Kanit', sans-serif; color: var(--nike-black); background-color: #fff; }
        h1 { font-family: 'Inter', sans-serif; font-weight: 800; font-size: clamp(3rem, 10vw, 5rem); line-height: 0.9; letter-spacing: -2px; }
        .navbar { padding: 1.2rem 2rem; background: white; border-bottom: 1px solid #eee; }
        .hero-section { padding: 60px 0; }
        .hero-image { width: 100%; height: 500px; object-fit: cover; border-radius: 4px; }
        .btn-nike { background: var(--nike-black); color: white; padding: 12px 35px; border-radius: 50px; text-transform: uppercase; font-weight: 600; text-decoration: none; transition: 0.3s; border: none; }
        .btn-nike:hover { background: #444; color: white; transform: scale(1.02); }
        .status-badge { font-size: 0.9rem; padding: 4px 12px; border-radius: 20px; }
    </style>
</head>

<body>

    <nav class="navbar sticky-top shadow-sm">
        <div class="container-fluid px-md-5">
            <a class="navbar-brand" href="index.php">
                <span style="font-family: 'Inter'; font-weight: 800; letter-spacing: -1px;">RUNNER PRO</span>
            </a>
            
            <div class="ms-auto d-flex align-items-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="user-welcome d-none d-md-block text-uppercase me-3 small fw-bold">สวัสดี, <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
                    <a href="profile.php" class="btn btn-outline-dark btn-sm rounded-pill px-3 me-2">MY BIB</a>
                    <a href="logout.php" class="btn-nike" style="font-size: 0.75rem; padding: 6px 15px; background: #dc3545;">LOGOUT</a>
                <?php else: ?>
                    <a href="register.php" class="text-decoration-none text-dark fw-bold me-4 small">REGISTER</a>
                    <a href="login_form.php" class="btn-nike" style="font-size: 0.85rem; padding: 8px 24px;">SIGN IN</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container text-center">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="mb-5 p-4 bg-light rounded-4 d-inline-block border">
                    <span class="text-muted small text-uppercase fw-bold">Your Race Info</span>
                    <h2 class="fw-bold mt-2">BIB: <span class="text-primary"><?php echo $user_bib ?: 'รอการยืนยัน'; ?></span></h2>
                    <div class="mt-2">
                        <?php 
                        if ($reg_status == 'Paid') {
                            echo '<span class="status-badge bg-success text-white">ชำระเงินเรียบร้อยแล้ว</span>';
                        } elseif ($reg_status == 'Pending') {
                            echo '<span class="status-badge bg-warning text-dark">รอการตรวจสอบชำระเงิน</span>';
                        } else {
                            echo '<a href="registration_form.php" class="btn btn-sm btn-dark">ลงทะเบียนงานวิ่งเลย</a>';
                        }
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <h1 class="mb-4 text-uppercase">Win From<br>Within.</h1>
            <p class="lead mb-5 text-secondary mx-auto" style="max-width: 600px;">ท้าทายขีดจำกัดของคุณในงาน Nakhon Pathom Marathon 2025 ประสบการณ์การวิ่งระดับพรีเมียม</p>
            
            <div class="mb-5">
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="register.php" class="btn-nike">เริ่มสมัครใช้งาน</a>
                <?php endif; ?>
            </div>

            <div class="row g-0">
                <div class="col-12">
                    <img src="https://images.unsplash.com/photo-1530143311094-34d807799e8f?auto=format&fit=crop&q=80&w=2000" class="hero-image mb-5 shadow-lg" alt="Runner">
                </div>
            </div>

            <div class="row mt-5 py-5 border-top border-bottom">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h3 class="fw-bold mb-0">42.195 KM</h3>
                    <p class="text-muted small fw-bold">FULL MARATHON</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h3 class="fw-bold mb-0">21.1 KM</h3>
                    <p class="text-muted small fw-bold">HALF MARATHON</p>
                </div>
                <div class="col-md-4">
                    <h3 class="fw-bold mb-0">10.5 KM</h3>
                    <p class="text-muted small fw-bold">MINI MARATHON</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Participants List Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">รายชื่อผู้เข้าร่วม</h2>
                <p class="text-muted">แสดงผู้ที่ลงทะเบียนทั้งหมด</p>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>ประเภทการแข่งขัน</th>
                            <th>ระยะทาง</th>
                            <th>เลข BIB</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // ดึงข้อมูลตารางผู้สมัคร (แสดงทั้งหมด)
                        $sql = "SELECT reg.reg_id, run.first_name, run.last_name, cat.name AS race_name,
                                       cat.distance_km, reg.status, reg.bib_number
                                FROM registration reg
                                JOIN runner run ON reg.runner_id = run.runner_id
                                JOIN race_category cat ON reg.category_id = cat.category_id
                                ORDER BY reg.reg_id ASC";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0):
                            $counter = 1;
                            while($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td class="fw-bold">#<?php echo $counter++; ?></td>
                            <td><?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></td>
                            <td><?php echo htmlspecialchars(strtoupper($row['race_name'])); ?></td>
                            <td><?php echo $row['distance_km']; ?> KM</td>
                            <td><?php echo $row['bib_number'] ?: 'ยังไม่กำหนด'; ?></td>
                            <td>
                                <?php if($row['status'] == 'Paid'): ?>
                                    <span class="badge bg-success">ชำระเงินแล้ว</span>
                                <?php elseif($row['status'] == 'Pending'): ?>
                                    <span class="badge bg-warning text-dark">รอการชำระเงิน</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?php echo htmlspecialchars($row['status']); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php
                            endwhile;
                        else:
                        ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">ยังไม่มีผู้เข้าร่วมที่ลงทะเบียน</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <footer class="bg-white py-5 mt-5">
        <div class="container border-top pt-5">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-4 mb-md-0">
                    <h5 class="fw-bold">RUNNER PRO.</h5>
                    <p class="small text-muted mb-0">© 2025 POWERED BY SOFTWARE ENGINEERING NPRU.</p>
                </div>

                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-unstyled d-flex justify-content-center justify-content-md-end gap-4 mb-0">
                        <li><a href="index.php" class="text-dark text-decoration-none small fw-bold text-uppercase">Home</a></li>
                        <li><a href="register.php" class="text-dark text-decoration-none small fw-bold text-uppercase">Register</a></li>
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                            <li><a href="admin/admin_dashboard.php" class="text-danger text-decoration-none small fw-bold">ADMIN PANEL</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>