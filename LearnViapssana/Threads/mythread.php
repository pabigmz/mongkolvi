<?php
session_start();
require '../includes/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

try {
    $userId = $_SESSION['user_id'];
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

    $stmt = $conn->prepare("SELECT threads.id, threads.title, users.fname, users.lname, threads.created_at 
                        FROM threads 
                        JOIN users ON threads.user_id = users.user_id 
                        WHERE threads.user_id = :userId 
                        ORDER BY threads.created_at DESC");
    $stmt->execute(['userId' => $userId]);
    $threads = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("เกิดข้อผิดพลาด: " . $e->getMessage());
}

date_default_timezone_set('Asia/Bangkok'); // ตั้งค่าโซนเวลา


?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/threads/mythread.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>กระทู้ของฉัน</title>
</head>

<body>
    <header>
        <div class="nav">
            <span><a href="./" class="menu"><i class='bx bx-left-arrow-alt'></i>กลับ</a></span>
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
        <h1>กระทู้ของฉัน</h1>
        <?php if (empty($threads)): ?>
            <p>ขออภัย คุณยังไม่มีกระทู้ในตอนนี้</p>
        <?php else: ?>
            <?php if (isset($_GET['deleted'])): ?>
                <p style="color: green;">ลบกระทู้เรียบร้อยแล้ว</p>
            <?php elseif (isset($_GET['error']) && $_GET['error'] == 'unauthorized'): ?>
                <p style="color: red;">คุณไม่มีสิทธิ์ลบกระทู้นี้</p>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>กระทู้</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($threads as $thread): ?>
                        <tr>
                            <td><a href="thread.php?id=<?= $thread['id'] ?>"><?php echo htmlspecialchars($thread['title']); ?></a></td>
                            <td>
                                <div class="btn">
                                    <a class="delete" href="delete_thread.php?id=<?php echo $thread['id']; ?>" onclick="return confirmDelete()">ลบ</a>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const btnToggle = document.querySelector(".toggle-menu");
            const menu = document.querySelector(".menu-sub");

            btnToggle.addEventListener("click", function() {
                menu.classList.toggle("active");
            });
        });

        function confirmDelete() {
            return confirm("คุณแน่ใจหรือไม่ว่าต้องการลบกระทู้นี้?");
        }
    </script>
</body>

</html>