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
		if(count($_FILES) > 0) 
		{

			$uploadcorrect= true;
			$current_user_id = $_SESSION['id_user'];
			
					
				if($uploadcorrect==true)
				{
					if(is_uploaded_file($_FILES['img-upload']['tmp_name'])) 
					{
						$imgData =addslashes(file_get_contents($_FILES['img-upload']['tmp_name']));
						$imageProperties = getimageSize($_FILES['img-upload']['tmp_name']);
						
						$sql = "UPDATE users SET user_avatar='$imgData' WHERE id_user=$current_user_id";
						
						$errorcheck = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));
					}
						$sql2="SELECT user_avatar FROM users WHERE id_user=$current_user_id";
						
						if ($result = $conn->query($sql2))
						{
							$_SESSION['zaktualizowano_avatar']=True;
							
							$new_row = $result ->fetch_assoc();
							$_SESSION['new_avatar'] = $new_row['user_avatar'];
							header("Location: ../user-profile.php");	
							$result->free_result();
					}
											
				}
				
		}
		
		$conn->close();
	}

?>


<?php

	require_once "connect.php";
	$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
		
	if ($conn->connect_errno!=0)
	{
		echo "Error: ".$conn->connect_errno;
	}
	else
	{
		if(count($_FILES) > 0) 
		{

			$uploadcorrect= true;
			$current_user_id = $_SESSION['id_user'];
			
					
				if($uploadcorrect==true)
				{
					if(is_uploaded_file($_FILES['backgroundphoto_upload']['tmp_name'])) 
					{
						$imgData =addslashes(file_get_contents($_FILES['backgroundphoto_upload']['tmp_name']));
						$imageProperties = getimageSize($_FILES['backgroundphoto_upload']['tmp_name']);
						
						$sql = "UPDATE users SET user_backgroundphoto='$imgData' WHERE id_user=$current_user_id";
						
						$errorcheck = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));
					}
						$sql2="SELECT user_backgroundphoto FROM users WHERE id_user=$current_user_id";
						
						if ($result = $conn->query($sql2))
						{
							$_SESSION['zaktualizowano_zdjecie_w_tle']=True;
							
							$new_row = $result ->fetch_assoc();
							$_SESSION['new_backgroundphoto'] = $new_row['user_backgroundphoto'];
							header("Location: ../user-profile.php");	
							$result->free_result();
					}
											
				}
				
		}
		
		$conn->close();
	}

?>
