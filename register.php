<?php include 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER | RUNNER PRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@700;800&family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --nike-black: #111111;
            --nike-gray: #f5f5f5;
        }
        body { 
            font-family: 'Kanit', 'Inter', sans-serif; 
            background-color: #ffffff; 
            color: var(--nike-black);
        }
        /* Navigation */
        .navbar {
            padding: 1.5rem 2rem;
            background: white !important;
            border-bottom: 1px solid #eee;
        }
        .navbar-brand img {
            height: 30px; /* ปรับขนาดโลโก้ที่นี่ */
            filter: grayscale(100%);
        }
        /* Typography */
        h1, h2, h3 { font-family: 'Inter', sans-serif; font-weight: 800; text-transform: uppercase; letter-spacing: -1px; }
        .section-title { font-size: 1.5rem; margin-bottom: 2rem; border-left: 4px solid var(--nike-black); padding-left: 15px; }

        /* Form Style */
        .form-control, .form-select {
            border: 1px solid #e5e5e5;
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--nike-black);
            box-shadow: none;
        }
        .card { border: none; }

        /* Nike Button */
        .btn-nike {
            background-color: var(--nike-black);
            color: white;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            transition: 0.3s;
            text-transform: uppercase;
        }
        .btn-nike:hover {
            background-color: #444;
            color: white;
        }
        .price-display {
            font-size: 2.5rem;
            font-weight: 800;
            font-family: 'Inter', sans-serif;
        }
        .sticky-summary {
            position: sticky;
            top: 100px;
        }
        .navbar-brand img {
    height: 35px; /* ปรับความสูงตามความเหมาะสมของโลโก้คุณ */
    width: auto;  /* ให้ความกว้างปรับตามสัดส่วนภาพ */
    display: block;
    transition: transform 0.3s ease;
}

.navbar-brand img:hover {
    transform: scale(1.05); /* เพิ่มลูกเล่นเวลาเอาเมาส์ไปวาง */
}
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">
    <img src="../assets/logo.png" height="30" alt="Admin Logo">
</a>
        <div class="ms-auto">
            <span class="fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Marathon 2025</span>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-7">
            <h1 class="display-4 mb-5">BECOME A<br>RUNNER.</h1>
            
            <form action="process_register.php" method="POST" id="regForm">
                
                <div class="mb-5">
                    <div class="section-title">ข้อมูลผู้สมัคร</div>
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
                    </div>
                </div>
<div class="row g-3">
    <div class="col-md-12">
        <label class="small text-muted mb-1">เลขบัตรประจำตัวประชาชน (13 หลัก)</label>
        <input type="text" name="citizen_id" class="form-control" maxlength="13" placeholder="x-xxxx-xxxxx-xx-x" required>
    </div>

    <div class="col-md-12">
        <label class="small text-muted mb-1">อีเมล (Email)</label>
        <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
    </div>

    <div class="col-md-12">
        <label class="small text-muted mb-1">ที่อยู่สำหรับการจัดส่ง (กรอกเมื่อเลือก EMS)</label>
        <textarea name="address" class="form-control" rows="2" placeholder="บ้านเลขที่, ถนน, แขวง/ตำบล, เขต/อำเภอ, จังหวัด, รหัสไปรษณีย์"></textarea>
    </div>

    <div class="col-12 mt-3">
        <div class="form-check p-0 d-flex align-items-center">
            <input class="form-check-input ms-0 me-2" type="checkbox" name="is_disabled" id="is_disabled" value="1">
            <label class="form-check-label small" for="is_disabled">
                ฉันเป็นผู้พิการ (ต้องการรับสิทธิ์ราคาพิเศษสำหรับผู้พิการ)
            </label>
        </div>
    </div>
