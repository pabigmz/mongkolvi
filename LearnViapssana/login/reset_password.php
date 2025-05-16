<?php
require '../includes/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["token"])) {
    $token = $_GET["token"];

    // ตรวจสอบว่า token ถูกต้องและยังไม่หมดอายุ
    $stmt = $conn->prepare("SELECT email FROM users WHERE reset_token = ? AND reset_expires > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        die("Invalid or expired token.");
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["token"], $_POST["new_password"], $_POST["confirm_password"])) {
        die("Invalid request.");
    }

    $token = $_POST["token"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    if ($new_password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // ตรวจสอบว่า token ยังใช้งานได้
    $stmt = $conn->prepare("SELECT email FROM users WHERE reset_token = ? AND reset_expires > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        die("Invalid or expired token.");
    }

    // เข้ารหัสรหัสผ่านใหม่
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // อัปเดตรหัสผ่านและล้าง token
    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE email = ?");
    $stmt->execute([$hashed_password, $user["email"]]);

    header("Location: ./login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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

        main h2 {
            font-weight: 500;
            margin-top: 100px;
            margin-bottom: 2rem;
        }

        main form {
            width: 400px;
            height: auto;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: white;
            border-radius: 10px;
        }

        main form h3 {
            font-weight: 400;
            margin-bottom: 1rem;
        }

        main form input {
            width: 300px;
            height: 40px;
            padding-left: 10px;
            font-family: "Prompt", "serif";
            border: none;
            border-radius: 5px;
            background-color: rgb(233, 233, 233);
            margin-bottom: 1rem;
        }

        main form button {
            width: 300px;
            height: 40px;
            font-family: "Prompt", "serif";
            border: none;
            outline: none;
            background-color: #BB0FCB;
            font-weight: 500;
            color: white;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        /* Mobile เล็กมาก */
        @media (max-width: 480px) {
            main {
                background-color: white;
            }

            main form {
                width: 100%;
                box-shadow: none;
            }
        }
    </style>
    <title>Reset Password</title>
</head>

<body>
    <main>
        <h2>เปลี่ยนรหัสผ่าน</h2>
        <form method="POST">
            <h3>ตั้งรหัสผ่านใหม่</h3>
            <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
            <input type="password" name="new_password" placeholder="รหัสผ่าน" required><br>
            <input type="password" name="confirm_password" placeholder="ยืนยันรหัสผ่าน" required><br>
            <button type="submit">เปลี่ยนรหัสผ่าน</button>
        </form>
    </main>
</body>

</html>