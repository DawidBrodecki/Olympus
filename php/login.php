<?php

	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['password'])))
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
		$login = $_POST['login'];
		$pass = $_POST['password'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");

		if ($rezultat = @$conn->query(
		sprintf("SELECT * FROM users WHERE nickname='%s'",
		mysqli_real_escape_string($conn,$login))))
		{
			$usersnumber = $rezultat->num_rows;
			if($usersnumber>0)
			{
				
				$wiersz = $rezultat->fetch_assoc();
				//$password_unhashed = password_verify($pass, $wiersz['haslo']);
				//$_SESSION['password_unhashed'] = $password_unhashed;
				
				if (password_verify($pass, $wiersz['haslo']))
				{

					$_SESSION['zalogowany'] = true;
						$_SESSION['id_user'] = $wiersz['id_user'];
						$_SESSION['imie'] = $wiersz['imie'];
						$_SESSION['nazwisko'] = $wiersz['nazwisko'];
						$_SESSION['nickname'] = $wiersz['nickname'];
						$_SESSION['email'] = $wiersz['email'];
						$_SESSION['data_urodzenia'] = $wiersz['data_urodzenia'];
						$_SESSION['plec'] = $wiersz['plec'];
						$_SESSION['haslo'] = $wiersz['haslo'];
						$_SESSION['data_rejestracji'] = $wiersz['data_rejestracji'];
						$_SESSION['kraj'] = $wiersz['kraj'];
						$_SESSION['zamieszkuje'] = $wiersz['zamieszkuje'];
						$_SESSION['praca'] = $wiersz['praca'];
						$_SESSION['szkola'] = $wiersz['szkola'];
						$_SESSION['user_avatar'] = $wiersz['user_avatar'];
						$_SESSION['user_backgroundphoto'] = $wiersz['user_backgroundphoto'];
						$_SESSION['opis'] = $wiersz['opis'];
						$_SESSION['zaproszenia'] = $wiersz['zaproszenia'];
						$_SESSION['weryfikacja'] = $wiersz['weryfikacja'];
					
					unset($_SESSION['blad']);
					$rezultat->free_result();
					header('Location: fetch_data.php');
				}
				else 
				{
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location: ../signin.php');
				}
				
			} 
			else 
			{
				
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: ../signin.php');
				
			}
			
		}
		
		$conn->close();
	}
	
?>



