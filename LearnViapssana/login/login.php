<?php
session_start();
include('../includes/connect.php');

// แสดงข้อความสำเร็จจาก session
if (isset($_SESSION['success_message'])) {
    echo '<div style="color: green; font-weight: 400; display: flex; justify-content: center; align-items: center; 
            width: 100%; position: fixed; z-index: 100; top: 0; background: #d4edda; padding: 10px; text-align: center;">
            ' . $_SESSION['success_message'] . '
          </div>';
    unset($_SESSION['success_message']);
}

$message = '';

try {
    function logLoginAttempt($conn, $userId, $status, $ipAddress, $deviceInfo, $errorMessage = null)
    {
        $stmt = $conn->prepare("INSERT INTO login_logs (user_id, status, ip_address, device_info, error_message) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $status, $ipAddress, $deviceInfo, $errorMessage]);
    }

    if (isset($_COOKIE['remember_token'])) {
        $rememberToken = $_COOKIE['remember_token'];
        $stmt = $conn->prepare("SELECT * FROM users WHERE remember_token = ?");
        $stmt->execute([$rememberToken]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['remember_token'] === $rememberToken) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['first_name'] = $user['fname'];
            $_SESSION['last_name'] = $user['lname'];
            $_SESSION['role'] = $user['role'];

            $deviceInfo = $_SERVER['HTTP_USER_AGENT'];
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            logLoginAttempt($conn, $user['user_id'], 'success', $ipAddress, $deviceInfo);

            header('Location: ' . ($user['role'] == 'admin' ? '../Admin/' : '../Lessons/'));
            exit();
        } else {
            setcookie('remember_token', '', time() - 3600, "/");
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $deviceInfo = $_SERVER['HTTP_USER_AGENT'];
        $ipAddress = $_SERVER['REMOTE_ADDR'];

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['first_name'] = $user['fname'];
            $_SESSION['last_name'] = $user['lname'];
            $_SESSION['role'] = $user['role'];

            logLoginAttempt($conn, $user['user_id'], 'success', $ipAddress, $deviceInfo);

            if (isset($_POST['remember_me']) && $_POST['remember_me'] == 'on') {
                // สร้าง Token แบบสุ่ม
                $rememberToken = bin2hex(random_bytes(16));
            
                // ตั้งค่าคุกกี้ remember_token
                setcookie("remember_token", $rememberToken, [
                    "expires" => time() + (60 * 60 * 24 * 30), // 30 วัน
                    "path" => "/",
                    "domain" => "", // สามารถตั้งค่าเป็นโดเมนของคุณ เช่น "example.com"
                    "secure" => true, // ใช้ HTTPS เท่านั้น
                    "httponly" => true, // ป้องกันการเข้าถึงจาก JavaScript
                    "samesite" => "Strict" // ป้องกัน CSRF
                ]);
            
                // บันทึก Token ลงในฐานข้อมูล
                $stmt = $conn->prepare("UPDATE users SET remember_token = ? WHERE user_id = ?");
                $stmt->execute([$rememberToken, $user['user_id']]);
            }
            

            // $_SESSION['success_message'] = "เข้าสู่ระบบสำเร็จ!";
            header('Location: ' . ($user['role'] == 'admin' ? '../Admin/' : '../Lessons/'));
            exit();
        } else {
            $message = 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!';
            logLoginAttempt($conn, $user['user_id'] ?? null, 'failed', $ipAddress, $deviceInfo, $message);
        }
    }
} catch (PDOException $e) {
    echo 'เกิดข้อผิดพลาด: ' . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LINK CSS -->
    <link rel="stylesheet" href="../assets/css/login.css">
    <style>
        .cookie-banner {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .cookie-banner button {
            background: #ff9800;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            color: white;
            font-weight: bold;
            border-radius: 5px;
        }

        .cookie-banner button:hover {
            opacity: 0.8;
        }
    </style>

    <!-- LINK ICONS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>เข้าสู่ระบบ</title>
</head>

<body>
    <main>
        <div class="container">
            <form class="form-login" method="POST">
                <h1>เข้าสู่ระบบ</h1>
                <div class="inputbox">
                    <input type="text" name="email" placeholder="อีเมล" required>
                </div>
                <div class="inputbox show-password">
                    <input type="password" name="password" placeholder="รหัสผ่าน" required>
                    <img src="../assets/img/eye-password/eye-close.png" id="eye-close">
                </div>
                <div class="remember" style="display: flex; gap: 5px;">
                    <input type="checkbox" name="remember_me" id="remember_me">
                    <label for="remember_me">จดจำฉัน</label>
                </div>
                <!-- แสดงข้อความผิดพลาด -->
                <?php if ($message) : ?>
                    <div class="alert alert-danger" style="color: red;" role="alert">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>
                <a href="./forgot.php">ลืมรหัสผ่าน</a>
                <div class="box-button">
                    <button type="submit">เข้าสู่ระบบ</button>
                </div>
            </form>
            <div class="box-link">
                <span>ยังไม่มีบัญชีผู้ใช้? <a href="./register.php">สมัครสมาชิก</a></span>
            </div>
        </div>
        <a class="link-return" href="../"><i class='bx bx-left-arrow-alt'></i> กลับหน้าแรก</a>
    </main>

    <!-- แถบแจ้งเตือนการใช้คุกกี้ -->
    <div id="cookie-banner" class="cookie-banner" style="display: none;">
        <p>เว็บไซต์นี้ใช้คุกกี้เพื่อปรับปรุงประสบการณ์ของคุณ <a href="../privacy.php">เรียนรู้เพิ่มเติม</a></p>
        <button id="accept-cookies">ยอมรับ</button>
        <button id="deny-cookies">ปฏิเสธ</button>
    </div>

    <script>
        // ฟังก์ชันสำหรับแสดง/ซ่อนรหัสผ่าน
        const passwordInput = document.querySelector('.show-password input[type="password"]');
        const eyeClose = document.getElementById('eye-close'); 
      
        eyeClose.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeClose.src = '../assets/img/eye-password/eye-open.png'; // เปลี่ยนเป็น icon เปิดตา
                } else {
                    passwordInput.type = 'password';
                    eyeClose.src = '../assets/img/eye-password/eye-close.png'; // เปลี่ยนเป็น icon ปิดตา
                }
            });



        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector(".form-login");
            const rememberMeCheckbox = document.querySelector("#remember_me");
            const cookieBanner = document.getElementById("cookie-banner");
            const acceptButton = document.getElementById("accept-cookies");
            const denyButton = document.getElementById("deny-cookies");
            const rememberSection = document.querySelector(".remember"); // เลือก div ที่มี checkbox
            const cookieConsent = localStorage.getItem("cookie_consent"); // โหลดสถานะการยอมรับคุกกี้จาก localStorage

            // ถ้าผู้ใช้กด "ยอมรับ" คุกกี้
            acceptButton.addEventListener("click", function() {
                localStorage.setItem("cookie_consent", "accepted"); // บันทึกสถานะการยอมรับคุกกี้ไปยัง localStorage
                document.cookie = "remember_token=" + generateToken() + "; path=/; max-age=" + (60 * 60 * 24 * 30); // ตั้งคุกกี้ remember_token
                cookieBanner.style.display = "none"; // ซ่อนแถบคุกกี้
                rememberSection.style.display = "flex"; // แสดง checkbox

                // รีเฟรชหน้าเว็บหลังจากตั้งคุกกี้
                setTimeout(function() {
                    window.location.reload(); // รีเฟรชหน้าเว็บ
                }, 500); // หน่วงเวลา 500ms เพื่อให้ตั้งคุกกี้เสร็จสมบูรณ์ก่อน
            });


            // ถ้าผู้ใช้กด "ปฏิเสธ"
            denyButton.addEventListener("click", function() {
                localStorage.setItem("cookie_consent", "denied"); // บันทึกสถานะการปฏิเสธคุกกี้ไปยัง localStorage
                document.cookie = "remember_token=; path=/; max-age=0"; // ลบคุกกี้ remember_token
                cookieBanner.style.display = "none"; // ซ่อนแถบคุกกี้
                rememberSection.style.display = "none"; // ซ่อน checkbox
                rememberMeCheckbox.checked = false; // ยกเลิกการเลือก checkbox
            });

            // เช็คก่อนส่งฟอร์ม
            form.addEventListener("submit", function(event) {
                if (rememberMeCheckbox.checked) {
                    if (cookieConsent !== "accepted") {
                        event.preventDefault(); // ป้องกันการส่งฟอร์ม
                        cookieBanner.style.display = "block"; // แสดงแถบคุกกี้
                        alert("คุณต้องยอมรับคุกกี้ก่อนใช้ฟังก์ชัน 'จดจำฉัน'");
                    }
                }
            });

            // เช็คสถานะคุกกี้เมื่อโหลดหน้าเว็บ
            // ตรวจสอบค่า cookie_consent ใน localStorage
            if (cookieConsent) {
                console.log("การยอมรับคุกกี้: " + cookieConsent);
                // ทำการดำเนินการตามค่า cookie_consent
                if (cookieConsent === "accepted") {
                    // หากยอมรับคุกกี้
                    console.log("ผู้ใช้ยอมรับคุกกี้แล้ว");
                    rememberSection.style.display = "flex"; // แสดง checkbox
                    cookieBanner.style.display = "none"; // ซ่อนแถบคุกกี้
                } else if (cookieConsent === "denied") {
                    // หากปฏิเสธคุกกี้
                    console.log("ผู้ใช้ปฏิเสธคุกกี้");
                    rememberSection.style.display = "none"; // ซ่อน checkbox
                    cookieBanner.style.display = "none";
                    rememberMeCheckbox.checked = false; // ยกเลิกการเลือก checkbox
                }
            } else {
                console.log("ไม่มีข้อมูลการยอมรับคุกกี้");
            }
        });

        function generateToken() {
            return Math.random().toString(36).substr(2, 16); // สร้าง token แบบสุ่ม
        }
    </script>




</body>

</html>