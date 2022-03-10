<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: login.php');
		exit();
	}
	

	if (isset($_POST['FormStart-AddFriend']))
	{
			
		require_once "connect.php";
		$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
			
		$EverythingOk=true;
		
		$current_user_id = $_SESSION['id_user'];
		$current_user_nickname = $_SESSION['nickname'];
		$add_friend = $_POST['add_friend'];
		
		if (ctype_alnum($add_friend)==false)
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_addfriend'] = '<div style="color:red; text-align:center; font-weight:550;  margin-top:1rem; font-size:14px;">Dozwolone tylko litery i cyfry!</div>';
		}
		
		$rezultat = $conn->query("SELECT nickname FROM users WHERE nickname='$add_friend'");
		$rezultat2 = $conn->query("SELECT invited_user_nickname FROM invitations WHERE invited_user_nickname='$add_friend' AND id_inviting_user=$current_user_id");
		$rezultat3 = $conn->query("SELECT blocked_user FROM blocked WHERE blocked_user='$add_friend' AND id_user=$current_user_id");
		$rezultat4 = $conn->query("SELECT friend_nickname FROM relations WHERE friend_nickname='$add_friend' AND id_user=$current_user_id");
	
		if (!$rezultat) throw new Exception($conn->error);
		if (!$rezultat2) throw new Exception($conn->error);
		if (!$rezultat3) throw new Exception($conn->error);
		if (!$rezultat4) throw new Exception($conn->error);
				
		$chceck_did_exist = $rezultat->num_rows;
		$chceck_did_exist2 = $rezultat2->num_rows;
		$chceck_did_exist3 = $rezultat3->num_rows;
		$chceck_did_exist4 = $rezultat4->num_rows;
		
		if ($chceck_did_exist < 1)
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_addfriend']= '<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:13px;">Taki użytkownik nie istnieje!</div>';
		}
		
		if ($current_user_nickname == $add_friend)
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_addfriend']= '<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:13px;">Nie możesz zaprosić samego siebie!</div>';
		}
		
		if ($chceck_did_exist2 > 0)
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_addfriend']= '<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:13px;">Ten użytkownik został już zaproszony!</div>';
		}
		
		if ($chceck_did_exist3 > 0)
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_addfriend']= '<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:13px;">Ten użytkownik został przez Ciebie zablokowany!</div>';
		}
		
		if ($chceck_did_exist4 > 0)
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_addfriend']= '<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:13px;">Jesteście już znajomymi!</div>';
		}
		

		try 
		{

			if ($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			
					if ($EverythingOk == true)
					{
						if ($rezultat5 = $conn->query("INSERT INTO invitations VALUES (NULL, '$add_friend', '$current_user_id')"))
						{
							$_SESSION['updated_successfully_addfriend'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:4rem; font-size:14px;">Użytkownik '. '<span style="font-weight:850;">@'.$add_friend.'</span>'.' został zaproszony do znajomych!</div>';
							header('Location: ../settings.php');	
						}	
							else
						{
							throw new Exception($conn->error);
						}
					}
				$rezultat->free_result();
				$rezultat2->free_result();
				$rezultat3->free_result();
				$rezultat4->free_result();
				
				header('Location: ../settings.php');	
				$conn->close();
				
			
			
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Error! ";
		}
	}

?>

