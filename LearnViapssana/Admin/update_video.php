<?php
include('../includes/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['name'];
    $urlVideo = $_POST['url'];
    $duration = $_POST['duration'];
    $id = $_POST['id'];


    function convertToEmbedUrl($url)
    {
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return "https://www.youtube.com/embed/" . $matches[1];
        }
        return $url;
    }

    $embedUrl = convertToEmbedUrl($urlVideo);

    if ($duration > 0) {
        $sql = "UPDATE practice SET 
                    practice_title = :title, 
                    video_url = :url, 
                    duration = :duration
                WHERE practice_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['title' => $title, 'url' => $urlVideo, 'duration' => $duration, 'id' => $id]);

        $_SESSION['message'] = "อัปเดตข้อมูลสำเร็จแล้ว";
        header('Location: ./listvideo.php');
        exit();
    } elseif ($embedUrl) {
        $sql = "UPDATE practice SET 
        practice_title = :title, 
        video_url = :url
    WHERE practice_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['title' => $title, 'url' => $urlVideo, 'id' => $id]);

        $_SESSION['message'] = "อัปเดตข้อมูลสำเร็จแล้ว";
        header('Location: ./listvideo.php');
        exit();
    } else {
        header('Location: ./listvideo.php');
        exit();
    }
}
