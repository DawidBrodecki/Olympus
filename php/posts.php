<?php

session_start();

	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: signin.php');
		exit();
	}
	
	if (isset($_POST['publishbtn_start']))
	{
		$EverythingOk=true;
		
		$this_user_id = $_SESSION['id_user'];
		$this_user_name = $_SESSION['imie'];
		$this_user_lastname = $_SESSION['nazwisko']; 
		$this_user_nickname = $_SESSION['nickname']; 
		$this_user_veryfication = $_SESSION['weryfikacja']; 

		
		$post_content = $_POST['textarea'];
		$visibility = $_POST['visibility'];

		if ((strlen($post_content)<1) || (strlen($post_content)>5000))
		{
			$EverythingOk=false;
			$_SESSION['error_post']="<div  id='text_clear' style='color:red; position:absolute; top:53.5px; left:4.7rem; font-weight:550; font-size:14px;'>Opis musi zawierać od 1 do max. 5000 znaków!</div>";
			header('Location: ../user-profile.php');
			$conn->close();
		}
		
		date_default_timezone_set("Europe/Warsaw");
		$date = date('Y.m.d');	
		$time = date("H:i:s");

		try 
		{
		
		require_once "connect.php";
		$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
		

			
			if ($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}			
			else
			{
				
				if($EverythingOk== TRUE)
				{
					if(is_uploaded_file($_FILES['post_photo']['tmp_name'])) 
					{
						$imgData =addslashes(file_get_contents($_FILES['post_photo']['tmp_name']));
						$imageProperties = getimageSize($_FILES['post_photo']['tmp_name']);
					}
					
						if ($rezultat = $conn->query("INSERT INTO posts VALUES (NULL, $this_user_id, '$this_user_name', '$this_user_lastname', '$this_user_nickname', '', '$this_user_veryfication', '$date', '$time', '$post_content', '$imgData', '', '', '', '$visibility')"))
						{
							$conn->query ("UPDATE posts, users SET posts.author_avatar=users.user_avatar WHERE users.id_user=$this_user_id AND users.id_user=posts.id_user");
							header('Location: ../user-profile.php');
						}		
				}
				else 
				{
					echo "Error: " . $conn->error;
				}
			}
			$conn->close();
					
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Error! ";
		}
	
	}
?>
