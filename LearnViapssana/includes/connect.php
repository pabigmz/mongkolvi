<?php
$servername = "mysql";
$username = "root";
$password = "1234";
$database = "vipassana";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    // ตั้งค่าให้ PDO โยนข้อผิดพลาดออกมาเป็น Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // ตั้งค่าให้ PDO คืนค่าผลลัพธ์เป็น Associative Array อัตโนมัติ
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
