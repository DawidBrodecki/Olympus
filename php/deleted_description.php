<?php 

session_start();

	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: signin.php');
		exit();
	}
	

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
							$_SESSION['nowy_opis'] = $new_row['opis'];
							$_SESSION['new_description'] = '<div id="text_clear" style="color:green; font-weight:550;  margin-top:1rem; font-size:14px;">Usunieto</div>';
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