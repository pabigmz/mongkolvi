<?php
ob_start(); // ✅ ป้องกันปัญหา header already sent
session_start();
include('../../includes/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        die("Error: User is not logged in.");
    }

    $user_id = $_SESSION['user_id'];
    $lesson_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $user_answers = isset($_POST['answer']) ? $_POST['answer'] : [];
    $time_taken = isset($_POST['time_taken']) ? (int)$_POST['time_taken'] : 0;
    $score = 0;
    $progressIncrease = 30; 
    $is_completed = 0; 

    if ($lesson_id == 0) {
        die("Error: Invalid lesson ID.");
    }

    foreach ($user_answers as $quiz_id => $answer) {
        $stmt = $conn->prepare("SELECT correct_answer FROM quizzes WHERE quiz_id = :quiz_id");
        $stmt->execute(['quiz_id' => $quiz_id]);
        $correct = $stmt->fetch(PDO::FETCH_ASSOC)['correct_answer'];

        if ($answer == $correct) {
            $score++;
        }
    }

    if ($score >= 7) {
        $is_completed = 1;
    }

    $stmt = $conn->prepare("SELECT progress FROM user_progress WHERE user_id = :user_id AND lesson_id = :lesson_id");
    $stmt->execute(['user_id' => $user_id, 'lesson_id' => $lesson_id]);
    $existingProgress = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingProgress) {
        $currentProgress = (int) $existingProgress['progress'];
        $newProgress = $currentProgress + $progressIncrease;

        if ($newProgress > 100) {
            $newProgress = 100;
        }
    } else {
        $newProgress = min($progressIncrease, 100);
    }

    $stmt = $conn->prepare("SELECT * FROM user_progress WHERE user_id = :user_id AND lesson_id = :lesson_id");
    $stmt->execute(['user_id' => $user_id, 'lesson_id' => $lesson_id]);
    $existingData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingData) {
        $stmt = $conn->prepare("UPDATE user_progress 
                                SET time_post_test = :time_taken, 
                                    score_post = :score, 
                                    post_completed = 1, 
                                    progress = :progress, 
                                    is_completed = :is_completed,
                                    updated_at = NOW() 
                                WHERE user_id = :user_id 
                                AND lesson_id = :lesson_id");
    } else {
        $stmt = $conn->prepare("INSERT INTO user_progress (user_id, lesson_id, time_post_test, score_post, post_completed, progress, is_completed, updated_at) 
                                VALUES (:user_id, :lesson_id, :time_taken, :score, 1, :progress, :is_completed, NOW())");
    }

    $stmt->execute([
        'time_taken' => $time_taken,
        'score' => $score,
        'progress' => $newProgress,
        'is_completed' => $is_completed,
        'user_id' => $user_id,
        'lesson_id' => $lesson_id
    ]);

    // ✅ Redirect ก่อนส่ง output
    header("Location: ./check_score.php?id=" . intval($lesson_id));
    exit; 

    // ❌ ห้ามมี echo หรือ output ก่อน header
    // echo "<h2>ผลการสอบของคุณ</h2>";
    // echo "<p>คุณได้คะแนน: $score / " . count($user_answers) . "</p>";
    // echo "<p>เวลาที่ใช้: $time_taken วินาที</p>";
}
?>
