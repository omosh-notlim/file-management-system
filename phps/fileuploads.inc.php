<?php
	session_start();
	include 'db_connection.php';


//start------------------------------------------------------------
	if (isset($_POST['add'])) { //if button add is clicked...
		$file = $_FILES['file']; //file input box name

		$fileN = mysqli_real_escape_string($db, $_POST['fileN']); //an inputbox inthe html: file name
		$client = mysqli_real_escape_string($db, $_POST['client']); //an inputbox inthe html: client name
		$currDate = date("Y-m-d"); // for the upload date
		$errors = ''; // empty variable to hold the errors

	//the following values assigned to the variables below come with the attached file
		$fileName = $_FILES['file']['name'];
		$fileTmpName = $_FILES['file']['tmp_name'];
		$fileSize = $_FILES['file']['size'];
		$fileError = $_FILES['file']['error'];
		$fileType = $_FILES['file']['type'];

		$fileExt = explode('.', $fileName);
		$fileActualExt =  strtolower(end($fileExt));
	//----------------------------------------------------------------------------------------------

		$allowed = array('jpg', 'jpeg', 'png', 'pdf', 'csv', 'docx', 'txt', 'xlsx', 'doc'); //allowed file extensions

		if (in_array($fileActualExt, $allowed)) { //if the extension is allowed then...
			if ($fileError === 0) { //if no file error then....
				if ($fileSize < 1000000) { //if file size does not exceed the set max size then...
					$fileNameNew = $fileN.uniqid('', true).".".$fileActualExt; //assign file name
					$fileDestination = '../files/'.$fileNameNew; //set file destination

					//checking if file name already exist before posting the name inthe db
					 	// just the name because actual files are stored inthe stated folder/directory
					$fileN_check_query = "SELECT * FROM filesdb WHERE filename='$fileN' LIMIT 1";
					$result = mysqli_query($db, $fileN_check_query);
					$file_check = mysqli_fetch_assoc($result);

					if ($file_check) {//if file name exists
						if ($file_check['filename'] === $fileN) {
							$errors = "Sorry, file name already exists!!";

							header("Location: ../files-upload?error=file-name-exists");
							exit();
						}
					}

					//upload file details if name doesn't exist
						//actual file not stored inthe db
					if ($errors == "") {
						$query = "INSERT INTO filesdb (filename, savedname, client, uploaddate) VALUES ('$fileN', '$fileNameNew', '$client', '$currDate')";
						
						$query_run = mysqli_query($db, $query);
		
						if($query_run){
							move_uploaded_file($fileTmpName, $fileDestination); //line that moves the actual file to the desired destination
							header("Location: ../files-upload?upload=success"); //redirect to this page
							exit();
						}else{
							header("Location: ../files-upload?error=upload-failed"); //redirect to this page
							exit();
						}
					}			
				} else{
					header("Location: ../files-upload?error=file-too-large"); //redirect to this page
					exit();
				}
			} else{
				header("Location: ../files-upload?error=upload-error"); //redirect to this page
				exit();
			}
		} else {
			header("Location: ../files-upload?error=file-extension-error"); //redirect to this page
			exit();
		}
	}
//end----------------------------------------

	
	// file editing.....
	if (isset($_POST['update'])) {
		$editFileN = mysqli_real_escape_string($db, $_POST['editFileN']);
		$editFile = mysqli_real_escape_string($db, $_POST['editFile']);
		$editClient = mysqli_real_escape_string($db, $_POST['editClient']);

		$editErrors = '';

		//checking if file name already exist
		// $editFileN_check_query = "SELECT * FROM filesdb WHERE filename='$editFileN' LIMIT 1";
		// $editResult = mysqli_query($db, $editFileN_check_query);
		// $editFile_check = mysqli_fetch_assoc($editResult);

		//if ($editFile_check) {//if file name exists
		// 	if ($editFile_check['filename'] === $editFileN) {
		// 		$editErrors = "Sorry, file name already exists!!";

		// 		header("Location: ../file_search?error=file-name-exists");
		// 		exit();
		// 	}
		// }

		//edit file if name doesn't exist
		if ($editErrors == "") {
			$edit_query = "UPDATE filesdb SET filename='$editFileN', client='$editClient' WHERE savedname='$editFile'";
			
			$edit_query_run = mysqli_query($db, $edit_query);

			if($edit_query_run){
				header("Location: ../file_search?upload=success");
				exit();
			}else{
				header("Location: ../file_search?error=upload-failed");
				exit();
			}
		}
	}

	if (isset($_POST['delete'])) {
		$editFile = mysqli_real_escape_string($db, $_POST['editFile']);

		//Delete file......
		$del_file = '../files/'.$editFile;
		$status=unlink($del_file);    

		$del_query = "DELETE FROM filesdb WHERE savedname='$editFile'";  

		$del_query_run = mysqli_query($db, $del_query);

		if($del_query_run){
			header("Location: ../file_search?error=file-deleted");
		}else{
			header("Location: ../file_search?error=delete-failed");
		}
	}