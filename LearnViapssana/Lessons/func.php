<?php 

function getLessonStatus($userId, $lessonId) {
    global $conn;

    // หา id ของบทเรียนน้อยกที่สุดในฐานข้อมูล
    $stmt = $conn->prepare("SELECT MIN(lesson_id) AS min_lesson_id FROM lessons");
    $stmt->execute();
    $minLessonId = $stmt->fetch(PDO::FETCH_ASSOC)['min_lesson_id'];

    // บทเรียนที่ 1 ปลดล็อกเสมอ และ progress เริ่มต้นที่ 0%
    if ($lessonId == $minLessonId) {
        return ['unlocked' => true, 'progress' => getLessonProgress($userId, $lessonId)];
    }

    // ตรวจสอบว่าผู้ใช้ผ่านบทเรียนก่อนหน้า (บทเรียนก่อนหน้าต้องมี `is_completed = 1`)
    $prevLessonId = $lessonId - 1;
    $stmt = $conn->prepare("SELECT is_completed FROM user_progress WHERE user_id = :user_id AND lesson_id = :lesson_id");
    $stmt->execute(['user_id' => $userId, 'lesson_id' => $prevLessonId]);
    $progress = $stmt->fetch(PDO::FETCH_ASSOC);

    // ปลดล็อกบทเรียนหากบทก่อนหน้ามี `is_completed = 1`
    $isUnlocked = $progress && $progress['is_completed'] == 1;

    // ดึง progress ของบทเรียนปัจจุบัน
    $lessonProgress = getLessonProgress($userId, $lessonId);

    return ['unlocked' => $isUnlocked, 'progress' => $lessonProgress];
}

