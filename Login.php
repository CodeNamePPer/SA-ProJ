<?php
session_start(); // เริ่มต้น session

$success_message = '';

// ตรวจสอบว่ามีข้อความจากการสมัครสมาชิกหรือไม่
if (isset($_SESSION['register_success'])) {
    $success_message = $_SESSION['register_success'];
    unset($_SESSION['register_success']); // ลบข้อความหลังจากแสดงเพื่อไม่ให้แสดงซ้ำ
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="SA.css">
    
    <?php
    $Image = "<img src='Picture\logo-kab-phone.png' alt='Logo' width=100>";
    ?>
    
</head>
<body>
    <div class="KabPigture">
        <?php echo $Image; ?>
        <div class="KABTEXT">KAB SHOP</div>
    </div>
    
    <div class="login-form-container">
        <form class="container" id="loginForm" method="POST" action="process-login.php">
            <h2>Login</h2>
            <input name="email_account"class="text" type="text" placeholder="Email" required>
            <input name="password_account"class="text" type="password" placeholder="Password" required>
            <div class="g-recaptcha" data-sitekey="6Lcb8lUqAAAAAGr9BCmH4PjWa9L8v4jqjAtwy-1B"></div>
            <input class="ButtonLG" type="submit" value="Login">
            <div class="options">
                <a href="Forgot.php" class="forgot">Forgot password</a>
                <a href="Register.php" class="register">Register</a>
            </div>
        </form>
    </div>
<script src="/JS/Login.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
 
</body>
</html>

