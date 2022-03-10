<?php

	session_start();
	
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: signin.php');
		exit();
	}
	
?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title> Olympus | Ustawienia</title>
	<meta name="description" content="Olympus - projekt serwisu społecznościowego jako propozycja pracy magisterskiej."/>
	<meta name="keywords" content="Portal spolecznosciowy, komunikator, znajomi, wiadomosci"/>
	<meta charset="utf-8">
	<meta name="author" content="Dawid Brodecki" />
	<meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1"/>
	<meta http-equiv="cache-control" content="no-cache">
	<link rel="stylesheet" href="css/body.css" type="text/css"/>
	<link rel="stylesheet" href="css/header.css" type="text/css"/>
	<link rel="stylesheet" href="css/search.css" type="text/css"/>
	<link rel="stylesheet" href="css/settings.css" type="text/css"/>
	<link rel="stylesheet" href="css/invitation.css" type="text/css">
		<link rel="stylesheet" href="css/modal.css" type="text/css">
	<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css'>
	<script src="https://kit.fontawesome.com/b0413121fe.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	

</head>


<body>

<div id="container">

	<div id="header" style="top:0;" class="sticky">
		<div class="header-left_section">
				<div class="logo">
					<a href="index.php">
						<div class="logo-image"><img src="img/logo.png" height="90px" width="108px"></div>
						<div class="logo-caption"><span style="font-size:50px;">O</span><span style="	font-size:45px;">lympus</span></div>
						</a>
				</div>
			
			<div id="search-header">
					<div style="float:left"><i class="fas fa-search fa-2x" style="margin-left:8px; padding-top:1rem; color: #818181;"></i></div>
					<div style="float:left"><input  id="search" class="search" name="search" type="search" placeholder="Przeszukaj Olympusa..."   autocomplete="off" novalidate /></div>
					<div style="clear:both;"></div>
				<div id="display_search"></div>
			</div>
		</div>
		
		<div class="header-middle_section">
			<div class="MainPageBtn">
				<div class="tooltip"><a href="index.php"><i class="fas fa-home fa-6x MainButton2" id="MainButton" ></i></a><span class="tooltiptext">Strona Główna</span></div>
			</div>
		</div>
		
		<div class="header-right_section">
			
			<div id="nav">
				<ul>
					<li class="linav"><a class="NavStyle" href="user-profile.php"><i class="fas fa-house-user"></i>&nbsp;Profil</a></li><span style="color:white; cursor:default;">|</span>
					<li class="linav"><a class="NavStyle"><button id="myBtn"><i class="fas fa-user-plus"></i>&nbsp;Zaproszenia&nbsp;<span id="InvitationsNumber"><?php echo $_SESSION['number_of_invitations']; ?></span></button></a></li><span  style="color:white; cursor:default;">|</span>
					<li class="linav"><a class="NavStyle navpicked" href="settings.php"><i class="fas fa-user-cog"></i>&nbsp;Ustawienia</a></li><span  style="color:white; cursor:default;">|</span>
					<li class="linav"><a class="NavStyle" href="php/logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Wyloguj</a></li>
				</ul>
			</div>

		<div style="clear:both;"></div>
		
		<a href="user-profile.php"><div id="WelcomingBox">
			<div class="UserPhoto">
				<?php 
					if(@$_SESSION['zaktualizowano_avatar']!=TRUE)
					{
						echo '<img class="borderradius" height="40px" width="40px"  src="data:image/jpeg;base64,'.base64_encode($_SESSION['user_avatar']).'">';
					}
					else
					{
						echo '<img class="borderradius" height="40px" width="40px" src="data:image/jpeg;base64,'.base64_encode($_SESSION['new_avatar']).'">';
					}		
				?>
			</div>
			<div id="UserName">Witaj! <?php echo $_SESSION['imie']; ?></div>
		</div></a>
		
		<div style="clear:both;"></div>
		</div>
		
	</div>
	
		<div style="clear:both;"></div>
	
		<div class="main" style="margin-top:5rem;" id="outgoing_invitations">
		<div style="float:left; margin-top:-1px;" > 
			<div class="tooltip_global" style="z-index:1;" ><button id="TogleToIncoming" class="ButtonGlobal" style="margin-left:-6px;"><div class="InvitationsChoose InvitationsChoose1 CloseOutgoing" ><i class="fas fa-envelope-open-text"></i><span class="tooltiptext_global" style="margin-left:1.3rem;  font-size: 13px; width:170px;">Zaproszenia przychodzące</span></div></button></div>
			<div class="tooltip_global" ><div class="InvitationsChoose" style="margin-left:-2px; background-color:#3A7CD4;  cursor:default"><i class="far fa-paper-plane"></i><span class="tooltiptext_global" style="margin-left:1.3rem;  font-size: 15.5px;  width:175px;">Zaproszenia wychodzące</span></div></div>

		</div>
		<span style="" class="closenow closeX2">&times;</span>
		<div style="clear:both;"></div>

		<?php 	
		
			require_once "php/connect.php";
			$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
									
			$current_user_id = $_SESSION['id_user'];
			$sql = "SELECT users.imie, users.nazwisko, users.nickname, users.user_avatar, users.id_user FROM users, invitations WHERE invitations.invated_user_id=users.id_user AND invitations.id_inviting_user=$current_user_id";
			
			$check_validation = $conn->query($sql);
								
			if ($check_validation->num_rows > 0) 
			{

					while($row = $check_validation->fetch_assoc()) 
					{

					$_SESSION['cancel_the_invitation_by_user_id'] = $row['id_user'];
					
					echo
					$row['id_user'].
					'<div class="request" style="margin-top:5px; ">'.
						'<div class="" style=" float:left; max-width:80%; width:80%; padding:12px; border-right: 1px solid gray; ">'.	
							'<div  class="" id="left" style="">'.
								'<div style="">'.
									"<div class='rightbar-contacts '>".
										'<div class="rightbar-contacts-image">'.'<img class="borderradius" height="42px" width="42px"  src="data:image/jpeg;base64,'.base64_encode($row['user_avatar']).'">'."</div>".'<div class="rightbar-contacts-user">'.$row["imie"]." ".$row["nazwisko"]." "."<span style='font-size:1.6rem; color:#b0b3b8; font-style:italic;'>@".$row['nickname']."</span>"."</div>"."<br>".
									"</div>".		
								'</div>'.
							'<div style="clear:both;"></div>'.
						'</div>'.
					'</div>'.
						
					'<div class="" style=" float:left; max-width:20%; width:20%; position:relative ">'.	
						'<div style="text-align:center; position:relative; top: 3.1rem; ">
							<div class="tooltip_global" ><a href="php/cancel_the_invitation_by_user_id.php"><div class="AcceptOrReject" style="padding:4.5px 9px; background-color:red;"><i class="fas fa-times"></i><span class="tooltiptext_global" style="margin:-0.35rem 0rem 0rem 1.1rem;  width:55px; font-weight:550;">Anuluj</span></div></a></div>
						</div>'.
					'</div>'.

			'<div style="clear:both;"></div>'.
		'</div>';
		
				}
			}
			else
		{
			echo '<div class="NoFriends">Nikogo jeszcze nie zaproszono :(</div>';
		}
	
	?>

	</div>

		<div id="modalBox_confirm_delete" class="modal">
		  <div class="modal-content">
			<div class="modal-header">
			  <span class="closeBox">&times;</span>
			  <div style="font-size:2.4rem; font-weight:550; font-family:Segoe UI; padding:10px; color:#e3e3e3;">Zaktualizuj zdjęcie profilowe:</div>
			  	<form enctype="multipart/form-data" action="php/img_upload.php" method="post" >
					<div style="text-align:center;  padding:20px 0px;">
						<div style="display:inline;"><label for="img-upload" class="custom-file-upload"><i class="fas fa-upload" style="font-size:1.5rem; color:#e3e3e3;"></i>&nbsp;&nbsp;Dodaj zdjęcie</label>
							<input style="" id="img-upload" type="file" name="img-upload" onchange="loadFile(event)">
						</div>
						<a href="php/delete_profile_image.php"><div style=" display:inline;" class="custom-file-upload"><i class="fas fa-trash-alt" style="font-size:1.5rem; color:#e3e3e3;"></i>&nbsp;&nbsp;Usuń zdjęcie</div></a>
					</div>
					<div style="clear:both;"></div>
			</div>
			<div class="modal-body" style=" text-align:center;">
				<img id="preview"/ >
				
			</div>
			<div class="modal-footer">
			    <button type="submit" value="Submit" class="UploadToDbButton ButtonGlobal"><div class="share" style="color:#e3e3e3; cursor:pointer;">Zapisz</div></button>
			   </form>
			  <div style="clear:both;"></div>
			</div>
		  </div>
		</div>	
	
	
	<div id="Mainbar">
		
		<div id="leftbar">
				<button class="tablinks" onclick="openblock(event, 'all')"  id="defaultOpen"><div class="settings-block"><i style="margin-right:25px; font-size:20px;" class="fas fa-cog"></i>Ustawienia ogólne</div></button>
				<button class="tablinks" onclick="openblock(event, 'MyInfo')"><div class="settings-block"><i style="margin-right:25px; font-size:21px;" class="fas fa-user-circle"></i>Informacje o mnie</div></button>
				<button class="tablinks" onclick="openblock(event, 'ChangePassword')"><div class="settings-block"><i style="margin-right:25px; font-size:20px;" class="fas fa-unlock-alt"></i>Zmiana hasła</div></button>
				<button class="tablinks" onclick="openblock(event, 'FriendsBlock')"><div class="settings-block"><i style="margin-right:21px; font-size:20px;" class="fas fa-users-cog"></i>Opcje użytkowników</div></button>
				<button class="tablinks" onclick="openblock(event, 'DeleteAcc')"><div class="settings-block"><i style="margin-right:21px; font-size:20px;" class="fas fa-user-slash"></i>Usuń konto</div></button>
				<button class="tablinks" onclick="openblock(event, 'AddFriend')"><div class="settings-block"><i style="margin-right:21px; font-size:20px;" class="fas fa-user-plus"></i>Dodaj znajomych</div></button>
				
		<div class="footer">
			<ul>
				<li class="footerstyle"><a href=""><span> Regulamin</span></a><span style="padding-left:4px; padding-right:4px;">&middot;</span><a href=""><span>Kontakt</span></a></li>
				<li class="footerstyle"><span> Olympus 2022 <i class="far fa-copyright"></i> Made by Dawid Brodecki. All rights reserved.</span> </li>
			</ul>
		</div>
		<div style="color:white; font-size:16px;">

		</div>
		<div style="clear:both;"></div>
		</div>
		
		<div id="righbar">
	
			<div id="all" class="tabcontent">
				<div style="font-size:22px; padding:15px 12px 19px 12px; border-bottom:1px solid #323334; font-weight:550;"> Ustawienia ogólne: </div>
					
					<div class="settings" >
						<div style="float:left; width:30%;"> Imię i nazwisko:</div> <div style="float:left; font-weight:550;"><?php if(@$_SESSION['is_updated_name']!=TRUE){echo $_SESSION['imie'];}else{echo $_SESSION['updated_name'];}?> <?php if(@$_SESSION['is_updated_lastname']!=TRUE){echo $_SESSION['nazwisko'];}else{echo $_SESSION['updated_lastname'];}?></div> <div class="TabButton" onclick="openTab('a1');" >Edytuj</div>
						<div style="clear:both;"></div>
						<form method="POST" action="php/settings_update.php">
							<div id="a1" class="containerTab" style="margin-top:2rem; display:none;">
									<table style="text-align: right;">
										<tr>
											<td>Imię: </td> <td style="padding-left:1.5rem;"><input type="text" class="StyleInput" size=40 name="name" autocomplete="off"></td>
										</tr>
							
										<tr>
											<td  style="padding-top:1.5rem;">Nazwisko: </td> <td style="padding-left:1.5rem;"><input type="text" class="StyleInput" size=40 name="lastname" autocomplete="off"></td>
										</tr>
									</table>
									<?php
										if (isset($_SESSION['settings_validation_error_name']))
										{
											echo $_SESSION['settings_validation_error_name'];
										unset($_SESSION['settings_validation_error_name']);
										}
										
									
										
										if (isset($_SESSION['updated_successfully']))
										{
											echo $_SESSION['updated_successfully'];
										unset($_SESSION['updated_successfully']);
										}
									?>
									
									<?php
										if (isset($_SESSION['settings_validation_error_lastname']))
										{
											echo $_SESSION['settings_validation_error_lastname'];
										unset($_SESSION['settings_validation_error_lastname']);
										}
									?>
									
									<div onclick="this.parentElement.style.display='none'"  class="closebtn closebtn2" style="float:right;">Anuluj</div><div  style="float:right; padding-right:0.7rem;"><input class="closebtn closebtn2 settings-saveoptionBtn" type="submit" value="Zapisz" name="FormStart-fullname"></div>
									<div style="clear:both;"></div>
							</div>
						</form>
					</div>
					
					<div class="settings" >
						<div style="float:left; width:30%;"> Nazwa użytkownika:</div> <div style="float:left; font-weight:550;">@<?php if(@$_SESSION['is_updated_nickname']!=TRUE){echo $_SESSION['nickname'];}else{echo $_SESSION['updated_nickname'];}?></div> <div class="TabButton" onclick="openTab('a2');" >Edytuj</div>
						<div style="clear:both;"></div>
						<form method="POST" action="php/settings_update.php">
							<div id="a2" class="containerTab" style="margin-top:2rem; display:none; ">
									<table style="text-align: right;">
										<tr>
											<td>Nazwa użytkownika: </td> <td style="padding-left:1.5rem;"><input type="text" class="StyleInput" size=29 name="nickname" autocomplete="off"></td>
										</tr>
									</table>
										<?php
											if (isset($_SESSION['settings_validation_error_n']))
											{
												echo $_SESSION['settings_validation_error_n'];
											unset($_SESSION['settings_validation_error_n']);
											}
											
										
											
											if (isset($_SESSION['updated_successfully_nickname']))
											{
												echo $_SESSION['updated_successfully_nickname'];
											unset($_SESSION['updated_successfully_nickname']);
											}
									?>
									<div onclick="this.parentElement.style.display='none'"  class="closebtn closebtn2" style="float:right;">Anuluj</div><div  style="float:right; padding-right:0.7rem;"><input class="closebtn closebtn2 settings-saveoptionBtn" type="submit" value="Zapisz" name="FormStart-username"></div>
									<div style="clear:both;"></div>
							</div>
							</form>
					</div>
					
					<div class="settings" >
						<div style="float:left; width:30%;"> Email:</div> <div style="float:left; font-weight:550;"><?php if(@$_SESSION['is_updated_email']!=TRUE){echo $_SESSION['email'];}else{echo $_SESSION['updated_email'];}?></div> <div class="TabButton" onclick="openTab('a3');" >Edytuj</div>
						<div style="clear:both;"></div>
						<form method="POST" action="php/settings_update.php">
							<div id="a3" class="containerTab" style="margin-top:2rem; display:none;">
									<table style="text-align: right;">
										<tr>
											<td>Email: </td> <td style="padding-left:1.5rem;"><input type="text" class="StyleInput" size=44 name="email" autocomplete="off"></td>
										</tr>
									</table>
										<?php
											if (isset($_SESSION['settings_validation_error_email']))
											{
												echo $_SESSION['settings_validation_error_email'];
											unset($_SESSION['settings_validation_error_email']);
											}
											
										
											
											if (isset($_SESSION['updated_successfully_email']))
											{
												echo $_SESSION['updated_successfully_email'];
											unset($_SESSION['updated_successfully_email']);
											}
									?>
									<div onclick="this.parentElement.style.display='none'"  class="closebtn closebtn2" style="float:right;">Anuluj</div><div  style="float:right; padding-right:0.7rem;"><input class="closebtn closebtn2 settings-saveoptionBtn" type="submit" value="Zapisz" name="FormStart-email"></div>
									<div style="clear:both;"></div>
							</div>
							</form>
					</div>
					
					<div class="settings" >
						<div style="float:left; width:30%;"> Weryfikacja konta:</div> <div style="float:left; font-weight:550;"><?php echo $_SESSION['weryfikacja']; ?></div> <div class="TabButton" onclick="openTab('a4');" >Zweryfikuj</div>
						<div style="clear:both;"></div>
						<form method="POST" action="php/settings_update.php">
							<div id="a4" class="containerTab" style="margin-top:2rem; display:none;">
									<table style="">
										<tr>
											<td>Prześlij do moderacji wniosek o weryfikację mojego konta: </td> 
										</tr>
									</table>
									<?php
											if (isset($_SESSION['sent_request_fail']))
											{
												echo $_SESSION['sent_request_fail'];
											unset($_SESSION['sent_request_fail']);
											}
											
										
											
											if (isset($_SESSION['sent_request_success']))
											{
												echo $_SESSION['sent_request_success'];
											unset($_SESSION['sent_request_success']);
											}
									?>
									<div onclick="this.parentElement.style.display='none'"  class="closebtn closebtn2" style="float:right;">Anuluj</div><div  style="float:right; padding-right:0.7rem;"><input class="closebtn closebtn2 settings-saveoptionBtn" type="submit" value="Wyślij" name=""></div>
									<div style="clear:both;"></div>
							</div>
							</form>
					</div>
					
					
			</div>
			
			<div id="ChangePassword" class="tabcontent">
				<div style="font-size:22px; padding:15px 12px 19px 12px; border-bottom:1px solid #323334; font-weight:550;"> Zmiana hasła: </div>
					
					<div class="settings" >
						<div style="float:left; width:30%;"> Zmień hasło:</div> <div style="float:left; font-weight:550;"></div> <div class="TabButton" onclick="openTab('b1');" >Edytuj</div>
						<div style="clear:both;"></div>
						<form method="POST" action="php/settings_update.php">
							<div id="b1" class="containerTab" style="margin-top:2rem; display:none;">
									<table style="text-align: right;">
										<tr>
											<td  style="padding-top:0.7em;">Aktualne hasło: </td> <td style="padding:0.7em 0em 0em 1.5rem;"><input type="password" class="StyleInput" name="check_current_password" size=33 autocomplete="off"></td>
										</tr>
										<tr>
											<td  style="padding-top:0.7em;">Nowe hasło: </td> <td style="padding:0.7em 0em 0em 1.5rem;"><input type="password" class="StyleInput" name="new_password" size=33 autocomplete="off"></td>
										</tr>
										<tr>
											<td  style="padding-top:0.7em;">Potwierdź hasło: </td> <td style="padding:0.7em 0em 0em 1.5rem;"><input type="password" class="StyleInput" name="password_repeat" size=33 autocomplete="off"></td>
										</tr>
									</table>
									<?php
											if (isset($_SESSION['settings_validation_error_password']))
											{
												echo $_SESSION['settings_validation_error_password'];
											unset($_SESSION['settings_validation_error_password']);
											}
											
										
											
											if (isset($_SESSION['updated_successfully_password']))
											{
												echo $_SESSION['updated_successfully_password'];
											unset($_SESSION['updated_successfully_password']);
											}
									?>
									<div onclick="this.parentElement.style.display='none'"  class="closebtn closebtn2" style="float:right;">Anuluj</div><div  style="float:right; padding-right:0.7rem;"><input class="closebtn closebtn2 settings-saveoptionBtn" type="submit" value="Zapisz" name="FormStart-password"></div>
									<div style="clear:both;"></div>
							</div>
						</form>
					</div>
	
					
			</div>
			
			<div id="MyInfo" class="tabcontent">
				<div style="font-size:22px; padding:15px 12px 19px 12px; border-bottom:1px solid #323334; font-weight:550;"> Informacje o mnie: </div>
					
					<div class="settings" >
						<div style="float:left; width:30%;"> Kraj:</div> <div style="float:left; font-weight:550;"><?php if(@$_SESSION['is_updated_country']!=TRUE){echo $_SESSION['kraj'];}else{echo $_SESSION['updated_country'];}?></div> <div class="TabButton" onclick="openTab('c1');" >Edytuj</div>
						<div style="clear:both;"></div>
						<form method="POST" action="php/settings_update.php">
							<div id="c1" class="containerTab" style="margin-top:2rem; display:none; width:20em;">
									<table style="text-align: right;">
										<tr>
											<td>Kraj: </td> <td style="padding-left:1.5rem;"><input type="text" class="StyleInput" size=32 name="country" autocomplete="off"></td>
										</tr>
									</table>
									<?php
											if (isset($_SESSION['settings_validation_error_country']))
											{
												echo $_SESSION['settings_validation_error_country'];
											unset($_SESSION['settings_validation_error_country']);
											}
											
										
											
											if (isset($_SESSION['updated_successfully_country']))
											{
												echo $_SESSION['updated_successfully_country'];
											unset($_SESSION['updated_successfully_country']);
											}
									?>
									  <div style="display:inline-block;">
											<div style="float:left; font-size:14px; margin-top:13px;">
												<input type="checkbox" name="checkbox_country" id="checkbox-country" style="height:20px; padding-top:5px;">
												<label for="checkbox-country" class="label-checkboxpass" style="position:relative; top:-5px;">Nie podawać</label>
											</div>
									</div>
									<div onclick="this.parentElement.style.display='none'"  class="closebtn closebtn2" style="float:right;">Anuluj</div><div  style="float:right; padding-right:0.7rem;"><input class="closebtn closebtn2 settings-saveoptionBtn" type="submit" value="Zapisz" name="FormStart-country"></div>
									<div style="clear:both;"></div>
							</div>
						</form>
					</div>
					
					<div class="settings" >
						<div style="float:left; width:30%;"> Płeć:</div> <div style="float:left; font-weight:550;"><?php if(@$_SESSION['is_updated_gender']!=TRUE){echo $_SESSION['plec'];}else{echo $_SESSION['updated_gender'];}?></div> <div class="TabButton" onclick="openTab('c2');" >Edytuj</div>
						<div style="clear:both;"></div>
							<form method="POST" action="php/settings_update.php">
							<div id="c2" class="containerTab" style="margin-top:2rem; display:none; width:20em;">	
									<table style="text-align: right;">
										<tr>
											<td>Płeć: </td> <td style="padding-left:1.5rem;">
												<select name="gender" id="" class="form-control"  >
													<option value="" disabled selected class="font input100">Płeć</option>								
													<option value="Mężczyzna">Mężczyzna</option>
													<option value="Kobieta">Kobieta</option>
													<option value="Brak Danych">Nie podawać</option>
												</select>
											</td>
										</tr>
									</table>
										<?php
											if (isset($_SESSION['settings_validation_error_gender']))
											{
												echo $_SESSION['settings_validation_error_gender'];
											unset($_SESSION['settings_validation_error_gender']);
											}
											
										
											
											if (isset($_SESSION['updated_successfully_gender']))
											{
												echo $_SESSION['updated_successfully_gender'];
											unset($_SESSION['updated_successfully_gender']);
											}
									?>
									<div onclick="this.parentElement.style.display='none'"  class="closebtn closebtn2" style="float:right;">Anuluj</div><div  style="float:right; padding-right:0.7rem;"><input class="closebtn closebtn2 settings-saveoptionBtn" type="submit" value="Zapisz" name="FormStart-gender"></div>
									<div style="clear:both;"></div>
							</div>
							</form>
					</div>
					
					<div class="settings" >
						<div style="float:left; width:30%;"> Zamieszkuje:</div> <div style="float:left; font-weight:550;"><?php if(@$_SESSION['is_updated_living']!=TRUE){echo $_SESSION['zamieszkuje'];}else{echo $_SESSION['updated_living'];}?></div> <div class="TabButton" onclick="openTab('c3');" >Edytuj</div>
						<div style="clear:both;"></div>
							<form method="POST" action="php/settings_update.php">
							<div id="c3" class="containerTab" style="margin-top:2rem; display:none; width:20em;">
									<table style="text-align: right;">
										<tr>
											<td>Mieszkam w: </td> <td style="padding-left:1.5rem;"><input type="text" class="StyleInput" size=23 name="living" autocomplete="off"></td>
										</tr>
									</table>
										<?php
											if (isset($_SESSION['settings_validation_error_living']))
											{
												echo $_SESSION['settings_validation_error_living'];
											unset($_SESSION['settings_validation_error_living']);
											}
											
										
											
											if (isset($_SESSION['updated_successfully_living']))
											{
												echo $_SESSION['updated_successfully_living'];
											unset($_SESSION['updated_successfully_living']);
											}
									?>
									<div style="display:inline-block;">
											<div style="float:left; font-size:14px; margin-top:13px;">
												<input type="checkbox" name="checkbox_living" id="checkbox-town" style="height:20px; padding-top:5px;">
												<label for="checkbox-town" class="label-checkboxpass" style="position:relative; top:-5px;">Nie podawać</label>
											</div>
									</div>
									<div onclick="this.parentElement.style.display='none'"  class="closebtn closebtn2" style="float:right;">Anuluj</div><div  style="float:right; padding-right:0.7rem;"><input class="closebtn closebtn2 settings-saveoptionBtn" type="submit" value="Zapisz" name="FormStart-living"></div>
									<div style="clear:both;"></div>
							</div>
							</form>
					</div>
					
					<div class="settings" >
						<div style="float:left; width:30%;"> Pracuje:</div> <div style="float:left; font-weight:550;"><?php if(@$_SESSION['is_updated_work']!=TRUE){echo $_SESSION['praca'];}else{echo $_SESSION['updated_work'];}?></div> <div class="TabButton" onclick="openTab('c4');" >Edytuj</div>
						<div style="clear:both;"></div>
							<form method="POST" action="php/settings_update.php">
							<div id="c4" class="containerTab" style="margin-top:2rem; display:none;">
									<table style="text-align: right;">
										<tr>
											<td>Pracuję w: </td> <td style="padding-left:1.5rem;"><input type="text" class="StyleInput" size=39 name="work" autocomplete="off"></td>
										</tr>
									</table>
									<?php
											if (isset($_SESSION['settings_validation_error_work']))
											{
												echo $_SESSION['settings_validation_error_work'];
											unset($_SESSION['settings_validation_error_work']);
											}
											
										
											
											if (isset($_SESSION['updated_successfully_work']))
											{
												echo $_SESSION['updated_successfully_work'];
											unset($_SESSION['updated_successfully_work']);
											}
									?>
									<div style="display:inline-block;">
											<div style="float:left; font-size:14px; margin-top:13px;">
												<input type="checkbox" name="checkbox_work" id="checkbox-work" style="height:20px; padding-top:5px;">
												<label for="checkbox-work" class="label-checkboxpass" style="position:relative; top:-5px;">Nie podawać</label>
											</div>
									</div>
									<div onclick="this.parentElement.style.display='none'"  class="closebtn closebtn2" style="float:right;">Anuluj</div><div  style="float:right; padding-right:0.7rem;"><input class="closebtn closebtn2 settings-saveoptionBtn" type="submit" value="Zapisz" name="FormStart-work"></div>
									<div style="clear:both;"></div>
							</div>
							</form>
					</div>
					
					<div class="settings" >
						<div style="float:left; width:30%;"> Szkoła:</div> <div style="float:left; font-weight:550;"><?php if(@$_SESSION['is_updated_school']!=TRUE){echo $_SESSION['szkola'];}else{echo $_SESSION['updated_school'];}?></div> <div class="TabButton" onclick="openTab('c5');" >Edytuj</div>
						<div style="clear:both;"></div>
						<form method="POST" action="php/settings_update.php">
							<div id="c5" class="containerTab" style="margin-top:2rem; display:none;">
									<table style="text-align: right;">
										<tr>
											<td>Uczę się w: </td> <td style="padding-left:1.5rem;"><input type="text" class="StyleInput" size=38 name="school" autocomplete="off"></td>
										</tr>
									</table>
									<?php
											if (isset($_SESSION['settings_validation_error_school']))
											{
												echo $_SESSION['settings_validation_error_school'];
											unset($_SESSION['settings_validation_error_school']);
											}
											
										
											
											if (isset($_SESSION['updated_successfully_school']))
											{
												echo $_SESSION['updated_successfully_school'];
											unset($_SESSION['updated_successfully_school']);
											}
									?>
									<div style="display:inline-block;">
											<div style="float:left; font-size:14px; margin-top:13px;">
												<input type="checkbox" name="checkbox_school" id="checkbox-school" style="height:20px; padding-top:5px;">
												<label for="checkbox-school" class="label-checkboxpass" style="position:relative; top:-5px;">Nie podawać</label>
											</div>
									</div>
									<div onclick="this.parentElement.style.display='none'"  class="closebtn closebtn2" style="float:right;">Anuluj</div><div  style="float:right; padding-right:0.7rem;"><input class="closebtn closebtn2 settings-saveoptionBtn" type="submit" value="Zapisz" name="FormStart-school"></div>
									<div style="clear:both;"></div>
							</div>
							</form>
					</div>
					
					
			</div>
			
			<div id="FriendsBlock" class="tabcontent">
				<div style="font-size:22px; padding:15px 12px 19px 12px; border-bottom:1px solid #323334;	font-weight:550;"> Opcje użytkowników: </div>
					
					<div class="settings" >
						<div style="float:left; width:25%;"> Zaproszeni znajomi:</div> 
							<form method="POST" action="php/settings_update.php">
							<div style="float:left; font-weight:550; max-width:75%;">
								<?php 	
		
									require_once "php/connect.php";
									$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
									
									$current_user_id = $_SESSION['id_user'];
									$sql = "SELECT users.imie, users.nazwisko, users.nickname FROM users, invitations WHERE invitations.invated_user_id=users.id_user AND invitations.id_inviting_user=$current_user_id";
									$check_validation = $conn->query($sql);
								
									if ($check_validation->num_rows > 0) 
									{

								while($show_result = $check_validation->fetch_assoc()) 
									{
										
										echo 
										'<div style="float:left; padding-bottom:10px;"><div class="blocked_user">'.$show_result['imie']." ".$show_result['nazwisko']." "."<span style='font-size:14px; color:#b0b3b8;'>@".$show_result['nickname']."</span>"." ".'<div class="tooltip1"><button class="btn_unblock" type="submit" name="FormStart-unblock"><i class="fas fa-times fa_x"></i></button><span class="tooltiptext1">Anuluj</span></div>'."</div></div>";
				
									}
						
									} 

								
								$conn->close();
								
							?>
							</div> 
							</form>
						<div style="clear:both;"></div>
					</div>
					
					<div class="settings" >
						<div style="float:left; width:25%;"> Lista zablokowanych:</div> 
							<form method="POST" action="php/settings_update.php">
							<div style="float:left; font-weight:550; max-width:55%;">
								<?php 	
		
									require_once "php/connect.php";
									$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
									
									$current_user_id = $_SESSION['id_user'];
									$select_blocked_user = "SELECT blocked_user FROM blocked WHERE id_user=$current_user_id";
									$check_validation = $conn->query($select_blocked_user);
									
									if ($check_validation->num_rows > 0) 
									{

								while($show_result = $check_validation->fetch_assoc()) 
									{
										
										echo 
										'<div class="blocked_user">'.$show_result['blocked_user']." ".'<div class="tooltip1"><button class="btn_unblock" type="submit" name="FormStart-unblock"><i class="fas fa-times fa_x"></i></button><span class="tooltiptext1">Odblokuj</span></div>'."</div>";
				
									}
						
									} 

								
								$conn->close();
								
							?>
							</div> 
							</form>
						<div class="TabButton" onclick="openTab('d2');" >Opcje blokowania</div>
						<div style="clear:both;"></div>
							<form method="POST" action="php/settings_update.php">
							<div id="d2" class="containerTab" style="margin-top:2rem; display:none; width:28.5em;">
									<table style="text-align: right;">
										<tr>
											<td>Zablokuj użytkownika: </td> <td style="padding-left:1.5rem;"><input id="placeholder" type="text" class="StyleInput" size="30" placeholder="Podaj @Nazwę użytkownika" name="block" autocomplete="off"></td>
										</tr>
										<!--<tr>
											<td style="padding-top:0.7em;">Odblokuj użytkownika: </td> <td style="padding:0.7em 0em 0em 1.5rem;"><input id="placeholder" type="text" class="StyleInput"  size="23" placeholder="Podaj @Nazwę użytkownika" name="unblock" autocomplete="off"></td>
										</tr>-->
									</table>
										<?php
											if (isset($_SESSION['settings_validation_error_block']))
											{
												echo $_SESSION['settings_validation_error_block'];
											unset($_SESSION['settings_validation_error_block']);
											}
											
										
											
											if (isset($_SESSION['updated_successfully_block']))
											{
												echo $_SESSION['updated_successfully_block'];
											unset($_SESSION['updated_successfully_block']);
											}
									?>
									<div onclick="this.parentElement.style.display='none'"  class="closebtn closebtn2" style="float:right;">Anuluj</div><div  style="float:right; padding-right:0.7rem;"><input class="closebtn closebtn2 settings-saveoptionBtn" type="submit" value="Zapisz" name="FormStart-block"></div>
									<div style="clear:both;"></div>
							</div>
							</form>
					</div>
							
					
			</div>
			
			<div id="DeleteAcc" class="tabcontent">
				<div style="font-size:22px; padding:15px 12px 19px 12px; border-bottom:1px solid #323334;	font-weight:550;"> Usuń konto: </div>
					
					<div class="settings" >
						<div style="float:left; width:30%;"> Usuń konto:</div> <div style="float:left; font-weight:550;">Permanentna likwidacja konta w serwisie Olympus</div> <div class="TabButton" onclick="openTab('e1');" >Wyświetl</div>
						<div style="clear:both;"></div>
						
							<div id="e1" class="containerTab" style="margin-top:2rem; display:none; width:27.5em;">
									<div style="padding:5px 0px 6px 0px; font-size:17px;">Aby kontynuować, wpisz swoje hasło do konta: </div>
									
									<table style="text-align: right;">
										<tr>
											<td  style="padding-top:0.7em;">Wpisz swoje hasło: </td> <td style="padding:0.7em 0em 0em 1.5rem;"><input type="password" class="StyleInput" name="new_password" size=33 autocomplete="off"></td>
										</tr>

									</table>
									
							
									<div onclick="this.parentElement.style.display='none'"  class="closebtn closebtn2" style="float:right;">Anuluj</div><div  style="float:right; padding-right:0.7rem;"><button id="Btn_user_delete" class="closebtn closebtn2 settings-saveoptionBtn"><div style="font-size:13px; margin-top:-2.5px;">Kontynuuj</div></button></div>
									<div style="clear:both;"></div>
							</div>
				
					</div>
			</div>
			
			<div id="AddFriend" class="tabcontent">
				<div style="font-size:22px; padding:15px 12px 19px 12px; border-bottom:1px solid #323334; font-weight:550;">Zaproś do znajomych: </div>
					
					<div class="settings" >
						<div style="float:left; width:30%;">Wyślij zaproszenie:</div> <div style="float:left; font-weight:550;"></div> <div class="TabButton" onclick="openTab('f1');" >Dodaj</div>
						<div style="clear:both;"></div>
						<form method="POST" action="php/invitations.php">
							<div id="f1" class="containerTab" style="margin-top:2rem; display:none;">
									<table style="text-align: right;">
										<tr>
											<td  style="padding-top:0.7em;">Zaproś znajomego: </td> <td style="padding:0.7em 0em 0em 1.5rem;"><input type="text" class="StyleInput" name="add_friend" size=30 autocomplete="off" placeholder="Podaj nickname znajomego"></td>
										</tr>
									</table>
									<?php
											if (isset($_SESSION['settings_validation_error_addfriend']))
											{
												echo $_SESSION['settings_validation_error_addfriend'];
											unset($_SESSION['settings_validation_error_addfriend']);
											}
											
										
											
											if (isset($_SESSION['updated_successfully_addfriend']))
											{
												echo $_SESSION['updated_successfully_addfriend'];
											unset($_SESSION['updated_successfully_addfriend']);
											}
									?>
									<div onclick="this.parentElement.style.display='none'"  class="closebtn closebtn2" style="float:right;">Anuluj</div><div  style="float:right; padding-right:0.7rem;"><input class="closebtn closebtn2 settings-saveoptionBtn" type="submit" value="Zapisz" name="FormStart-AddFriend"></div>
									<div style="clear:both;"></div>
							</div>
						</form>
					</div>
		
			</div>
		</div>		
	</div>
	


</div>
<script src="js/tabicontent.js"></script>
<script src="js/modal.js"> </script>
<script src="js/modal3.js"> </script>
<script src="js/containertab.js"> </script>
<script src="js/display_search_result_header.js"> </script>
</body>
</html>




