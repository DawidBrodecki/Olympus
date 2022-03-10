<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: login.php');
		exit();
	}
	
	require_once "connect.php";
	$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);		
	
	$this_user_id = $_SESSION['cancel_the_invitation_by_user_id'];				
	
	echo $this_user_id;
		
?>

