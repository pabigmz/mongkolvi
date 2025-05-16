<!-- ไว้ตรวจสอบสถานะการใช้งานในปัจจุบัน -->
<?php 

// include('../includes/connect.php');
// สมมติว่าผู้ใช้ล็อกอินอยู่ (ตรวจสอบ Session ก่อน)
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("UPDATE users SET last_active = NOW() WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
}

?>