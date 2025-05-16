<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}
include('../includes/connect.php');
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM answer WHERE user_id = :user_id");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($answers)) {
    header("Location: ./thankyou.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM evaluations");
$stmt->execute();
$evaluations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/evaluate/evaluate.css">
    <title>แบบประเมิน</title>
</head>

<body>
    <div class="container">
        <div class="head">
            <h1>แบบประเมินเว็บแอปพลิเคชันสื่อบทเรียนออนไลน์การปฏิบัติวิปัสสนากรรมฐาน</h1>
        </div>

        
        <form action="submit_evaluation.php" method="post">
            <div class="detail">
                <h2>คำชี้แจง</h2>
                <p>คำเครื่องหมายในช่องความคิดเห็น โดยเลือกตามระดับความคิดเห็นที่กำหนดไว้ ระดับคุณภาพในการประเมินมีดังนี้</p>
                <ul>
                    <li>5 หมายถึง    คุณภาพดีมากที่สุด</li>
                    <li>4 หมายถึง    คุณภาพดีมาก</li>
                    <li>3 หมายถึง    คุณภาพปานกลาง</li>
                    <li>2 หมายถึง    คุณภาพน้อย</li>
                    <li>1 หมายถึง    คุณภาพน้อยมาก</li>
                </ul>
            </div>
            <?php foreach ($evaluations as $eval): ?>
                <input type="hidden" name="evaluation_id" value="<?= $eval['evaluation_id'] ?>"> <!-- เพิ่ม hidden field สำหรับ evaluation_id -->
                <h2><?= htmlspecialchars($eval['name']) ?></h2>

                <div class="choice-container">
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM question_evaluation WHERE evaluation_id = :eva ORDER BY section, order_number ASC");
                    $stmt->execute(['eva' => $eval['evaluation_id']]);
                    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $current_section = "";
                    ?>

                    <?php foreach ($questions as $question): ?>
                        <?php
                        if ($current_section !== $question['section']) {
                            $current_section = $question['section'];
                            echo "<h3>" . htmlspecialchars($current_section) . "</h3>";
                        }
                        ?>
                        <div class="inchoice-container">
                            <p><?= htmlspecialchars($question['question_text']) ?></p>

                            <?php if ($question['question_type'] == 'rating'): ?>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <label>
                                        <input type="radio" name="answers[<?= $question['question_id'] ?>]" value="<?= $i ?>" required>
                                        <?= $i ?>
                                    </label>
                                <?php endfor; ?>
                                <br>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <h2>ความคิดเห็นเพิ่มเติม</h2>
            <textarea name="additional_comments" rows="4" cols="50" placeholder="กรุณาใส่ความคิดเห็นเพิ่มเติมที่นี่"></textarea>
            <br><br>

            <button type="submit">ส่งแบบประเมิน</button>
        </form>
    </div>


</body>

</html>