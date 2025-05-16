<?php
session_start();
include('../../includes/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        die("Error: User is not logged in.");
    }

    $user_id = $_SESSION['user_id'];
    $lesson_id = isset($_GET['id']) ? (int)$_GET['id'] : 0; // ตรวจสอบค่า lesson_id
    $user_answers = isset($_POST['answer']) ? $_POST['answer'] : [];
    $time_taken = isset($_POST['time_taken']) ? (int)$_POST['time_taken'] : 0;
    $score = 0;
    $progress = 30; // ค่าความก้าวหน้า

    if ($lesson_id == 0) {
        die("Error: Invalid lesson ID.");
    }

    // ตรวจสอบคำตอบของผู้ใช้
    foreach ($user_answers as $quiz_id => $answer) {
        $stmt = $conn->prepare("SELECT correct_answer FROM quizzes WHERE quiz_id = :quiz_id");
        $stmt->execute(['quiz_id' => $quiz_id]);
        $correct = $stmt->fetch(PDO::FETCH_ASSOC)['correct_answer'];

        if ($answer == $correct) {
            $score++;
        }
    }

    // บันทึกคะแนนและเวลาลงฐานข้อมูล
    $stmt = $conn->prepare("UPDATE user_progress 
                            SET time_pre_test = :time_taken, 
                                score_pre = :score, 
                                pre_completed = 1, 
                                progress = :progress, 
                                updated_at = NOW() 
                            WHERE user_id = :user_id 
                            AND lesson_id = :lesson_id");

    $stmt->execute([
        'time_taken' => $time_taken,
        'score' => $score,
        'progress' => $progress,
        'user_id' => $user_id,
        'lesson_id' => $lesson_id
    ]);

    header("Location: ./learn.php?id=".$lesson_id);
    exit();
}
?>
