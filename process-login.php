<?php
    session_start();
    $open_connect = 1;
    require('connect.php');

    $secret = "6Lcb8lUqAAAAAM0udoxs19Tylz_PjwUMnFUhTp9A";

    $secret = "6Lcb8lUqAAAAAM0udoxs19Tylz_PjwUMnFUhTp9A";

    if(isset($_POST['g-recaptcha-response'])){
       $captcha = $_POST['g-recaptcha-response'];
       $verifyResponse = file_get_contents('https://google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$captcha);
       $reponseData= json_decode($verifyResponse);
       
       if(!$captcha){
          $_SESSION['error'] = "ReCaptcha Error";
          header("location: Login.php");
       }
    if(isset($_POST['email_account'])&& isset($_POST['password_account'])&& $reponseData->success){
        $email_account = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['email_account']));
        $password_account = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['password_account']));
        $query_check_account = "SELECT * FROM account WHERE email_account = '$email_account'";
        $call_back_check_account = mysqli_query($connect,$query_check_account);
        if(mysqli_num_rows($call_back_check_account) == 1){
            $result_check_account = mysqli_fetch_assoc($call_back_check_account);
            $hash = $result_check_account['password_account'];
            $password_account = $password_account . $result_check_account['salt_account'];

            if(password_verify($password_account,$hash)){
                if($result_check_account['role_account'] == 'member'){
                    $_SESSION['id_account']=$result_check_account['id_account'];
                    $_SESSION['role_account']=$result_check_account['role_account'];
                    die(header('Location: member.php'));
                }else if($result_check_account['role_account'] == 'admin'){
                    $_SESSION['id_account']=$result_check_account['id_account'];
                    $_SESSION['role_account']=$result_check_account['role_account'];
                    die(header('Location: admin.php'));
                }
            }else{
                die(header('Location: Login.php'));//รหัสผิด
            }

        }else{
            die(header('Location: Login.php')); //ไม่ได้ใส่ข้อมูล
        }
    }else{
        die(header('Location: Login.php')); //ไม่ได้ใส่ข้อมูล
    }
}
?>

