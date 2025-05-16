<?php
include('../../includes/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];
    $pracId = $_POST['practice_id'];

    try {
        // ตรวจสอบวิดีโอเคยถูกทำเป็น completed หรือยัง
        $stmt = $conn->prepare("SELECT is_completed FROM user_practice_progress WHERE user_id = :user_id AND practice_id = :pracId");
        $stmt->execute(['user_id' => $userId, 'pracId' => $pracId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data['is_completed']) {
            echo "✔ ผู้ใช้เคยดูจบแล้ว!";
            exit();
        }

        // ถ้ายังไม่ถูกทำ completed และดูครบ 90% ให้อัปเดต
        $stmt = $conn->prepare("
            UPDATE user_practice_progress 
            SET is_completed = 1 
            WHERE user_id = :user_id AND practice_id = :pracId
        ");
        $stmt->execute(['user_id' => $userId, 'pracId' => $pracId]);

        echo "✅ บทเรียนนี้เรียนครบแล้ว!";
    } catch (Exception $e) {
        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}
?>
