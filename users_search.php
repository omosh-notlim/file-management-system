<?php
    session_start();
    error_reporting(0);
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
                    <li>
                        <a href="#" class="serv-btn focus"><i class="bi bi-people-fill"></i> Users<i class="bi bi-caret-down-fill"></i>
                        </a>
                        <ul class="serv-show">
                            <li><a href="users">Add</a></li><hr>
                            <li><a href="#">Manage</a></li>
                        </ul>
                    </li>
                    <li><a href="profile"><i class="bi bi-person-bounding-box"></i> Profile</a></li>
                    <li><a href="change_pwd"><i class="bi bi-lock-fill"></i> Change password</a></li>
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
                        if ($_GET['error'] == "empty-fields") {
                            echo "<p class='errors'>Fill in all the fields!</p>";
                        }
                        elseif ($_GET['error'] == "invalid-mail") {
                            echo "<p class='errors'>User details not edited. Invalid email!</p>";
                        }
                        elseif ($_GET['error'] == "sqlerror") {
                            echo "<p class='errors'>An SQL error occured, please try again!</p>";
                        }
                        // elseif ($_GET['error'] == "email-exits") {
                        //     echo "<p class='errors'>User details not edited. Email already exists!</p>";
                        // }
                        elseif ($_GET['error'] == "user-deleted") {
                            echo "<p class='errors'>Account deleted!</p>";
                        }
                    }
                    elseif (isset($_GET['edit'])) {
                        if ($_GET['edit'] == "success") {
                            echo "<p class='success'>User details edited successfully.</p>";
                        }
                    }
                ?>

                <div class="search-area">
                    <div class="forms">
                        <form action="#" method="POST">
                            <div>
                                <input type="text" name="creteria" required>
                                <input type="submit" name="search" value="SEARCH">
                            </div>
                        </form>
                    </div>
                </div>

                <?php include 'users_table.php'; ?>

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