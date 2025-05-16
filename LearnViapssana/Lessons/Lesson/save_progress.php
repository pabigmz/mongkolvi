<?php
session_start();
include('../../includes/connect.php');

// รับ JSON ที่ส่งมาจาก JavaScript
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id']) || !isset($data['lesson_id']) || !isset($data['progress'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing required data"]);
    exit();
}

$userId = (int) $data['user_id'];
$lessonId = (int) $data['lesson_id'];
$progressIncrease = (int) $data['progress'];

// ตรวจสอบว่ามีข้อมูลอยู่ใน `user_progress` หรือไม่
$stmt = $conn->prepare("SELECT progress FROM user_progress WHERE user_id = :user_id AND lesson_id = :lesson_id");
$stmt->execute(['user_id' => $userId, 'lesson_id' => $lessonId]);
$existingData = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existingData) {
    $currentProgress = (int) $existingData['progress'];
    $newProgress = $currentProgress + $progressIncrease;

    // ถ้า progress เกิน 70 ให้ตั้งค่าเป็น 70
    if ($currentProgress == 100) {
        $newProgress = $currentProgress;
    } else {
        $newProgress = 70;
    }
    
    // อัปเดตค่า progress
    $stmt = $conn->prepare("UPDATE user_progress SET progress = :progress WHERE user_id = :user_id AND lesson_id = :lesson_id");
    $stmt->execute(['progress' => $newProgress, 'user_id' => $userId, 'lesson_id' => $lessonId]);
} else {
    // ถ้ายังไม่มีข้อมูล และ progress ที่จะเพิ่มเกิน 70 ให้ตั้งค่าเป็น 70
    $initialProgress = min($progressIncrease, 70);
    
    $stmt = $conn->prepare("INSERT INTO user_progress (user_id, lesson_id, progress) VALUES (:user_id, :lesson_id, :progress)");
    $stmt->execute(['user_id' => $userId, 'lesson_id' => $lessonId, 'progress' => $initialProgress]);

    $newProgress = $initialProgress;
}

// ✅ เพิ่มการเปลี่ยนหน้าไป `postest.php`
header("Location: ../Lesson/posttest.php?id=" . $lessonId);
exit(); // ป้องกันโค้ดทำงานต่อ
?>