</div>
                <div class="mb-5">
    <div class="section-title">เลือกการแข่งขัน</div>
    <div class="row g-3">
        <div class="col-12">
            <label class="small text-muted mb-1">ระยะทางที่คุณต้องการท้าทาย</label>
            <select name="category_id" id="category" class="form-select mb-3" onchange="updatePrice()" required>
    <option value="" data-price="0">-- กรุณาเลือกระยะทาง --</option>
    <?php
    // ตรวจสอบการเชื่อมต่อก่อนดึงข้อมูล
    if ($conn->connect_error) {
        echo "<option value=''>Database Connection Error</option>";
    } else {
        // Query ดึงข้อมูลจากฐานข้อมูล running
        $sql_cat = "SELECT c.category_id, c.name, p.amount 
                    FROM RACE_CATEGORY c 
                    INNER JOIN PRICE_RATE p ON c.category_id = p.category_id 
                    WHERE p.runner_type = 'Standard'";
        
        $res_cat = $conn->query($sql_cat);

        if ($res_cat && $res_cat->num_rows > 0) {
            while($row = $res_cat->fetch_assoc()) {
                echo "<option value='{$row['category_id']}' data-price='{$row['amount']}'>";
                echo strtoupper($row['name']) . " - ฿" . number_format($row['amount']);
                echo "</option>";
            }
        } else {
            // กรณีไม่มีข้อมูล หรือ Query ผิด
            echo "<option value=''>ไม่พบข้อมูลการแข่งขัน (กรุณาเช็คตาราง PRICE_RATE)</option>";
            // แสดง Error จริงออกมาเพื่อการ Debug (เฉพาะตอน Develop)
            // echo "<option value=''>" . $conn->error . "</option>"; 
        }
    }
    ?>
</select>
        </div>
        
        <div class="col-md-6">
            <label class="small text-muted mb-1">ไซส์เสื้อ (Shirt Size)</label>
            <select name="shirt_size" class="form-select" required>
                <option value="">เลือกไซส์เสื้อ</option>
                <option value="S">S (รอบอก 36")</option>
                <option value="M">M (รอบอก 38")</option>
                <option value="L">L (รอบอก 40")</option>
                <option value="XL">XL (รอบอก 42")</option>
                <option value="2XL">2XL (รอบอก 44")</option>
            </select>
        </div>
    </div>
</div>

                <div class="mb-5">
                    <div class="section-title">การจัดส่ง</div>
                    <div class="bg-light p-4 rounded-3">
                        <?php
                        $ship = $conn->query("SELECT * FROM SHIPPING_OPTION");
                        while($s = $ship->fetch_assoc()) {
                            $checked = ($s['shipping_id'] == 2) ? "checked" : "";
                            echo "<div class='form-check mb-3'>
                                    <input class='form-check-input' type='radio' name='shipping_id' id='ship{$s['shipping_id']}' value='{$s['shipping_id']}' data-cost='{$s['cost']}' onchange='updatePrice()' $checked>
                                    <label class='form-check-label d-flex justify-content-between w-100' for='ship{$s['shipping_id']}'>
                                        <span>{$s['type']} <br><small class='text-muted'>{$s['detail']}</small></span>
                                        <span class='fw-bold'>฿{$s['cost']}</span>
                                    </label>
                                  </div>";
                        }
                        ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-nike w-100 mb-5">ลงทะเบียนตอนนี้</button>
            </form>
        </div>

        <div class="col-lg-4 offset-lg-1">
            <div class="sticky-summary">
                <h3 class="mb-4">สรุปยอดชำระ</h3>
                <div class="d-flex justify-content-between mb-2">
                    <span>ค่าสมัครวิ่ง</span>
                    <span id="race_price_display">฿0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <span>ค่าจัดส่ง</span>
                    <span id="ship_price_display">฿0.00</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <span class="h5 mb-0">รวมทั้งสิ้น</span>
                    <span class="price-display">฿<span id="total_display">0</span></span>
                </div>
                <p class="small text-muted">การกดลงทะเบียนแสดงว่าคุณยอมรับเงื่อนไขการเข้าแข่งขันและระเบียบความปลอดภัยของเรา</p>
            </div>
        </div>
    </div>
</div>

<script>
function updatePrice() {
    // 1. ดึงราคางานวิ่งที่เลือก
    const categorySelect = document.getElementById('category');
    const selectedOption = categorySelect.options[categorySelect.selectedIndex];
    const racePrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
    
    // 2. ดึงค่าจัดส่งที่เลือก
    const shippingRadios = document.getElementsByName('shipping_id');
    let shipPrice = 0;
    for (const radio of shippingRadios) {
        if (radio.checked) {
            shipPrice = parseFloat(radio.getAttribute('data-cost')) || 0;
            break;
        }
    }

    // 3. คำนวณยอดรวม
    const total = racePrice + shipPrice;
    
    // 4. แสดงผลในหน้าเว็บ
    document.getElementById('race_price_display').innerText = '฿' + racePrice.toLocaleString(undefined, {minimumFractionDigits: 2});
    document.getElementById('ship_price_display').innerText = '฿' + shipPrice.toLocaleString(undefined, {minimumFractionDigits: 2});
    document.getElementById('total_display').innerText = total.toLocaleString();
}
// รันตอนโหลดหน้าเว็บ
updatePrice();
</script>

</body>
</html>