<?php

session_start();

	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: signin.php');
		exit();
	}
	
	if (isset($_POST['update_description']))
	{
		$EverythingOk=true;
		
		$current_user_id = $_SESSION['id_user'];
		$user_description = $_POST['user_description'];

		if ((strlen($user_description)<1) || (strlen($user_description)>1000))
		{
			$EverythingOk=false;
			$_SESSION['error_description']="<div  id='text_clear' style='color:red; position:absolute; top:53.5px; left:4.7rem; font-weight:550; font-size:14px;'>Opis musi zawierać od 1 do max. 1000 znaków!</div>";
			header('Location: ../user-profile.php');
			$conn->close();
		}


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
					if ($rezultat = $conn->query("UPDATE users SET opis ='$user_description' WHERE id_user=$current_user_id"))
					{
							if ($result = $conn->query("SELECT opis FROM users WHERE id_user=$current_user_id"))
							{
								$_SESSION['zaktualizowano_opis']=True;
								
								$new_row = $result ->fetch_assoc();
								$_SESSION['new_description'] = $new_row['opis'];
								$_SESSION['description_query_success'] = '<div  id="text_clear" style="color:green; font-weight:550; text-align:center; margin-top:0.65rem; font-size:14px;">Zaktualizowano opis</div>';
								header('Location: ../user-profile.php');
								$result->free_result();
						}
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

<?php 

	if (isset($_POST['delete_description']))
	{
		$EverythingOk=true;
		
		$current_user_id = $_SESSION['id_user'];

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
				
				if ($rezultat = $conn->query("UPDATE users SET opis ='' WHERE id_user=$current_user_id"))
				{
						if ($result = $conn->query("SELECT opis FROM users WHERE id_user=$current_user_id"))
						{
							$_SESSION['zaktualizowano_opis']=True;
							
							$new_row = $result ->fetch_assoc();
							$_SESSION['new_description'] = $new_row['opis'];
							header('Location: ../user-profile.php');
							$result->free_result();
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