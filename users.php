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
                            <li><a href="#" onclick="document.getElementById('id01').style.display='block'">Add</a></li><hr>
                            <li><a href="users_search">Manage</a></li>
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
                        if ($_GET['error'] == "password-mismatch") {
                            echo "<p class='errors'>User not created. Password mismatch</p>";
                        }
                        elseif ($_GET['error'] == "empty-fields") {
                            echo "<p class='errors'>Fill in all the fields!</p>";
                        }
                        elseif ($_GET['error'] == "invalid-mail") {
                            echo "<p class='errors'>User not created. Invalid email!</p>";
                        }
                        elseif ($_GET['error'] == "sqlerror") {
                            echo "<p class='errors'>An SQL error occured, please try again!</p>";
                        }
                        elseif ($_GET['error'] == "email-exits") {
                            echo "<p class='errors'>User not created. Email already exists!</p>";
                        }
                    }
                    // elseif (isset($GET['registration'])) {
                    //     if ($_GET['registration'] == "success") {
                    //         echo "<p class='success'>Account successfully created</p>";
                    //     }
                    // }
                    elseif (isset($_GET['registration'])) {
                        if ($_GET['registration'] == "success") {
                            echo "<p class='success'>Account successfully created.</p>";
                        }
                    }
                ?>

                <div onload="table();">
                    <script type="text/javascript">
                        function table(){
                            const xhttp = new XMLHttpRequest();
                            xhttp.onload = function(){
                                document.getElementById("table").innerHTML = this.responseText;
                            }
                            xhttp.open("GET", "users_table.php");
                            xhttp.send();
                        }
                        setInterval(function(){
                            table();
                        },500);
                    </script>

                    <div id="table">
                        
                    </div>
                </div>

                <div id="id01" class="modal">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                    <div class="modal-content">
                        <form action="phps/register.inc.php" method="POST">
                            <h3>Add user</h3><hr>
                            <div class="fields">
                                <div class="input-box">
                                    <label for=""> Name:  </label><br>
                                    <input type="text" name="name" id="name" required/>
                                </div>
                                <div class="input-box">
                                    <label for=""> Email:  </label><br>
                                    <input type="email" name="email" id="email" required/>
                                </div>
                                <?php
                                    if (isset($_SESSION['u_role'])) {
                                        $u_role = $_SESSION['u_role'];

                                        if ( $u_role == 'admin') {?>
                                            <div class="input-box">
                                                <label for=""> Role:  </label><br>
                                                <select name="role" id="role">
                                                    <option value="admin">Admin</option>
                                                    <option value="user" selected="selected">User</option>
                                                </select>
                                            </div>
                                        <?php
                                        }
                                        elseif ($u_role == 'user') {?>
                                            <div class="input-box">
                                                <label for=""> Role:  </label><br>
                                                <select name="role" id="role">
                                                    <option value="user" selected="selected">User</option>
                                                </select>
                                            </div>
                                        <?php
                                        }
                                    }             
                                ?>
                                <div class="input-box">
                                    <label for=""> Password:  </label><br>
                                    <input type="password" name="password" id="password" required/>
                                </div>
                                <div class="input-box">
                                    <label for=""> Confirm Password:  </label><br>
                                    <input type="password" name="conpassword" id="conpassword" required/>
                                </div>
                            </div>

                            <div class="clearfix">
                                <button type="submit" name="add" class="addbtn">Add</button>
                              <button type="button" class="cancelbtn" onclick="cancel()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="id02" class="modal">
                    <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                    <div class="modal-content">
                        <form action="#">
                            <h3>Action not allowed!</h3>
                            <div class="clearfix">
                                <button type="button" class="cancelbtn" onclick="cancel2()">Cancel</button>
                            </div>
                        </form>
                    </div>
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

    <script>
        // Get the modal
        var modal = document.getElementById('id01');
        var modal2 = document.getElementById('id02');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
            modal2.style.display = "none";
          }
        }

        function cancel(){
            modal.style.display = "none";
        }
        function cancel2(){
            modal2.style.display = "none";
        }
    </script>
</body>
</html>