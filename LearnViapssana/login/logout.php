<?php
include('../includes/connect.php');
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    // ลบคุกกี้
    setcookie('remember_token', '', time() - 3600, "/");

    // อัปเดต last_active ให้เป็นเวลาปัจจุบัน
    $stmt = $conn->prepare("UPDATE users SET last_active = NOW() WHERE user_id = ?");
    $stmt->execute([$user_id]);
    // ลบ session
    session_unset();
    session_destroy();

    header("Location: ../"); // เปลี่ยนเส้นทางไปหน้า Login
    exit();
}
?>
