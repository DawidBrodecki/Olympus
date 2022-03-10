<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: index.php');
		exit();
	}
	
	if (isset($_POST['signup']))
	{
		$DataCorrectness=true;
		
		$name = $_POST['name'];

		if (((strlen($name)<3) || (strlen($name)>20)) || (preg_match('/^[A-PR-UWY-ZĄĆĘŁŃÓŚŹŻ0-9QXV]*$/iu',$name)==false))
		{
			$DataCorrectness=false;
			$_SESSION['e_name']=" Dozwolone tylko litery oraz cyfry o długości od 3 do 20 znaków!";
		}
		
		$lastname = $_POST['lastname'];

		if (((strlen($lastname)<3) || (strlen($lastname)>20)) || (preg_match('/^[A-PR-UWY-ZĄĆĘŁŃÓŚŹŻ0-9QXV]*$/iu',$lastname)==false))
		{
			$DataCorrectness=false;
			$_SESSION['e_lastname']="Dozwolone tylko litery oraz cyfry o długości od 3 do 20 znaków!";
		}
		
		$nickname = $_POST['nickname'];

		if (ctype_alnum($nickname)==false)
		{
			$DataCorrectness=false;
			$_SESSION['e_nickname']="Nazwa użytkownika nie może zawierać niedozwolonych znaków!";
		}
		
		if ((strlen($nickname)<3) || (strlen($nickname)>20))
		{
			$DataCorrectness=false;
			$_SESSION['e_nickname']="Nazwa użytkownika musi posiadać od 3 do 20znaków!";
		}
		
		
		$email = $_POST['email'];
		$emailCHECK = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailCHECK, FILTER_VALIDATE_EMAIL)==false) || ($emailCHECK!=$email))
		{
			$DataCorrectness=false;
			$_SESSION['e_email']="Podano niepoprawny adres e-mail!";
		}
		
		
		$password = $_POST['password'];
		$password_repeat = $_POST['password_repeat'];
		
		if (($password != $password_repeat) && ($password_repeat != $password))
		{
			$DataCorrectness=false;
			
			$_SESSION['e_password'] = "Podane hasła nie są identyczne!";	 
		}	
		
		if (empty($password))
		{
			$DataCorrectness=false;
			$_SESSION['e_password']="Nie podano hasła!";
		}	

		@$gender = $_POST['gender'];	

		if (empty($gender))
		{
			$DataCorrectness=false;
			$_SESSION['e_gender']="Musisz podać płeć!";
		}	
		
		$date = $_POST['date'];	
		
		if (empty($date))
		{
			$DataCorrectness=false;
			$_SESSION['e_date']="Musisz podać datę urodzenia!";
		}	
		
			$registraiontime = date('Y-m-d');

	
		
		if (!isset($_POST['regulamin']))
		{
			$DataCorrectness=false;
			$_SESSION['e_regulamin']="Musisz zaakceptować regulamin!";
		}	
		
		
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		
	
		$_SESSION['remember_name'] = $name;
		$_SESSION['remember_lastname'] = $lastname;
		$_SESSION['remember_nickname'] = $nickname;
		$_SESSION['remember_email'] = $email;
		$_SESSION['remember_date'] = $date;
		$_SESSION['remember_gender'] = $gender;
		$_SESSION['remember_password'] = $password;
		$_SESSION['remember_password_repeat'] = $password_repeat;

		
		require_once "php/connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$conn = new mysqli($serverhost, $db_admin, $db_password, $database);
			if ($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$rezultat = $conn->query("SELECT id_user FROM users WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($conn->error);
				
				$ile_takich_maili = $rezultat->num_rows;

				if($ile_takich_maili>0)
				{
					$DataCorrectness=false;
					$_SESSION['e_email']="Ten e-mail jest już zajęty!";
				}

				
				$rezultat = $conn->query("SELECT id_user FROM users WHERE nickname='$nickname'");
				
				if (!$rezultat) throw new Exception($conn->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				
				if($ile_takich_nickow>0)
				{
					$DataCorrectness=false;
					$_SESSION['e_nickname']="Istnieje już konto o podanej nazwie!.";
				}
				
					if ($DataCorrectness == true)
					{
						if ($conn->query("INSERT INTO users VALUES (NULL, '$name', '$lastname', '$nickname', '$email', '$date', '$gender', '$password_hash', '$registraiontime', 'Brak danych', 'Brak danych', 'Brak danych', 'Brak danych', '', '', 0, 'nie')"))
						{
							$conn->query ("UPDATE placeholders, users SET users.user_avatar=placeholders.img WHERE placeholders.id_placeholder=1 AND users.nickname='$nickname'");
							$conn->query ("UPDATE placeholders, users SET users.user_backgroundphoto=placeholders.img WHERE placeholders.id_placeholder=2 AND users.nickname='$nickname'");
							
								$_SESSION['registration_success'] = true;
								$_SESSION['registration_success_popup'] = "Rejestracja przebiegła pomyślnie, możesz teraz zalogować się na swoje konto! ";
								header('Location: signin.php');
							
						}
							else
						{
							throw new Exception($conn->error);
						}
					}
					
				$conn->close();
			}	
			
			
		}
		catch(Exception $e)
		{
			$_SESSION['e_exception'] = "Błąd serwera! Przepraszamy i prosimy spróbować za chwilę! ".$e; 
		}
	}

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title> Olympus | Rejestracja</title>
	<meta name="description" content="Olympus - projekt serwisu społecznościowego jako propozycja pracy magisterskiej."/>
	<meta name="keywords" content="Portal spolecznosciowy, komunikator, znajomi, wiadomosci"/>
	<meta charset="utf-8">
	<meta name="author" content="Dawid Brodecki" />
	<meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1"/>
	<meta http-equiv="cache-control" content="no-cache">
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/validation.css">
	
