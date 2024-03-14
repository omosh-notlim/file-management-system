<?php
	if (isset($_POST['login'])) {
		require 'db_connection.php';

		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($email) || empty($password)) {
			header("Location: ../login?error=empty-fields");
			exit();
		}
		else{
			$sql = "SELECT * FROM users WHERE email=?";
			$stmt = mysqli_stmt_init($db);
			if (!mysqli_stmt_prepare($stmt, $sql)) {
				header("Location: ../login?error=sqlerror");
				exit();
			}
			else{
				mysqli_stmt_bind_param($stmt, "s", $email);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				if ($row = mysqli_fetch_assoc($result)) {
					$pwdCheck = password_verify($password, $row['password']);
					if ($pwdCheck == false) {
						header("Location: ../login?error=wrong-password");
						exit();
					}
					elseif ($pwdCheck == true) {
						session_start();
						$_SESSION['userid'] = $row['id'];
						$_SESSION['username'] = $row['name'];
						$_SESSION['u_role'] = $row['role'];

						header("Location: ../files-upload?login-successful");
						exit();
					}
					else{
						header("Location: ../login?error=wrong-password");
						exit();
					}
				}
				else{
					header("Location: ../login?error=no-user");
					exit();
				}
			}
		}
	}
	else{
		header("Location: ../login");
	}
