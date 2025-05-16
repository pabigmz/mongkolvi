<?php
if (!isset($_COOKIE['cookiesAccepted'])) {
    setcookie("cookiesAccepted", "true", time() + 31536000, "/"); // เก็บคุกกี้ 1 ปี ใช้ได้ทุกหน้า
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./assets/css/home.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>หน้าแรก</title>

    <style>
        .cookie-banner {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 16px;
            display: none;
        }

        .cookie-banner button {
            background: #ff9800;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-left: 10px;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
        }

        .main {
            width: 100%;
            justify-content: center;
        }

        .container {
            width: 80%;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            text-align: center;
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .container ol {
            padding-left: 20px;
            line-height: 1.6;
        }

        .container li {
            font-size: 18px;
            font-weight: 500;
            color: #444;
            margin: 15px 0;
        }

        .container p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
            text-align: justify;
        }

        .container ul {
            margin-left: 20px;
        }

        .container ul li {
            font-size: 16px;
            color: #555;
            margin-bottom: 8px;
        }

        .container li:last-child {
            margin-bottom: 0;
        }
    </style>
</head>

<body>

    <nav>
        <div class="logo">
            <a href="./" style="display: flex; color: black">
                <img src="./assets/img/learnvipassana.png" alt="" width="50" style="border-radius: 5px; margin-right: 0.5rem;">
                <div class="logo-header">
                    <span class="on_text">สื่อบทเรียนอนนไลน์</span>
                    <span class="under_text">การวิปัสสนากรรมฐาน ตามแนวพระพรหมมงคล วิ</span>
                </div>
            </a>
        </div>
        <div class="toggle-menu">
            <i class='bx bx-menu'></i>
        </div>
        <div class="menu">
            <ul id="menu">
                <li><a href="./">หน้าหลัก</a></li>
                <li><a href="#benefit">สิ่งที่จะได้เรียน</a></li>
                <li>
                    <div class="btn register">
                        <a href="./login/register.php">สมัครใช้งาน</a>
                    </div>
                </li>
                <li>
                    <div class="btn">
                        <a href="./login/login.php">เข้าสู่ระบบ</a>
                    </div>
                </li>
            </ul>
            <!-- <i class='bx bx-menu' id="icon-menu"></i> -->
        </div>
    </nav>

    <div class="main">

        <div class="container">
            <h1>ข้อกำหนดการใช้งาน (Terms of Service)</h1>
            <ol>
                <li>การยอมรับข้อกำหนด</li>
                <p>การสมัครใช้งานเว็บไซต์นี้ถือว่าคุณยอมรับและตกลงปฏิบัติตามข้อกำหนดการใช้งานเหล่านี้ หากคุณไม่ยอมรับข้อกำหนด กรุณาอย่าสมัครหรือใช้งานเว็บไซต์นี้</p>
                <li>การใช้บริการ</li>
                <ul>
                    <li>ผู้ใช้งานจะต้องให้ข้อมูลที่เป็นจริงและเป็นปัจจุบันเท่านั้น</li>
                    <li>ผู้ใช้งานต้องไม่ใช้เว็บไซต์นี้ในลักษณะที่ขัดต่อกฎหมายหรือละเมิดสิทธิของบุคคลอื่น</li>
                </ul>
                <li>การระงับบัญชีผู้ใช้</li>
                <p>ผู้ดูแลระบบมีสิทธิ์ในการระงับหรือยกเลิกบัญชีของผู้ใช้งานที่ฝ่าฝืนข้อกำหนดนี้โดยไม่จำเป็นต้องแจ้งให้ทราบล่วงหน้า</p>
                <li>การเปลี่ยนแปลงข้อกำหนด</li>
                <p>ข้อกำหนดการใช้งานอาจมีการเปลี่ยนแปลงตามความเหมาะสม โดยจะแจ้งให้ผู้ใช้ทราบผ่านทางเว็บไซต์</p>
            </ol>
        </div>
    </div>

    <footer></footer>

    <script src="script.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const btnToggle = document.querySelector(".toggle-menu");
            const menu = document.querySelector(".menu");

            btnToggle.addEventListener("click", function() {
                menu.classList.toggle("active");
            });
        });
    </script>


</body>

</html>