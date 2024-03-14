<?php
	session_start();
	require 'db_connection.php';

	if (isset($_POST['add'])) {
		$name = mysqli_real_escape_string($db, $_POST['name']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$role= mysqli_real_escape_string($db, $_POST['role']);
		$password = mysqli_real_escape_string($db, $_POST['password']);
		$conpassword = mysqli_real_escape_string($db, $_POST['conpassword']);

		if (empty($name) || empty($email) || empty($role) || empty($password) || empty($conpassword)) {
			header("Location: ../users?error=empty-fields&name=".$name."&email=".$email."&role=".$role);
			exit();
		}
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			header("Location: ../users?error=invalid-mail&name=".$name."&role=".$role);
			exit();
		}
		elseif ($password !== $conpassword) {
			header("Location: ../users?error=password-mismatch&name=".$name."&email=".$email."&role=".$role);
			exit();
		}
		else{
			$sql = "SELECT email FROM users WHERE email=?";
			$stmt = mysqli_stmt_init($db);
			if (!mysqli_stmt_prepare($stmt, $sql)) {
				header("Location: ../users?error=sqlerror");
				exit();
			}
			else{
				mysqli_stmt_bind_param($stmt, "s", $email);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
				$resultCheck = mysqli_stmt_num_rows($stmt);
				if ($resultCheck > 0) {
					header("Location: ../users?error=email-exits&name=".$name."&role=".$role);
					exit();
				}
				else{
					$sql = "INSERT INTO users (name, email, role, password) VALUES (?, ?, ?, ?)";
					$stmt = mysqli_stmt_init($db);
					if (!mysqli_stmt_prepare($stmt, $sql)) {
						header("Location: ../users?error=sqlerror");
						exit();
					}
					else{
						$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

						mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $role, $hashedPwd);
						mysqli_stmt_execute($stmt);
						header("Location: ../users?registration=success");
						exit();
					}
				}
			}
		}
		mysqli_stmt_close($stmt);
		mysqli_close($db);
	}

	elseif (isset($_POST['update'])) {
		$userid = mysqli_real_escape_string($db, $_POST['userid']);
		$editName = mysqli_real_escape_string($db, $_POST['editName']);
		$editEmail = mysqli_real_escape_string($db, $_POST['editEmail']);
		$editRole= mysqli_real_escape_string($db, $_POST['editRole']);

		$editErrors = '';

		if (empty($editName) || empty($editEmail) || empty($editRole)) {
			header("Location: ../users_search?error=empty-fields&name=".$editName."&email=".$editEmail."&role=".$editRole);
			exit();
		}
		elseif (!filter_var($editEmail, FILTER_VALIDATE_EMAIL)) {
			header("Location: ../users_search?error=invalid-mail&name=".$editName."&role=".$editRole);
			exit();
		}

		//edit user
		if ($editErrors == "") {
			$edit_query = "UPDATE users SET name='$editName', email='$editEmail', role='$editRole' WHERE id='$userid'";
			
			$edit_query_run = mysqli_query($db, $edit_query);

			if($edit_query_run){
				header("Location: ../users_search?edit=success");
				exit();
			}else{
				header("Location: ../users_search?error=sqlerror");
				exit();
			}
		}
		mysqli_close($db);
	}

	elseif (isset($_POST['delete'])) {
		$userid = mysqli_real_escape_string($db, $_POST['userid']);

		//Delete uaccount......
		$del_query = "DELETE FROM users WHERE id='$userid'";  

		$del_query_run = mysqli_query($db, $del_query);

		if($del_query_run){
			header("Location: ../users_search?error=user-deleted");
		}else{
			header("Location: ../users_search?error=delete-failed");
		}
	}

	elseif (isset($_POST['profileUpdate'])) {
		$userid = mysqli_real_escape_string($db, $_POST['userid']);
		$name = mysqli_real_escape_string($db, $_POST['name']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$role= mysqli_real_escape_string($db, $_POST['role']);

		$editErrors = '';

		if (empty($name) || empty($email) || empty($role)) {
			header("Location: ../profile?error=empty-fields&name=".$name."&email=".$email."&role=".$role);
			exit();
		}
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			header("Location: ../profile?error=invalid-mail&name=".$name."&role=".$role);
			exit();
		}

		//edit user
		if ($editErrors == "") {
			$edit_query = "UPDATE users SET name='$name', email='$email', role='$role' WHERE id='$userid'";
			
			$edit_query_run = mysqli_query($db, $edit_query);

			if($edit_query_run){
				header("Location: ../login?edit=success");
				exit();
			}else{
				header("Location: ../profile?error=sqlerror");
				exit();
			}
		}
		mysqli_close($db);
	}

	elseif (isset($_POST['pwdUpdate'])) {
		$userid = mysqli_real_escape_string($db, $_POST['userid']);
		$currentpwd = mysqli_real_escape_string($db, $_POST['currentpwd']);
		$newpwd = mysqli_real_escape_string($db, $_POST['newpwd']);
		$repeatpwd = mysqli_real_escape_string($db, $_POST['repeatpwd']);

		if (empty($currentpwd) || empty($newpwd) || empty($repeatpwd)) {
			header("Location: ../change_pwd?error=empty-fields");
			exit();
		}
		elseif ($newpwd !== $repeatpwd) {
			header("Location: ../change_pwd?error=password-mismatch");
			exit();
		}

		else{
			//checking if file name already exist
			$sql = "SELECT * FROM users WHERE id='$userid'";
			$editpwd = mysqli_query($db, $sql);
			$editpwd_check = mysqli_fetch_assoc($editpwd);

			if ($editpwd_check) {//if file name exists
				$pwdCheck = password_verify($currentpwd, $editpwd_check['password']);
				if ($pwdCheck == false) {
					header("Location: ../change_pwd?error=wrong-password");
					exit();
				}
				elseif ($pwdCheck == true) {
					$hashedPwd = password_hash($newpwd, PASSWORD_DEFAULT);
					$edit_query = "UPDATE users SET password='$hashedPwd' WHERE id='$userid'";
					
					$edit_query_run = mysqli_query($db, $edit_query);
					if($edit_query_run){
						header("Location: ../login?change=success");
						exit();
					}else{
						header("Location: ../change_pwd?error=upload-failed");
						exit();
					}
					
				}
			}
		}
	}

	else{
		header("Location: ../users_search");
	}
	