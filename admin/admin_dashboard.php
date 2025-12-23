<?php
session_start();
include '../config/db.php';

// 1. ตรวจสอบสิทธิ์ (Security Check)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login_form.php");
    exit();
}

// 2. ดึงข้อมูลสถิติ
$total_runners = $conn->query("SELECT COUNT(*) as total FROM REGISTRATION")->fetch_assoc()['total'];
$paid_runners = $conn->query("SELECT COUNT(*) as total FROM REGISTRATION WHERE status='Paid'")->fetch_assoc()['total'];
// คำนวณรายได้โดยเชื่อมตาราง PRICE_RATE
$income_res = $conn->query("SELECT SUM(p.amount) as total 
                            FROM REGISTRATION r 
                            JOIN PRICE_RATE p ON r.price_id = p.price_id 
                            WHERE r.status='Paid'")->fetch_assoc()['total'];

// 3. ดึงข้อมูลตารางผู้สมัคร
$sql = "SELECT reg.reg_id, run.first_name, run.last_name, cat.name AS race_name, 
               cat.distance_km, reg.status, reg.reg_date, reg.bib_number
        FROM REGISTRATION reg
        JOIN RUNNER run ON reg.runner_id = run.runner_id
        JOIN RACE_CATEGORY cat ON reg.category_id = cat.category_id
        ORDER BY reg.reg_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD | RUNNER PRO ADMIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;800&family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --nike-black: #111; --bg-gray: #f8f9fa; }
        body { font-family: 'Kanit', sans-serif; background-color: var(--bg-gray); color: var(--nike-black); }
        h1, h2, .stats-val { font-family: 'Inter', sans-serif; font-weight: 800; text-transform: uppercase; }
        
        /* Sidebar/Navbar */
        .admin-nav { background: white; border-bottom: 1px solid #eee; padding: 1rem 2rem; }
        .admin-nav img { height: 25px; }

        /* Stats Cards */
        .stat-card { border: none; border-radius: 0; background: white; padding: 25px; transition: 0.3s; border-left: 5px solid var(--nike-black); }
        .stat-label { font-size: 0.75rem; font-weight: 600; color: #888; text-transform: uppercase; letter-spacing: 1px; }
        .stat-val { font-size: 1.8rem; margin-top: 5px; }

        /* Table Style */
        .table-container { background: white; padding: 30px; border-radius: 0; box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
        .table thead th { background: transparent; color: #888; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; border-bottom: 2px solid #eee; padding: 15px; }
        .table tbody td { padding: 18px 15px; vertical-align: middle; border-bottom: 1px solid #f1f1f1; }
        
        /* Status Badges */
        .badge-paid { background: #e6fcf5; color: #0ca678; padding: 6px 12px; border-radius: 4px; font-weight: 600; font-size: 0.75rem; }
        .badge-pending { background: #fff4e6; color: #f76707; padding: 6px 12px; border-radius: 4px; font-weight: 600; font-size: 0.75rem; }
        
        .btn-action { border-radius: 4px; font-weight: 600; font-size: 0.8rem; padding: 8px 16px; text-transform: uppercase; transition: 0.3s; }
    </style>
</head>
<body>

<nav class="admin-nav sticky-top d-flex justify-content-between align-items-center">
    <a href="../index.php">
        <img src="../assets/logo.png" alt="Logo">
    </a>
    <div class="d-flex align-items-center gap-3">
        <span class="small fw-bold">ADMIN: <?php echo $_SESSION['full_name']; ?></span>
        <a href="../logout.php" class="btn btn-outline-dark btn-sm rounded-pill px-3">Logout</a>
    </div>
</nav>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <h6 class="text-muted mb-1 text-uppercase small fw-bold">Overview</h6>
            <h1 class="mb-0">Race Management</h1>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card shadow-sm">
                <div class="stat-label">Total Runners</div>
                <div class="stat-val"><?php echo number_format($total_runners); ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card shadow-sm" style="border-left-color: #0ca678;">
                <div class="stat-label">Paid Registrations</div>
                <div class="stat-val"><?php echo number_format($paid_runners); ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card shadow-sm" style="border-left-color: #f76707;">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-val">฿<?php echo number_format($income_res ?? 0, 2); ?></div>
            </div>
        </div>
    </div>

    <div class="table-container shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Registration List</h5>
            <button class="btn btn-dark btn-sm rounded-0">Export CSV</button>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Runner Name</th>
                        <th>Race Category</th>
                        <th>BIB Number</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="fw-bold text-muted">#<?php echo $row['reg_id']; ?></td>
                        <td>
                            <div class="fw-bold"><?php echo $row['first_name'] . " " . $row['last_name']; ?></div>
                            <div class="small text-muted"><?php echo $row['reg_date']; ?></div>
                        </td>
                        <td>
                            <div class="fw-bold"><?php echo strtoupper($row['race_name']); ?></div>
                            <div class="small text-muted"><?php echo $row['distance_km']; ?> KM</div>
                        </td>
                        <td>
                            <code class="fw-bold text-dark h6 mb-0"><?php echo $row['bib_number'] ?: '---'; ?></code>
                        </td>
                        <td>
                            <?php if($row['status'] == 'Paid'): ?>
                                <span class="badge-paid">PAID</span>
                            <?php else: ?>
                                <span class="badge-pending">PENDING</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="edit_reg.php?id=<?php echo $row['reg_id']; ?>" class="btn btn-outline-dark btn-action">Edit</a>
                                <button onclick="deleteEntry(<?php echo $row['reg_id']; ?>)" class="btn btn-outline-danger btn-action">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function deleteEntry(id) {
        if(confirm('Are you sure you want to delete this registration? This action cannot be undone.')) {
            window.location.href = 'delete_process.php?id=' + id;
        }
    }
</script>

</body>
</html>