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

    <title>Files</title>
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
                    <li><a href="files-upload"><i class="bi bi-people-fill"></i> Files</a></li>
                    <li><a href="users"><i class="bi bi-people-fill"></i> Users</a></li>
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
                        if ($_GET['error'] == "file-name-exists") {
                            echo "<p class='errors'>Upload failed. File name already exists!</p>";
                        }
                        elseif ($_GET['error'] == "upload-error") {
                            echo "<p class='errors'>Upload failed. An error occured while uploading the file!</p>";
                        }
                        elseif ($_GET['error'] == "upload-failed") {
                            echo "<p class='success'>Upload failed!</p>";
                        }
                    }
                ?>

                <div class="profile-form">
                    <form action="phps/fileuploads.inc.php" method="POST" enctype="multipart/form-data">
                        <?php
                            if (isset($_GET['name'])) {
                                $savedFileName = $_GET['name'];

                                $res = mysqli_query($db, "SELECT * from filesdb WHERE savedname='$savedFileName'");
                                    while ($row = mysqli_fetch_array($res)) {
                        ?>
                        
                        
                        <h3>Edit file</h3><hr>
                        <div class="fields">
                            <div class="input-box">
                                <label for=""> File name:  </label><br>
                                <input type="text" name="editFileN" id="fileN" value="<?php echo $row['filename']; ?>" required/>
                            </div>
                            <div class="input-box">
                                <label for=""> Saved name:  </label><br>
                                <input type="text" name="editFile" id="file" value="<?php echo $row['savedname']; ?>" readonly required/>
                            </div>
                            <div class="input-box">
                                <label for=""> Client:  </label><br>
                                <input type="text" name="editClient" id="client" value="<?php echo $row['client']; ?>" required/>
                            </div>
                        </div>
                        <?php
                                }
                            }
                        ?>

                        <div class="profile-btns">
                            <input type="submit" name="update" class="update-btn" value="Update" />
                            <input type="button" name="del-modal" class="del-btn" value="Delete" onclick="document.getElementById('id01').style.display='block'" />
                            <input type="reset" name="clear" class="clear-btn" value="Clear">
                        </div>

                        <div id="id01" class="modal">
                            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                            <div class="modal-content">
                                <!-- <form action="phps/fileuploads.inc.php" method="POST" enctype="multipart/form-data"> -->
                                    <p>
                                        A file once deleted cannot be recover.<br>
                                        Delete file?
                                    </p>

                                    <div class="clearfix">
                                        <button type="submit" name="delete" class="del-btn">Delete</button>
                                        <button type="button" class="cancelbtn" onclick="cancel()">Cancel</button>
                                    </div>
                                <!-- </form> -->
                            </div>
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

    <script>
        // Get the modal
        var modal = document.getElementById('id01');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        }

        function cancel(){
            modal.style.display = "none";
        }
    </script>
</body>
</html>