// ฟังก์ชันดึง progress ของแต่ละบทเรียน
function getLessonProgress($userId, $lessonId) {
    global $conn;
    $stmt = $conn->prepare("SELECT progress FROM user_progress WHERE user_id = :user_id AND lesson_id = :lesson_id");
    $stmt->execute(['user_id' => $userId, 'lesson_id' => $lessonId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result ? $result['progress'] : 0; // ถ้าไม่มีข้อมูลให้คืนค่า 0
}



function checkLessonProgress($userId, $lessonId, $postTestScore, $videoPercentage) {
    global $conn;

    // ดึงข้อมูลความคืบหน้าปัจจุบัน
    $stmt = $conn->prepare("SELECT * FROM User_Progress WHERE user_id = :user_id AND lesson_id = :lesson_id");
    $stmt->execute(['user_id' => $userId, 'lesson_id' => $lessonId]);
    $progress = $stmt->fetch(PDO::FETCH_ASSOC);

    // ตรวจสอบเงื่อนไขการปลดล็อก
    if ($postTestScore >= 70 && $videoPercentage >= 90 && $progress['attempts'] <= 3) {
        // อัปเดตบทเรียนปัจจุบันให้เป็นสำเร็จ
        $update = $conn->prepare("UPDATE User_Progress SET is_completed = TRUE WHERE progress_id = :progress_id");
        $update->execute(['progress_id' => $progress['progress_id']]);

        // ปลดล็อกบทเรียนถัดไป
        $nextLessonId = $lessonId + 1; // สมมติว่าบทเรียนถัดไปคือ +1
        $insertNextLesson = $conn->prepare("INSERT INTO User_Progress (user_id, lesson_id) VALUES (:user_id, :lesson_id)");
        $insertNextLesson->execute(['user_id' => $userId, 'lesson_id' => $nextLessonId]);

        return true; // ปลดล็อกสำเร็จ
    } else {
        // เพิ่มจำนวนครั้งการทำแบบทดสอบ
        $updateAttempts = $conn->prepare("UPDATE User_Progress SET attempts = attempts + 1 WHERE progress_id = :progress_id");
        $updateAttempts->execute(['progress_id' => $progress['progress_id']]);

        return false; // เงื่อนไขไม่ผ่าน
    }
}

// ดึงสถานะของบทปฏิบัติ
function getPracticeStatus($userId, $practiceId) {
    global $conn;

    // หา id ของบทปฏิบัติน้อยที่สุดในฐานข้อมูล
    $stmt = $conn->prepare("SELECT MIN(practice_id) AS min_practice_id FROM practice");
    $stmt->execute();
    $minPracticeId = $stmt->fetch(PDO::FETCH_ASSOC)['min_practice_id'];

    // บทปฏิบัติที่ 1 ปลดล็อกเสมอ และ progress เริ่มต้นที่ 0%
    if ($practiceId == $minPracticeId) {
        return ['unlocked' => true, 'progress' => getPracticeProgress($userId, $practiceId)];
    }

    // ตรวจสอบว่าผู้ใช้ผ่านบทปฏิบัติก่อนหน้าหรือไม่
    $prevPracticeId = $practiceId - 1;
    $stmt = $conn->prepare("SELECT is_completed FROM user_practice_progress WHERE user_id = :user_id AND practice_id = :practice_id");
    $stmt->execute(['user_id' => $userId, 'practice_id' => $prevPracticeId]);
    $progress = $stmt->fetch(PDO::FETCH_ASSOC);

    // ปลดล็อกบทปฏิบัติหากบทก่อนหน้ามี `is_completed = 1`
    $isUnlocked = $progress && $progress['is_completed'] == 1;

    // ดึง progress ของบทปฏิบัติปัจจุบัน
    $practiceProgress = getPracticeProgress($userId, $practiceId);

    return ['unlocked' => $isUnlocked, 'progress' => $practiceProgress];
}

// ฟังก์ชันดึง progress ของแต่ละบทปฏิบัติ
function getPracticeProgress($userId, $practiceId) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT progress FROM user_practice_progress WHERE user_id = :user_id AND practice_id = :practice_id");
    $stmt->execute(['user_id' => $userId, 'practice_id' => $practiceId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result ? $result['progress'] : 0; // ถ้าไม่มีข้อมูลให้คืนค่า 0
}


// ตรวจสอบความคืบหน้าของการฝึก
function checkPracticeProgress($userId, $practiceId, $videoPercentage) {
    global $conn;

    // ดึงข้อมูลความคืบหน้าปัจจุบัน
    $stmt = $conn->prepare("SELECT * FROM user_practice_progress WHERE user_id = :user_id AND practice_id = :practice_id");
    $stmt->execute(['user_id' => $userId, 'practice_id' => $practiceId]);
    $progress = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($videoPercentage >= 90) {
        // อัปเดตสถานะบทเรียนให้เป็นสำเร็จ
        if ($progress) {
            $update = $conn->prepare("UPDATE user_practice_progress SET is_completed = 1 WHERE id = :progress_id");
            $update->execute(['progress_id' => $progress['id']]);
        } else {
            // ถ้ายังไม่มีข้อมูลในตาราง ให้เพิ่มเข้าไปเลย
            $insert = $conn->prepare("INSERT INTO user_practice_progress (user_id, practice_id, is_completed) VALUES (:user_id, :practice_id, 1)");
            $insert->execute(['user_id' => $userId, 'practice_id' => $practiceId]);
        }

        // ตรวจสอบว่ามีบทเรียนถัดไปหรือยัง
        $nextPracticeId = $practiceId + 1;
        $checkNext = $conn->prepare("SELECT * FROM user_practice_progress WHERE user_id = :user_id AND practice_id = :next_practice_id");
        $checkNext->execute(['user_id' => $userId, 'next_practice_id' => $nextPracticeId]);
        $nextProgress = $checkNext->fetch(PDO::FETCH_ASSOC);

        if (!$nextProgress) {
            // ถ้าไม่มีบทเรียนถัดไป ให้เพิ่มเข้าไปเพื่อปลดล็อก
            $insertNextPractice = $conn->prepare("INSERT INTO user_practice_progress (user_id, practice_id) VALUES (:user_id, :practice_id)");
            $insertNextPractice->execute(['user_id' => $userId, 'practice_id' => $nextPracticeId]);
        }

        return true; // ปลดล็อกสำเร็จ
    } else {
        return false; // เงื่อนไขไม่ผ่าน
    }
}


?>