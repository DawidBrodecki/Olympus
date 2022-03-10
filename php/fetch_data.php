<?php

session_start();

	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ../signin.php');
		exit();
	}

	require_once "connect.php";

	$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
	
	if ($conn->connect_errno!=0)
	{
		echo "Error: ".$conn->connect_errno;
	}
	else
	{
		$weryfikacja = $_SESSION['weryfikacja'];
		
			if ($weryfikacja == "tak")
			{
				$_SESSION['weryfikacja_konta'] = '<span style="margin-left:10px; padding-right:3px;"><i class="fas fa-check-circle fa-xs"></i></span>';
			}
			else
			{
				$_SESSION['weryfikacja_konta'] = '';
			}
			
		header('Location: ../index.php');
	}
	
		$_SESSION['blad'] = '<span style="color:red">Błąd serwera!</span>';
		header('Location: ../signin.php');
		
		$conn->close();
	
?>



