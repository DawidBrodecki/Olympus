<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: login.php');
		exit();
	}
	
	require_once "connect.php";
	$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);		
	
	$current_user_nickname = $_SESSION['nickname'];				
	
	$result = $conn->query("SELECT COUNT('invited_user_nickname') FROM invitations WHERE invited_user_nickname='$current_user_nickname'");
		while ($row = $result->fetch_assoc()) 
		{
			$_SESSION['number_of_invitations'] = $row["COUNT('invited_user_nickname')"];
		}
		
?>

