<?php
    session_start();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <link rel="stylesheet" type="text/css" href="admin.css">
    <link rel="stylesheet" type="text/css" href="fonts/css/all.css">
    <link rel="stylesheet" href="fontboot/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">

    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <form action="phps/login.inc.php" method="POST">
            <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == "empty-fields") {
                        echo "<p class='errors'>Fill in all the fields!</p>";
                    }
                    elseif ($_GET['error'] == "sqlerror") {
                        echo "<p class='errors'>An SQL error occured, please try again!</p>";
                    }
                    elseif ($_GET['error'] == "wrong-password") {
                        echo "<p class='errors'>Wrong login credentials!</p>";
                    }
                    elseif ($_GET['error'] == "no-user") {
                        echo "<p class='errors'>Wrong login credentials!</p>";
                    }
                }
                elseif (isset($_GET['edit'])) {
                    if ($_GET['edit'] == "success") {
                        echo "<p class='success'>Edit successful. Log in to view changes.</p>";
                    }
                }
                elseif (isset($_GET['change'])) {
                    if ($_GET['change'] == "success") {
                        echo "<p class='success'>Password update successful. Log in to view changes.</p>";
                    }
                }
            ?>
            <div class="img">
                <img src="images/logo2.jpg">
            </div>
            <div class="my-input">
                <input type="text" name="email" placeholder="Enter your email" required>
            </div>
            <div class="my-input">
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="login-btn">
                <input type="submit" name="login" value="LOGIN">
            </div>
            <a href="#">Forgot password?</a>
        </form>
    </div>

</body>
</html>