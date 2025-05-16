<?php
session_start();

try {
    include("./func.php");
    include("../includes/connect.php");

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
        // ถ้าไม่มี session หรือ role ไม่ใช่ admin ให้ redirect ออกไป
        header("Location: ../login/login.php");
        exit();
    }

    include("./log-inline.php");

    if (isset($_SESSION['lesson_id'])) {
        unset($_SESSION['lesson_id']);
    }

    if (isset($_SESSION['success_message'])) {
        unset($_SESSION['success_message']);
    }

    $userId = $_SESSION['user_id']; // ดึง ID ผู้ใช้ที่ล็อกอิน

    // ดึงข้อมูลผู้ใข้งาน
    $user_sql = ("SELECT * FROM users WHERE user_id = :id");
    $stmt = $conn->prepare($user_sql);
    $stmt->execute(['id' => $userId]);
    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    // ดึงข้อมูลบทเรียน
    $lesson_stmt = $conn->query("SELECT * FROM lessons ORDER BY lesson_id ASC");
    $lessons = $lesson_stmt->fetchAll(PDO::FETCH_ASSOC);
    $lesson_count = count($lessons);

    // ดึงข้อมูลบทปฏิบัติ
    $practice_sql = "SELECT * FROM practice ORDER BY practice_id ASC";
    $stmt = $conn->prepare($practice_sql);
    $stmt->execute();
    $practices = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $practice_count = count($practices);

    // ดึง Progress บทเรียนปกติ
    $sql_lessonProgress = "SELECT * FROM user_progress WHERE user_id = :userId AND is_completed = :completed";
    $stmt = $conn->prepare($sql_lessonProgress);
    $stmt->execute(['userId' => $userId, 'completed' => 1]);
    $progerss = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $progerssCount = count($progerss);

    // ดึง Progress บทเรียนป
    $sql_pracitceProgress = "SELECT * FROM user_practice_progress WHERE user_id = :userId AND is_completed = :completed";
    $stmt = $conn->prepare($sql_pracitceProgress);
    $stmt->execute(['userId' => $userId, 'completed' => 1]);
    $practice = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $practiceProgress = count($practice);

    // ดึง certificate 
    $sql_certificate = "SELECT * FROM certificate WHERE user_id = :userId";
    $stmt = $conn->prepare($sql_certificate);
    $stmt->execute(['userId' => $userId]);
    $certificate = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("เกิดข้อผิดพลาด: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บทเรียน</title>
    <link rel="stylesheet" href="../assets/css/lesson/home.css">

    <!-- ICON -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <header>
        <div class="nav">
            <div class="profile">
                <a href="./" style="display: flex; color: black">
                    <img src="../assets/img/learnvipassana.png" alt="" width="50" style="border-radius: 5px; margin-right: 0.5rem;">
                    <div class="logo-header">
                        <span class="on_text">สื่อบทเรียนออนไลน์</span>
                        <span class="under_text">การปฏิบัติวิปัสสนากัมมัฏฐาน ตามแนวคิดสติปัฏฐาน 4 ของพระพรหมมงคล วิ.</span>
                    </div>
                </a>
            </div>
            <img src="<?php echo htmlspecialchars($users['path_profile']); ?>" alt="user-pic" onclick="toggleMenu()">

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="<?php echo htmlspecialchars($users['path_profile']); ?>" alt="Profile">
                        <h2><?php echo $users['fname'] . " " . $users['lname']; ?></h2>
                    </div>
                    <hr>
                    <div class="mobile-menu">
                        <a href="./" class="sub-menu-link">
                            <i class='bx bx-book-alt'></i>
                            <p>การเรียนของฉัน</p>
                            <span>></span>
                        </a>
                        <a href="../Threads/" class="sub-menu-link">
                            <i class='bx bx-user-voice'></i>
                            <p>กระทู้</p>
                            <span>></span>
                        </a>
                        <?php
                        if ($lesson_count == $progerssCount && $practice_count == $practiceProgress) { ?>
                            <a href="./certificate/certificate.php" class="sub-menu-link">
                                <i class='bx bx-award'></i>
                                <p>ใบประกาศนียบัตร</p>
                                <span>></span>
                            </a>
                        <?php
                        }
                        ?>
                        <?php
                        if ($lesson_count == $progerssCount && $practice_count == $practiceProgress) { ?>
                            <a href="https://forms.gle/dpRF3AnRGaJn5tto6" target="_blank" class="sub-menu-link">
                                <i class='bx bx-file'></i>
                                <p>แบบประเมิน</p>
                                <span>></span>
                            </a>
                        <?php
                        }
                        ?>

                    </div>

                    <a href="./editprofile.php" class="sub-menu-link">
                        <i class='bx bx-cog'></i>
                        <p>แก้ไขโปรไฟล์</p>
                        <span>></span>
                    </a>
                    <a href="../login/logout.php" class="sub-menu-link">
                        <i class='bx bx-log-out'></i>
                        <p>ออกจากระบบ</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <aside>
            <div class="left-box">
                <p>การเรียนรู้</p>
                <div class="menu">
                    <ul>
                        <li>
                            <a href="./" class="active"><i class='bx bx-book-alt'></i>การเรียนของฉัน</a>
                        </li>
                        <li>
                            <a href="../Threads/"><i class='bx bx-user-voice'></i>กระทู้</a>
                        </li>
                        <?php
                        if ($lesson_count == $progerssCount && $practice_count == $practiceProgress) { ?>
                            <li>
                                <a href="./certificate/certificate.php"><i class='bx bx-award'></i>ใบประกาศนียบัตร</a>
                            </li>
                        <?php
                        }
                        ?>
                        <?php
                        if ($lesson_count == $progerssCount && $practice_count == $practiceProgress) { ?>
                            <li>
                                <a href="https://forms.gle/dpRF3AnRGaJn5tto6" target="_blank"><i class='bx bx-file'></i>แบบประเมิน</a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </aside>

        <main>
            <div class="container-main">
                <p>การเรียนของคุณ <?php echo $users['fname'] . " " . $users['lname']; ?></p>
                <p style="margin: 0; padding: 0; margin-bottom: 2rem; font-size: 14px;">หมายเหตุ : กรณีผู้ใช้งานเรียนครบทุกบท ทั้งบทเรียนทั่วไปและบทเรียนปฏิบัติ ผู้ใช้งานจะได้รับใบประกาศนียบัตร</p>
                <div class="switch-toggle">
                    <div id="btn"></div>
                    <button id="leftBtn" type="button" class="toggle-btn" onclick="leftClick();">บทเรียน</button>
                    <button id="rightBtn" type="button" class="toggle-btn" onclick="rightClick();">บทปฏิบัติ</button>
                </div>
                <div class="box-lessons">
                    <p>จำนวน: <?php echo count($lessons); ?> บทเรียน</p>




                    <div class="card">
                        <?php
                        // ตัวแปร number เพื่อแสดงหมายเลขบทเรียน
                        $number = 0;
                        foreach ($lessons as $lesson) {
                            $number++; // เพิ่มหมายเลขบทเรียนขึ้นทีละ 1
                            $lessonStatus = getLessonStatus($userId, $lesson['lesson_id']);
                            $isUnlocked = $lessonStatus['unlocked'];
                            $progress = $lessonStatus['progress'];

                            error_log("Lesson {$lesson['lesson_id']} unlocked: " . ($isUnlocked ? 'true' : 'false'));

                            if ($isUnlocked) { ?>
                                <div class="box-info">
                                    <p>บทเรียนที่ <?php echo $number; ?></p>
                                    <div class="box-label">
                                        <p>ความคืบหน้า</p>
                                        <p><?php echo $progress; ?>%</p> <!-- แสดง progress จริง -->
                                    </div>
                                    <div class="progress-bar">
                                        <span class="progres" data-width="<?php echo $progress; ?>%" style="width: <?php echo $progress; ?>%;"></span>
                                    </div>
                                    <a href="./Lesson/index.php?id=<?php echo $lesson['lesson_id']; ?>">
                                        <?php echo ($progress > 0) ? "เรียนต่อ" : "เริ่มเรียน"; ?>
                                    </a>
                                </div>
                            <?php } else { ?>
                                <div class="box-info locked">
                                    <p>บทเรียน <?php echo $number; ?></p>
                                    <div class="box-label">
                                        <p>ความคืบหน้า</p>
                                        <p><?php echo $progress; ?>%</p>
                                    </div>
                                    <div class="progress-bar">
                                        <span class="progres" data-width="<?php echo $progress; ?>%" style="width: <?php echo $progress; ?>%;"></span>
                                    </div>
                                    <a href="#" class="disabled">เริ่มเรียน</a>
                                </div>
                        <?php }
                        }
                        ?>

                    </div>
                </div>
                <div class="box-practice" style="display: none;">
                    <p>จำนวน: <?php echo count($practices); ?> บทปฏิบัติ</p>

                    <div class="card">
                        <?php
                        foreach ($practices as $practice) {
                            $practiceStatus = getPracticeStatus($userId, $practice['practice_id']);
                            $isUnlocked = $practiceStatus['unlocked'];
                            $progress = $practiceStatus['progress'];

                            if ($isUnlocked) { ?>
                                <div class="box-info">
                                    <p><?php echo htmlspecialchars($practice['practice_title']); ?></p>
                                    <div class="box-label">
                                        <p>ความคืบหน้า</p>
                                        <p><?php echo $progress; ?>%</p>
                                    </div>
                                    <div class="progress-bar">
                                        <span class="progres" data-width="<?php echo $progress; ?>%" style="width: <?php echo $progress; ?>%;"></span>
                                    </div>
                                    <a href="./Practice/index.php?id=<?php echo $practice['practice_id']; ?>">
                                        <?php echo ($progress > 0) ? "ฝึกต่อ" : "เริ่มฝึก"; ?>
                                    </a>
                                </div>
                            <?php } else { ?>
                                <div class="box-info locked">
                                    <p><?php echo htmlspecialchars($practice['practice_title']) ?></p>
                                    <div class="box-label">
                                        <p>ความคืบหน้า</p>
                                        <p><?php echo $progress; ?>%</p>
                                    </div>
                                    <div class="progress-bar">
                                        <span class="progres" data-width="<?php echo $progress; ?>%" style="width: <?php echo $progress; ?>%;"></span>
                                    </div>
                                    <a href="#" class="disabled">เริ่มฝึก</a>
                                </div>
                        <?php }
                        }
                        ?>
                    </div>
                </div>

            </div>
        </main>

    </div>

    <script>
        var btn = document.getElementById('btn');
        var leftBtn = document.getElementById('leftBtn');
        var rightBtn = document.getElementById('rightBtn');
        var lessonsBox = document.getElementsByClassName('box-lessons');
        var practiceBox = document.getElementsByClassName('practice-lessons');

        leftBtn.classList.add('active-toggle');

        function leftClick() {
            btn.style.left = '5px';
            leftBtn.classList.add('active-toggle');
            rightBtn.classList.remove('active-toggle');
            document.querySelector('.box-lessons').style.display = 'block';
            document.querySelector('.box-practice').style.display = 'none';
        }

        function rightClick() {
            btn.style.left = '155px';
            rightBtn.classList.add('active-toggle');
            leftBtn.classList.remove('active-toggle');
            document.querySelector('.box-lessons').style.display = 'none';
            document.querySelector('.box-practice').style.display = 'block';
        }


        // PROGRESS
        const spans = document.querySelectorAll('.progress-bar span');

        spans.forEach((span) => {
            span.style.width = span.dataset.width;
            // span.innerHTML = span.dataset.width;
        });

        let subMenu = document.getElementById('subMenu');

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>
</body>

</html>