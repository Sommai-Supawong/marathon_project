<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'config/db.php'; 
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER | RUNNER PRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@700;800&family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --nike-black: #111111; --nike-gray: #f5f5f5; }
        body { font-family: 'Kanit', sans-serif; background-color: #ffffff; color: var(--nike-black); }
        .navbar { padding: 1rem 2rem; background: white !important; border-bottom: 1px solid #eee; }
        .navbar-brand img { height: 35px; width: auto; transition: 0.3s; }
        .navbar-brand img:hover { transform: scale(1.1); }
        
        h1, h2, h3 { font-family: 'Inter', sans-serif; font-weight: 800; text-transform: uppercase; letter-spacing: -1px; }
        .section-title { font-size: 1.2rem; margin-bottom: 2rem; border-left: 4px solid var(--nike-black); padding-left: 15px; font-weight: 600; }

        .form-control, .form-select { border: 1px solid #e5e5e5; padding: 12px; border-radius: 4px; font-size: 1rem; }
        .form-control:focus, .form-select:focus { border-color: var(--nike-black); box-shadow: none; }

        .btn-nike { background-color: var(--nike-black); color: white; padding: 16px; border-radius: 50px; font-weight: 600; border: none; transition: 0.3s; text-transform: uppercase; width: 100%; }
        .btn-nike:hover { background-color: #444; color: white; }
        
        .price-display { font-size: 2.5rem; font-weight: 800; font-family: 'Inter', sans-serif; }
        .sticky-summary { position: sticky; top: 100px; background: var(--nike-gray); padding: 30px; border-radius: 8px; }
    </style>
</head>
<body>

<nav class="navbar sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="assets/logo.png" alt="Logo">
        </a>
        <div class="ms-auto d-none d-md-block">
            <span class="fw-bold text-uppercase small" style="letter-spacing: 1px;">NPRU Marathon 2025</span>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-7">
            <h1 class="display-4 mb-5">BECOME A<br>RUNNER.</h1>
            
            <form action="process_register.php" method="POST" id="regForm">
                
                <div class="mb-5">
                    <div class="section-title">ข้อมูลผู้สมัคร (PERSONAL INFO)</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="first_name" class="form-control" placeholder="ชื่อจริง" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="last_name" class="form-control" placeholder="นามสกุล" required>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted mb-1">วันเกิด</label>
                            <input type="date" name="date_of_birth" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted mb-1">เพศ</label>
                            <select name="gender" class="form-select">
                                <option value="Male">ชาย</option>
                                <option value="Female">หญิง</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="citizen_id" class="form-control" maxlength="13" placeholder="เลขบัตรประชาชน 13 หลัก" required>
                        </div>
                        <div class="col-md-12">
                            <input type="email" name="email" class="form-control" placeholder="อีเมลสำหรับการติดต่อ" required>
                        </div>
                        <div class="col-md-12">
                            <textarea name="address" class="form-control" rows="2" placeholder="ที่อยู่สำหรับการจัดส่งอุปกรณ์"></textarea>
                        </div>
                        <div class="col-md-12">
                            <input type="password" name="reg_password" class="form-control" placeholder="ตั้งรหัสผ่าน (Password)" minlength="6" required>
                            <small class="text-secondary mt-1 d-block">ชื่อผู้ใช้งานของคุณคือเลขบัตรประชาชน</small>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-check d-flex align-items-center">
                                <input class="form-check-input me-2" type="checkbox" name="is_disabled" id="is_disabled" value="1" onchange="updatePrice()">
                                <label class="form-check-label small fw-bold" for="is_disabled">
                                    ฉันเป็นผู้พิการ (รับสิทธิ์วิ่งฟรี!)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <div class="section-title">เลือกการแข่งขัน (RACE & SHIRT)</div>
                    <div class="row g-3">
                        <div class="col-12">
                            <select name="category_id" id="category" class="form-select mb-3" onchange="updatePrice()" required>
                                <option value="" data-price="0">-- เลือกระยะทาง --</option>
                                <?php
                                $sql_cat = "SELECT c.category_id, c.name, p.amount FROM race_category c JOIN price_rate p ON c.category_id = p.category_id WHERE p.runner_type = 'Standard'";
                                $res_cat = $conn->query($sql_cat);
                                while($row = $res_cat->fetch_assoc()) {
                                    echo "<option value='{$row['category_id']}' data-price='{$row['amount']}'>" . strtoupper($row['name']) . " - ฿" . number_format($row['amount']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <select name="shirt_size" class="form-select" required>
                                <option value="">เลือกไซส์เสื้อ</option>
                                <option value="S">S (36")</option><option value="M">M (38")</option>
                                <option value="L">L (40")</option><option value="XL">XL (42")</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <div class="section-title">การจัดส่ง (SHIPPING)</div>
                    <div class="bg-light p-3 border rounded">
                        <?php
                        $ship = $conn->query("SELECT * FROM shipping_option");
                        while($s = $ship->fetch_assoc()) {
                            $checked = ($s['shipping_id'] == 2) ? "checked" : "";
                            echo "<div class='form-check mb-2'>
                                    <input class='form-check-input' type='radio' name='shipping_id' id='ship{$s['shipping_id']}' value='{$s['shipping_id']}' data-cost='{$s['cost']}' onchange='updatePrice()' $checked>
                                    <label class='form-check-label d-flex justify-content-between w-100' for='ship{$s['shipping_id']}'>
                                        <span>{$s['type']}</span>
                                        <span class='fw-bold'>฿" . number_format($s['cost']) . "</span>
                                    </label>
                                  </div>";
                        }
                        ?>
                    </div>
                </div>

                <button type="submit" class="btn-nike mb-5">COMPLETE REGISTRATION</button>
            </form>
        </div>

        <div class="col-lg-4 offset-lg-1">
            <div class="sticky-summary shadow-sm">
                <h3 class="mb-4">SUMMARY</h3>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Race Fee</span>
                    <span id="race_price_display">฿0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <span class="text-muted">Shipping</span>
                    <span id="ship_price_display">฿0.00</span>
                </div>
                <hr>
                <div class="text-end">
                    <div class="small fw-bold">TOTAL</div>
                    <div class="price-display">฿<span id="total_display">0</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updatePrice() {
    const categorySelect = document.getElementById('category');
    const selectedOption = categorySelect.options[categorySelect.selectedIndex];
    const isDisabled = document.getElementById('is_disabled').checked;
    
    // ถ้าเป็นผู้พิการ ให้ค่าสมัครเป็น 0 (ตัวอย่าง Logic)
    let racePrice = isDisabled ? 0 : (parseFloat(selectedOption.getAttribute('data-price')) || 0);
    
    const shippingRadios = document.getElementsByName('shipping_id');
    let shipPrice = 0;
    for (const radio of shippingRadios) {
        if (radio.checked) {
            shipPrice = parseFloat(radio.getAttribute('data-cost')) || 0;
            break;
        }
    }

    const total = racePrice + shipPrice;
    
    document.getElementById('race_price_display').innerText = '฿' + racePrice.toLocaleString(undefined, {minimumFractionDigits: 2});
    document.getElementById('ship_price_display').innerText = '฿' + shipPrice.toLocaleString(undefined, {minimumFractionDigits: 2});
    document.getElementById('total_display').innerText = total.toLocaleString();
}
updatePrice();
</script>

</body>
</html>