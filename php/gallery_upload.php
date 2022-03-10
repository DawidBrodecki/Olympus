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
					if(is_uploaded_file($_FILES['photo_upload']['tmp_name'])) 
					{
						$imgData =addslashes(file_get_contents($_FILES['photo_upload']['tmp_name']));
						$imageProperties = getimageSize($_FILES['photo_upload']['tmp_name']);
						
						$sql = "INSERT INTO gallery VALUES (NULL, $current_user_id,  '$imgData')";
						
						$errorcheck = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));
					}
						$sql2="SELECT photo FROM gallery WHERE id_user=$current_user_id";
						
						if ($result = $conn->query($sql2))
						{
							$_SESSION['photo_in_database']=True;
							
							$row = $result ->fetch_assoc();
							$_SESSION['user_photo'] = $row['photo'];
									
							$result->free_result();

							header("Location: ../gallery.php");
					}	
				}
		}
		
		$conn->close();
	}

?>
