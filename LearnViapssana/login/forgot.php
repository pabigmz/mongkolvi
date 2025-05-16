<?php
include('../includes/connect.php');
session_start();
$message = '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/forgot.css">
    <title>Forgot Password</title>
</head>
<body>
    <main>
        <!-- <h1>LearnVipassana</h1> -->
        <div class="container">
            <h2>ลืมรหัสผ่าน</h2>
            <p>กรุณากรอกอีเมลของคุณ</p>
            <form class="form-login" action="./forgot_password.php" method="POST">
                <input type="email" name="email" placeholder="อีเมล" required><br>
                <?php if ($message) : ?>
                    <div class="alert alert-info" role="alert">
                        <?= $message ?>
                    </div>
                <?php endif; ?>
                <br>
                <button type="submit">รีเซ็ตรหัสผ่าน</button>
            </form>

            <a href="./login.php">เข้าสู่ระบบ</a>
        </div>
    </main>
</body>
</html>
