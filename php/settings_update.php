<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: login.php');
		exit();
	}
	

	if (isset($_POST['FormStart-fullname']))
	{
		$EverythingOk=true;
		
		$current_user_id = $_SESSION['id_user'];
		
		$name = $_POST['name'];
		
		if (preg_match('/^[A-PR-UWY-ZĄĆĘŁŃÓŚŹŻ0-9QXV]*$/iu',$name)==false)
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_name'] = '<div style="color:red; text-align:center; font-weight:550;  margin-top:1rem; font-size:14px;">Dozwolone tylko litery oraz cyfry o długości od 3 do 20 znaków!</div>';
		}
		
		if((strlen($name)<3) || (strlen($name)>20))
		{
			$EverythingOk=false;
			//$_SESSION['settings_validation_error_name'] = '<div style="color:red; text-align:center; font-weight:550;  margin-top:1rem; font-size:14px;">Dozwolone tylko litery oraz cyfry o długości od 3 do 20 znaków!</div>';
		}

			
		try 
		{
		
		require_once "connect.php";
		$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
			
			if ($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			
					if ($EverythingOk == true)
					{
						if ($conn->query("UPDATE users SET imie='$name' WHERE id_user = '$current_user_id'"))
						{
							$name_updated_successfully = 1;
						}
						
						if ($result = $conn->query("SELECT imie FROM users WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['is_updated_name']=True;
							
							$updated_name = $result ->fetch_assoc();
							$_SESSION['updated_name'] = $updated_name['imie'];
									
							$result->free_result();

							header('Location: ../settings.php');	
						}
							else
						{
							throw new Exception($conn->error);
						}
					}
				header('Location: ../settings.php');	
				$conn->close();
				
			
			
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Error! ";
		}
	}

?>

<?php
	
	if (isset($_POST['FormStart-fullname']))
	{
		$EverythingOk=true;
		
		$current_user_id = $_SESSION['id_user'];
		
		$lastname = $_POST['lastname'];
		
		if (preg_match('/^[A-PR-UWY-ZĄĆĘŁŃÓŚŹŻ0-9QXV]*$/iu',$lastname)==false)
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_lastname'] = '<div style="color:red; text-align:center; font-weight:550;  margin-top:1rem; font-size:14px;">Dozwolone tylko litery oraz cyfry o długości od 3 do 20 znaków!</div>';
		}
		
		if((strlen($lastname)<3) || (strlen($lastname)>20))
		{
			$EverythingOk=false;
			//$_SESSION['settings_validation_error_lastname'] = '<div style="color:red; text-align:center; font-weight:550;  margin-top:1rem; font-size:14px;">Dozwolone tylko litery oraz cyfry o długości od 3 do 20 znaków!</div>';
		}
			
		try 
		{
		
		require_once "connect.php";
		$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
			
			if ($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			
					if ($EverythingOk == true)
					{
						if ($conn->query("UPDATE users SET nazwisko ='$lastname' WHERE id_user = '$current_user_id'"))
						{
							$lastname_updated_successfully = 1;
						}
						
						if ($result = $conn->query("SELECT nazwisko FROM users WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['is_updated_lastname']=True;
							
							$updated_lastname = $result ->fetch_assoc();
							$_SESSION['updated_lastname'] = $updated_lastname['nazwisko'];
									
							$result->free_result();

							header('Location: ../settings.php');	
						}
							else
						{
							throw new Exception($conn->error);
						}
					}
					
					if (($name_updated_successfully == 1) && ($lastname_updated_successfully ==1))
					{
						$_SESSION['updated_successfully'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:3.5rem; font-size:14px;">Imię i nazwisko zostały zaktualizowane poprawnie!</div>';
					}

					if (($name_updated_successfully == 1) && ($lastname_updated_successfully == 0))
					{
						$_SESSION['updated_successfully'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:3.5rem; font-size:14px;">Imię zostało zaktualizowane poprawnie!</div>';
					}

					if (($name_updated_successfully == 0) && ($lastname_updated_successfully == 1))
					{
						$_SESSION['updated_successfully'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:3.5rem; font-size:14px;">Nazwisko zostało zaktualizowane poprawnie!</div>';
					}
					
						header('Location: ../settings.php');	
						$conn->close();
					
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Error! ";
		}
	}

?>

<?php
	
	if (isset($_POST['FormStart-username']))
	{
		$EverythingOk=true;
		
		$current_user_id = $_SESSION['id_user'];
		
		$nickname = $_POST['nickname'];
		
		if (ctype_alnum($nickname)==false)
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_n'] = '<div style="color:red; text-align:center; font-weight:550;  margin-top:1rem; font-size:14px;">Dozwolone tylko litery oraz cyfry!</div>';
		}
		
		if ((strlen($nickname)<3) || (strlen($nickname)>20))
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_n']='<div style="color:red; text-align:center; font-weight:550;  margin-top:1rem; font-size:14px;">Nazwa użytkownika musi posiadać od 3 do 20znaków!"</div>';
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
				$rezultat = $conn->query("SELECT id_user FROM users WHERE nickname='$nickname'");
				
				if (!$rezultat) throw new Exception($conn->error);
				
				$walidacja = $rezultat->num_rows;

				if($walidacja>0)
				{
					$EverythingOk=false;
					$_SESSION['settings_validation_error_n']='<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:4.5rem; font-size:14px;">Ta nazwa użytkownika jest już zajęta!</div>';
				}
				
			
					if ($EverythingOk == true)
					{
						if ($conn->query("UPDATE users SET nickname ='$nickname' WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['updated_successfully_nickname'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:3.5rem; font-size:14px;">Twoja nazwa użytkownika została zaktualizowane poprawnie!</div>';
						}
						
						if ($result = $conn->query("SELECT nickname FROM users WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['is_updated_nickname']=True;
							
							$updated_nickname = $result ->fetch_assoc();
							$_SESSION['updated_nickname'] = $updated_nickname['nickname'];
									
							$result->free_result();

							header('Location: ../settings.php');	
						}
							else
						{
							throw new Exception($conn->error);
						}
					}
					
				header('Location: ../settings.php');	
				$conn->close();
			}
			
			
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Error! ";
		}
	}

?>

<?php
	
	if (isset($_POST['FormStart-username']))
	{
		$EverythingOk=true;
		
		$current_user_id = $_SESSION['id_user'];
		
		$nickname = $_POST['nickname'];
		
		if (ctype_alnum($nickname)==false)
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_n'] = '<div style="color:red; text-align:center; font-weight:550;  margin-top:1rem; font-size:14px;">Dozwolone tylko litery oraz cyfry!</div>';
		}
		
		if ((strlen($nickname)<3) || (strlen($nickname)>20))
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_n']='<div style="color:red; text-align:center; font-weight:550;  margin-top:1rem; font-size:14px;">Nazwa użytkownika musi posiadać od 3 do 20znaków!"</div>';
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
				$rezultat = $conn->query("SELECT id_user FROM users WHERE nickname='$nickname'");
				
				if (!$rezultat) throw new Exception($conn->error);
				
				$walidacja = $rezultat->num_rows;

				if($walidacja>0)
				{
					$EverythingOk=false;
					$_SESSION['settings_validation_error_n']='<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:4.5rem; font-size:14px;">Ta nazwa użytkownika jest już zajęta!</div>';
				}
				
			
					if ($EverythingOk == true)
					{
						if ($conn->query("UPDATE users SET nickname ='$nickname' WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['updated_successfully_nickname'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:3.5rem; font-size:14px;">Twoja nazwa użytkownika została zaktualizowane poprawnie!</div>';
						}
						
						if ($result = $conn->query("SELECT nickname FROM users WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['is_updated_nickname']=True;
							
							$updated_nickname = $result ->fetch_assoc();
							$_SESSION['updated_nickname'] = $updated_nickname['nickname'];
									
							$result->free_result();

							header('Location: ../settings.php');	
						}
							else
						{
							throw new Exception($conn->error);
						}
					}
					
				header('Location: ../settings.php');	
				$conn->close();
			}
			
			
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Error! ";
		}
	}

?>

<?php
	
	if (isset($_POST['FormStart-email']))
	{
		$EverythingOk=true;
		
		$current_user_id = $_SESSION['id_user'];
		
		$email = $_POST['email'];
		$emailCHECK = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailCHECK, FILTER_VALIDATE_EMAIL)==false) || ($emailCHECK!=$email))
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_email']='<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:2.5rem; font-size:14px;">Podano nieprawidłowy adres e-mail!</div>';
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
				$rezultat = $conn->query("SELECT id_user FROM users WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($conn->error);
				
				$walidacja = $rezultat->num_rows;

				if($walidacja>0)
				{
					$EverythingOk=false;
					$_SESSION['settings_validation_error_email']='<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:4.5rem; font-size:14px;">Ten adres e-mail jest już zajęty!</div>';
				}
				
			
					if ($EverythingOk == true)
					{
						if ($conn->query("UPDATE users SET email ='$email' WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['updated_successfully_email'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:3.5rem; font-size:14px;">Adres e-mail został zaktualizowany!</div>';
						}
						
						if ($result = $conn->query("SELECT email FROM users WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['is_updated_email']=True;
							
							$updated_email = $result ->fetch_assoc();
							$_SESSION['updated_email'] = $updated_email['email'];
									
							$result->free_result();

							header('Location: ../settings.php');	
						}
							else
						{
							throw new Exception($conn->error);
						}
					}
					
				header('Location: ../settings.php');	
				$conn->close();
			}
			
			
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Error! ";
		}
	}

?>

<?php
	
	if (isset($_POST['FormStart-AccVerify']))
	{
		
		$user_id = $_SESSION['id_user'];
		$user_name = $_SESSION['imie'];
		$user_lastname= $_SESSION['nazwisko'];
		
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
				$to = "dawid.brodecki96@gmail.com";
				$subject = "HTML email";
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				
				$headers .= 'From Olympus: Request for account verification from ID user: '. $user_id .'' . "\r\n";

				$message = "
				<html>
					<head>
						<title>New message from website contact form</title>
					</head>
					<body>
					<h1> Request for account verification from ID user: ". $user_id ."</h1>
						<p>User ".$user_name." ".$user_lastname." and ID number ". $user_id .", sent a request for account verification.</p>
					</body>
				</html>";
  
  
					if (mail($to,$subject,$message,$headers))
					{
					   $_SESSION['sent_request_success'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:3.5rem; font-size:14px;">Prośba o weryfikację została przesłana!</div>';
					}
					 else
					 {
					   $_SESSION['sent_request_fail']='<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:0.5rem; font-size:14px;">Błąd, prosimy spróbować później!</div>';
					 }
					
				header('Location: ../settings.php');	
				$conn->close();
			}
			
			
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Error! ";
		}
	}

