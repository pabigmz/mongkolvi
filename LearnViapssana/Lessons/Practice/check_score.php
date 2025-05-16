<?php
session_start();
include('../../includes/connect.php');

if (!isset($_SESSION['user_id'])) {
    die("Error: User is not logged in.");
}

$userId = $_SESSION['user_id'];
$pracId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($pracId === 0) {
    die("Error: Invalid lesson ID.");
}

// ✅ ตรวจสอบว่าผู้ใช้เรียนครบ 5 บทแล้วหรือยัง
$stmt = $conn->prepare("SELECT COUNT(*) AS total_lessons FROM user_practice_progress WHERE user_id = :userId AND is_completed = 1");
$stmt->execute(['userId' => $userId]);
$totalLessons = $stmt->fetch(PDO::FETCH_ASSOC)['total_lessons'];

$stmt = $conn->prepare("SELECT COUNT(*) AS total_prac FROM practice");
$stmt->execute();
$totalPractice = $stmt->fetch(PDO::FETCH_ASSOC)['total_prac'];

if ($totalLessons == $totalPractice) {
    // ✅ ถ้าเรียนครบ 5 บท → ไปยัง completed.php
    header("Location: ./completed.php?id=". $pracId . "&complete=1");
    exit();
}

// ✅ ดึงข้อมูลจาก user_progress
$sql = "SELECT score_post FROM user_practice_progress WHERE user_id = :userId AND practice_id = :pracId";
$stmt = $conn->prepare($sql);
$stmt->execute(['userId' => $userId, 'pracId' => $pracId]);
$score = $stmt->fetch(PDO::FETCH_ASSOC);

// ✅ ตรวจสอบว่ามีข้อมูลหรือไม่
if ($score === false) {
    die("Error: ไม่พบข้อมูลบทเรียนใน user_progress");
}

if ($score['score_post'] >= 4) {
    $nextLessonId = $pracId + 1;

    // ✅ ตรวจสอบว่ามี record ของบทเรียนถัดไปหรือไม่
    $stmt = $conn->prepare("SELECT * FROM user_practice_progress WHERE user_id = :userId AND practice_id = :nextLessonId");
    $stmt->execute(['userId' => $userId, 'nextLessonId' => $nextLessonId]);
    $existingNextLesson = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingNextLesson) {
        // ✅ ถ้ายังไม่มีบทเรียนถัดไป ให้เพิ่มลงใน user_progress
        $stmt = $conn->prepare("
            INSERT INTO user_practice_progress (user_id, practice_id, pre_completed, is_completed, video_watch_time) 
            VALUES (:user_id, :pracId, FALSE, FALSE, 0)
        ");
        $stmt->execute(['user_id' => $userId, 'pracId' => $nextLessonId]);
    }

    // ✅ Redirect ไปยัง `completed.php`
    header("Location: ./completed.php?id=" . $nextLessonId);
    exit();

} else {
    // ✅ Redirect ไปยัง `completed.php`
    header("Location: ./uncompleted.php?id=" . $pracId);
    exit();
}
?>
