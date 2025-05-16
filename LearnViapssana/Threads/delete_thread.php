<?php
session_start();
require '../includes/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

if (isset($_GET['id'])) {
    $threadId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    try {
        // ตรวจสอบว่าผู้ใช้เป็นเจ้าของกระทู้ก่อนลบ
        $stmt = $conn->prepare("SELECT * FROM threads WHERE id = :id AND user_id = :user_id");
        $stmt->execute(['id' => $threadId, 'user_id' => $userId]);
        $thread = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($thread) {
            // ลบกระทู้
            $deleteStmt = $conn->prepare("DELETE FROM threads WHERE id = :id");
            $deleteStmt->execute(['id' => $threadId]);

            // กลับไปหน้ากระทู้ของฉัน
            header("Location: mythread.php?deleted=1");
            exit;
        } else {
            // ถ้าไม่ใช่เจ้าของกระทู้
            header("Location: mythread.php?error=unauthorized");
            exit;
        }
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }
} else {
    header("Location: mythread.php");
    exit;
}
?>
