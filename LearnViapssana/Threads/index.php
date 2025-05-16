<?php
session_start();
require '../includes/connect.php';

date_default_timezone_set('Asia/Bangkok'); // ตั้งค่าโซนเวลา

// ฟังก์ชันแปลงวันที่เป็นภาษาไทย
function formatDateThai($date)
{
    $thai_months = [
        "01" => "มกราคม",
        "02" => "กุมภาพันธ์",
        "03" => "มีนาคม",
        "04" => "เมษายน",
        "05" => "พฤษภาคม",
        "06" => "มิถุนายน",
        "07" => "กรกฎาคม",
        "08" => "สิงหาคม",
        "09" => "กันยายน",
        "10" => "ตุลาคม",
        "11" => "พฤศจิกายน",
        "12" => "ธันวาคม"
    ];

    $dateTime = new DateTime($date);
    $year = $dateTime->format("Y") + 543; // แปลง ค.ศ. เป็น พ.ศ.
    $month = $thai_months[$dateTime->format("m")]; // แปลงเลขเดือนเป็นชื่อเดือนภาษาไทย
    $day = $dateTime->format("j"); // วันที่ไม่มีเลข 0 นำหน้า

    return "$day $month $year";
}

$stmt = $conn->query("SELECT threads.id, threads.title, users.fname, users.lname, threads.created_at FROM threads 
                     JOIN users ON threads.user_id = users.user_id ORDER BY threads.created_at DESC");
$threads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/threads/index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>กระทู้ทั้งหมด</title>
</head>

<body>
    <header>
        <div class="nav">
            <span><a href="../Lessons/" class="menu"><i class='bx bx-left-arrow-alt'></i>กลับ</a></span>
            <span class="toggle-menu"><i class='bx bx-menu'></i></span>
            <div class="menu-sub">
                <ul>
                    <li><a href="./mythread.php">กระทู้ของฉัน<i class='bx bx-message-square-detail'></i>
                    <li><a href="create_thread.php">สร้างกระทู้ใหม่<i class='bx bx-message-square-add'></i></a></li>
                </ul>
            </div>
        </div>
    </header>
    <main>
        
        <div class="container">
        <h1>กระทู้ทั้งหมด</h1>
        <ul>
            <?php if (empty($threads)): ?>
                <p>ขออภัย ในตอนนี้ระบบไม่มีกระทู้แสดง</p>
            <?php else: ?>
                <?php foreach ($threads as $thread): ?>
                    <li>
                        <a href="thread.php?id=<?= $thread['id'] ?>">
                            <p><?= htmlspecialchars($thread['title']) ?></p>
                            <p> โดย <?= htmlspecialchars($thread['fname']) . " " . htmlspecialchars($thread['lname']); ?>
                                เมื่อ <?= formatDateThai($thread['created_at']) ?></p>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const btnToggle = document.querySelector(".toggle-menu");
            const menu = document.querySelector(".menu-sub");

            btnToggle.addEventListener("click", function() {
                menu.classList.toggle("active");
            });
        });
    </script>
</body>

</html>