<?php
	$db = mysqli_connect('localhost', 'root', '', 'poca');
	date_default_timezone_set('Africa/Nairobi');

	if (!$db) {
		die("Connection failed: ".mysqli_connect_error());
	}

	error_reporting(0);
?>
