<?php 
include 'config/db.php';
$id = $_GET['id'];
$data = $conn->query("SELECT r.*, c.name as race_name FROM REGISTRATION r JOIN RACE_CATEGORY c ON r.category_id = c.category_id WHERE r.reg_id = $id")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>SUCCESS | RUNNER PRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@800&family=Kanit:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Kanit', sans-serif; background: #f5f5f5; }
        .victory-card { background: white; border-radius: 0; border-top: 10px solid #111; padding: 60px; }
        .bib-box { border: 2px solid #111; display: inline-block; padding: 20px 40px; margin: 30px 0; }
        .bib-number { font-family: 'Inter', sans-serif; font-size: 4rem; font-weight: 800; line-height: 1; }
    </style>
</head>
<body>

<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="victory-card shadow-sm">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a6/Logo_NIKE.svg" height="25" class="mb-4" alt="">
                <h1 style="font-family: 'Inter'; font-weight: 800;">YOU'RE IN.</h1>
                <p class="text-muted text-uppercase">การสมัครของคุณเสร็จสมบูรณ์แล้ว</p>
                
                <div class="bib-box">
                    <div class="small text-uppercase fw-bold text-muted">Your Official BIB</div>
                    <div class="bib-number"><?php echo $data['bib_number']; ?></div>
                    <div class="fw-bold"><?php echo strtoupper($data['race_name']); ?></div>
                </div>

                <div class="mt-4">
                    <p class="mb-1">เลขที่ใบสั่งซื้อ: #<?php echo $data['reg_id']; ?></p>
                    <p class="fw-bold">สถานะ: <span class="text-danger"><?php echo strtoupper($data['status']); ?></span></p>
                </div>

                <a href="index.php" class="btn btn-dark rounded-pill px-5 py-3 mt-4 w-100 fw-bold">BACK TO HOME</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>