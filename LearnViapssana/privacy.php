<?php
if (!isset($_COOKIE['cookiesAccepted'])) {
    setcookie("cookiesAccepted", "true", time() + 31536000, "/", "", true, true); // ปลอดภัยมากขึ้น
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

        .cookie-banner {
            display: none;
            /* ซ่อนจนกว่าจะตรวจพบว่าคุกกี้ยังไม่ได้ตั้งค่า */
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 16px;
            z-index: 1000;
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
            <h1>นโยบายความเป็นส่วนตัว (Privacy Policy)</h1>
            <ol>
                <li>การเก็บรวบรวมข้อมูลส่วนบุคคล</li>
                <p>เว็บไซต์นี้จะเก็บข้อมูลเฉพาะที่จำเป็นต่อการให้บริการ เช่น ชื่อ, อีเมล, เบอร์โทรศัพท์, วันเดือนปีเกิด, อายุ, เพศ, ประสบการณ์การปฏิบัติ และระดับการศึกษา</p>

                <li>วัตถุประสงค์ในการใช้ข้อมูล</li>
                <ul>
                    <li>เพื่อให้บริการการเรียนการสอนออนไลน์</li>
                    <li>เพื่อพัฒนาการให้บริการและเนื้อหาให้เหมาะสมกับผู้ใช้</li>
                    <li>เพื่อการติดต่อและการแจ้งเตือนเกี่ยวกับการอัปเดตระบบหรือบทเรียนใหม่</li>
                </ul>

                <li>การเปิดเผยข้อมูล</li>
                <p>ข้อมูลส่วนบุคคลจะไม่ถูกเปิดเผยแก่บุคคลที่สาม ยกเว้นกรณีที่กฎหมายกำหนดหรือได้รับความยินยอมจากผู้ใช้</p>

                <li>สิทธิของผู้ใช้งาน</li>
                <ul>
                    <li>ผู้ใช้งานมีสิทธิ์ในการเข้าถึง แก้ไข หรือขอลบข้อมูลส่วนบุคคลได้ตลอดเวลา</li>
                    <li>ผู้ใช้งานสามารถเพิกถอนความยินยอมในการใช้ข้อมูลได้โดยติดต่อผู้ดูแลระบบ</li>
                </ul>

                <li>การรักษาความปลอดภัยของข้อมูล</li>
                <p>เว็บไซต์มีมาตรการรักษาความปลอดภัยตามมาตรฐานเพื่อป้องกันข้อมูลจากการเข้าถึงโดยไม่ได้รับอนุญาต</p>

                <li>การใช้คุกกี้</li>
                <p>เว็บไซต์นี้ใช้คุกกี้เพื่อเก็บ token การเข้าสู่ระบบของผู้ใช้ โดยจะใช้คุกกี้เฉพาะในกระบวนการยืนยันตัวตนและไม่ใช้คุกกี้ในการวิเคราะห์หรือโฆษณา</p>

                <li>การขออนุญาตคุกกี้</li>
                <p>เมื่อผู้ใช้เข้าชมเว็บไซต์ครั้งแรก เว็บไซต์จะขอให้ผู้ใช้ยอมรับการใช้งานคุกกี้ หากผู้ใช้ไม่ยอมรับ จะไม่สามารถใช้งานฟีเจอร์บางประการได้ เว็บไซต์จะไม่ติดตั้งคุกกี้ที่ไม่จำเป็นจนกว่าผู้ใช้จะให้ความยินยอม</p>

                <li>การจัดการคุกกี้</li>
                <p>ผู้ใช้สามารถจัดการหรือลบคุกกี้ได้ตลอดเวลา โดยการตั้งค่าคุกกี้ในเบราว์เซอร์ของท่าน หากต้องการรายละเอียดเพิ่มเติมเกี่ยวกับการจัดการคุกกี้ สามารถดูข้อมูลในหน้าความช่วยเหลือของเบราว์เซอร์ที่ท่านใช้</p>
            </ol>
        </div>

    </div>

    <footer></footer>
    <div class="cookie-banner" id="cookie-banner">
        เว็บไซต์นี้ใช้คุกกี้เพื่อพัฒนาประสบการณ์การใช้งานของคุณ
        <button id="accept-cookies">ยอมรับ</button>
    </div>

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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cookieBanner = document.getElementById("cookie-banner");
            const acceptButton = document.getElementById("accept-cookies");

            if (!document.cookie.includes("cookiesAccepted=true")) {
                cookieBanner.style.display = "block";
            }

            acceptButton.addEventListener("click", function() {
                document.cookie = "cookiesAccepted=true; path=/; max-age=" + (60 * 60 * 24 * 365);
                cookieBanner.style.display = "none";
            });
        });
    </script>


</body>

</html>