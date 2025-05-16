<?php
session_start();
require '../includes/connect.php';

if (!isset($_GET['id'])) {
    die("ไม่พบกระทู้");
}

$thread_id = $_GET['id'];

$stmt = $conn->prepare("SELECT threads.*, users.fname, users.lname FROM threads 
                       JOIN users ON threads.user_id = users.user_id 
                       WHERE threads.id = ?");
$stmt->execute([$thread_id]);
$thread = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$thread) {
    die("ไม่พบกระทู้");
}

$stmt = $conn->prepare("SELECT comments.*, users.fname, users.lname FROM comments 
                       JOIN users ON comments.user_id = users.user_id 
                       WHERE comments.thread_id = ? ORDER BY comments.created_at ASC");
$stmt->execute([$thread_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id']; // จำลอง user ID 1

    $stmt = $conn->prepare("INSERT INTO comments (thread_id, user_id, content) VALUES (?, ?, ?)");
    $stmt->execute([$thread_id, $user_id, $content]);

    header("Location: thread.php?id=" . $thread_id);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/threads/comment.css">
    <title><?= htmlspecialchars($thread['title']) ?></title>
</head>

<body>
    <main>
        <div class="container">
            <h1><?= htmlspecialchars($thread['title']) ?></h1>
            <p><?= nl2br(htmlspecialchars($thread['content'])) ?></p>
            <p>โดย <?= htmlspecialchars($thread['fname']) . " " . htmlspecialchars($thread['lname']); ?> เมื่อ <?= $thread['created_at'] ?></p>

            <h2>ความคิดเห็น</h2>
            <ul>
                <?php foreach ($comments as $comment): ?>
                    <li>
                        <?= nl2br(htmlspecialchars($comment['content'])) ?>
                        - <?= htmlspecialchars($comment['fname']) . " " . htmlspecialchars($comment['lname']) ?> (<?= $comment['created_at'] ?>)
                    </li>
                <?php endforeach; ?>
            </ul>

            <h3>แสดงความคิดเห็น</h3>
            <form method="post">
                <textarea name="content" required></textarea>
                <br>
                <button type="submit">โพสต์ความคิดเห็น</button>
            </form>
            <a href="./">กลับ</a>
        </div>
    </main>
</body>

</html>