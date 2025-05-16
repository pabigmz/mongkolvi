<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./assets/css/home.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .cookie-banner {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .cookie-banner button {
            background: #ff9800;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            color: white;
            font-weight: bold;
            border-radius: 5px;
        }

        .cookie-banner button:hover {
            opacity: 0.8;
        }
    </style>

    <title>หน้าแรก</title>
</head>

<body>

    <nav>
        <div class="logo">
            <a href="./" style="display: flex; color: black">
                <img src="./assets/img/learnvipassana.png" alt="" width="50" style="border-radius: 5px; margin-right: 0.5rem;">
                <div class="logo-header">
                    <span class="on_text">สื่อบทเรียนออนไลน์</span>
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
                <li><a href="./assets/document/คู่มือการใช้งานเว็บแอปพลิเคชันสื่อบทเรียนออนไลน์.pdf" target="_blank">คู่มือการใช้งาน</a></li>
                <li><a href="#footer">ติดต่อเรา</a></li>
                <?php
                if (isset($_SESSION['user_id'])) { ?>
                    <div class="btn">
                        <li><a href="./Lessons">เข้าบทเรียน</a></li>
                    </div>
                <?php
                } else { ?>
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
                <?php
                }
                ?>
            </ul>
            <!-- <i class='bx bx-menu' id="icon-menu"></i> -->
        </div>
    </nav>

    <main>
        <section id="detail">
            <div class="content">
                <div class="left-detail">
                    <span>แพลตฟอร์มบทเรียนออนไลน์ <br>สำหรับฝึกปฏิบัติวิปัสสนากรรมฐาน ตามแนวพระพรหมมงคล วิ</span>
                    <p>บทเรียนของ LearnVipassana มีการแบบบทความและการสอนผ่านวิดีโอ ที่ผ่านการตรวจจากผู้เชี่ยวชาญมาแล้ว</p>
                </div>
                <div class="right-detail">
                    <div class="box">
                        <i class='bx bxs-book-open'></i>
                        <p>การเรียนแบบทั่วไป มีการทำแบบทดสอบก่อนเรียนและหลังเรียน</p>
                    </div>
                    <div class="box">
                        <i class='bx bxl-youtube'></i>
                        <p>การเรียนแบบวิดีโอ มีการทำแบบทดสอบก่อนเรียนและหลังเรียน</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="slider-image">
            <div class="slide-container">
                <div class="wrapper">
                    <img src="./assets/img/cover.png" alt="slide1">
                    <img src="./assets/img/cover (1).png" alt="slide2">
                    <img src="./assets/img/cover (2).png" alt="slide3">
                    <img src="./assets/img/cover (3).png" alt="slide3">
                </div>
            </div>
        </section>


        <section id="benefit">
            <div class="content">
                <h2>ประโยชน์ที่ผู้ใช้จะได้รับจากสื่อบทเรียนออนไลน์ การปฏิบัติวิปัสสนากรรมฐาน ตามแนวพระพรหมมงคล วิ</h2>
                <ol>
                    <li>เรียนรู้แนวทางปฏิบัติวิปัสสนากรรมฐานที่ถูกต้อง</li>
                    <li>สามารถเรียนรู้ได้ทุกที่ทุกเวลา</li>
                    <li>มีโครงสร้างการเรียนรู้ที่เป็นระบบ</li>
                    <li>สื่อการสอนครบถ้วน</li>
                    <li>มีระบบสอบวัดผลเพื่อประเมินความเข้าใจ</li>
                </ol>
            </div>
        </section>

        <section id="why-use">
            <div class="content">
                <h2>ทำไมต้องใช้ระบบนี้</h2>
                <ol>
                    <li>สะดวกและเข้าถึงได้ง่าย</li>
                    <li>ช่วยให้การปฏิบัติมีแนวทางที่ถูกต้อง</li>
                    <li>มีการวัดผลและติดตามผลการเรียนรู้</li>
                    <li>ช่วยให้การปฏิบัติธรรมเป็นไปอย่างมีระเบียบและต่อเนื่อง</li>
                    <li>เป็นช่องทางสำหรับผู้ที่สนใจ แต่ไม่สามารถเดินทางไปยังสถานปฏิบัติธรรมได้</li>
                </ol>
            </div>
        </section>

        <section id="manual">

        </section>
    </main>

    <footer class="footer" id="footer">
        <div class="footer-content">
            <div class="footer-logo">สื่อบทเรียนออนไลน์การวิปัสสนากรรมฐาน ตามแนวพระพรหมมงคล วิ</div>

            <div class="footer-links">
                <a href="./">หน้าแรก</a>
                <a href="./Lessons/">บทเรียน</a>
                <a href="./privacy.php">นโยบายความเป็นส่วนตัว</a>
            </div>
        </div>
        <!-- Contact Information -->
        <div class="footer-contact">
            <h4>ติดต่อเรา</h4>
            <p>📞 โทรศัพท์: 062-389-4070</p>
            <p>📧 อีเมล: aibuddhismthai@gmail.com</p>
        </div>


        <div class="footer-bottom">
            <em>"เว็บไซต์นี้สร้างขึ้นเพื่อการศึกษาเกี่ยวกับการปฏิบัติวิปัสสนาเท่านั้น และไม่มีความเกี่ยวข้องกับองค์กรวิปัสสนาใด ๆ อย่างเป็นทางการ"</em><br>
            © 2025 สื่อบทเรียนอนนไลน์การวิปัสสนากรรมฐาน ตามแนวพระพรหมมงคล วิ.
        </div>
    </footer>

    <!-- แถบแจ้งเตือนการใช้คุกกี้ -->
    <div id="cookie-banner" class="cookie-banner">
        <p>เว็บไซต์นี้ใช้คุกกี้เพื่อปรับปรุงประสบการณ์ของคุณ <a href="./privacy.php">เรียนรู้เพิ่มเติม</a></p>
        <button id="accept-cookies">ยอมรับ</button>
        <button id="deny-cookies">ปฏิเสธ</button>
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
            const banner = document.getElementById("cookie-banner");
            const acceptBtn = document.getElementById("accept-cookies");
            const denyBtn = document.getElementById("deny-cookies");



            // ตรวจสอบการยอมรับคุกกี้จาก localStorage
            if (localStorage.getItem("cookie_consent")) {
                banner.style.display = "none"; // หากมีการยอมรับแล้วไม่แสดงแถบคุกกี้
            }

            acceptBtn.addEventListener("click", function() {
                localStorage.setItem("cookie_consent", "accepted");
                document.cookie = "remember_token=" + generateToken() + "; path=/; max-age=" + (60 * 60 * 24 * 30); // ตั้งคุกกี้ remember_token
                banner.style.display = "none"; // ซ่อนแถบคุกกี้
            });

            denyBtn.addEventListener("click", function() {
                localStorage.setItem("cookie_consent", "denied");
                document.cookie = "remember_token=; path=/; max-age=0"; // ลบคุกกี้ remember_token
                banner.style.display = "none"; // ซ่อนแถบคุกกี้
            });
        });

        function generateToken() {
            return Math.random().toString(36).substr(2, 16); // สร้าง token แบบสุ่ม
        }
    </script>

</body>

</html>