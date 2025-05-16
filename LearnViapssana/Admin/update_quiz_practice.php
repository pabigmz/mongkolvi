<?php
include('../includes/connect.php'); // เชื่อมต่อฐานข้อมูล
session_start(); // เริ่ม session สำหรับแจ้งเตือนข้อความ

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // รับค่าจากฟอร์มและกรองข้อมูลเพื่อความปลอดภัย
        $quiz_id = isset($_POST['quiz_id']) ? trim($_POST['quiz_id']) : null;
        $question = isset($_POST['question']) ? trim(htmlspecialchars($_POST['question'])) : null;
        $choice_a = isset($_POST['choice_a']) ? trim(htmlspecialchars($_POST['choice_a'])) : null;
        $choice_b = isset($_POST['choice_b']) ? trim(htmlspecialchars($_POST['choice_b'])) : null;
        $choice_c = isset($_POST['choice_c']) ? trim(htmlspecialchars($_POST['choice_c'])) : null;
        $choice_d = isset($_POST['choice_d']) ? trim(htmlspecialchars($_POST['choice_d'])) : null;
        $choice_e = isset($_POST['choice_e']) ? trim(htmlspecialchars($_POST['choice_e'])) : null;
        $answer = isset($_POST['correct_answer']) ? trim($_POST['correct_answer']) : null;

        // ตรวจสอบว่าค่าที่ต้องการอัปเดตมีครบหรือไม่
        if (!$quiz_id || !$question || !$choice_a || !$choice_b || !$choice_c || !$choice_d || !$choice_e || !$answer) {
            $_SESSION['message'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
            header("Location: ./listvideo.php");
            exit();
        }

        // **อัปเดตคำถามลงฐานข้อมูล**
        $sql = "UPDATE quizzes_practice SET 
                    quiz_title = :question, 
                    choice_a = :choice_a, 
                    choice_b = :choice_b, 
                    choice_c = :choice_c, 
                    choice_d = :choice_d, 
                    choice_e = :choice_e, 
                    correct_answer = :answer, 
                    updated_at = NOW() 
                WHERE id = :quiz_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'question' => $question,
            'choice_a' => $choice_a,
            'choice_b' => $choice_b,
            'choice_c' => $choice_c,
            'choice_d' => $choice_d,
            'choice_e' => $choice_e,
            'answer' => $answer,
            'quiz_id' => $quiz_id
        ]);

        $_SESSION['message'] = "อัปเดตข้อมูลสำเร็จแล้ว";
        header("Location: ./listvideo.php");
        exit();
    } else {
        header("Location: ./listvideo.php");
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['message'] = "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
    header("Location: ./listvideo.php");
    exit();
}
