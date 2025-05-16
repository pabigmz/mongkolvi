<?php
session_start();
include('../includes/connect.php');
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $password = $_POST['password'];
    $password_confirm = $_POST['confirm_password'];
    $level = $_POST['level'];
    $learn = $_POST['learn'];

    // ตรวจสอบรูปแบบอีเมล
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "อีเมลไม่ถูกต้อง!";
    }

    // ตรวจสอบอีเมลซ้ำ
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "อีเมลนี้มีผู้ใช้งานแล้ว!";
    }

    // ตรวจสอบเบอร์โทรศัพท์
    $phone_number = preg_replace('/[^0-9]/', '', $phone_number);
    if (strlen($phone_number) < 9 || strlen($phone_number) > 10) {
        $errors[] = "เบอร์โทรศัพท์ไม่ถูกต้อง!";
    }


    // ตรวจสอบระดับการศึกษา
    $stmt = $conn->prepare("SELECT COUNT(*) FROM educationlevels WHERE id = ?");
    $stmt->execute([$level]);
    if ($stmt->fetchColumn() == 0) {
        $errors[] = "ระดับการศึกษาที่เลือกไม่ถูกต้อง!";
    }

    // ตรวจสอบรหัสผ่าน
    if ($password !== $password_confirm) {
        $errors[] = "รหัสผ่านไม่ตรงกัน!";
    }

    if (strlen($password) < 8 || !preg_match('/[0-9]/', $password) || !preg_match('/[a-zA-Z]/', $password)) {
        $errors[] = "รหัสผ่านต้องมีอย่างน้อย 8 ตัว และต้องมีทั้งตัวเลขและตัวอักษร!";
    }

    // หากไม่มีข้อผิดพลาดให้เพิ่มข้อมูล
    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $role = 'student';

        try {
            $stmt = $conn->prepare("INSERT INTO `users` (`fname`, `lname`, `password`, `email`, `telephone`, `vipassana`, `education_id`, `role`) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$first_name, $last_name, $password_hash, $email, $phone_number, $learn, $level, $role]);

            $_SESSION['success_message'] = "สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ";
            header('Location: ./login.php');
            exit();
        } catch (PDOException $e) {
            $errors[] = "Database Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="../assets/css/register.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>
</head>

<body>
    <header>
        <h2>สื่อบทเรียนออนไลน์</h2>
    </header>
    <main>
        <div class="container">

            <form class="form-register" method="POST">
                <h1>สมัครสมาชิก</h1>
                <div class="inputbox">
                    <input type="email" name="email" required>
                    <span>อีเมล</span>
                </div>
                <p style="color:rgb(173, 173, 173);">รหัสผ่านต้องมีอย่างน้อย 8 ตัว มีตัวเลขและตัวอักษร</p>
                <div class="inputbox">
                    <input type="password" name="password" required>
                    <span>รหัสผ่าน</span>
                </div>
                <div class="inputbox">
                    <input type="password" name="confirm_password" required>
                    <span>ยืนยันรหัสผ่านอีกครั้ง</span>
                </div>
                <?php if (!empty($errors)): ?>
                    <div class="error-messages">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li style="color: red;"><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <h1>ข้อมูลส่วนบุคคล</h1>
                <div class="inputbox">
                    <input type="text" name="first_name" required>
                    <span>ชื่อ</span>
                </div>
                <div class="inputbox">
                    <input type="text" name="last_name" required>
                    <span>นามสกุล</span>
                </div>
                <div class="inputbox">
                    <input type="text" name="phone_number" required>
                    <span>เบอร์โทรศัพท์</span>
                </div>
                <div class="inputbox">
                    <select name="level" required>
                        <option value="" disabled selected>ระดับการศึกษา</option>
                        <option value="1">ประถมศึกษา</option>
                        <option value="2">มัธยมศึกษาตอนต้น</option>
                        <option value="3">มัธยมศึกษาตอนปลาย</option>
                        <option value="4">ปริญญาตรี</option>
                        <option value="5">ปริญญาโท</option>
                        <option value="6">ปริญญาเอก</option>
                    </select>
                </div>
                <h3>เคยผ่านการปฏิบัติวิปัสสนากรรมฐานหรือไม่</h3>
                <div class="inputbox">
                    <select name="learn" required>
                        <option value="1">เคย</option>
                        <option value="0">ไม่เคย</option>
                    </select>
                </div>
                <div class="box-button">
                    <input type="checkbox" name="confirm" id="confirm" required>
                    <span>ข้าพเจ้ายอมรับ <a href="../term.php">ข้อกำหนดการใช้งาน</a> และ <a href="../privacy.php">นโยบายความเป็นส่วนตัว</a> และยินยอมให้เว็บไซต์เก็บรวบรวม ใช้ และประมวลผลข้อมูลส่วนบุคคลตามวัตถุประสงค์ที่กำหนด</span>
                    <button type="submit">สมัครสมาชิก</button>
                </div>
                <div class="btn-login">
                    <p>มีบัญชีแล้ว ? <a href="./login.php">เข้าสู่ระบบ</a></p>
                </div>
            </form>
        </div>
        <a class="link-login" href="../"><i class='bx bx-left-arrow-alt'></i>กลับหน้าแรก</a>
    </main>

    <script>
        flatpickr("#birthDate", {
            locale: "th",
            dateFormat: "d/m/Y",
            allowInput: true,
            altInput: true,
            altFormat: "d/m/Y",
            defaultDate: null, // ไม่ให้มีค่าเริ่มต้น
            onReady: function(selectedDates, dateStr, instance) {
                // ✅ เปลี่ยนปีในปฏิทินเป็น พ.ศ. ตั้งแต่แรก
                let currentYear = new Date().getFullYear() + 543;
                instance.currentYearElement.value = currentYear;
            },
            parseDate: function(datestr, format) {
                // ✅ แปลง ปี พ.ศ. → ค.ศ.
                let parts = datestr.split("/");
                if (parts.length === 3) {
                    let day = parseInt(parts[0]);
                    let month = parseInt(parts[1]) - 1;
                    let year = parseInt(parts[2]) - 543;
                    return new Date(year, month, day);
                }
                return null;
            },
            formatDate: function(date, format) {
                // ✅ แปลง ปี ค.ศ. → พ.ศ.
                let day = date.getDate();
                let month = date.getMonth() + 1;
                let year = date.getFullYear() + 543;
                return `${day}/${month}/${year}`;
            },
            onChange: function(selectedDates, dateStr, instance) {
                let inputField = document.querySelector("#birthDate");
                if (selectedDates.length > 0) {
                    inputField.classList.add("has-value");
                } else {
                    inputField.classList.remove("has-value");
                }
            },
            onMonthChange: function(selectedDates, dateStr, instance) {
                // ✅ อัปเดตปี พ.ศ. เมื่อเปลี่ยนเดือน
                let currentYear = instance.currentYear;
                instance.currentYearElement.value = currentYear + 543;
            },
            onYearChange: function(selectedDates, dateStr, instance) {
                // ✅ อัปเดตปี พ.ศ. เมื่อเปลี่ยนปี
                let currentYear = instance.currentYear;
                instance.currentYearElement.value = currentYear + 543;
            }
        });


        // ตรวจสอบค่าเมื่อโหลดหน้าเว็บ
        document.addEventListener("DOMContentLoaded", function() {
            let birthDateInput = document.getElementById("birthDate");

            if (birthDateInput.value.trim() !== "") {
                birthDateInput.classList.add("has-value");
            }

            birthDateInput.addEventListener("input", function() {
                if (birthDateInput.value.trim() !== "") {
                    birthDateInput.classList.add("has-value");
                } else {
                    birthDateInput.classList.remove("has-value");
                }
            });
        });
    </script>


</body>

</html>