<?php
session_start();
require_once '../../config/config.php';

header('Content-Type: application/json; charset=utf-8');

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    echo json_encode(["status"=>"error", "message"=>"Phương thức không hợp lệ"]);
    exit;
}

$username = trim($_POST["ten_dang_nhap"] ?? '');
$password = $_POST["mat_khau"] ?? '';

if($username === '' || $password === ''){
    echo json_encode([
        "status"=>"error",
        "message"=>"Vui lòng nhập đầy đủ thông tin"
    ]);
    exit;
}

$sql = "SELECT nd.*, vt.ten_vai_tro
        FROM nguoi_dung nd
        JOIN vai_tro vt ON nd.ma_vai_tro = vt.ma_vai_tro
        WHERE nd.ten_dang_nhap = ?
        AND nd.trang_thai = 1
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows !== 1){
    echo json_encode([
        "status"=>"error",
        "message"=>"Tài khoản không tồn tại hoặc đã bị khóa"
    ]);
    exit;
}

$user = $result->fetch_assoc();

// Kiểm tra mật khẩu - Hỗ trợ cả mật khẩu đã mã hóa và chưa mã hóa
$password_valid = false;

// Thử với password_verify trước (cho mật khẩu đã mã hóa)
if(password_verify($password, $user["mat_khau"])) {
    $password_valid = true;
}
// Nếu không được, thử so sánh trực tiếp (cho mật khẩu chưa mã hóa)
elseif($password === $user["mat_khau"]) {
    $password_valid = true;
    
    // Tự động cập nhật lên mật khẩu mã hóa
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $update_sql = "UPDATE nguoi_dung SET mat_khau = ? WHERE ma_nguoi_dung = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $hashed_password, $user["ma_nguoi_dung"]);
    
    if($update_stmt->execute()) {
        // Log để debug (có thể xóa dòng này sau)
        error_log("Đã cập nhật mật khẩu mã hóa cho user: " . $username);
    }
    $update_stmt->close();
}

if(!$password_valid) {
    echo json_encode([
        "status"=>"error",
        "message"=>"Sai mật khẩu"
    ]);
    exit;
}

// Đăng nhập thành công - lưu session
$_SESSION["ma_nguoi_dung"] = $user["ma_nguoi_dung"];
$_SESSION["ten_dang_nhap"] = $user["ten_dang_nhap"];
$_SESSION["ho_ten"] = $user["ho_ten"];
$_SESSION["vai_tro"] = $user["ten_vai_tro"];

echo json_encode([
    "status"=>"success",
    "message"=>"Đăng nhập thành công"
]);

// Đóng các statement
$stmt->close();
$conn->close();
exit;
?>