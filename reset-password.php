<?php
session_start();
require('connect.php');

// ตรวจสอบว่าอีเมลถูกบันทึกใน session หรือไม่
if (!isset($_SESSION['reset_email'])) {
    echo "Error: Unauthorized access.";
    exit;
}

if (isset($_POST['new_password'])) {
    $new_password = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['new_password']));
    $salt = bin2hex(random_bytes(16));
    $hashed_password = password_hash($new_password . $salt, PASSWORD_BCRYPT);
    
    $email = $_SESSION['reset_email'];
    $query_update = "UPDATE account SET password_account = '$hashed_password', salt_account = '$salt' WHERE email_account = '$email'";
    mysqli_query($connect, $query_update);
    
    // ลบ session ที่ใช้ในการรีเซ็ตรหัสผ่านหลังจากเสร็จสิ้น
    unset($_SESSION['reset_email']);
    echo "Password has been reset. You can now <a href='Login.php'>login</a>.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <form method="POST" action="reset-password.php">
        <h2>Reset Password</h2>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>