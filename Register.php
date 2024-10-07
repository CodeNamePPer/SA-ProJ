<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Register.css">

    <?php
    $Image = "<img src='Picture\logo-kab-phone.png' alt='Logo' width=100>";
    ?>

</head>
<body>
    <?php if(isset($_SESSION['error'])){?>
        <div class="alert alert-danger"role="alert">
            <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            ?>
        </div>
    <?php } ?>
    <div class="KabPigture">
        <?php echo $Image; ?>
        <div class="KABTEXT">KAB SHOP</div>
    </div>

    <div class="login-form-container">
        <form class="container" id="loginForm" action="process-register.php" method="POST">
            <h2>Register</h2>
            <input name="username_account" class="text" type="text" placeholder="Username" required>
            <input name="email_account" class="text" type="email" placeholder="Email" required>
            <input name="phone_account" class="text" type="tel" placeholder="08xxxxxxxx" pattern="[0-9]{3}[0-9]{3}[0-9]{4}">
            <input name="address_account" class="text" type="text" placeholder="Address" required>

            <form id="myForm">
                <input name="password_account1"class="text" type="password" placeholder="Password" required>
                <input name="password_account2" class="text" type="password" placeholder="Password again" required>
                <div>
                    <div class="g-recaptcha" data-sitekey="6Lcb8lUqAAAAAGr9BCmH4PjWa9L8v4jqjAtwy-1B"></div>
                </div>
                <input class="ButtonLG" type="submit" value="Register">
                <a href="Login.php" class="register">Have an Account? Login Here</a>
              </form>
            
        </form>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>

