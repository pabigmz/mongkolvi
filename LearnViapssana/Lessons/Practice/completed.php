<?php 
session_start();
include('../../includes/connect.php');
$userId = $_SESSION['user_id'];
if (isset($_GET['complete']) && $_GET['id']) {
    $pracId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $oldPracId = $pracId;
    $complete = $_GET['complete'];
} else {
    $pracId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $oldPracId = $pracId - 1;
    $complete = 0;
}

$stmt = $conn->prepare("SELECT is_completed FROM user_practice_progress WHERE user_id = :user_id AND is_completed = :is_completed");
$stmt->execute(['user_id' => $userId, 'is_completed' => 1]);

$rowCount = $stmt->rowCount(); // ✅ ตรวจสอบจำนวนแถวที่คืนค่า

$score_sql = "SELECT score_post FROM user_practice_progress WHERE user_id = :user_id AND practice_id = :pracId";
$stmt = $conn->prepare($score_sql);
$stmt->execute(['user_id' => $userId, 'pracId' => $oldPracId]);
$score = $stmt->fetch(PDO::FETCH_ASSOC);

// ตรวจสอบว่ามีค่า score_post หรือไม่
$scoreValue = isset($score['score_post']) ? (int)$score['score_post'] : 0;

$percent = $scoreValue * 20;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>COMPLETE</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Prompt",'serif';
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
        .skill-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
        }

        .skill-container .skill {
            position: relative;
        }

        .skill-container .skill .outer {
            height: 160px;
            width: 160px;
            border-radius: 50%;
            padding: 20px;
            box-shadow: 6px 6px 10px -1px rgba(0 0 0 /.15),
                -6px -6px 10px -1px rgba(255 255 255 / .7);
        }

        .skill-container .skill .outer .inner {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 120px;
            width: 120px;
            width: 120px;
            border-radius: 50%;
            box-shadow: inset 4px 4px 6px -1px rgba(0 0 0/ .2),
                inset -4px -4px 6px -1px rgba(255 255 255 / .7),
                -.5px -.5px 0px rgba(255 255 255 / 1),
                .5px .5px 0px rgba(0 0 0 / .15),
                0px 12px 10px -10px rgba(0 0 0 / 0.05);
        }

        .skill-container .skill .outer .inner .number {
            font-weight: 800;
        }

        .skill-container .skill:nth-child(1) .outer .inner .number {
            color: #f75023;
        }

        circle {
            fill: none;
            stroke-width: 20px;
            stroke-dasharray: 472;
            stroke-dashoffset: 472;
            transition: 2s linear;
        }

        svg {
            position: absolute;
            top: 0;
            left: 0;
        }

        .skill-container .skill:nth-child(1) circle {
            stroke: #f75023;
        }

        /* Mobile เล็กมาก */
        @media (max-width: 480px) {
            body {
                background-color: white;
            }

            .container {
                box-shadow: none;

                & h1 {
                    font-size: 20px;
                }
            }

            main {
                background-color: white;
                align-items: start;
                padding-top: 50px;
            }


        }
        /* Tablet */
        @media (min-width: 768px) and (max-width: 991px) {
            main {
                width: 100vw;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: start;
                margin-top: 100px;
            }
        }
    </style>
</head>
<body>
    <main>
        <div class="container">
            <h1>ยินดีด้วยคุณผ่านบทสอบแล้ว</h1>
            <div class="skill-container">
                <div class="skill">
                    <div class="outer">
                        <div class="inner">
                            <div class="number" data-num="<?php echo $percent; ?>">0%
                            </div>
                        </div>
                    </div>
                    <svg height="160px" width="160px" xmlns="http://www.w3.org/2000/svg">
                        <circle r="70" cx="80" cy="80" fill="red" strtok-linecap="round" />
                        Sorry, your browser does not support inline SVG.
                    </svg>
                </div>
            </div>
            <div class="btn">
                <?php 
                if ($complete == 1) { ?>
                <a class="return" href="../"><i class='bx bx-left-arrow-alt' ></i>กลับไปหน้าแรก</a>
                <?php } else { ?>
                <a class="return" href="../"><i class='bx bx-left-arrow-alt' ></i>กลับไปหน้าแรก</a>
                <a href="./pretest.php?id=<?php echo $pracId; ?>">เรียนบทต่อไป<i class='bx bx-right-arrow-alt'></i></a>
                <?php } ?>
            </div>
        </div>
    </main>

    <script>
        const numbers = document.querySelectorAll('.number');
        const svgEl = document.querySelectorAll('svg circle');
        const counters = Array(numbers.length);
        const intervals = Array(counters.length);
        counters.fill(0);

        numbers.forEach((numbers, index) => {
            intervals[index] = setInterval(() => {
                if(counters[index] === parseInt(numbers.dataset.num)) {
                    clearInterval(counters[index]);
                } else {
                    counters[index] += 1;
                    numbers.innerHTML = counters[index] + "%";
                    svgEl[index].style.strokeDashoffset = Math.floor(472 - 440 * parseFloat(numbers.dataset.num) / 100);
                }
            }, 20);
        });
    </script>
</body>
</html>