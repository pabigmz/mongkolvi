<?php
session_start();
include('../../includes/connect.php');

// รับ JSON ที่ส่งมาจาก JavaScript
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id']) || !isset($data['lesson_id']) || !isset($data['time_spent'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing required data"]);
    exit();
}

$userId = (int) $data['user_id'];
$lessonId = (int) $data['lesson_id'];
$timeSpent = (int) $data['time_spent'];
$progress = 60;

// ตรวจสอบว่ามี record อยู่แล้วหรือไม่
$stmt = $conn->prepare("SELECT content_time FROM user_progress WHERE user_id = :user_id AND lesson_id = :lesson_id");
$stmt->execute(['user_id' => $userId, 'lesson_id' => $lessonId]);
$existingData = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existingData) {
    // บวกเวลาใหม่กับเวลาที่เคยบันทึกไว้
    $newTime = $existingData['content_time'] + $timeSpent;
    $stmt = $conn->prepare("UPDATE user_progress SET content_time = :content_time WHERE user_id = :user_id AND lesson_id = :lesson_id");
    $stmt->execute(['content_time' => $newTime, 'user_id' => $userId, 'lesson_id' => $lessonId]);
} else {
    // ถ้ายังไม่มีข้อมูล ให้เพิ่มข้อมูลใหม่
    $stmt = $conn->prepare("INSERT INTO user_progress (user_id, lesson_id, content_time) VALUES (:user_id, :lesson_id, :content_time)");
    $stmt->execute(['user_id' => $userId, 'lesson_id' => $lessonId, 'content_time' => $timeSpent]);
}

echo json_encode(["success" => true, "time_spent" => $timeSpent]);
?>
