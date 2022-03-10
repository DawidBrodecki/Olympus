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
		$current_user_id = $_SESSION['id_user'];
		$DeleteSql = "UPDATE users SET user_backgroundphoto='' WHERE id_user=$current_user_id ";
		
		
		if ($conn->query($DeleteSql) === TRUE) 
		{
		  	$AddPlaceholder ="UPDATE placeholders, users SET users.user_backgroundphoto=placeholders.img WHERE placeholders.id_placeholder=2 AND users.id_user=$current_user_id";
			$errorcheck = mysqli_query($conn, $AddPlaceholder) or die("Error: " . mysqli_error($conn));
			
			$SelectNew="SELECT user_backgroundphoto FROM users  WHERE id_user=$current_user_id";
			
				if ($result = $conn->query($SelectNew))
				{
					$_SESSION['zaktualizowano_zdjecie_w_tle']=True;
							
					$new_row = $result ->fetch_assoc();
					$_SESSION['new_backgroundphoto'] = $new_row['user_backgroundphoto'];
								
						$result->free_result();

						header("Location: ../user-profile.php");
					}	
		}
		else 
		{
		  echo "Error: " . $conn->error;
		}
			
			
	$conn->close();
		
	}


?>
