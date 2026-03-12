<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "quanlykhohang";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Ket noi that bai: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

if (isset($_SESSION['ma_nguoi_dung']) && $_SESSION['ma_nguoi_dung'] > 0) {
    $conn->query("SET @current_user_id = " . $_SESSION['ma_nguoi_dung']);
} else {
    // Set thành NULL thay vì 0
    $conn->query("SET @current_user_id = NULL");
}

// Lấy IP
$ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$conn->query("SET @current_ip = '" . $conn->real_escape_string($ip) . "'");
?>