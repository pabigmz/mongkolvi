<?php
// 🚀 ป้องกัน Chrome แคช
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");

session_start();
if ($_SERVER['REQUEST_URI'] == '/favicon.ico') {
    header("Content-Type: image/x-icon");
    readfile("favicon.ico");
    exit();
}

if (!isset($_SESSION['role'])) {
    header("Location:../../login/login.php");
    exit();
}

include('../../includes/connect.php');
include('../log-inline.php');

// ✅ ป้องกัน error ถ้า `id` ไม่ถูกส่งมา
$pracId = isset($_GET['id']) ? $_GET['id'] : null;
if (!$pracId) {
    echo json_encode(["status" => "error", "message" => "ไม่ได้รับค่า practice_id"]);
    exit();
}

$userId = $_SESSION['user_id'];

// ✅ เช็ค watch time ปัจจุบันในฐานข้อมูล
try {
    $stmt = $conn->prepare("SELECT video_watch_time FROM user_practice_progress WHERE user_id = :user_id AND practice_id = :pracId");
    $stmt->execute(['user_id' => $userId, 'pracId' => $pracId]);
    $progress = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentWatchTime = isset($progress['video_watch_time']) ? (int)$progress['video_watch_time'] : 0;

    // ✅ ดึงข้อมูลวิดีโอ
    $stmt = $conn->prepare("SELECT * FROM practice WHERE practice_id = :pracId");
    $stmt->execute(['pracId' => $pracId]);
    $practices = $stmt->fetch(PDO::FETCH_ASSOC);
    $duration = $practices['duration'];
    $successTime = ($duration * 90) / 100; // ต้องดูถึง 90% ถึงจะสำเร็จ
} catch (Exception $e) {
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    exit();
}

// ✅ อัปเดต progress เป็น 40 เมื่อดูครบ 90%
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Content-Type: application/json"); // ✅ บังคับให้ response เป็น JSON
    error_reporting(0); // ✅ ปิด Warning ที่อาจรบกวน response
    ini_set('display_errors', 0);

    if (isset($_POST['watch_time'])) {
        try {
            $watchTime = (int) $_POST['watch_time'];

            // ✅ บันทึก watch_time ลงฐานข้อมูล
            $stmt = $conn->prepare("UPDATE user_practice_progress SET video_watch_time = :watchTime WHERE user_id = :user_id AND practice_id = :pracId");
            $stmt->execute(['watchTime' => $watchTime, 'user_id' => $userId, 'pracId' => $pracId]);

            echo json_encode(["status" => "success", "message" => "อัปเดต watch_time สำเร็จ"]);
        } catch (Exception $e) {
            error_log("❌ เกิดข้อผิดพลาดในการอัปเดต watch_time: " . $e->getMessage());
            echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาด: " . $e->getMessage()]);
        }
        exit();
    }

    if (isset($_POST['update_progress'])) {
        try {
            $stmt = $conn->prepare("SELECT progress FROM user_practice_progress WHERE user_id = :user_id AND practice_id = :pracId");
            $stmt->execute(['user_id' => $userId, 'pracId' => $pracId]);
            $currentProgress = (int) $stmt->fetchColumn();

            if ($currentProgress < 70) {
                $stmt = $conn->prepare("UPDATE user_practice_progress SET progress = 70, updated_at = NOW() WHERE user_id = :user_id AND practice_id = :pracId");
                $stmt->execute(['user_id' => $userId, 'pracId' => $pracId]);

                error_log("🚀 อัปเดต progress: 70 สำหรับ user_id: $userId, practice_id: $pracId");
                echo json_encode(["status" => "success", "message" => "บันทึก progress = 70 เรียบร้อย"]);
            } else {
                echo json_encode(["status" => "no_update", "message" => "progress = 70 มีอยู่แล้ว ไม่ต้องอัปเดต"]);
            }
        } catch (Exception $e) {
            error_log("❌ เกิดข้อผิดพลาดในการอัปเดต progress: " . $e->getMessage());
            echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาด: " . $e->getMessage()]);
        }
        exit();
    }
}



?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>การปฏิบัติ - <?php echo htmlspecialchars($practices['practice_title']); ?></title>

    <link rel="stylesheet" href="../../assets/css/Practice/practice.css?v=<?php echo time(); ?>">
    <style>
        .loading-message {
            font-size: 16px;
            font-weight: bold;
            color: #555;
            margin-top: 10px;
            text-align: center;
        }

        #videoContainer {
            display: none;
            /* 🔥 ซ่อนวิดีโอจนกว่าจะโหลดเสร็จ */
        }
    </style>
</head>

