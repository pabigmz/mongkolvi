<?php
session_start();
include('../../includes/connect.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login/login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$lessonId = $_GET['id'];



// ตรวจสอบว่า user ผ่าน pre-test แล้วหรือยัง
$sql_pretest = "SELECT pre_completed FROM user_progress WHERE user_id = :user_id AND lesson_id = :lesson_id";
$stmt = $conn->prepare($sql_pretest);
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->bindParam(':lesson_id', $lessonId, PDO::PARAM_INT);
$stmt->execute();
$pretestComplete = $stmt->fetch(PDO::FETCH_ASSOC);

// ดึงข้อมูลข้อสอบจากฐานข้อมูล (ใช้ `prepare()` + `bindParam()` เพื่อป้องกัน SQL Injection)
$sql = "SELECT quiz_id, numbers, question, choice_a, choice_b, choice_c, choice_d FROM quizzes WHERE lesson_id = :lesson_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':lesson_id', $lessonId, PDO::PARAM_INT);
$stmt->execute();
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POSTTEST</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../assets/css/lesson/pretest.css">
</head>

<body>
    <header>
        <div class="return">
            <a href="./learn.php?id=<?php echo $lessonId; ?>"><i class='bx bx-left-arrow-alt'></i> กลับ</a>
        </div>
    </header>

    <main>
        <div class="container">
            <h1>แบบทดสอบหลังเรียน</h1>
            <p>แบบทดสอบหลังเรียน เพื่อวัดระดับความรู้ของคุณหลังเรียน</p>
            <p class="detail">
                <i class='bx bx-info-circle'></i> การทำแบบทดสอบนี้เป็นการถามคำถาม 10 ข้อ มีเวลาในการทำข้อสอบ 10 นาที
            </p>
            <div id="startExam" class="btn">
                <button class="btn-start">เริ่มทำแบบทดสอบ</button>
            </div>
            <div class="content-exam" style="display: none;">
                <div class="time">
                    <i class='bx bx-timer'></i>
                    <p>เหลือเวลา 10:00 นาที</p>
                </div>
                <form id="quizForm" action="check_posttest.php?id=<?php echo $lessonId; ?>" method="post">
                    <input type="hidden" name="time_taken" id="timeTaken" value="0">
                    <?php foreach ($questions as $index => $q): ?>
                        <div id="quiz-container">
                            <div class="question-container <?php echo $index === 0 ? 'active' : ''; ?>">
                                <p><?php echo $q['numbers']; ?>. <?php echo $q['question']; ?></p>
                                <input type="radio" name="answer[<?php echo $q['quiz_id']; ?>]" value="a"> <?php echo $q['choice_a']; ?><br>
                                <input type="radio" name="answer[<?php echo $q['quiz_id']; ?>]" value="b"> <?php echo $q['choice_b']; ?><br>
                                <input type="radio" name="answer[<?php echo $q['quiz_id']; ?>]" value="c"> <?php echo $q['choice_c']; ?><br>
                                <input type="radio" name="answer[<?php echo $q['quiz_id']; ?>]" value="d"> <?php echo $q['choice_d']; ?><br>
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

            let timeLeft = 600; // 3 นาที = 180 วินาที
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
