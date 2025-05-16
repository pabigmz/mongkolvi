<?php
session_start();
include('../../includes/connect.php');
include("../log-inline.php");

$userId = $_SESSION['user_id'];
$lessonId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$lessonId) {
    echo "รหัสบทเรียนไม่ถูกต้อง";
    header('Location: ../');
    exit();
}


try {
    // ตรวจสอบความคืบหน้าในตาราง user_progress
    $stmt = $conn->prepare("SELECT * FROM user_progress WHERE user_id = :user_id AND lesson_id = :lesson_id");
    $stmt->execute(['user_id' => $userId, 'lesson_id' => $lessonId]);
    $progress = $stmt->fetch(PDO::FETCH_ASSOC);

    // เพิ่มข้อมูลใหม่ถ้าไม่มีใน user_progress
    if (!$progress) {
        $stmt = $conn->prepare("
            INSERT INTO user_progress (user_id, lesson_id, pre_completed, is_completed, content_time) 
            VALUES (:user_id, :lesson_id, FALSE, FALSE, 0)
        ");
        $stmt->execute(['user_id' => $userId, 'lesson_id' => $lessonId]);

        $progress = [
            'progress' => 0 // ตั้งค่าเริ่มต้นเป็น 0%
        ];
    }

    // ดึงข้อมูลบทเรียน
    $stmt = $conn->prepare("SELECT * FROM lessons WHERE lesson_id = :lesson_id");
    $stmt->execute(['lesson_id' => $lessonId]);
    $lessons = $stmt->fetch(PDO::FETCH_ASSOC);

    // คำนวณความคืบหน้า
    $progressValue = isset($progress['progress']) ? $progress['progress'] : 0;
} catch (Exception $e) {
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    exit();
}


?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VipassaLearn</title>
    <link rel="stylesheet" href="../../assets/css/lesson/lesson.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <header>
        <div class="nav">
            <div class="profile">
                <a href="../" style="display: flex; color: black">
                    <img src="../../assets/img/learnvipassana.png" alt="" width="50" style="border-radius: 5px; margin-right: 0.5rem;">
                    <div class="logo-header">
                        <span class="on_text">สื่อบทเรียนออนไลน์</span>
                        <span class="under_text">การวิปัสสนากรรมฐาน ตามแนวพระพรหมมงคล วิ</span>
                    </div>
                </a>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="return-icon">
                <a href="../"><i class='bx bx-left-arrow-alt'></i> กลับ</a>
            </div>
            <div class="lesson-content">
                <h1><?php echo htmlspecialchars($lessons['lesson_title']); ?></h1>
                <div class="btn">
                    <a href="./pretest.php?id=<?php echo $lessonId; ?>">เริ่มเรียน</a>
                </div>
            </div>
            <div class="tab_box">
                <button class="tab_btn active">รายละเอียดบทเรียน</button>
                <button class="tab_btn">แบบทดสอบ</button>
                <div class="line"></div>
            </div>
            <div class="content_box">
                <div class="content active">
                    <h2>รายละเอียดบทเรียน</h2>
                    <ul>
                        <li>
                            <?php echo htmlspecialchars($lessons['lesson_title']); ?>
                        </li>
                    </ul>
                </div>
                <div class="content">
                    <h2>แบบทดสอบ</h2>

                    <div class="pretest_box">
                        <h3>แบบทดสอบก่อนเรียน</h3>
                        <div class="result">
                            <?php if (!isset($progress['score_pre']) || $progress['score_pre'] === null) { ?>
                                <div class="score">
                                    <h4>ยังไม่ได้ทำแบบทดสอบ</h4>
                                </div>
                            <?php } else { ?>
                                <div class="score">
                                    <h4>คะแนนของคุณ</h4>
                                    <p><?php echo $progress['score_pre']; ?>/10</p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="posttest_box">
                        <h3>แบบทดสอบหลังเรียน</h3>
                        <div class="result">
                            <?php if (!isset($progress['score_post']) || $progress['score_post'] === null) { ?>
                                <div class="score">
                                    <h4>ยังไม่ได้ทำแบบทดสอบ</h4>
                                </div>
                            <?php } else { ?>
                                <div class="score">
                                    <h4>คะแนนของคุณ</h4>
                                    <p><?php echo $progress['score_post']; ?>/10</p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>


    <script>
        const tabs = document.querySelectorAll('.tab_btn');
        const all_content = document.querySelectorAll('.content');

        tabs.forEach((tab, index) => {
            tab.addEventListener('click', (e) => {
                tabs.forEach(tab => {
                    tab.classList.remove('active')
                });
                tab.classList.add('active');

                var line = document.querySelector('.line');
                line.style.width = e.target.offsetWidth + "px";
                line.style.left = e.target.offsetLeft + "px";

                all_content.forEach(content => {
                    content.classList.remove('active')
                });
                all_content[index].classList.add('active');
            })


        })
    </script>
</body>

</html>