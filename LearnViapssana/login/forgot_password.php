<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// โหลดข้อมูล SMTP จากไฟล์แยก
$smtp_config = require 'phpmailer_config.php';

require 'vendor/autoload.php';
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../includes/connect.php';  // เชื่อมต่อฐานข้อมูล

    $email = $_POST["email"];
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(50));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $stmt = $conn->prepare("UPDATE users SET reset_token=?, reset_expires=? WHERE email=?");
        $stmt->execute([$token, $expires, $email]);

        // สร้างลิงก์รีเซ็ตรหัสผ่าน
        $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/login/reset_password.php?token=" . $token;

        // ตั้งค่า PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $smtp_config['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username =  $smtp_config['SMTP_USER'];  // ใส่อีเมลของคุณ
            $mail->Password = $smtp_config['SMTP_PASS'];  // ใส่ **App Password** ที่สร้างจาก Google
            $mail->SMTPSecure = $smtp_config['SMTP_SECURE'];
            $mail->Port = $smtp_config['SMTP_PORT'];

            $mail->setFrom($smtp_config['SMTP_USER'], 'Support');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Reset Your Password';

            // HTML Email Template
            $mail->Body = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Reset Your Password</title>
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
                <style>
                    body { font-family: "Prompt", serif; background-color: #f4f4f4; padding: 20px; }
                    .container { max-width: 500px; background: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: center; }
                    .logo img { width: 100px; margin-bottom: 20px; }
                    .button { background-color: #007bff; color: #ffffff; padding: 10px 20px; text-decoration: none; display: inline-block; border-radius: 5px; font-size: 16px; }
                    .footer { margin-top: 20px; font-size: 12px; color: #777; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="logo">
                        <img src="https://learnvipassana.com/assets/img/learnvipassana.png" alt="Your Logo" width="100">
                    </div>
                    <h2>เปลี่ยนรหัสของคุณ</h2>
                    <p>สวัสดี,</p>
                    <p>กรุณากดปุ่มด้านล่างเพื่อทำการเปลี่ยนรหัสผ่านใหม่:</p>
                    <p>
                        <a href="' . $resetLink . '" style="background-color: #007bff; color: #ffffff; padding: 10px 20px; text-decoration: none; display: inline-block; border-radius: 5px; font-size: 16px;">Reset Password</a>
                    </p>

                    <p>หากคุณไม่ได้เป็นขอเปลี่ยนรหัสผ่าน โปรดอย่าสนใจอีเมลนี้</p>
                    <div class="footer">
                        &copy; 2025 สื่อบทเรียนอนนไลน์การวิปัสสนากรรมฐาน ตามแนวพระพรหมมงคล วิ.
                    </div>
                </div>
            </body>
            </html>';

            $mail->AltBody = "Click this link to reset your password: $resetLink";

            // ส่งอีเมล
            $mail->send();
            // echo "A password reset link has been sent to your email.";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        $message = "ไม่พบอีเมลของคุณในระบบ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Prompt", "serif";
        }

        main {
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #DEDEDE;
        }

        main h1 {
            margin-top: 100px;
            font-weight: 500;
        }

        main .container {
            background-color: white;
            width: 400px;
            height: auto;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 10px;
            margin-top: 1rem;
        }

        main .container i {
            font-size: 100px;
        }

        main .container h2 {
            font-weight: 400;
            font-size: 20px;
        }

        main .container p {
            font-size: 14px;
            color: rgb(151, 151, 151);
            text-align: center;
        }

        main .container a {
            margin-top: 1rem;
            margin-bottom: 1rem;
            color: #329BE5;
            text-decoration: none;
        }
    </style>
    <title>ส่งอีเมล</title>
</head>

<body>
    <main>
        <h1>LearnVipassana</h1>
        <div class="container">
            <i class='bx bxs-envelope'></i>
            <?php 
            if (isset($message)) {
                echo "<h2>$message</h2>";
            } else { ?>
                <h2>ตรวจสอบอีเมลของคุณ</h2>
                <p>เราส่งลิงค์รีเซ็ตรหัสผ่านไปตามอีเมลที่ระบุ<br>โปรดตรวจสอบอีเมลของคุณ<br>หากไม่พบโปรดดูที่จดหมายขยะ</p>
            <?php
            }
            ?>
            <a href="./login.php">หรือเข้าสู่ระบบ</a>
        </div>
    </main>
</body>

</html>