<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Will Hergott">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../js/login.js" defer></script>
    <title>Log in</title>
</head>
<body>
    <div class="formcontainer">
        <h1>Login</h1>
        <hr>
        <form id="loginForm" action="login_user.php" method="post" onsubmit="return validate();">
            <div class="textfield">
                <label for="login" class="hiddenLabel">User Name</label>
                <input class="loginField" type="text" name="login" id="login" placeholder="Username">
            </div>

            <div class="textfield">
                <label for="pass" class="hiddenLabel">Password</label>
                <input class="loginField" type="password" name="pass" id="pass" placeholder="Password">
            </div>

            <button type="submit">Log in</button>
            <button type="reset" onclick="resetErrors()">Reset</button>
            <p>Don't have an account?</p>
            <a class="registerButton" href="register.php">Click here to register</a>
        </form>
    </div>

    <?php include('footer.php') ?>

</body>
</html>