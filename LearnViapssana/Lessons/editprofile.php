<?php
session_start();

try {
    include("../includes/connect.php");

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
        header("Location: ../login/login.php");
        exit();
    }

    $userId = $_SESSION['user_id'];

    // ดึงข้อมูลผู้ใช้งาน
    $user_sql = ("SELECT * FROM users WHERE user_id = :id");
    $stmt = $conn->prepare($user_sql);
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // เมื่อมีการส่งฟอร์มแก้ไขข้อมูล
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        
        // ตรวจสอบไฟล์รูปภาพ
        $profilePath = $user['path_profile']; // ค่าเริ่มต้นเป็นรูปเดิม
        if (isset($_FILES['path_profile']) && $_FILES['path_profile']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['path_profile']['tmp_name'];
            $fileName = $_FILES['path_profile']['name'];
            $fileSize = $_FILES['path_profile']['size'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png']; // เอา gif ออก

            // ตรวจสอบประเภทและขนาดไฟล์
            if (in_array($fileExtension, $allowedExtensions)) {
                if ($fileSize <= 2 * 1024 * 1024) { // จำกัดขนาดไม่เกิน 2MB
                    $newFileName = uniqid() . '.' . $fileExtension;
                    $uploadFileDir = '../assets/uploads/profile/';
                    $dest_path = $uploadFileDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $profilePath = $dest_path;
                    } else {
                        throw new Exception("เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ");
                    }
                } else {
                    throw new Exception("ขนาดไฟล์เกิน 2MB");
                }
            } else {
                throw new Exception("อนุญาตให้ใช้ไฟล์เฉพาะ jpg, jpeg และ png เท่านั้น");
            }
        }

        // อัปเดตข้อมูลในฐานข้อมูล
        $update_sql = "UPDATE users SET fname = :fname, lname = :lname, email = :email, telephone = :phone, path_profile = :profile WHERE user_id = :id";
        $stmt = $conn->prepare($update_sql);
        $stmt->execute([
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'phone' => $phone,
            'profile' => $profilePath,
            'id' => $userId
        ]);

        $_SESSION['success_message'] = "อัปเดตโปรไฟล์เรียบร้อยแล้ว!";
        header("Location: editprofile.php");
        exit();
    }
} catch (PDOException $e) {
    die("เกิดข้อผิดพลาด: " . $e->getMessage());
} catch (Exception $e) {
    die("เกิดข้อผิดพลาด: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/lesson/edit.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>แก้ไขโปรไฟล์</title>
</head>

<body>
    <main>
        <h1>แก้ไขโปรไฟล์</h1>
        <?php if (isset($_SESSION['success_message'])): ?>
            <p style="color: green;">
                <?= $_SESSION['success_message'];
                unset($_SESSION['success_message']); ?>
            </p>
        <?php endif; ?>

        <img src="<?php echo htmlspecialchars($user['path_profile']); ?>" alt="รูปโปรไฟล์" width="150"><br><br>

        <form method="POST" enctype="multipart/form-data">
            <label for="path_profile">อัปโหลดรูปใหม่ (png,jpg,jpeg,gif)</label>
            <input type="file" name="path_profile" accept="image/*"><br><br>

            <label>ชื่อ</label>
            <input type="text" name="fname" value="<?= htmlspecialchars($user['fname']) ?>" required><br><br>

            <label>นามสกุล</label>
            <input type="text" name="lname" value="<?= htmlspecialchars($user['lname']) ?>" required><br><br>

            <label>อีเมล</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>

            <label>เบอร์โทรศัพท์</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($user['telephone']) ?>" required><br><br>

            <button type="submit">บันทึก</button>
        </form>
        <a href="./">กลับ</a>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>
    <script>
        flatpickr("#birthdate", {
            locale: "th", // ใช้ locale ภาษาไทย
            dateFormat: "d/m/Y", // รูปแบบวันที่ dd/mm/yyyy
            altInput: true, // ใช้ input แบบ alternative
            altFormat: "d/m/Y", // แสดงในฟอร์แมต d/m/Y
            allowInput: true, // อนุญาตให้กรอกวันที่เอง
            defaultDate: "<?= date('d/m/', strtotime($user['birthday'])) . (date('Y', strtotime($user['birthday'])) + 543) ?>", // แสดงวันที่เป็น พ.ศ.
            onReady: function(selectedDates, dateStr, instance) {
                let currentYear = new Date().getFullYear() + 543; // ปี พ.ศ.
                instance.currentYearElement.value = currentYear;
            },
            parseDate: function(datestr, format) {
                let parts = datestr.split("/");
                if (parts.length === 3) {
                    let day = parseInt(parts[0]);
                    let month = parseInt(parts[1]) - 1;
                    let year = parseInt(parts[2]) - 543; // แปลงจาก พ.ศ. เป็น ค.ศ.
                    return new Date(year, month, day);
                }
                return null;
            },
            formatDate: function(date, format) {
                let day = date.getDate();
                let month = date.getMonth() + 1;
                let year = date.getFullYear() + 543; // แปลงจาก ค.ศ. เป็น พ.ศ.
                return `${day}/${month}/${year}`;
            },
            onMonthChange: function(selectedDates, dateStr, instance) {
                let currentYear = instance.currentYear;
                instance.currentYearElement.value = currentYear + 543; // อัปเดตปีเป็น พ.ศ. เมื่อเปลี่ยนเดือน
            },
            onYearChange: function(selectedDates, dateStr, instance) {
                let currentYear = instance.currentYear;
                instance.currentYearElement.value = currentYear + 543; // อัปเดตปีเป็น พ.ศ. เมื่อเปลี่ยนปี
            }
        });
    </script>
</body>

</html>