<?php
session_start();

include("../../includes/connect.php");

try {
    $user_id = $_SESSION['user_id'];

    $sqluser = "SELECT fname, lname FROM users WHERE user_id = :userId";
    $stmt = $conn->prepare($sqluser);
    $stmt->execute(['userId' => $user_id]);
    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    $count_sql = "SELECT * FROM certificate WHERE user_id = :userId";
    $stmt = $conn->prepare($count_sql);
    $stmt->execute(['userId' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style type='text/css'>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: white;
            flex-direction: column;
        }

        body {
            color: black;
            font-family: "Prompt", serif;
            font-size: 18px;
            text-align: center;
        }

        .container {
            border: 8px solid tan;
            width: 700px;
            /* กำหนดความกว้าง */
            height: 490px;
            /* กำหนดความสูง */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            /* ทำให้อยู่กลางเมื่อแสดงในหน้าเว็บ */
        }

        .marquee {
            color: tan;
            font-size: 36px;
            margin: 0px 0 10px 0;
            font-weight: 600;
        }


        .person {
            border-bottom: 2px solid black;
            font-size: 24px;
            font-style: italic;
            margin: 10px auto;
            width: 400px;
        }

        .reason {
            margin: 15px;
            display: flex;
            flex-direction: column;
            gap: 0;
            max-width: 500px;

            & p {
                margin: 0;
                padding: 0;
            }

            & .date {
                font-size: 16px;
                font-weight: 300;
            }
        }

        #download-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-family: "Prompt",serif;
        }

        #download-btn:hover {
            background-color: #45a049;
        }
    </style>
    <title>ประกาศนียบัตร</title>
</head>

<body>
    <div class="container" id="certificate">
        <!-- <div class="logo">
            <img src="./assets/img/learnvipassana.png" alt="Logo learnvipassana" width="100">
        </div> -->

        <div class="marquee">
            ประกาศนียบัตร
        </div>

        <div class="assignment">
            ขอมอบเกียรติบัตรฉบับนี้เพื่อแสดงว่า
        </div>

        <div class="person" id="user-name">
            <?php echo htmlspecialchars($users['fname']) . " " . htmlspecialchars($users['lname']); ?>
        </div>

        <div class="reason">
            <p>ได้ผ่านการเรียนสื่อบทเรียนออนไลน์<br>การฝึกปฏิบัติการวิปัสสนากรรมฐานตามแนวพระพรหมมงคล วิ</p>
            <?php
            function thai_date($format, $timestamp = null)
            {
                $thai_months = [
                    "January" => "มกราคม",
                    "February" => "กุมภาพันธ์",
                    "March" => "มีนาคม",
                    "April" => "เมษายน",
                    "May" => "พฤษภาคม",
                    "June" => "มิถุนายน",
                    "July" => "กรกฎาคม",
                    "August" => "สิงหาคม",
                    "September" => "กันยายน",
                    "October" => "ตุลาคม",
                    "November" => "พฤศจิกายน",
                    "December" => "ธันวาคม"
                ];

                $thai_day = [
                    "Sunday" => "อาทิตย์",
                    "Monday" => "จันทร์",
                    "Tuesday" => "อังคาร",
                    "Wednesday" => "พุธ",
                    "Thursday" => "พฤหัสบดี",
                    "Friday" => "ศุกร์",
                    "Saturday" => "เสาร์"
                ];

                $timestamp = $timestamp ?? time();
                $date = date($format, $timestamp);

                // แปลงชื่อเดือนและวันเป็นภาษาไทย
                $date = str_replace(array_keys($thai_months), array_values($thai_months), $date);
                $date = str_replace(array_keys($thai_day), array_values($thai_day), $date);

                // แปลง ค.ศ. เป็น พ.ศ.
                $date = str_replace(date("Y", $timestamp), date("Y", $timestamp) + 543, $date);

                return $date;
            }
            ?>

            <!-- <p class="date">ให้ไว้ ณ วันที่  -->
                <!-- <?php echo thai_date('j F Y', strtotime($user['created_at'])); ?> -->
            <!-- </p> -->


        </div>

    </div>

    <button id="download-btn">ดาวน์โหลด ประกาศนียบัตร</button>
    <a href="../">กลับหน้าแรก</a>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script>
        document.getElementById('download-btn').addEventListener('click', function() {
            const element = document.getElementById('certificate');

            // กำหนดตัวเลือกสำหรับการดาวน์โหลด PDF
            const options = {
                margin: [6, 6, 6, 6], // กำหนดขอบกระดาษให้เหมาะสม
                filename: 'Certificate_of_Completion.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                }, // ลดการย่อภาพ
                jsPDF: {
                    orientation: 'landscape', // แนวนอน
                    unit: 'mm', // หน่วยเป็นมิลลิเมตร
                    format: [210, 148], // ขนาด A5 ในแนวนอน
                    compressPdf: true, // บีบอัดไฟล์ PDF ให้เล็กลง
                    putOnlyUsedFonts: true
                }
            };

            // เพิ่มตัวเลือกให้เนื้อหากลาง PDF
            html2pdf()
                .from(element)
                .set(options)
                .save(); // ชื่อไฟล์ที่ผู้ใช้จะดาวน์โหลด
        });
    </script>
</body>

</html>