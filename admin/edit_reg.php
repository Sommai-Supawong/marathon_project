<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login_form.php");
    exit();
}

$id = $_GET['id'];
$res = $conn->query("SELECT reg.*, run.first_name, run.last_name FROM REGISTRATION reg 
                    JOIN RUNNER run ON reg.runner_id = run.runner_id 
                    WHERE reg.reg_id = $id");
$data = $res->fetch_assoc();

// ประมวลผลเมื่อกดบันทึก
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $_POST['status'];
    $bib = $_POST['bib_number'];
    
    $update = "UPDATE REGISTRATION SET status='$status', bib_number='$bib' WHERE reg_id=$id";
    if ($conn->query($update)) {
        header("Location: admin_dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>EDIT REGISTRATION | ADMIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@800&family=Kanit:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Kanit', sans-serif; background: #f8f9fa; }
        .edit-card { background: white; border-radius: 0; border-top: 5px solid #111; padding: 40px; }
        .btn-nike { background: #111; color: white; border-radius: 50px; padding: 10px 30px; border: none; font-weight: 600; text-transform: uppercase; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="edit-card shadow-sm">
                <h2 style="font-family: 'Inter'; font-weight: 800;" class="mb-4">EDIT RUNNER</h2>
                <p class="text-muted mb-4">แก้ไขสถานะของ: <strong><?php echo $data['first_name']." ".$data['last_name']; ?></strong></p>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">สถานะการชำระเงิน</label>
                        <select name="status" class="form-select">
                            <option value="Pending" <?php if($data['status']=='Pending') echo 'selected'; ?>>Pending (รอชำระ)</option>
                            <option value="Paid" <?php if($data['status']=='Paid') echo 'selected'; ?>>Paid (ชำระแล้ว)</option>
                            <option value="Cancelled" <?php if($data['status']=='Cancelled') echo 'selected'; ?>>Cancelled (ยกเลิก)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">หมายเลข BIB</label>
                        <input type="text" name="bib_number" class="form-control" value="<?php echo $data['bib_number']; ?>" placeholder="เช่น R-0001">
                    </div>

                    <div class="d-flex gap-2 mt-5">
                        <button type="submit" class="btn btn-nike w-100">SAVE CHANGES</button>
                        <a href="admin_dashboard.php" class="btn btn-light w-100 rounded-pill fw-bold border">CANCEL</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>