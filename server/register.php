<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Will Hergott, Andrew Kim, and Paulo Gomes">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../js/register.js" defer></script>
    <title>Register</title>
</head>
<body>
    <div class="formcontainer">
        <h1>Register</h1>
        <hr>
        <form id="registerForm" action="create.php" method="POST" onsubmit="return validate();">

            <div class="textfield">
                <label for="email" class="hiddenLabel">Email Address</label> 
                <input type="text" name="email" id="email" placeholder="Email">
            </div>

            <div class="textfield">
                <label for="login" class="hiddenLabel">User Name</label> 
                <input type="text" name="login" id="login" placeholder="Username">
            </div>

            <div class="textfield">
                <label for="pass" class="hiddenLabel">Password</label>
                <input type="password" name="pass" id="pass" placeholder="Password">
            </div>
        
            <div class="textfield">
                <label for="pass2" class="hiddenLabel">Re-type Password</label>
                <input type="password" id="pass2" name="pass2" placeholder="Password">
            </div>

            <div class="checkbox">
                <input type="checkbox" name="terms" id="terms">
                <label for="terms">I agree to the terms and conditions</label>
            </div>

            <button type="submit" name="submit">Register</button>
            <button type="reset" onclick="resetErrors()">Reset</button>
            <p>Already have an account?</p>
            <a class="loginButton" href="login.php">Click here to login</a>

        </form>
    </div>

    <?php include('footer.php') ?>

</body>
</html>