?>


<?php
	
	if (isset($_POST['FormStart-password']))
	{
			
		require_once "connect.php";
		$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
		
		$EverythingOk=true;
		
		$current_user_id = $_SESSION['id_user'];
		$pass_from_db = $_SESSION['haslo'];
		//	$unhashed_password= $_SESSION['password_unhashed'];

		
		$check_current_password = $_POST['check_current_password'];
		$new_password = $_POST['new_password'];
		$password_repeat = $_POST['password_repeat'];
		
		$sql_query_pass = "SELECT haslo FROM users WHERE id_user = $current_user_id";
		
		/*if ($result = $conn->query($sql_query_pass))
		{
			$fetch_password = $result ->fetch_assoc();
			
			$password_unhashed = password_verify($_SESSION['pass_login'], $fetch_password['haslo']);
			
			$_SESSION['password'] = $fetch_password['haslo'];
			$_SESSION['unhashed_password'] = $password_unhashed;
									
			$result->free_result();
		}*/
		
		if (password_verify($check_current_password, $_SESSION['haslo']))
				{
		
						if ((strlen($new_password)<3) || (strlen($new_password)>20))
						{
							$EverythingOk=false;
							$_SESSION['settings_validation_error_password']='<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:2.5rem; font-size:14px;">Hasło musi posiadać od 3 do 20 znaków!</div>';
						}
		
		
						if (($new_password != $password_repeat) && ($password_repeat != $new_password))
						{
							$EverythingOk=false;
							$_SESSION['settings_validation_error_password'] = '<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:2.5rem; font-size:14px;">Podane hasła nie są identyczne!</div>';
						}	
						
						$password_hash = password_hash($new_password, PASSWORD_DEFAULT);
				}
				else 
				{
					$EverythingOk=false;
					$_SESSION['settings_validation_error_password']='<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:2.5rem; font-size:14px;">Podano nieprawidłowe aktualne hasło!</div>';
				}
		

		

	
		try 
		{
			
			if ($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}

			
					if ($EverythingOk == true)
					{
						if ($conn->query("UPDATE users SET haslo ='$password_hash' WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['updated_successfully_password'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:3.5rem; font-size:14px;">Hasło zostało zaktualizowane!</div>';
						}
						
						if ($result = $conn->query("SELECT haslo FROM users WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['is_updated_password']=True;
							
							$updated_password = $result ->fetch_assoc();
							$_SESSION['updated_password'] = $updated_password['haslo'];
									
							$result->free_result();

							header('Location: ../settings.php');	
						}
							else
						{
							throw new Exception($conn->error);
						}
					}

						header('Location: ../settings.php');	
						$conn->close();
					
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Error! ";
		}
	}

?>

<?php
	
	if (isset($_POST['FormStart-country']))
	{
			
		require_once "connect.php";
		$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
		
		$EverythingOk=true;
		
		$current_user_id = $_SESSION['id_user'];
		
		$country = $_POST['country'];
		$checkbox_country = $_POST['checkbox_country'];
		
		
		if((preg_match('/^[A-PR-UWY-ZĄĆĘŁŃÓŚŹŻQXV]*$/iu',$country)==false) || ((strlen($country)<3) || (strlen($country)>20)))
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_country']= '<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:2rem; font-size:13px;">Nazwa kraju może składać się tylko z liter alfabetu o długości od 3 do 20 znaków!</div>';
		}
		
		if (isset($_POST['checkbox_country']))
		{
			$EverythingOk=true;
			$_SESSION['settings_validation_error_country']= '';
		}
			
	
		try 
		{
			
			if ($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
					if ($EverythingOk == true)
					{
						if (isset($_POST['checkbox_country']))
						{
							$conn->query("Update users SET kraj='Brak danych' WHERE id_user=$current_user_id");
							$_SESSION['updated_successfully_country'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:3.5rem; font-size:14px;">Informacje o kraju zostały ukryte!</div>';
						}
						else
						{
							$conn->query("Update users SET kraj='$country' WHERE id_user=$current_user_id");
							$_SESSION['updated_successfully_country'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:3.5rem; font-size:14px;">Informacje o kraju zostały zaktualizowane!</div>';
						}
						
						if ($result = $conn->query("SELECT kraj FROM users WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['is_updated_country']=True;
							
							$updated_country = $result ->fetch_assoc();
							$_SESSION['updated_country'] = $updated_country['kraj'];
									
							$result->free_result();

							header('Location: ../settings.php');	
						}
							else
						{
							throw new Exception($conn->error);
						}
					}

						header('Location: ../settings.php');	
						$conn->close();
					
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Error! ";
		}
	}

?>

<?php
	
	if (isset($_POST['FormStart-gender']))
	{
			
		require_once "connect.php";
		$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
		
		$EverythingOk=true;
		
		$current_user_id = $_SESSION['id_user'];
		
		$gender = $_POST['gender'];

		if (empty($gender))
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_gender']='<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:14px;">Musisz wybrać jedną z opcji!</div>';
		}		
		
		
		try 
		{
			
			if ($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
					
					if ($EverythingOk == true)
					{
						if ($conn->query("UPDATE users SET plec ='$gender' WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['updated_successfully_gender'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:14px;">Informacje o płci zostały zaktualizowane!</div>';
						}
						
						if ($result = $conn->query("SELECT plec FROM users WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['is_updated_gender']=True;
							
							$updated_gender = $result ->fetch_assoc();
							$_SESSION['updated_gender'] = $updated_gender['plec'];
									
							$result->free_result();

							header('Location: ../settings.php');	
						}
							else
						{
							throw new Exception($conn->error);
						}
					}

						header('Location: ../settings.php');	
						$conn->close();
					
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Error! ";
		}
	}

?>

<?php
	
	if (isset($_POST['FormStart-living']))
	{
			
		require_once "connect.php";
		$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
		
		$EverythingOk=true;
		
		$current_user_id = $_SESSION['id_user'];
		
		$living = $_POST['living'];
		$checkbox_living = $_POST['checkbox_living'];
		
		
		if((preg_match('/^[A-PR-UWY-ZĄĆĘŁŃÓŚŹŻQXV]*$/iu',$living)==false) || ((strlen($living)<3) || (strlen($living)>20)))
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_living']= '<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:13px;">Nazwa miasta może składać się tylko z liter alfabetu o długości od 3 do 20 znaków!</div>';
		}
		
		if (isset($_POST['checkbox_living']))
		{
			$EverythingOk=true;
			$_SESSION['settings_validation_error_living']= '';
		}
			

		try 
		{
			
			if ($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
					if ($EverythingOk == true)
					{
						if (isset($_POST['checkbox_living']))
						{
							$conn->query("Update users SET zamieszkuje='Brak danych' WHERE id_user=$current_user_id");
							$_SESSION['updated_successfully_living'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:14px;">Informacje o miejscu zamieszkania zostały ukryte!</div>';
						}
						else
						{
							$conn->query("Update users SET zamieszkuje='$living' WHERE id_user=$current_user_id");
							$_SESSION['updated_successfully_living'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:14px;">Informacje o miejscu zamieszkania zostały zaktualizowane!</div>';
						}
						
						if ($result = $conn->query("SELECT zamieszkuje FROM users WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['is_updated_living']=True;
							
							$updated_living = $result ->fetch_assoc();
							$_SESSION['updated_living'] = $updated_living['zamieszkuje'];
									
							$result->free_result();

							header('Location: ../settings.php');	
						}
							else
						{
							throw new Exception($conn->error);
						}
					}

						header('Location: ../settings.php');	
						$conn->close();
					
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Error! ";
		}
	}

?>

<?php
	
	if (isset($_POST['FormStart-work']))
	{
			
		require_once "connect.php";
		$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
		
		$EverythingOk=true;
		
		$current_user_id = $_SESSION['id_user'];
		
		$work = $_POST['work'];
		$checkbox_work = $_POST['checkbox_work'];
		
		
		if((preg_match('/^[A-PR-UWY-ZĄĆĘŁŃÓŚŹŻQXV]*$/iu',$work)==false) || ((strlen($work)<3) || (strlen($work)>20)))
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_work']= '<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:13px;">Nazwa pracy może składać się tylko z liter alfabetu o długości od 3 do 20 znaków!</div>';
		}
		
		if (isset($_POST['checkbox_work']))
		{
			$EverythingOk=true;
			$_SESSION['settings_validation_error_work']= '';
		}
			

		try 
		{
			
			if ($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
					if ($EverythingOk == true)
					{
						if (isset($_POST['checkbox_work']))
						{
							$conn->query("Update users SET praca='Brak danych' WHERE id_user=$current_user_id");
							$_SESSION['updated_successfully_work'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:14px;">Informacje o pracy zamieszkania zostały ukryte!</div>';
						}
						else
						{
							$conn->query("Update users SET praca='$work' WHERE id_user=$current_user_id");
							$_SESSION['updated_successfully_work'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:14px;">Informacje o pracy zamieszkania zostały zaktualizowane!</div>';
						}
						
						if ($result = $conn->query("SELECT praca FROM users WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['is_updated_work']=True;
							
							$updated_work = $result ->fetch_assoc();
							$_SESSION['updated_work'] = $updated_work['praca'];
									
							$result->free_result();

							header('Location: ../settings.php');	
						}
							else
						{
							throw new Exception($conn->error);
						}
					}

						header('Location: ../settings.php');	
						$conn->close();
					
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Error! ";
		}
	}

?>

<?php
	
	if (isset($_POST['FormStart-school']))
	{
			
		require_once "connect.php";
		$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
		
		$EverythingOk=true;
		
		$current_user_id = $_SESSION['id_user'];
		
		$school = $_POST['school'];
		$checkbox_school = $_POST['checkbox_school'];
		
		
		if((preg_match('/^[A-PR-UWY-ZĄĆĘŁŃÓŚŹŻQXV]*$/iu',$school)==false) || ((strlen($school)<3) || (strlen($school)>20)))
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_school']= '<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:13px;">Nazwa szkoły może składać się tylko z liter alfabetu o długości od 3 do 20 znaków!</div>';
		}
		
		if (isset($_POST['checkbox_school']))
		{
			$EverythingOk=true;
			$_SESSION['settings_validation_error_school']= '';
		}
			

		try 
		{
			
			if ($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
					if ($EverythingOk == true)
					{
						if (isset($_POST['checkbox_school']))
						{
							$conn->query("Update users SET szkola='Brak danych' WHERE id_user=$current_user_id");
							$_SESSION['updated_successfully_school'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:14px;">Informacje o szkole zostały ukryte!</div>';
						}
						else
						{
							$conn->query("Update users SET szkola='$school' WHERE id_user=$current_user_id");
							$_SESSION['updated_successfully_school'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:14px;">Informacje o szkole zostały zaktualizowane!</div>';
						}
						
						if ($result = $conn->query("SELECT szkola FROM users WHERE id_user = '$current_user_id'"))
						{
							$_SESSION['is_updated_school']=True;
							
							$updated_school = $result ->fetch_assoc();
							$_SESSION['updated_school'] = $updated_school['szkola'];
									
							$result->free_result();

							header('Location: ../settings.php');	
						}
							else
						{
							throw new Exception($conn->error);
						}
					}

						header('Location: ../settings.php');	
						$conn->close();
					
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Error! ";
		}
	}

?>

<?php
	
	if (isset($_POST['FormStart-block']))
	{
			
		require_once "connect.php";
		$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
		
		$EverythingOk=true;
		
		$current_user_id = $_SESSION['id_user'];
		
		$block = $_POST['block'];
		
		if((preg_match('/^[A-PR-UWY-ZĄĆĘŁŃÓŚŹŻQXV]*$/iu',$block)==false) || ((strlen($block)<3) || (strlen($block)>20)))
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_block']= '<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:13px;">Nazwa użytkownika może składać się tylko z liter alfabetu o długości od 3 do 20 znaków!</div>';
		}
		
		$rezultat = $conn->query("SELECT nickname FROM users WHERE nickname='$block'");
		$rezultat2 = $conn->query("SELECT blocked_user FROM blocked WHERE blocked_user='$block' AND id_user=$current_user_id");
		if (!$rezultat) throw new Exception($conn->error);
		if (!$rezultat2) throw new Exception($conn->error);
				
		$chceck_did_exist = $rezultat->num_rows;
		$chceck_did_exist2 = $rezultat2->num_rows;
		
		if ($chceck_did_exist < 1)
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_block']= '<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:13px;">Taki użytkownik nie istnieje!</div>';
		}
		
		if ($chceck_did_exist2 > 0)
		{
			$EverythingOk=false;
			$_SESSION['settings_validation_error_block']= '<div style="color:red; text-align:center; font-weight:550; margin-top:1rem; margin-left:rem; font-size:13px;">Ten użytkownik jest już zablokowany!</div>';
		}

		try 
		{
			
			if ($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
					if ($EverythingOk == true)
					{
						if ($conn->query("INSERT INTO blocked VALUES (NULL, $current_user_id, '$block')"))
						{
							$conn->query("DELETE FROM relations WHERE id_user=$current_user_id AND friend_nickname='$block'");
							$_SESSION['updated_successfully_block'] = '<div style="color:green; text-align:center; font-weight:550; margin-top:1rem; margin-left:4rem; font-size:14px;">Użytkownik '. '<span style="font-weight:850;">@'.$block.'</span>'.' został zablokowany!</div>';
							header('Location: ../settings.php');	
						}
							else
						{
							throw new Exception($conn->error);
						}
					}

						header('Location: ../settings.php');	
						$conn->close();
					
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Error! ";
		}
	}

?>