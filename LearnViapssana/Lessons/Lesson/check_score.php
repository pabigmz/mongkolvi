<?php
session_start();
include('../../includes/connect.php');

if (!isset($_SESSION['user_id'])) {
    die("Error: User is not logged in.");
}

$userId = $_SESSION['user_id'];
$lessonId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($lessonId === 0) {
    die("Error: Invalid lesson ID.");
}

// ✅ ตรวจสอบว่าผู้ใช้เรียนครบ 5 บทแล้วหรือยัง
$stmt = $conn->prepare("SELECT COUNT(*) AS total_lessons FROM user_progress WHERE user_id = :userId AND is_completed = 1");
$stmt->execute(['userId' => $userId]);
$totalLessons = $stmt->fetch(PDO::FETCH_ASSOC)['total_lessons'];

$stmt = $conn->prepare("SELECT COUNT(*) AS total_less FROM lessons");
$stmt->execute();
$countLessons = $stmt->fetch(PDO::FETCH_ASSOC)['total_less'];

if ($totalLessons == $countLessons) {
    // ✅ ถ้าเรียนครบ 5 บท → ไปยัง completed.php
    header("Location: ./completed.php?complete=1"."&id=". $lessonId);
    exit();
}

// ✅ ดึงข้อมูลจาก user_progress
$sql = "SELECT score_post FROM user_progress WHERE user_id = :userId AND lesson_id = :lessonId";
$stmt = $conn->prepare($sql);
$stmt->execute(['userId' => $userId, 'lessonId' => $lessonId]);
$score = $stmt->fetch(PDO::FETCH_ASSOC);

// ✅ ตรวจสอบว่ามีข้อมูลหรือไม่
if ($score === false) {
    die("Error: ไม่พบข้อมูลบทเรียนใน user_progress");
}

if ($score['score_post'] >= 4) {
    $nextLessonId = $lessonId + 1;

    // ✅ ตรวจสอบว่ามี record ของบทเรียนถัดไปหรือไม่
    $stmt = $conn->prepare("SELECT * FROM user_progress WHERE user_id = :userId AND lesson_id = :nextLessonId");
    $stmt->execute(['userId' => $userId, 'nextLessonId' => $nextLessonId]);
    $existingNextLesson = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingNextLesson) {
        // ✅ ถ้ายังไม่มีบทเรียนถัดไป ให้เพิ่มลงใน user_progress
        $stmt = $conn->prepare("
            INSERT INTO user_progress (user_id, lesson_id, pre_completed, is_completed, content_time) 
            VALUES (:user_id, :lesson_id, FALSE, FALSE, 0)
        ");
        $stmt->execute(['user_id' => $userId, 'lesson_id' => $nextLessonId]);
    }

    // ✅ Redirect ไปยัง `completed.php`
    header("Location: ./completed.php?id=" . $nextLessonId);
    exit();

} else {
    header("Location: ./uncompleted.php?id=" . $lessonId);
    exit();
}
?>
