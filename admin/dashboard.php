<?php
// คำสั่ง SQL สำหรับสรุปยอด
$total_runners = $conn->query("SELECT COUNT(*) as total FROM REGISTRATION")->fetch_assoc()['total'];
$paid_runners = $conn->query("SELECT COUNT(*) as total FROM REGISTRATION WHERE status='Paid'")->fetch_assoc()['total'];
$total_income = $conn->query("SELECT SUM(total_amount) as total FROM PAYMENT WHERE status='Success'")->fetch_assoc()['total'];
?>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white shadow-sm border-0">
            <div class="card-body">
                <h6>ผู้สมัครทั้งหมด</h6>
                <h2 class="mb-0"><?php echo number_format($total_runners); ?> คน</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white shadow-sm border-0">
            <div class="card-body">
                <h6>ชำระเงินแล้ว</h6>
                <h2 class="mb-0"><?php echo number_format($paid_runners); ?> คน</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white shadow-sm border-0">
            <div class="card-body">
                <h6>รายได้รวม (ประมาณการ)</h6>
                <h2 class="mb-0">฿<?php echo number_format($total_income, 2); ?></h2>
            </div>
        </div>
    </div>
</div>