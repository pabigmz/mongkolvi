<?php
session_start();
include('../../includes/connect.php');


if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login/login.php");
    exit();
}
$pracId = $_GET['id'];
$userId = $_SESSION['user_id'];

try {
    // ตรวจสอบความคืบหน้า
    $stmt = $conn->prepare("SELECT * FROM user_practice_progress WHERE user_id = :user_id AND practice_id = :pracId");
    $stmt->execute(['user_id' => $userId, 'pracId' => $pracId]);
    $progress = $stmt->fetch(PDO::FETCH_ASSOC);

    // ถ้าไม่มีข้อมูลให้เพิ่มเข้าไป
    if (!$progress) {
        $stmt = $conn->prepare("
            INSERT INTO user_practice_progress (user_id, practice_id, video_watch_time, is_completed) 
            VALUES (:user_id, :pracId, 0, 0)
        ");
        $stmt->execute(['user_id' => $userId, 'pracId' => $pracId]);
        $progress = ['video_watch_time' => 0, 'is_completed' => 0];
    }

    // ตรวจสอบว่า user ผ่าน pre-test แล้วหรือยัง
    $sql_pretest = "SELECT pre_completed FROM user_practice_progress WHERE user_id = :user_id AND practice_id = :practice_id";
    $stmt = $conn->prepare($sql_pretest);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':practice_id', $pracId, PDO::PARAM_INT);
    $stmt->execute();

    $pretestComplete = $stmt->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลแค่แถวเดียว

    if ($pretestComplete && $pretestComplete['pre_completed'] == 1) {
        header('Location: ./practice.php?id=' . $pracId);
        exit(); // ต้องใส่ exit() เพื่อหยุดการทำงานหลัง redirect
    }

    // ดึงข้อมูลข้อสอบจากฐานข้อมูล
    $sql = "SELECT id, number, quiz_title, choice_a, choice_b, choice_c, choice_d, choice_e FROM quizzes_practice WHERE practice_id = $pracId";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRETEST</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../assets/css/lesson/pretest.css">
</head>

<body>
    <header>
        <div class="return">
            <a href="../"><i class='bx bx-left-arrow-alt'></i> กลับ</a>
        </div>
    </header>

    <main>
        <div class="container">
            <h1>แบบทดสอบก่อนเรียน</h1>
            <p>แบบทดสอบก่อนเรียน เพื่อวัดระดับความรู้ของคุณก่อนเริ่มเรียน</p>
            <p class="detail">
                <i class='bx bx-info-circle'></i> การทำแบบทดสอบนี้เป็นการถามคำถาม 5 ข้อ มีเวลาในการทำข้อสอบ 5 นาที
            </p>
            <div id="startExam" class="btn">
                <button class="btn-start">เริ่มทำแบบทดสอบก่อนเรียน</button>
            </div>
            <div class="content-exam" style="display: none;">
                <div class="time">
                    <i class='bx bx-timer'></i>
                    <p>เหลือเวลา 5 นาที</p>
                </div>
                <form id="quizForm" action="check_pretest.php?id=<?php echo $pracId; ?>" method="post">
                    <input type="hidden" name="time_taken" id="timeTaken" value="0">
                    <?php foreach ($questions as $index => $q): ?>
                        <div id="quiz-container">
                            <div class="question-container <?php echo $index === 0 ? 'active' : ''; ?>">
                                <p><?php echo $q['number']; ?>. <?php echo $q['quiz_title']; ?></p>
                                <input type="radio" name="answer[<?php echo $q['id']; ?>]" value="a"> <?php echo $q['choice_a']; ?><br>
                                <input type="radio" name="answer[<?php echo $q['id']; ?>]" value="b"> <?php echo $q['choice_b']; ?><br>
                                <input type="radio" name="answer[<?php echo $q['id']; ?>]" value="c"> <?php echo $q['choice_c']; ?><br>
                                <input type="radio" name="answer[<?php echo $q['id']; ?>]" value="d"> <?php echo $q['choice_d']; ?><br>
                                <input type="radio" name="answer[<?php echo $q['id']; ?>]" value="e"> <?php echo $q['choice_e']; ?><br>
                            </div>
                        </div>
                    <?php endforeach; ?>


                    <button type="submit" id="submitBtn">ส่งคำตอบ</button>
                </form>

            </div>
        </div>
    </main>
    <script>
        let totalTime = 0; // เวลาที่ใช้ทำข้อสอบ (วินาที)
        let countdown;

        document.getElementById("startExam").addEventListener("click", function() {
            let timeElement = document.querySelector(".time p");
            let startButton = document.getElementById("startExam");
            let quizContent = document.querySelector(".content-exam");
            let hiddenTimeInput = document.getElementById("timeTaken");

            let timeLeft = 300; // 3 นาที = 180 วินาที
            totalTime = 0; // รีเซ็ตเวลาที่ใช้

            startButton.style.display = "none";
            quizContent.style.display = "block";

            countdown = setInterval(function() {
                let minutes = Math.floor(timeLeft / 60);
                let seconds = timeLeft % 60;
                timeElement.innerHTML = `เหลือเวลา ${minutes}:${seconds < 10 ? '0' : ''}${seconds} นาที`;

                totalTime++; // เพิ่มเวลาที่ใช้ทำข้อสอบ
                hiddenTimeInput.value = totalTime; // อัปเดตค่าใน hidden input

                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    alert("หมดเวลา! ระบบจะส่งคำตอบอัตโนมัติ");
                    document.getElementById("quizForm").submit();
                }

                timeLeft--;
            }, 1000);
        });

        // หยุดจับเวลาถ้าส่งฟอร์มก่อนหมดเวลา
        document.getElementById("quizForm").addEventListener("submit", function() {
            clearInterval(countdown);
        });
    </script>


</body>

</html>