<?php
include('../includes/connect.php');

include('../includes/connect.php'); // เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $urlVideo = $_POST['link'];
    $duration = isset($_POST['duration']) ? (int)$_POST['duration'] : 0;

    function convertToEmbedUrl($url) {
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return "https://www.youtube.com/embed/" . $matches[1];
        }
        return $url;
    }

    $embedUrl = convertToEmbedUrl($urlVideo);

    if ($duration > 0) {
        $sql = "INSERT INTO practice (practice_title, video_url, duration) VALUES (:title, :urlVideo, :duration)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['title' => $title, 'urlVideo' => $embedUrl, 'duration' => $duration]);

        header('Location: index.php');
        exit();
    } else {
        echo "Error: Duration is missing!";
    }
}


?>