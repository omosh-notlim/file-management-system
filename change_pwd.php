<?php
    session_start();
    include 'phps/db_connection.php';
    // error_reporting(0);
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

    <title>Users</title>
</head>
<body>
    <?php
        if (isset($_SESSION['userid'])) {?>
            <div class="btn">
                <i class="bi bi-list"></i>
                <i class="bi bi-x"></i>
            </div>
            <nav class="sidebar">
                <div class="text">
                    <div class="image"><img src="images/logo.jpg"></div>
                </div>
                <ul>
                    <li><a href="files-upload"><i class="bi bi-file-earmark-fill"></i> Files</li>
                    <li><a href="users"><i class="bi bi-people-fill"></i> Users</a></li>
                    <li><a href="profile"><i class="bi bi-person-bounding-box"></i> Profile</a></li>
                    <li><a href="#" class="focus"><i class="bi bi-lock-fill"></i> Change password</a></li>
                    <li><a href="phps/logout.inc.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </nav>

            <div class="content-area">
                <div class="welcome">
                    <p>
                        <?php
                            if (isset($_SESSION['username'])) {
                                echo "<p>Welcome ".$_SESSION['username']."</p>";
                            }
                        ?>
                    </p>
                </div>

                <?php
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "password-mismatch") {
                            echo "<p class='errors'>Update failed. Password mismatch</p>";
                        }
                        elseif ($_GET['error'] == "empty-fields") {
                            echo "<p class='errors'>Fill in all the fields!</p>";
                        }
                        elseif ($_GET['error'] == "wrong-password") {
                            echo "<p class='errors'>Wrong current password!</p>";
                        }
                        elseif ($_GET['error'] == "upload-failed") {
                            echo "<p class='errors'>An error occured, please try again!</p>";
                        }
                        elseif ($_GET['error'] == "sqlerror") {
                            echo "<p class='errors'>An SQL error occured, please try again!</p>";
                        }
                    }
                ?>

                <div class="profile-form">
                    <form action="phps/register.inc.php" method="POST">         
                        <h3>Change password</h3><hr>
                        <div class="fields">
                            <div class="input-box">
                                <label for=""> User ID:  </label>
                                <input type="text" name="userid" id="userid" value="<?php echo $_SESSION['userid']; ?>" readonly required/>
                            </div>
                            <div class="input-box">
                                <label for=""> Current password:  </label>
                                <input type="password" name="currentpwd" id="currentpwd" required/>
                            </div>

                            <div class="input-box">
                                <label for=""> New password:  </label>
                                <input type="password" name="newpwd" id="newpwd" required/>
                            </div>
                            <div class="input-box">
                                <label for=""> Repeat password:  </label>
                                <input type="password" name="repeatpwd" id="repeatpwd" required/>
                            </div>
                        </div>

                        <div class="profile-btns">
                            <input type="submit" name="pwdUpdate" class="update-btn" value="Update" />
                            <input type="reset" name="clear" class="clear-btn" value="Clear">
                        </div>
                    </form>
                </div>
            </div>
        <?php
        }else{?>
           <div class="no-log">
                <p>You are not logged in!!</p>
            </div>
        <?php
        }
    ?>

    <script src="scrolljQuery.js"></script>
    <script>
        $('.btn').click(function(){
            $(this).toggleClass("click");
            $('.sidebar').toggleClass("show");
        });

        $('.feat-btn').click(function(){
            $('nav ul .feat-show').toggleClass("show");
        });

        $('.serv-btn').click(function(){
            $('nav ul .serv-show').toggleClass("show1");
        });

        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        });

    </script>
</body>
</html>