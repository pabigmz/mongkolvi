<?php
session_start();
require '../includes/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$userRole = $_SESSION['role'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO threads (title, content, user_id) VALUES (?, ?, ?)");
    $stmt->execute([$title, $content, $userId]);

    if($userRole == "admin") {
        header("Location: ../Admin/thread.php");
        exit;
    } else {
        header("Location: ./index.php");
        exit;
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/threads/create.css">
    <title>สร้างกระทู้ใหม่</title>
</head>

<body>
    <main>
        <div class="container">
            <h1>สร้างกระทู้ใหม่</h1>
            <form method="post">
                <div class="box-input">
                    <label>หัวข้อ:</label>
                    <input type="text" name="title" required>
                </div>
                <div class="box-input">
                    <label>เนื้อหา:</label>
                    <textarea name="content" required></textarea>
                </div>
                <button type="submit">โพสต์กระทู้ใหม่</button>
            </form>
            <a
            <?php 
            if($userRole == "admin") { ?>
                href="../Admin/thread.php"
            <?php
            } else { ?>
            href="./"
            <?php
            }
            ?> 
            >กลับ</a>
        </div>
    </main>
</body>

</html>