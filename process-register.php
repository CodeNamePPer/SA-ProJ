<?php
session_start();
$open_connect = 1;
require('connect.php');

$secret = "6Lcb8lUqAAAAAM0udoxs19Tylz_PjwUMnFUhTp9A";

if(isset($_POST['g-recaptcha-response'])){
   $captcha = $_POST['g-recaptcha-response'];
   $verifyResponse = file_get_contents('https://google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$captcha);
   $reponseData= json_decode($verifyResponse);
   
   if(!$captcha){
      $_SESSION['error'] = "ReCaptcha Error";
      header("location: Register.php");
   }

if(isset($_POST['username_account']) && isset($_POST['email_account']) && isset($_POST['password_account1']) && isset($_POST['password_account2'])&& $reponseData->success){
     $username_account = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['username_account']));
     $email_account = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['email_account']));
     $password_account1 = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['password_account1']));
     $password_account2 = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['password_account2']));
     $phone_account = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['phone_account']));
     $address_account = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['address_account']));
     
     if(empty($username_account)){
         $_SESSION["error"] = "Please Enter Your UserName";
        die(header('Location: Register.php')); 
     }elseif(empty($email_account)){
        die(header('Location: Register.php')); 
     }elseif(empty($phone_account)){
      die(header('Location: Register.php')); 
     }elseif(empty($address_account)){
      die(header('Location: Register.php'));  
     }elseif(empty($password_account1)){
        die(header('Location: Register.php')); 
     }elseif(empty($password_account2)){
        die(header('Location: Register.php')); 
     }elseif($password_account1 != $password_account2){
         $_SESSION["error"]= "Not match Password";
        header('Location: Register.php'); 
     }else{
         $query_check_email_account = "SELECT email_account FROM account WHERE email_account = '$email_account'";
         $call_back_query_check_email_account = mysqli_query($connect, $query_check_email_account);
         if(mysqli_num_rows($call_back_query_check_email_account) > 0 ){
            die(header('Location: Register.php')); 
         }else{
             $length = random_int(97, 128);
             $salt_account = bin2hex(random_bytes($length)); 
             $password_account1 = $password_account1 . $salt_account; 
             $algo = PASSWORD_ARGON2ID;
             $options = [
                'cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
                'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
                'threads' => PASSWORD_ARGON2_DEFAULT_THREADS
             ];
             $password_account =password_hash($password_account1, $algo, $options); //นำรหัสผ่านที่ต่อกับค่าเกลือแล้ว เข้ารหัสด้วยวิธี ARGON2ID
             $query_create_account = "INSERT INTO account VALUES ('', '$username_account', '$email_account', '$password_account', '$salt_account', 'member', 'default_images_account.jpg','$phone_account','$address_account')";
             $call_back_create_account = mysqli_query($connect, $query_create_account);
             if($call_back_create_account){
                echo "<h1>เข้าสู่ระบบสำเร็จ!</h1>";

                 die(header('Location: Login.php'));
                 $_SESSION['register_success'] = 'สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ.';
             }else{
                die(header('Location: Register.php')); 
             }
         }
     }

}else{
    die(header('Location: Register.php')); //ไม่มีข้อมูล
}
$success_message = '';
}
?>