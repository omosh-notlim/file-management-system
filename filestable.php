<?php
	require 'phps/db_connection.php';
    session_start();

	if (isset($_POST['search'])) {
		$creteria = mysqli_real_escape_string($db, $_POST['creteria']);

		$search_query = "SELECT * FROM filesdb WHERE id LIKE '%$creteria%' OR filename LIKE '%$creteria%' OR client LIKE '%$creteria%' OR uploaddate LIKE '%$creteria%'";
		$res_data = mysqli_query($db,$search_query);
	}
	else{
		$sql = "SELECT * FROM filesdb";
		$res_data = mysqli_query($db,$sql);
	}
?>

<div class="table-users" id="all-users">
    <table>
        <tr>
            <th>#</th>
            <th>File</th>
            <th>Client</th>
            <th>Upload date</th>
            <th>Action</th>
        </tr>
    
    <?php
    while($row = mysqli_fetch_array($res_data)){
        $savedname = $row['savedname'];
    ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td>
            <a href="files/<?php echo $row['savedname']; ?>"> <?php echo $row['filename']; ?></a>
        </td>
        <td><?php echo $row['client']; ?></td>
        <td><?php echo $row['uploaddate']; ?></td>
        <td>
            <?php
                if (isset($_SESSION['u_role'])) {
                    $u_role = $_SESSION['u_role'];

                    if ( $u_role == 'admin') {
                        echo "<a href='file_edit?name={$row['savedname']}'> <i class='bi bi-pencil-square'></i>";
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