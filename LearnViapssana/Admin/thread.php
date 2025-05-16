<?php
session_start();
include('../includes/connect.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // ถ้าไม่มี session หรือ role ไม่ใช่ admin ให้ redirect ออกไป
    header("Location: ../login/login.php");
    exit();
}

$adminId = $_SESSION['user_id'];
$userRole = $_SESSION['role']; // ค่าของ role จะเป็น 'admin'

try {
    // ดึงข้อมูลของกระทู้
    $stmt = $conn->query("SELECT threads.id,users.fname, users.lname, threads.title, threads.content, threads.created_at 
    FROM threads
    JOIN users ON threads.user_id = users.user_id");

    $threads = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST หรือไม่
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $content = $_POST['content'];
        $user_id = $_SESSION['user_id']; // ดึง user_id จาก session
        $thread_id = $_POST['thread_id']; // รับ thread_id จากฟอร์ม

        // ตรวจสอบว่า content ไม่ว่าง
        if (!empty($content)) {
            $stmt = $conn->prepare("INSERT INTO comments (thread_id, user_id, content) VALUES (?, ?, ?)");

            if ($stmt->execute([$thread_id, $user_id, $content])) {
                echo "<script>alert('เพิ่มความคิดเห็นเรียบร้อย!'); window.location.href=document.referrer;</script>";
                exit();
            } else {
                echo "<script>alert('เกิดข้อผิดพลาด! กรุณาลองใหม่'); window.location.href=document.referrer;</script>";
                exit();
            }
        } else {
            echo "<script>alert('กรุณากรอกข้อความก่อนส่งความคิดเห็น!'); window.location.href=document.referrer;</script>";
            exit();
        }
    }



    // ดึงข้อมูลของ Admin
    $stmt = $conn->query("SELECT * FROM users WHERE user_id = $adminId");
    $adminData = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/Admin/dashboard.css">
    <link rel="stylesheet" href="../assets/css/Admin/thread.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <title>DASHBOARD ADMIN</title>
</head>

<body>
    <aside>
        <div class="sitebar">
            <div class="icon">
                <h1>ADMIN</h1>
                <span class="icon-menu">
                    <i class='bx bx-menu'></i>
                </span>
            </div>

            <?php include('sitebar.php'); ?>
        </div>
    </aside>

    <div class="container-main">
        <h1>กระทู้ทั้งหมด</h1>
        <div class="container-body">
            <div class="container-thread">
                <div class="accordion" id="content-1">
                    <?php foreach ($threads as $thread) { ?>
                        <div class="accordion-item">
                            <div class="list-name">
                                <?php echo htmlspecialchars($thread['title']); ?>

                            </div>
                            <div class="item-body">
                                <div class="item-body-content">
                                    <!-- ปุ่มลบกระทู้ -->
                                    <form action="delete_thread.php" method="POST" style="display:inline; float:right;">
                                        <input type="hidden" name="thread_id" value="<?= $thread['id'] ?>">
                                        <button style="background-color: red; width: 100px; float:right;" class="del-thread" type="submit" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบกระทู้นี้?');">
                                            🗑️ ลบกระทู้
                                        </button>
                                    </form>
                                    <?php
                                    $date = $thread['created_at'];
                                    $dateTime = strtotime($date);
                                    $newDate = date("d/m", $dateTime);
                                    $years = date("Y", $dateTime);
                                    $myYear = $years + 543;
                                    ?>
                                    <h2>ผู้สร้าง: <?php echo htmlspecialchars($thread['fname']) . " " . htmlspecialchars($thread['lname']); ?> </h2>
                                    <hr>
                                    <h2>วันที่สร้าง: <?= $newDate."/".$myYear ?></h2>
                                    <hr>
                                    <h2>ชื่อกระทู้: <?php echo htmlspecialchars($thread['title']) ?></h2>
                                    <hr>
                                    <h2>เนื้อหา</h2>
                                    <p><?php echo htmlspecialchars($thread['content']); ?></p>
                                    <hr>
                                    <h2>ข้อความแสดงความคิดเห็น</h2>
                                    <ul>
                                        <?php
                                        $id = $thread['id'];
                                        $stmt = $conn->prepare("
                            SELECT comments.*, users.fname, users.lname 
                            FROM comments 
                            JOIN users ON comments.user_id = users.user_id 
                            WHERE comments.thread_id = ? 
                            ORDER BY comments.created_at ASC
                        ");
                                        $stmt->execute([$id]);
                                        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        if (!$comments) {
                                            echo "<p>ไม่มีความคิดเห็น</p>";
                                        } else {
                                            foreach ($comments as $comment): ?>
                                                <li>
                                                    <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                                    | สร้างโดย <?= htmlspecialchars($comment['fname']) . " " . htmlspecialchars($comment['lname']) ?>
                                                    <?php
                                                    $date = $comment['created_at'];
                                                    $dateTime = strtotime($date);
                                                    $newDate = date("d/m", $dateTime);
                                                    $years = date("Y", $dateTime);
                                                    $myYear = $years + 543;
                                                    ?>
                                                    (<?= $newDate . "/" . $myYear; ?>)

                                                    <!-- ปุ่มลบความคิดเห็น -->
                                                    <form action="delete_comment.php" method="POST" style="display:inline;">
                                                        <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                                        <button class="del" type="submit" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบความคิดเห็นนี้?');">
                                                            ❌ ลบ
                                                        </button>
                                                    </form>
                                                </li>
                                        <?php endforeach;
                                        } ?>
                                    </ul>
                                    <hr>
                                    <h2>แสดงความคิดเห็น</h2>
                                    <form method="post">
                                        <textarea name="content" required></textarea>
                                        <input type="hidden" name="thread_id" value="<?php echo $id; ?>">
                                        <br>
                                        <button type="submit">โพสต์ความคิดเห็น</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="btn">
                        <a href="../Threads/create_thread.php">+ สร้างกระทู้ใหม่</a>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>
        // ดึงทุก element ที่มี class 'list-name'
        const accordionItems = document.querySelectorAll('.list-name');

        // เพิ่ม event listener ให้ทำงานเมื่อ accordion ถูกคลิก
        accordionItems.forEach(item => {
            item.addEventListener('click', () => {
                const parent = item.parentElement;
                const body = item.nextElementSibling;

                // ปิด accordion อื่น ๆ ที่เปิดอยู่
                accordionItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                        otherItem.nextElementSibling.style.maxHeight = null;
                    }
                });
                // สลับการเปิด-ปิด accordion ของตัวเอง
                const isActive = item.classList.toggle('active');
                parent.classList.toggle('active', isActive);

                if (isActive) {
                    body.style.maxHeight = body.scrollHeight + "px"; // เปิด accordion

                    // โหลดกราฟครั้งแรกเท่านั้น
                    const chartCanvases = body.querySelectorAll('canvas');
                    chartCanvases.forEach(canvas => {
                        if (!canvas.classList.contains('loaded')) {
                            triggerGraphResize();
                            canvas.classList.add('loaded'); // ป้องกันการโหลดซ้ำ
                        }
                    });

                    // รีเฟรชกราฟเมื่อเปิด accordion (รอให้ animation เสร็จก่อน)
                    setTimeout(triggerGraphResize, 300);
                } else {
                    body.style.maxHeight = null; // ปิด accordion
                }
            });
        });
    </script>
    <script>
        const btnToggle = document.querySelector(".icon-menu");
        const menu = document.querySelector(".menu");

        btnToggle.addEventListener("click", function() {
            menu.classList.toggle("active");
        });
    </script>
</body>

</html>