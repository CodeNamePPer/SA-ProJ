<?php
session_start();
$success_message = '';
$error_message = '';

// ตรวจสอบว่ามีข้อความจาก session หรือไม่
if (isset($_SESSION['forgot_error'])) {
    $error_message = $_SESSION['forgot_error'];
    unset($_SESSION['forgot_error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="SA.css">
</head>
<body>
    <div class="forgot-form-container">
        <form method="POST" action="process-forgot.php">
            <h2>Forgot Password</h2>
            <?php if ($error_message) echo "<p class='error'>$error_message</p>"; ?>
            <input type="email" name="email_account" placeholder="Enter your email" required>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>