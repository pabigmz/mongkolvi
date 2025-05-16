<?php
session_start();
include('../../includes/connect.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../login/login.php');
    exit();
}

include('../log-inline.php');

$userId = $_SESSION['user_id'];
$lessonId = isset($_GET['id']) ? (int)$_GET['id'] : 0;


// ดึงข้อมูลบทเรียน
$sql = "SELECT * FROM lessons WHERE lesson_id = :lesson_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':lesson_id', $lessonId, PDO::PARAM_INT);
$stmt->execute();
$lessons = $stmt->fetch(PDO::FETCH_ASSOC);

// ตรวจสอบว่าบทเรียนมีอยู่จริง
if (!$lessons) {
    die("<h2>ไม่พบเนื้อหาบทเรียน</h2>");
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บทเรียน - <?php echo htmlspecialchars($lessons['lesson_title']); ?></title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../assets/css/lesson/learn.css">

    <style>
        #pdf-pages canvas {
            width: 100% !important;
            height: auto !important;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }

        #pdf-pages {
            max-width: 800px;
            margin: auto;
        }
    </style>
</head>

<body>

    <header>
        <div class="return">
            <a href="../"><i class='bx bx-left-arrow-alt'></i> กลับ</a>
        </div>
    </header>

    <main>
        <div class="container">


            <div class="content-learn">
                <h2><?php echo htmlspecialchars($lessons['lesson_title']); ?></h2>
                <!-- <p><?php echo nl2br(htmlspecialchars($lessons['lesson_content'])); ?></p> -->

                <!-- <canvas id="pdf-canvas"></canvas> -->
                <div class="pfd-container">
                    <div id="pdf-pages"></div>
                </div>


                <div class="btn">
                    <a href="posttest.php?id=<?php echo $lessonId; ?>" onclick="updateProgress(event)">แบบทดสอบหลังเรียน <i class='bx bx-right-arrow-alt'></i></a>
                </div>



            </div>
        </div>
    </main>

    <script>
        let timeSpent = 0;
        let lessonId = <?php echo json_encode($lessonId); ?>;
        let userId = <?php echo json_encode($userId); ?>;
        let interval;

        // เริ่มจับเวลาเมื่อเข้าหน้า
        function startTimer() {
            interval = setInterval(() => {
                timeSpent++;
            }, 1000);
        }

        // หยุดจับเวลาและส่งข้อมูลไป PHP เมื่อออกจากหน้า
        function sendTimeSpent() {
            clearInterval(interval);
            if (timeSpent > 0) {
                let data = JSON.stringify({
                    user_id: userId,
                    lesson_id: lessonId,
                    time_spent: timeSpent
                });

                navigator.sendBeacon('./save_time.php', data);
            }
        }

        // อัปเดต Progress +40 เมื่อกดเริ่มทำแบบทดสอบ
        async function updateProgress(event) {
            event.preventDefault(); // ป้องกันการเปลี่ยนหน้าเร็วเกินไป

            let targetUrl = `posttest.php?id=${lessonId}`; // กำหนด URL ที่จะเปลี่ยนหน้า

            try {
                let response = await fetch('./save_progress.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        lesson_id: lessonId,
                        progress: 40
                    })
                });

                if (response.ok) {
                    setTimeout(() => {
                        window.location.href = targetUrl; // เปลี่ยนหน้าไป posttest.php พร้อม id
                    }, 500); // เพิ่ม delay 500ms ให้แน่ใจว่า fetch เสร็จแล้ว
                } else {
                    console.error("เกิดข้อผิดพลาดในการบันทึก progress");
                    setTimeout(() => {
                        window.location.href = targetUrl; // แม้จะ error ก็ให้เปลี่ยนหน้า
                    }, 1000);
                }
            } catch (error) {
                console.error("Fetch error:", error);
                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 1000);
            }
        }


        window.addEventListener("load", startTimer);
        window.addEventListener("beforeunload", sendTimeSpent);
    </script>


    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.min.js"></script>
    <script>
    const url = '../../assets/document/Upload-lesson-pdf/<?php echo htmlspecialchars($lessons['lesson_file']); ?>';

    const pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.worker.min.js';

    const dpr = window.devicePixelRatio || 1; // ความละเอียดของจอ (Retina)

    let loadingTask = pdfjsLib.getDocument(url);
    loadingTask.promise.then(function(pdf) {
        const totalPages = pdf.numPages;

        for (let pageNum = 1; pageNum <= totalPages; pageNum++) {
            pdf.getPage(pageNum).then(function(page) {
                const scale = 1.5;
                const viewport = page.getViewport({ scale });

                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');

                // กำหนดขนาด canvas ด้วย DPR
                canvas.width = viewport.width * dpr;
                canvas.height = viewport.height * dpr;
                canvas.style.width = viewport.width + 'px';
                canvas.style.height = viewport.height + 'px';

                context.scale(dpr, dpr);

                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };

                page.render(renderContext);
                document.getElementById('pdf-pages').appendChild(canvas);
            });
        }
    }).catch(function(error) {
        console.error('Error: ', error);
    });
</script>
</body>

</html>