<body>

    <header>
        <div class="return">
            <a href="../"><i class='bx bx-left-arrow-alt'></i>กลับ</a>
        </div>
        <div class="logo">
        </div>
    </header>

    <main>
        <div class="container">
            <h2><?php echo htmlspecialchars($practices['practice_title']); ?></h2>
            <div id="loadingMessage" class="loading-message">⏳ กำลังโหลดวิดีโอ...</div>
            <div id="videoContainer">
                <?php
                // แปลง URL จาก watch?v= เป็น embed/
                $video_url = str_replace("watch?v=", "embed/", $practices['video_url']);
                ?>
                <iframe id="videoPlayer" src="<?php echo htmlspecialchars($video_url); ?>?enablejsapi=1" frameborder="0" allowfullscreen></iframe>

                <!-- ลิงก์ดูวิดีโอเต็ม -->
                <div class="link-full">
                    <p>หากไม่เข้าใจ สามารถรับชม<a href="https://www.youtube.com/watch?v=YzCNXCTYOA8" target="_blank">เพิ่มเติม</a></p>
                </div>

                <div class="btn-group">
                    <span id="trackingMessage" class="loading-message">⏳ กำลังรอให้วิดีโอเริ่ม...</span>
                </div>
            </div>
        </div>
    </main>

    <script>
        console.log("🔄 สคริปต์กำลังทำงาน...");
        let player;
        let maxWatchedTime = <?php echo $currentWatchTime; ?>;
        let successTime = <?php echo $successTime; ?>;
        let isTrackingStarted = false;
        let hasProgressUpdated = false;

        function onYouTubeIframeAPIReady() {
            console.log("🎬 YouTube API โหลดแล้ว");

            let videoElement = document.getElementById('videoPlayer');
            if (!videoElement) {
                console.error("❌ ไม่พบ videoPlayer - ตรวจสอบ iframe");
                return;
            }

            player = new YT.Player(videoElement, {
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        function forceReloadYouTubeAPI() {
            console.log("🔄 กำลังโหลด YouTube API ใหม่...");
            let oldScript = document.querySelector("script[src*='youtube.com/iframe_api']");
            if (oldScript) oldScript.remove();

            let newScript = document.createElement("script");
            newScript.src = "https://www.youtube.com/iframe_api?v=" + new Date().getTime();
            document.head.appendChild(newScript);
        }
        forceReloadYouTubeAPI();

        function onPlayerReady(event) {
            console.log("✅ วิดีโอพร้อมเล่น");
            document.getElementById("loadingMessage").style.display = "none";
            document.getElementById("videoContainer").style.display = "block";
            document.getElementById("trackingMessage").innerText = "▶ กรุณากดเล่นวิดีโอ";
        }

        function onPlayerStateChange(event) {
            if (event.data === YT.PlayerState.PLAYING) {
                console.log("▶ วิดีโอกำลังเล่น...");
                document.getElementById("trackingMessage").innerText = "✅ กำลังติดตามเวลาการดูวิดีโอ...";
                if (!isTrackingStarted) {
                    startTracking();
                    isTrackingStarted = true;
                }
            }
        }

        function startTracking() {
            setInterval(() => {
                let currentTime = Math.floor(player.getCurrentTime());

                // 🔥 ป้องกันการข้ามเวลา แต่ให้ข้ามล่วงหน้าได้เล็กน้อย (10 วินาที)
                if (currentTime > maxWatchedTime + 10) {
                    console.warn("⏪ ตรวจพบการข้าม! กลับไปที่ " + maxWatchedTime + " วินาที");
                    player.seekTo(maxWatchedTime, true);
                } else {
                    maxWatchedTime = Math.max(maxWatchedTime, currentTime);
                    console.log(`⏳ ดูไปแล้ว: ${maxWatchedTime} วินาที`);
                    saveWatchTime(maxWatchedTime);
                }

                if (maxWatchedTime >= successTime && !hasProgressUpdated) {
                    unlockNextButton();
                    saveProgress();
                    saveWatchTime(maxWatchedTime); // ✅ บันทึกเวลา 90% ด้วย
                    hasProgressUpdated = true;
                }
            }, 1000);
        }

        function saveProgress() {
            console.log("🚀 กำลังบันทึก progress = 70 ...");

            let xhr = new XMLHttpRequest();
            xhr.open("POST", window.location.href, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onload = function() {
                try {
                    let response = JSON.parse(xhr.responseText);
                    console.log("✅ อัปเดต progress:", response);
                } catch (error) {
                    console.error("❌ เกิดข้อผิดพลาดในการแปลง JSON:", xhr.responseText);
                }
            };

            xhr.send(`update_progress=70`);
        }

        function unlockNextButton() {
            console.log("🔓 ปลดล็อกปุ่ม 'ต่อไป'");
            let nextButton = document.querySelector(".btn-group span");
            if (nextButton) {
                nextButton.outerHTML = `<a href="./posttest.php?id=<?php echo $pracId; ?>">ต่อไป <i class='bx bx-right-arrow-alt'></i></a>`;
            }
        }

        function saveWatchTime(watchTime) {
            if (watchTime <= maxWatchedTime) return; // ❌ ป้องกันการบันทึกค่าซ้ำ

            let xhr = new XMLHttpRequest();
            xhr.open("POST", window.location.href, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onload = function() {
                console.log("✅ อัปเดต watch_time:", xhr.responseText);
            };

            xhr.send(`watch_time=${watchTime}`);
        }

        // 🔥 บันทึกเวลาล่าสุดเมื่อออกจากหน้า
        window.addEventListener("beforeunload", function() {
            console.log("💾 บันทึก watch_time ก่อนออกจากหน้า:", maxWatchedTime);

            let formData = new FormData();
            formData.append("watch_time", maxWatchedTime);

            navigator.sendBeacon(window.location.href, formData);
        });
    </script>



</body>

</html>