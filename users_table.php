<?php
	require 'phps/db_connection.php';
    session_start();

	if (isset($_POST['search'])) {
		$creteria = mysqli_real_escape_string($db, $_POST['creteria']);

		$search_query = "SELECT * FROM users WHERE id LIKE '%$creteria%' OR name LIKE '%$creteria%' OR email LIKE '%$creteria%' OR role LIKE '%$creteria%'";
		$res_data = mysqli_query($db,$search_query);
	}
	else{
		$sql = "SELECT * FROM users";
		$res_data = mysqli_query($db,$sql);
	}
?>

<div class="table-users" id="all-users">
    <table>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    
    <?php
    while($row = mysqli_fetch_array($res_data)){
    ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['role']; ?></td>
        <td>
            <?php
                if (isset($_SESSION['u_role'])) {
                    $u_role = $_SESSION['u_role'];

                    if ( $u_role == 'admin') {
                        echo "<a href='user_edit?userID={$row['id']}'> <i class='bi bi-pencil-square'></i></a>";
                    }
                    elseif ($u_role == 'user') {?>
                        <a href='#' onclick="document.getElementById('id02').style.display='block'"> <i class='bi bi-pencil-square'></i></a><?php
                    }
                }             
            ?>
        </td>
    </tr>
    <?php
    }
    ?>
    </table>
     <?php
        mysqli_close($db);
    ?>
</div>