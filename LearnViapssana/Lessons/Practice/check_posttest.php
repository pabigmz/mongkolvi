<?php
ob_start(); // ✅ ป้องกันปัญหา header already sent
session_start();
include('../../includes/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        die("Error: User is not logged in.");
    }

    $user_id = $_SESSION['user_id'];
    $pracId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $user_answers = isset($_POST['answer']) ? $_POST['answer'] : [];
    $time_taken = isset($_POST['time_taken']) ? (int)$_POST['time_taken'] : 0;
    $score = 0;
    $progressIncrease = 30; // ✅ เพิ่ม progress ทีละ 30
    $is_completed = 0; 

    if ($pracId == 0) {
        die("Error: Invalid lesson ID.");
    }

    // ✅ ตรวจสอบคำตอบของผู้ใช้
    foreach ($user_answers as $quiz_id => $answer) {
        $stmt = $conn->prepare("SELECT correct_answer FROM quizzes_practice WHERE id = :quiz_id");
        $stmt->execute(['quiz_id' => $quiz_id]);
        $correct = $stmt->fetch(PDO::FETCH_ASSOC)['correct_answer'];

        if ($answer == $correct) {
            $score++;
        }
    }

    if ($score >= 4) {
        $is_completed = 1;
    }

    // ✅ ดึง progress ปัจจุบันจากฐานข้อมูล
    $stmt = $conn->prepare("SELECT progress FROM user_practice_progress WHERE user_id = :user_id AND practice_id = :pracId");
    $stmt->execute(['user_id' => $user_id, 'pracId' => $pracId]);
    $existingProgress = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingProgress) {
        $currentProgress = (int) $existingProgress['progress'];
        $newProgress = min($currentProgress + $progressIncrease, 100); // ✅ เพิ่มค่าจากเดิม +30 (แต่ไม่เกิน 100)
    } else {
        $newProgress = $progressIncrease;
    }

    // ✅ ตรวจสอบว่ามีข้อมูลอยู่แล้วหรือไม่
    $stmt = $conn->prepare("SELECT * FROM user_practice_progress WHERE user_id = :user_id AND practice_id = :pracId");
    $stmt->execute(['user_id' => $user_id, 'pracId' => $pracId]);
    $existingData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingData) {
        // ✅ อัปเดตข้อมูล
        $stmt = $conn->prepare("UPDATE user_practice_progress 
                                SET post_time = :time_taken, 
                                    score_post = :score, 
                                    post_completed = 1, 
                                    progress = :progress, 
                                    is_completed = :is_completed,
                                    updated_at = NOW() 
                                WHERE user_id = :user_id 
                                AND practice_id = :practice_id");
    } else {
        // ✅ ถ้ายังไม่มีข้อมูล ให้เพิ่มแถวใหม่
        $stmt = $conn->prepare("INSERT INTO user_practice_progress (user_id, practice_id, post_time, score_post, post_completed, progress, is_completed, updated_at) 
                                VALUES (:user_id, :practice_id, :time_taken, :score, 1, :progress, :is_completed, NOW())");
    }

    // ✅ บันทึกค่า Progress
    $stmt->execute([
        'time_taken' => $time_taken,
        'score' => $score,
        'progress' => $newProgress,
        'is_completed' => $is_completed,
        'user_id' => $user_id,
        'practice_id' => $pracId
    ]);

    // ✅ Debug Log เช็คค่าที่บันทึก
    error_log("🚀 อัปเดต progress: $newProgress สำหรับ user_id: $user_id, practice_id: $pracId");

    // ✅ Redirect ก่อนส่ง output
    header("Location: ./check_score.php?id=" . intval($pracId));
    exit; 
}
?>
