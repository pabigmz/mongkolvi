<?php
session_start();
include('../../includes/connect.php');
$lessonId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT score_post FROM user_progress WHERE user_id = :user_id AND lesson_id = :lessonId");
$stmt->execute(['user_id' => $userId, 'lessonId' => $lessonId]);

$score = $stmt->fetch(PDO::FETCH_ASSOC);

$percentScore = isset($score['score_post']) ? intval($score['score_post']) * 10 : 0;



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>ไม่ผ่าน</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Prompt", 'serif';
            background-color: #f6f6f9;
        }

        main {
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background-color: white;
            padding: 50px 0;
            border-radius: 10px;
            box-shadow: 0 0 1rem rgba(0, 0, 0, 0.3);

            & h1 {
                font-weight: 400;
            }
        }

        .btn {
            margin-top: 1rem;
            display: flex;
            gap: 10px;

            & a {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 250px;
                height: 50px;
                background-color: blueviolet;
                color: white;
                font-size: 18px;
                text-decoration: none;
                gap: 5px;
            }

            & .return {
                background-color: transparent;
                color: black;
            }
        }

        .circular-progress {
            margin: 2rem 0;
            position: relative;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: conic-gradient(#8B54DE 3.6deg, #ededed 0deg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .circular-progress::before {
            content: "";
            position: absolute;
            height: 120px;
            width: 120px;
            border-radius: 50%;
            background-color: white;
        }

        .progress-value {
            position: relative;
            font-size: 24px;
            font-weight: 400;
            color: #8B54DE;
        }

        /* Mobile เล็กมาก */
        @media (max-width: 480px) {
            body {
                background-color: white;
            }

            main {
                align-items: start;
            }

            .container {
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <main>
        <div class="container">
            <h1>คุณไม่ผ่านบททดสอบ</h1>
            <div class="circular-progress">
                <span class="progress-value">0%</span>
            </div>
            <div class="btn">
                <a href="./posttest.php?id=<?php echo $lessonId; ?>"><i class='bx bx-redo'></i>กลับไปสอบอีกครั้ง</a>
            </div>
        </div>
    </main>

    <script>
        let circularProgress = document.querySelector(".circular-progress"),
            progressValue = document.querySelector(".progress-value");

        let progressStartValue = 0,
            progressEndValue = Math.max(<?php echo $percentScore; ?>, 0),
            speed = 50; // ความเร็ว

        let progress = setInterval(() => {
            // หยุดเมื่อถึงเป้าหมายก่อนเพิ่มค่า
            if (progressStartValue >= progressEndValue) {
                clearInterval(progress);
            } else {
                progressStartValue++; // เพิ่มค่าเริ่มต้นทีละ 1
                // อัปเดตค่า % ใน HTML
                progressValue.textContent = `${progressStartValue}%`;
                circularProgress.style.background = `conic-gradient(#8B54DE ${progressStartValue * 3.6}deg, #ededed 0deg)`;
            }
        }, speed);
    </script>
</body>

</html>