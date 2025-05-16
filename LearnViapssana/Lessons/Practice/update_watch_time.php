<?php
session_start();

// ✅ เช็คว่า Session ยังทำงานอยู่หรือไม่
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // ❌ Unauthorized
    echo "❌ Unauthorized: กรุณาเข้าสู่ระบบก่อนทำรายการ";
    exit();
}

// ✅ ตั้งค่าคุกกี้รองรับทุกหน้า
setcookie("cookiesAccepted", "true", time() + 31536000, "/", "", false, false);

// ✅ เพิ่ม CORS Headers เพื่อรองรับ Cross-Origin Request
header("Access-Control-Allow-Origin: *"); // 🔹 ถ้าใช้ Frontend ที่กำหนด ให้เปลี่ยนเป็น `http://localhost:3000`
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include('../../includes/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
    $pracId = isset($_POST['practice_id']) ? (int)$_POST['practice_id'] : 0;
    $watchTime = isset($_POST['watch_time']) ? (int)$_POST['watch_time'] : 0;

    // ✅ Debug Log: ตรวจสอบค่าที่ได้รับ
    error_log("🔍 POST Data: user_id=$userId, practice_id=$pracId, watch_time=$watchTime");

    if ($userId === 0 || $pracId === 0) {
        http_response_code(400); // ❌ Bad Request
        echo "❌ ข้อมูลไม่ถูกต้อง";
        exit();
    }

    try {
        // ✅ ดึงค่าปัจจุบันจากฐานข้อมูล
        $stmt = $conn->prepare("SELECT video_watch_time, is_completed FROM user_practice_progress WHERE user_id = :user_id AND practice_id = :pracId");
        $stmt->execute(['user_id' => $userId, 'pracId' => $pracId]);
        $currentData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$currentData) {
            http_response_code(404); // ❌ Not Found
            echo "⚠ ไม่มีข้อมูลสำหรับ user_id=$userId และ practice_id=$pracId";
            exit();
        }

        $videoWatchTime = isset($currentData['video_watch_time']) ? (int)$currentData['video_watch_time'] : 0;
        $isCompleted = isset($currentData['is_completed']) ? (int)$currentData['is_completed'] : 0;

        // ✅ ดึงเวลาของวิดีโอ
        $stmt = $conn->prepare("SELECT duration FROM practice WHERE practice_id = :pracId");
        $stmt->execute(['pracId' => $pracId]);
        $duration = $stmt->fetch(PDO::FETCH_ASSOC);
        $timeAll = isset($duration['duration']) ? (int)$duration['duration'] : 0;

        // ✅ เช็คว่าผู้ใช้ดูครบแล้วหรือยัง
        if ($videoWatchTime >= $timeAll) {
            echo "⏳ ผู้ใช้ดูจบแล้ว ไม่ต้องบันทึกซ้ำ!";
            exit();
        }

        // ✅ ถ้า watchTime มากกว่าข้อมูลเดิม → อัปเดต
        if ($watchTime > $videoWatchTime) {
            $stmt = $conn->prepare("
                UPDATE user_practice_progress 
                SET video_watch_time = :watchTime 
                WHERE user_id = :user_id AND practice_id = :pracId
            ");
            $stmt->execute(['watchTime' => $watchTime, 'user_id' => $userId, 'pracId' => $pracId]);

            echo "✅ อัปเดตเวลาเรียบร้อย";
        } else {
            echo "⚠ ไม่อัปเดต เพราะเวลาที่บันทึกไว้มากกว่า";
        }
    } catch (Exception $e) {
        http_response_code(500); // ❌ Internal Server Error
        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}
?>
