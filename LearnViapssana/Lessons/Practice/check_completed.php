<?php
session_start();
include('../../includes/connect.php');

$pracId = $_GET['id'];
$userId = $_SESSION['user_id'];
if (isset($_GET['status'])) {
    header('Location: ../index.php');
    exit();
}

$stmt = $conn->prepare("SELECT * FROM user_practice_progress WHERE user_id = :userId AND practice_id = :PracId");
$stmt->execute(['userId' => $userId, 'PracId' => $pracId]);
$completed = $stmt->fetch(PDO::FETCH_ASSOC);
if ($completed['is_completed'] == 0) {
    header("Location: ../index.php");
}

if ($pracId != 0) {
    $newPracId = $pracId + 1;

    // ✅ ตรวจสอบว่ามี record ของบทเรียนถัดไปหรือไม่
    $stmt = $conn->prepare("SELECT * FROM user_practice_progress WHERE user_id = :userId AND practice_id = :newPracId");
    $stmt->execute(['userId' => $userId, 'newPracId' => $newPracId]);
    $existingNextLesson = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingNextLesson) {
        // ✅ ถ้ายังไม่มีบทเรียนถัดไป ให้เพิ่มลงใน user_progress
        $stmt = $conn->prepare("
            INSERT INTO user_practice_progress (user_id, practice_id, video_watch_time, is_completed) 
            VALUES (:user_id, :newPracId, 0, FALSE)
        ");
        $stmt->execute(['user_id' => $userId, 'newPracId' => $newPracId]);
    }

    // ✅ Redirect ไปยัง `completed.php`
    if ($status != 0) {
        header("Location: ./practice.php?id=" . $newPracId);
        exit();
    } else {
        header("Location: ../index.php");
        exit();
    }
}
