<?php

	session_start();
	
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['registration_success']);
	}
	
	if (isset($_SESSION['relogin'])) unset($_SESSION['relogin']);
	if (isset($_SESSION['remember_lastname'])) unset($_SESSION['remember_lastname']);
	if (isset($_SESSION['remember_nickname'])) unset($_SESSION['remember_nickname']);
	if (isset($_SESSION['remember_email'])) unset($_SESSION['remember_email']);
	if (isset($_SESSION['remember_date'])) unset($_SESSION['remember_date']);
	if (isset($_SESSION['remember_gender'])) unset($_SESSION['remember_gender']);
	if (isset($_SESSION['repassword'])) unset($_SESSION['repassword']);
	if (isset($_SESSION['repassword_repeat'])) unset($_SESSION['repassword_repeat']);
	
	if (isset($_SESSION['e_name'])) unset($_SESSION['e_name']);
	if (isset($_SESSION['e_lastname'])) unset($_SESSION['e_lastname']);
	if (isset($_SESSION['e_nickname'])) unset($_SESSION['e_nickname']);
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if (isset($_SESSION['e_password'])) unset($_SESSION['e_password']);
	if (isset($_SESSION['e_gender'])) unset($_SESSION['e_gender']);
	if (isset($_SESSION['e_date'])) unset($_SESSION['e_date']);
	if (isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
	

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title> Olympus | Logowanie</title>
	<meta name="description" content="Olympus - projekt serwisu społecznościowego jako propozycja pracy magisterskiej."/>
	<meta name="keywords" content="Portal spolecznosciowy, komunikator, znajomi, wiadomosci"/>
	<meta charset="utf-8">
	<meta name="author" content="Dawid Brodecki" />
	<meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1"/>
	<meta http-equiv="cache-control" content="no-cache">
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/validation.css">
	<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    
</head>
<body>

<div class="main" >

      
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="img/signin-image.jpg" alt="sing up image"></figure>
                        <div style="text-align:center;">
							<a href="registration.php" class="signup-image-link">Stwórz konto</a>
						</div>
                    </div>

                    <div class="signin-form" style="padding-top:1.2rem;">
                        <h2 class="form-title">Zaloguj si<span style="font-family:helvetica; font-weight:550;">ę</span></h2>
                        <form method="POST" action="php/login.php" class="register-form validate-form" id="login-form">
                            
							<div class="form-group validate-input"> <!-- Login -->
                             <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="login"  class="input100" id="login" placeholder="Twój login" />
                            </div> <!-- Login -->
							
                            <div class="form-group validate-input"> <!-- Password -->
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
								<span class="btn-show-pass"> 
									<i class="fa fa-eye"></i>
								</span>
                                <input type="password" name="password"  id="your_pass" class="input100" placeholder="Twoje hasło"/>
                            </div> <!-- Password -->
							
                            <div class="form-group"> <!-- Remember me -->
                                <input type="checkbox" name="remember" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term" style="font-family:Segoe UI;"><span><span></span></span  >Zapamiętaj mnie</label>
                            </div> <!-- Remember me -->
							
                            <div class="form-group form-button"> <!-- Login Button -->
                                <input type="submit" name="signin" id="signin" class="form-submit" style="font-family:arial;" value="Zaloguj się">
                            </div> <!-- Login Buttom -->
							
                        </form>
						
						<div style="padding-top:.6rem;">
						
							<?php
									if (isset($_SESSION['blad']))
									{
										echo $_SESSION['blad'];
									unset($_SESSION['blad']);
									}
									
								echo "<div style='color:green; font-family:Segoe UI, Helvetica, Arial, sans-serif; font-weight:550; font-size:15px; '>";
									if (isset($_SESSION['registration_success_popup']))
									{
										echo $_SESSION['registration_success_popup'];
										unset($_SESSION['registration_success_popup']);
									}	
									echo "</div>";
							?>
						</div>
						
                    </div>
                </div>
            </div>
        </section>
			<script src="js/jquery-3.2.1.min.js"></script>
			<script src="js/validation.js"></script>
			<script src="js/rememberme.js"></script>
			
    </div>


</body>
</html>