</head>
<body >

    <div class="main">

        <section class="signup">
            <div class="container">

                <div class="signup-content" >
                    <div class="signup-form" style="font-family:arial;">
                        <h2 class="form-title">Rejestracja</h2>
                        <form method="POST" class="register-form validate-form" id="register-form">
						
		
                           <div class="form-fullname validate-input" >
								<input type="text" class="font input100" name="name" value="<?php if (isset($_SESSION['remember_name'])) {echo $_SESSION['remember_name']; unset($_SESSION['remember_name']);}?>" placeholder="Imię" class="form-control">
								<input type="text" class="font input100" name="lastname" value="<?php if (isset($_SESSION['remember_lastname'])) {echo $_SESSION['remember_lastname']; unset($_SESSION['remember_lastname']);}?>" placeholder="Nazwisko" class="form-control">
							</div>
								<?php echo "<div class=''>";
									if (isset($_SESSION['e_name']))
									{
										echo '<div class="error">'.$_SESSION['e_name'].'</div>';
										unset($_SESSION['e_name']);
									}
								echo "</div>";?>
                            <div class="form-group validate-input">
                                <label for="nickname"><i class="zmdi zmdi-account"></i></label>
                                <input type="text" name="nickname" value="<?php if (isset($_SESSION['remember_nickname'])) {echo $_SESSION['remember_nickname']; unset($_SESSION['remember_nickname']);}?>" id="nickname" class="font input100" placeholder="Nazwa użytkownika"/>
							</div> 
								<?php echo "<div class=''>";
									if (isset($_SESSION['e_nickname']))
									{
										echo '<div class="error">'.$_SESSION['e_nickname'].'</div>';
										unset($_SESSION['e_nickname']);
									}
								echo "</div>";?>
							
							<div class="form-group validate-input">
                                <label  for="email"><i class="zmdi zmdi-email"></i></label> 
                             <input type="email" name="email" value="<?php if (isset($_SESSION['remember_email'])) {echo $_SESSION['remember_email']; unset($_SESSION['remember_email']);}?>" id="email" class="font input100" placeholder="Twój email" />
						   </div>
								<?php echo "<div class=''>";
									if (isset($_SESSION['e_email']))
									{
										echo '<div class="error">'.$_SESSION['e_email'].'</div>';
										unset($_SESSION['e_email']);
									}
								echo "</div>";?>
								
							<div class="form-group validate-input">
                                <label for="date"><i class="zmdi zmdi-calendar-alt"></i></label>
                                <input type="date" name="date"value="<?php if (isset($_SESSION['remember_date'])) {echo $_SESSION['remember_date']; unset($_SESSION['remember_date']);}?>" id="date" class="font input100" placeholder="Twoja data urodzenia"/></span> 
						  </div>
								<?php echo "<div class=''>";
									if (isset($_SESSION['e_date']))
									{
										echo '<div class="error">'.$_SESSION['e_date'].'</div>';
										unset($_SESSION['e_date']);
									}
								echo "</div>";?>
							<div class="form-group validate-input">
							 <label for="gender"><i class="zmdi zmdi-caret-down" style="font-size: 17px"></i></label>
								<select name="gender" id="" class="form-control "  >
									<option value="" disabled selected class="font input100">Płeć</option>								
									<option value="Mężczyzna" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Mężczyzna') ? 'selected="selected"': ''; ?>>Mężczyzna</option>
									<option value="Kobieta" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Kobieta') ? 'selected="selected"': ''; ?>>Kobieta</option>
								</select>
							</div>
								<?php echo "<div class=''>";
									if (isset($_SESSION['e_gender']))
									{
										echo '<div class="error">'.$_SESSION['e_gender'].'</div>';
										unset($_SESSION['e_gender']);
									}
								echo "</div>";?>
							
                            <div class="form-group validate-input">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
								<span class="btn-show-pass">
									<i class="fa fa-eye"></i>
								</span>
                                <input type="password" name="password" value="<?php if (isset($_SESSION['remember_password'])) {echo $_SESSION['remember_password']; unset($_SESSION['remember_password']);}?>" id="pass" class="font input100" placeholder="Hasło" />
                            </div>
								<?php echo "<div class=''>";
									if (isset($_SESSION['e_password']))
									{
										echo '<div class="error">'.$_SESSION['e_password'].'</div>';
										unset($_SESSION['e_password']);
									}
								echo "</div>";?>
							
                            <div class="form-group validate-input">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
								<span class="btn-show-pass">
									<i class="fa fa-eye"></i>
								</span>
                                <input type="password" name="password_repeat" value="<?php if (isset($_SESSION['remember_password_repeat'])) {echo $_SESSION['remember_password_repeat']; unset($_SESSION['remember_password_repeat']);}?>" id="re_pass" class="font input100" placeholder="Powtórz hasło"/>
                            </div>
							
                            <div class="form-group">
                                <input type="checkbox" name="regulamin" id="agree-term" class="agree-term " >
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>Zgadzam się z zasadami <a href="#" class="term-service">Regulaminu</a></label>
                            </div>
						
							<?php 
							echo "<div class='error' style='margin-top:-22px; padding-bottom:10px;'>";
									if (isset($_SESSION['e_regulamin']))
									{
										echo '<div >'.$_SESSION['e_regulamin'].'</div>';
										unset($_SESSION['e_regulamin']);
									}
								echo "</div>";
								?>
                            <div class="form-group form-button" style="margin-top:-20px;">
                                <input type="submit" name="signup" id="signup" class="form-submit " value="Zarejestruj się"/>
                            </div>
							
                        </form>
                    </div>
					
                    <div class="signup-image" style="padding-top:10px;">
                        <figure><img src="img/signup-image.jpg" alt="sing up image"></figure>
                        <div style="text-align:center;">
						<a href="signin.php" class="signup-image-link">Posiadam już konto</a>
						</div>
                    </div>
                </div>
            </div>
        </section>
			<script src="js/jquery-3.2.1.min.js"></script>
			<script src="js/validation.js"></script>
	</div>
	


</body>
</html>