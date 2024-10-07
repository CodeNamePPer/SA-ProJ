<?php
session_start();
require('connect.php');

if (isset($_POST['email_account'])) {
    $email_account = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['email_account']));
    $query = "SELECT * FROM account WHERE email_account = '$email_account'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) == 1) {
        // ถ้าอีเมลถูกต้อง ให้บันทึกอีเมลลง session และนำไปหน้าตั้งรหัสผ่านใหม่
        $_SESSION['reset_email'] = $email_account;
        header('Location: reset-password.php');
    } else {
        $_SESSION['forgot_error'] = "No account found with that email.";
        header('Location: Forgot.php');
    }
} else {
    $_SESSION['forgot_error'] = "Please provide an email.";
    header('Location: Forgot.php');
}
?>