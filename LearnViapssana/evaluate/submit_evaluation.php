<?php
session_start(); // เริ่มต้น session เพื่อใช้ในการจัดการข้อมูลผู้ใช้
include('../includes/connect.php');

// ตรวจสอบว่ามีข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ตรวจสอบว่า 'evaluation_id' มีค่าหรือไม่
    if (isset($_POST['evaluation_id']) && !empty($_POST['evaluation_id'])) {
        $evaluation_id = $_POST['evaluation_id'];
    } else {
        die("การประเมินไม่ถูกต้อง");
    }

    // รับข้อมูลจากฟอร์ม
    $answers = $_POST['answers']; // คำตอบของคำถามต่างๆ
    $additional_comments = $_POST['additional_comments']; // ความคิดเห็นเพิ่มเติม

    // สมมติว่ามีการจัดการ user_id
    $user_id = $_SESSION['user_id']; // กรณีนี้เป็นตัวอย่าง ควรแทนค่าด้วยการดึงจากระบบผู้ใช้

    // เริ่มต้นการบันทึกคำตอบในฐานข้อมูล
    try {
        // สตาร์ทการทำธุรกรรม
        $conn->beginTransaction();

        // บันทึกคำตอบที่เป็น 'rating'
        foreach ($answers as $question_id => $answer_value) {

            // ตรวจสอบว่า $answer_value มีค่าและ $question_id ไม่เป็น null
            if (is_numeric($answer_value) && !empty($question_id)) {
                $stmt = $conn->prepare("INSERT INTO answer (evaluation_id, question_id, user_id, answer_value, response_type) 
                                        VALUES (:evaluation_id, :question_id, :user_id, :answer_value, 'rating')");
                $stmt->execute([
                    'evaluation_id' => $evaluation_id,  // ใส่ ID ของการประเมิน
                    'question_id' => $question_id,      // ค่า question_id ที่ได้รับจากฟอร์ม
                    'user_id' => $user_id,
                    'answer_value' => $answer_value
                ]);
            } else {
                echo "คำตอบไม่ถูกต้อง หรือ question_id ไม่มีค่า<br>";
            }
        }

        // บันทึกความคิดเห็นเพิ่มเติม
        if (!empty($additional_comments)) {
            $stmt = $conn->prepare("INSERT INTO answer (evaluation_id, user_id, answer_value, response_type) 
                                    VALUES (:evaluation_id, :user_id, :additional_comments, 'text')");
            $stmt->execute([
                'evaluation_id' => $evaluation_id,  // ใส่ ID ของการประเมิน
                'user_id' => $user_id,
                'additional_comments' => $additional_comments
            ]);
        }

        // เสร็จสิ้นการทำธุรกรรม
        $conn->commit();
        header("Location: thankyou.php"); // เปลี่ยนเส้นทางไปยังหน้าขอบคุณหลังจากส่งแบบประเมิน
    } catch (Exception $e) {
        // หากเกิดข้อผิดพลาด ให้ย้อนกลับธุรกรรมทั้งหมด
        $conn->rollBack();
        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
} else {
    echo "ไม่มีข้อมูลฟอร์มที่ได้รับ";
}
