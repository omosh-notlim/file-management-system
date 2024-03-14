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
                    <li><a href="#" class="focus"><i class="bi bi-person-bounding-box"></i> Profile</a></li>
                    <li><a href="change_pwd"><i class="bi bi-lock-fill"></i> Change password</a></li>
                    <li><a href="phps/logout.inc"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
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
                    }
                    elseif (isset($_GET['edit'])) {
                        if ($_GET['edit'] == "success") {
                            echo "<p class='success'>Profile updated successfully.</p>";
                        }
                    }
                ?>

                <div class="profile-form">
                    <form action="phps/register.inc.php" method="POST">
                        <?php
                            if(isset($_SESSION['userid'])){
                                $searchDetail = mysqli_real_escape_string($db, $_SESSION['userid']);

                                $res = mysqli_query($db, "SELECT * from users WHERE id='$searchDetail'");
                                    while ($row = mysqli_fetch_array($res)) {
                        ?>
                        
                        
                        <h3>Edit profile</h3><hr>
                        <div class="fields">
                            <div class="input-box">
                                <label for=""> User_ID:  </label>
                                <input type="text" name="userid" id="userid" value="<?php echo $row['id']; ?>" readonly required/>
                            </div>
                            <div class="input-box">
                                <label for=""> Name:  </label>
                                <input type="text" name="name" id="name" value="<?php echo $row['name']; ?>" required/>
                            </div>
                            <div class="input-box">
                                <label for=""> Email:  </label>
                                <input type="email" name="email" id="email" value="<?php echo $row['email']; ?>" required/>
                            </div>
                            <?php
                                if (isset($_SESSION['u_role'])) {
                                    $u_role = $_SESSION['u_role'];

                                    if ( $u_role == 'admin') {
                                        ?>
                                        <div class="input-box">
                                            <label for=""> Role:  </label>
                                            <select name="role" id="role">
                                                <option value="admin">Admin</option>
                                                <option value="user" selected="selected">User</option>
                                                <option value="<?php echo $row['role'];?>" selected="selected"><?php echo $row['role']; ?></option>
                                            </select>
                                        </div>
                                        <?php
                                    }
                                    elseif ($u_role == 'user') {
                                        ?>
                                        <div class="input-box">
                                            <label for=""> Role:  </label>
                                            <input type="text" name="role" id="role" value="<?php echo $row['role']; ?>" readonly required/>
                                        </div>
                                        <?php
                                    }
                                }             
                            ?>
                        </div>
                        <?php
                                }
                            }
                        ?>

                        <div class="profile-btns">
                            <input type="submit" name="profileUpdate" class="update-btn" value="Update" />
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