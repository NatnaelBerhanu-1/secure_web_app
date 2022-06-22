<?php
    session_start();

    include "action_login.php";


    // session_unset();

    if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == "true") {
        header("Location: http://localhost/secure_web_app/dashboard.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6Lc7n4wgAAAAANkAEgk2ogq3Y25VTzkpIsUheoGh"></script>

        <title>Login</title>
</head>
<body>

<div id="login">
        <h3 class="text-center text-white pt-5">Login form</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="login.php" method="post">
                            <h3 class="text-center text-info">Login</h3>
                            <h6 class="text-center text-danger"><?php echo($login_error)?></h6>

                            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input type="text" name="username" id="username" class="form-control" value="<?php echo($username) ?>">
                                <label for="username_err" class="text-danger"><?php echo($username_err) ?></label><br>

                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control" value="<?php echo($password) ?>">
                                <label for="username_err" class="text-danger"><?php echo($password_err) ?></label><br>

                            </div>
                            <div class="form-group">
                                <!-- <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br> -->
                                <input type="submit" name="submit"  class="btn btn-info btn-md" value="submit">
                                <!-- recaptcha -->
                                <input type="hidden" name="recaptcha_response" value="" id="recaptchaResponse">

                            </div>
                            <div id="register-link" class="text-right">
                                <a href="signup.php" class="text-info">Register here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
grecaptcha.ready(function(){
    grecaptcha.execute('6Lc7n4wgAAAAANkAEgk2ogq3Y25VTzkpIsUheoGh', { action:'submit'}).then(function (token){
        var recaptchaResponse=document.getElementById('recaptchaResponse');
        recaptchaResponse.value=token;
    })
})
</script>
</body>
</html>