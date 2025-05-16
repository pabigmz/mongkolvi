<?php
include('../includes/connect.php');
session_start();

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $quiz_id = isset($_POST['quiz_id']) ? trim($_POST['quiz_id']) : null;
        $question = isset($_POST['question']) ? trim(htmlspecialchars($_POST['question'])) : null;
        $choice_a = isset($_POST['choice_a']) ? trim(htmlspecialchars($_POST['choice_a'])) : null;
        $choice_b = isset($_POST['choice_b']) ? trim(htmlspecialchars($_POST['choice_b'])) : null;
        $choice_c = isset($_POST['choice_c']) ? trim(htmlspecialchars($_POST['choice_c'])) : null;
        $choice_d = isset($_POST['choice_d']) ? trim(htmlspecialchars($_POST['choice_d'])) : null;

        // ✅ แก้ตรงนี้
        $answer_input_name = 'correct_answer_' . $quiz_id;
        $answer = isset($_POST[$answer_input_name]) ? trim($_POST[$answer_input_name]) : null;

        if (!$quiz_id || !$question || !$choice_a || !$choice_b || !$choice_c || !$choice_d || !$answer) {
            header("Location: ./listlesson.php");
            exit();
        }

        $sql = "UPDATE quizzes SET 
                    question = :question, 
                    choice_a = :choice_a, 
                    choice_b = :choice_b, 
                    choice_c = :choice_c, 
                    choice_d = :choice_d, 
                    correct_answer = :answer, 
                    updated_at = NOW() 
                WHERE quiz_id = :quiz_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'question' => $question,
            'choice_a' => $choice_a,
            'choice_b' => $choice_b,
            'choice_c' => $choice_c,
            'choice_d' => $choice_d,
            'answer' => $answer,
            'quiz_id' => $quiz_id
        ]);

        $_SESSION['message'] = "อัปเดตข้อมูลสำเร็จแล้ว";
        header("Location: ./listlesson.php");
        exit();
    } else {
        header("Location: ./listlesson.php");
        exit();
    }
} catch (PDOException $e) {
    header("Location: ./listlesson.php");
    exit();
}
?>
