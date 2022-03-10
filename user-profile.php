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
	<title> Olympus | <?php echo $_SESSION['imie']." ".$_SESSION['nazwisko'];?></title>
	<meta name="description" content="Olympus - projekt serwisu społecznościowego jako propozycja pracy magisterskiej."/>
	<meta name="keywords" content="Portal spolecznosciowy, komunikator, znajomi, wiadomosci"/>
	<meta charset="utf-8">
	<meta name="author" content="Dawid Brodecki" />
	<meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1"/>
	<meta http-equiv="cache-control" content="no-cache">
	<link rel="stylesheet" href="css/user-profile.css" type="text/css"/>
	<link rel="stylesheet" href="css/body.css" type="text/css"/>
	<link rel="stylesheet" href="css/header.css" type="text/css"/>
	<link rel="stylesheet" href="css/search.css" type="text/css"/>
	<link rel="stylesheet" href="css/feedbackwall.css" type="text/css"/>
	<link rel="stylesheet" href="css/invitation.css" type="text/css">
	<link rel="stylesheet" href="css/modal.css" type="text/css">
	<link rel="stylesheet" href="css/dropdown.css" type="text/css">
	<link rel="stylesheet" href="dist/css/lightbox.min.css">
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
						<div class="logo-caption"><span style="font-size:50px;">O</span><span style="font-size:45px;">lympus</span></div>
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
				<div class="tooltip"><a href="index.php"><i class="fas fa-home fa-6x MainButton2" id="MainButton"></i></a><span class="tooltiptext">Strona Główna</span></div>
			</div>
		</div>
		
		<div class="header-right_section">
			
			<div id="nav">
				<ul>
					<li class="linav"><a class="NavStyle navpicked" href="user-profile.php"><i class="fas fa-house-user"></i>&nbsp;Profil</a></li><span style="color:white; cursor:default;">|</span>
					<li class="linav"><a class="NavStyle"><button id="myBtn"><i class="fas fa-user-plus"></i>&nbsp;Zaproszenia&nbsp;<span id="InvitationsNumber"><?php echo $_SESSION['number_of_invitations']; ?></span></button></a></li><span  style="color:white; cursor:default;">|</span>
					<li class="linav"><a class="NavStyle" href="settings.php"><i class="fas fa-user-cog"></i>&nbsp;Ustawienia</a></li><span  style="color:white; cursor:default;">|</span>
					<li class="linav"><a class="NavStyle" href="php/logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Wyloguj</a></li>
				</ul>
			</div>

		<div style="clear:both;"></div>
		
		<div  id="WelcomingBox">
			<a href="user-profile.php">
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
				<div id="UserName" ><span class="textwrap">Witaj! <?php echo $_SESSION['imie']; ?><span></div>
			</a>
		</div>
		<div style="clear:both;"></div>
		</div>
		
	</div>
	
		<div style="clear:both;"></div>
	
	<div class="main" style="margin-top:5rem;" id="myModal">
		<span style="" class="closenow"><i class="fas fa-times"></i></span>
		<div style="clear:both;"></div>

		<div class="request" >
		
			<div id="left">
				<div style="float:left; padding-top:4px;"> <img  class="borderradius" height="45px" width="45px" src="<?php echo 'data:image/jpeg;base64,'.base64_encode( $_SESSION['user_avatar'])?>"></div>
				<div style="float:left; padding-left:11px; padding-top:7.5px;">
					<div>Imie Nazwisko</div>
					<div style="color:#b0b3b8; font-weight:100;"> @Nickname</div>
				</div>
					<div style="clear:both;"></div>
			</div>
			
			<div id="right">
				<div style="right;">
					<div class="AcceptorReject" style="color:green;">
						<i class="fas fa-check"></i>
					</div>
					
					<div class="AcceptorReject" style="color:red;">
						<i class="fas fa-times"></i>
					</div>
				</div>
				<span style="width:1px; height:80px; background-color:gray; position: absolute; top:0px; right:88px;"></span>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>
	
	<div class="main" style="margin-top:5rem;" id="incoming_invitations">
		<div style="float:left; margin-top:-1px;" > 
			<div class="tooltip_global" ><div class="InvitationsChoose" style="background-color:#3A7CD4; cursor:default"><i class="fas fa-envelope-open-text"></i><span class="tooltiptext_global" style="margin-left:1.3rem;  font-size: 15.5px; width:180px;">Zaproszenia przychodzące</span></div></div>
			<div class="tooltip_global" ><button id="TogleToOutgoing" class="ButtonGlobal"><div class="InvitationsChoose InvitationsChoose1 CloseIncoming" style="margin-left:-2px;"><i class="far fa-paper-plane"></i><span class="tooltiptext_global" style="margin-left:1.3rem;  font-size:13px ; width:160px;">Zaproszenia wychodzące</span></div></button></div>

		</div>
		<span style="" class="closenow closeX">&times;</span>
		<div style="clear:both;"></div>

		<?php 
			require_once "php/connect.php";
			$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);		
			
				$current_user_id = $_SESSION['id_user'];
				$current_user_nickname = $_SESSION['nickname'];			
			
				$result = $conn->query(" SELECT users.imie, users.nazwisko, users.nickname, users.user_avatar FROM users, invitations WHERE invitations.invited_user_nickname='$current_user_nickname' AND users.id_user=invitations.id_inviting_user");
						
				if ($result->num_rows > 0) 
				{
				while($row = $result->fetch_assoc()) 
				{
					
					echo
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
							<div class="tooltip_global" style="z-index:1001;" ><div class="AcceptOrReject" style="padding:4.5px 7px; background-color:green; "><i class="fas fa-check"></i><span class="tooltiptext_global" style="margin:-0.35rem 0rem 0rem 1.1rem;  width:65px; font-weight:550;">Przyjmij</span></div></div>
							<div class="tooltip_global" ><div class="AcceptOrReject" style="padding:4.5px 8px; background-color:red; margin-left:5px;"><i class="fas fa-times"></i><span class="tooltiptext_global" style="margin:-0.35rem 0rem 0rem 1.1rem;  width:55px; font-weight:550;">Odrzuć</span></div></div>
						</div>'.
					'</div>'.

			'<div style="clear:both;"></div>'.
		'</div>';
		
				}
			}
			else
		{
			echo '<div class="NoFriends">Nie masz żadnych nowych zaproszeń :(</div>';
		}
	
	?>

	</div>
	
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
	
		<div id="modalBox" class="modal">
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
		
		<div id="backgroundphotoUploadModal" class="modal">
		  <div class="modal-content">
			<div class="modal-header">
			  <span class="close_backgroundphoto_modal closeBox">&times;</span>
			  <div style="font-size:2.4rem; font-weight:550; font-family:Segoe UI; padding:10px; color:#e3e3e3;">Zaktualizuj zdjęcie w tle:</div>
			  	<form enctype="multipart/form-data" action="php/img_upload.php" method="post" >
					<div style="text-align:center;  padding:20px 0px;">
						<div style="display:inline;"><label for="backgroundphoto_upload" class="custom-file-upload"><i class="fas fa-upload" style="font-size:1.5rem; color:#e3e3e3;"></i>&nbsp;&nbsp;Dodaj zdjęcie</label>
							<input style="" id="backgroundphoto_upload" type="file" name="backgroundphoto_upload" onchange="loadFile3(event)">
						</div>
						<a href="php/delete_backgroundphoto.php"><div style=" display:inline;" class="custom-file-upload"><i class="fas fa-trash-alt" style="font-size:1.5rem; color:#e3e3e3;"></i>&nbsp;&nbsp;Usuń zdjęcie</div></a>
					</div>
					<div style="clear:both;"></div>
			</div>
			<div class="modal-body" style=" text-align:center;">
				<img id="preview3" >
				
			</div>
			<div class="modal-footer">
			    <button type="submit" value="Submit" class="UploadToDbButton ButtonGlobal"><div class="share" style="color:#e3e3e3; cursor:pointer;">Zapisz</div></button>
			   </form>
			  <div style="clear:both;"></div>
			</div>
		  </div>
		</div>
	
		<div id="upperbar">
				<?php		
					if(@$_SESSION["zaktualizowano_zdjecie_w_tle"]!=TRUE)
					{
						$_SESSION['backgroundphoto'] = 'data:image/jpeg;base64,'.base64_encode($_SESSION['user_backgroundphoto']);
					}
					else
					{
						$_SESSION['backgroundphoto'] = 'data:image/jpeg;base64,'.base64_encode($_SESSION['new_backgroundphoto']);
					}
				?>
			<div id="backgroundphoto" style="border-radius: 0px 0px 12px 12px;   background-size: cover; background-image: url('<?php echo $_SESSION['backgroundphoto']	?>');">
					<button id="backgroundphotoBtn" class="ButtonGlobal backgroundphotoBtn" style="float:right;"><i class="fas fa-upload"></i></button>
					<div style="clear:both;"></div>
				
					<div style="float:left; width:18.8%; height:367px; background-color:red; visibility:hidden;"></div>	
					<div style="float:left;">
							
						<div id="userdata" style="float:left;">	
							<div id="userphoto">
								<?php	
									if(@$_SESSION["zaktualizowano_avatar"]!=TRUE){
									echo '<a class="example-image-link" href="data:image/jpeg;base64,'.base64_encode($_SESSION['user_avatar']).'" data-lightbox="example-1"><img class="userphoto" style="border-radius: 15px 15px 15px 15px;" height="200px" width="200px" src="data:image/jpeg;base64,'.base64_encode($_SESSION['user_avatar']).'"></a>';
									}
									else{
										echo '<a class="example-image-link" href="data:image/jpeg;base64,'.base64_encode($_SESSION['new_avatar']).'" data-lightbox="example-2"><img class="userphoto" style="border-radius: 15px 15px 15px 15px;" height="200px" width="200px" src="data:image/jpeg;base64,'.base64_encode($_SESSION['new_avatar']).'"></a>';
									}
								?>
							</div>
							
								<button id="uploadbtn" ><div class="upload" id= "upload"><i class="fas fa-upload"></i></div></button> 

						</div>
						<?php		
							$weryfikacja = $_SESSION['weryfikacja'];
			
							if ($weryfikacja == "tak")
							{
								$_SESSION['weryfikacja_konta'] = '<span style="margin-left:10px; padding-right:3px;"><i class="fas fa-check-circle fa-xs"></i></span>';
							}
							else
							{
								$_SESSION['weryfikacja_konta'] = '';
							}
						?>
						<div id="my-username" style="float:left;">
							<div  class="textwrap my-username_padding"><span style="margin-left:5px;"><?php echo $_SESSION['imie']." ".$_SESSION['nazwisko'];?></span><?php echo $_SESSION['weryfikacja_konta']; ?></div>
							<div  class="textwrap  my-username_padding " style="margin-top:5px; margin-left:1px;"><?php echo "@".$_SESSION['nickname']; ?></div>
						</div>		
							
					</div>
					<div style="clear:both;"></div>
					
			</div>
			
			<div style="float:left; width:81%; overflow:hidden;">
				
					<div id="userinfo">
						<table class="textwrap" style="position:relative; width:65%; max-width:65%; margin-left:25.5rem; ">
								<tr style="background-color:;">
									<td class="userinfo"> <div class="textwrap" style="max-width:28rem;  text-align: left;">Data dołączenia: <?php echo $_SESSION['data_rejestracji']; ?></div></td> 
									<td class="userinfo"> <div class="textwrap" style="max-width:22rem; margin-right:4rem;">Kraj: <?php echo $_SESSION['kraj']; ?></div></td> 
								<td style=""> 
										<div class="textwrap" style="max-width:35rem; display:inline-block; text-decoration:underline; ">Zamieszkuje: <?php echo $_SESSION['zamieszkuje']; ?></div>
										<div class="kog" style="display:inline-block;"><i style="position:relative; left: 10px; top:-6px;" class="fas fa-cog"></i></div>
									</td> 
								
								</tr>
								
								<tr style="background-color:;">
								<td class="userinfo"> <div  class="textwrap" style="max-width:28rem; text-align: left; ">Data urodzenia:  <?php echo $_SESSION['data_urodzenia']; ?></div></td> 
								<td class="userinfo"> <div  class="textwrap" style="max-width:22rem;  margin-right:4rem;">Płeć:  <?php echo $_SESSION['plec']; ?></div></td> 
								<td class="userinfo" > <div  class="textwrap" style="max-width:40rem;   text-decoration:underline;">Pracuje/Uczy się: <?php echo $_SESSION['praca']; ?></div></td> 
							</tr>
						</table>
						
					</div>
				
				
			</div>
				
				<div style="clear:both;"></div>
				
		</div>
			
			<div style="float:left; width:18.8%; height:122px;">
				<div class="icon-bar">
					<a href="user-profile.php" class="toggle"><i class="fas fa-house-user"></i></a> 
					<a href="friends-list.php" class="toggle"><i class="fas fa-users"></i></a> 
					<a href="likes-list.php" class="toggle"><i class="fas fa-laugh-wink"></i></a> 
					<a href="gallery.php" class="toggle"><i class="fas fa-images"></i></a> 
				</div>
			</div>	
					
					
						<div id="leftbar" class="" style="">
							<div style="padding-right:1.5rem;">
								<div id="about-me">
									<div style="color: #E3E3E3; font-size:22px; float:left"> O mnie:</div>
										<div class="kog " style="float:right; font-size: 2rem;">
											<button onclick="function_dropdown()" class="ButtonGlobal dropdownh dropbtn"><i style="position:absolute; top:3.4px; left:3.9px;" class="fas fa-cog dropbtn" ></i></button>
												<div id="myDropdown" class="dropdown-content">
													<button class="ButtonGlobal dropbtn_options" id="makeClick" onclick="makeClick1(); makeClick2();"><div style="color: #E3E3E3; font-weight:550;">Edytuj opis</div></button>
													<form style="border-top: 1px solid gray;" action="php/my_description.php" method="POST" ><input style="color: #E3E3E3; font-weight:550;"class="ButtonGlobal dropbtn_options" type="submit" value="Usuń opis" name="delete_description"></form>
												</div>
												
										</div>
									<div style="clear:both;"></div>
								<div style="position:relative; display:block;">	
									<?php

									require_once "php/connect.php";
									$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
										
										if ($conn->connect_errno!=0)
										{
											echo "Error: ".$conn->connect_errno;
										}
										else
										{
											$current_user_id = $_SESSION['id_user'];
											
											if ($rezultat = $conn->query("SELECT opis, id_user FROM users WHERE id_user=$current_user_id")) 
											{
												$new_row = $rezultat ->fetch_assoc();
												$_SESSION['this_session_id'] = $new_row['id_user'];
												$_SESSION['description_db'] = $new_row['opis'];
												$rezultat->free_result();
												
												if (($_SESSION['this_session_id'] == $current_user_id) && ($current_user_id  == $_SESSION['this_session_id']))
												{
													if (empty($_SESSION['description_db']))
													{
														$_SESSION['empty_desc'] = '
														
														<button id="description_add_btn" class="js_toggle custom-file-upload" style="margin:1.4rem 0rem 2rem 2.86rem; outline:0;">Dodaj opis</button>
														
														<div id="description_add_toggle"  style="display:none; position:relative">
															<form  action="php/my_description.php" method="POST" >
																<textarea  spellcheck="false" id="make_focus2" class="textarea-style" rows="1" onclick="myFunction_description()" name="user_description" placeholder="Napisz coś o sobie..." maxlength="1000"></textarea>
																<div class="share" style="float:none; display:inline-block; position:relative; right:-30.5rem; margin:.85rem 0rem .5rem 0rem;"><input style="font-size: 16px; color: #E3E3E3; font-weight:450;" type="submit" class="ButtonGlobal" value="Zapisz" name="update_description"></div>
														</div></form>';
													}
													else{
														
														echo 
														
														'<form  action="php/my_description.php" method="POST" >
															<p style="margin-top:8px; margin-bottom:0rem;"><textarea spellcheck="false"  id="make_focus" class="textarea-style textarea-style1" rows="1"  onclick="myFunction_description()" name="user_description"  maxlength="1000">';

																if(@$_SESSION['zaktualizowano_opis']!=TRUE)
																{
																echo $_SESSION['opis'];
																}
																else
																{
																echo  $_SESSION['new_description'];
																}		
														echo
															'</textarea></p>
																
																<div id="descritpion_show" class="descritpion_show_btns">
																	<div class="share" style="float:none; display:inline-block; position:relative; right:-27.8rem; margin:.8rem 0rem .5rem 0rem;"><input style="font-size: 16px; color: #E3E3E3; font-weight:450;" class="ButtonGlobal" type="submit" value="Zaktualizuj" name="update_description"></div>
																</div>
														</form>';
														
													}
				
												}
											}
											else 
											{
											  echo "Error: " . $conn->error;
											}
												
											$conn->close();
											
										}
								?>
								
	
								
								<?php
										if (isset($_SESSION['description_query_success']))
										{
										echo $_SESSION['description_query_success'];
										unset($_SESSION['description_query_success']);
										}
										if (isset($_SESSION['error_description']))
										{
										echo $_SESSION['error_description'];
										unset($_SESSION['error_description']);
										}
										if (isset($_SESSION['empty_desc']))
										{
										echo $_SESSION['empty_desc'];
										unset($_SESSION['empty_desc']);
										}

										?>
								</div>
							</div>	
								
								<script>
									const txHeight = 33;
									const tx = document.getElementsByTagName("textarea");

									for (let i = 0; i < tx.length; i++) {
									  if (tx[i].value == '') {
										tx[i].setAttribute("style", "height:" + txHeight + "px;overflow-y:hidden;");
									  } else {
										tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "px;overflow-y:hidden;");
									  }
									  tx[i].addEventListener("input", OnInput, false);
									}

									function OnInput(e) {
									  this.style.height = "auto";
									  this.style.height = (this.scrollHeight) + "px";
									}
								</script>
							
							<?php
								
								require_once "php/connect.php";
									
									$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
									$current_user_id = $_SESSION['id_user'];
									$sql = "SELECT users.imie, users.nazwisko, users.nickname, users.user_avatar, users.id_user FROM users, relations WHERE relations.id_user=$current_user_id  and relations.id_friend=users.id_user ORDER BY users.id_user ASC LIMIT 9";
									$result = $conn->query($sql);
	
								if ($result->num_rows > 0) 
									{
									
									echo		
									'<div id="friends-list">'.
										'<div style="color: #E3E3E3; font-size:22px; float:left"><a class="underline" href="friends-list.php"> Moi znajomi:</a></div><div class="kog" id="cog" style="float:right; font-size: 2rem;"></div>'.
											'<div style="clear:both;"></div>'.	
										'<div style="padding-top:1.5rem; text-align: center;">'.
											'<div style=" padding-left: 2.5%; text-align: left;">';

											while($row = $result->fetch_assoc()) 
												{
												echo 
												'<table style="display:inline;">'.
												'<tr style="display: inline-block;">'.
														'<td class="padding" style="overflow:hidden;">'.
															'<div style="margin-top:-2px;"><img class="borderradius" src="data:image/jpeg;base64,'.base64_encode($row['user_avatar']).'"  height="107px" width="107px" style="border-radius: 12px 12px 12px 12px;"></div>'.
															'<div class="freads-list-user" >'.$row["imie"].' '.$row["nazwisko"].'</div>'.
														'</td> '.
												'</tr>'.	
												'</table>';
												}
										echo
										'</div>'.
											'<div style="clear:both;"></div>'.
										
											'<a href="friends-list.php"><div style="color: #0f96f0; font-size:16px;  font-family: Arial, sans-serif; display:inline-block; text-decoration:underline; padding-top:0.6rem;">Zobacz więcej</div></a>'.
										'</div>'.
									
									'</div>';
									} 
									$conn->close();
								?>
							
							
								<div id="friends-list">
									<div style="color: #E3E3E3; font-size:22px; float:left"><a class="underline" href="likes-list.php"> Moje polubienia:</a></div>
										<div style="clear:both;"></div>	
									<div style="padding-top:2rem; text-align: center;">
										<table style="width:100%; ">
											<tr style="display: inline-block;">
												<td class="padding" style="overflow:hidden;">
													<div style="margin-top:-6px;"><img src="img/winky.png"  height="107px" width="107px" style="border-radius: 12px 12px 12px 12px;"></div>
													<div class="freads-list-user">Jan Kowalski</div>
												</td> 
												<td class="padding">
													<div><img src="img/winky.png"  height="107px" width="107px" style="border-radius: 12px 12px 12px 12px;"></div>
													<div class="freads-list-user">Marian Kalinowskii</div>
												</td> 
												<td class="padding">
													<div><img src="img/winky.png"  height="107px" width="107px" style="border-radius: 12px 12px 12px 12px;"></div>
													<div class="freads-list-user">Antoni Wasilewska</div>
												</td>
											</tr>
											
											<tr style="display: inline-block; padding-top:.3rem;">
												<td class="padding">
													<div style="margin-top:-6px;"><img src="img/winky.png"  height="107px" width="107px" style="border-radius: 12px 12px 12px 12px;"></div>
													<div class="freads-list-user">Wanda Lis</div>
												</td> 
												<td class="padding">
													<div><img src="img/winky.png"  height="107px" width="107px" style="border-radius: 12px 12px 12px 12px;"></div>
													<div class="freads-list-user">Hubert Czarnecki</div>
												</td> 
												<td class="padding">
													<div><img src="img/winky.png"  height="107px" width="107px" style="border-radius: 12px 12px 12px 12px;"></div>
													<div class="freads-list-user">Krystyna Mazur</div>
												</td>
											</tr>
											
											<tr style="display: inline-block;  padding-top:.3rem;">
												<td class="padding">
													<div style="margin-top:-6px;"><img src="img/winky.png"  height="107px" width="107px" style="border-radius: 12px 12px 12px 12px;"></div>
													<div class="freads-list-user">Damian Maciejewski</div>
												</td> 
												<td class="padding">
													<div><img src="img/winky.png"  height="107px" width="107px" style="border-radius: 12px 12px 12px 12px;"></div>
													<div class="freads-list-user">Ada Chmielewska</div>
												</td> 
												<td class="padding">
													<div><img src="img/winky.png"  height="107px" width="107px" style="border-radius: 12px 12px 12px 12px;"></div>
													<div class="freads-list-user">Ryszard Sawicki</div>
												</td>
											</tr>
										</table>
										
										<div style="clear:both;"></div>
										
										<a href="likes-list.php"><div style="color: #0f96f0; font-size:16px;  font-family: Arial, sans-serif; display:inline-block; text-decoration:underline; padding-top:0.6rem;">Zobacz więcej</div></a>
									</div>
									
								</div>								
								<?php
								require_once "php/connect.php";
											$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
											
											$current_user_id = $_SESSION['id_user'];
											$sql = "SELECT photo FROM gallery WHERE id_user=$current_user_id LIMIT 9";
											$result = $conn->query($sql);
											
							
								if ($result->num_rows > 0) 
											{
												echo
								'<div id="gallery">'.
										'<div style="color: #E3E3E3; font-size:22px; float:left"><a class="underline" href="gallery.php"> Moja galeria:</a></div><div class="kog" id="cog" style="float:right; font-size: 2rem;"></div>'.
											'<div style="clear:both;"></div>'.	
										'<div style="padding-top:2rem; text-align: center;">'.
											'<div style=" padding-left: 2.5%; text-align: left;">';
										
											
										
											while($row = $result->fetch_assoc()) 
												{
												echo
													'<table style="display:inline;">'.
														'<tr>'.
															'<td class="padding"><a class="example-image-link" href="data:image/jpeg;base64,'.base64_encode($row['photo']).'" data-lightbox="example-set" data-title="&nbsp;"><img src="data:image/jpeg;base64,'.base64_encode($row['photo']).'"  height="107px" width="107px" style="border-radius: 12px 12px 12px 12px;"></td></a>'. 
														'</tr>'.
													'</table>';
											}
										
										echo
										'<div style="clear:both;"></div>'.
										'</div>'.
										'<a href="gallery.php"><div style="color: #0f96f0; font-size:16px;  font-family: Arial, sans-serif; display:inline-block; text-decoration:underline; padding-top:0.5rem;">Zobacz więcej</div></a>'.
									
								'</div>'.
									
								'</div>';
										
												} 
										
										$conn->close();
								?>
								<div class="Leftbarbottom">
									<ul >
										<li class="leftbarbottomstyle"><a href=""><span> Regulamin</span></a><span style="padding-left:4px; padding-right:4px;">&middot;</span><a href=""><span>Kontakt</span></a></li>
										<li class="leftbarbottomstyle"><span> Olympus 2022 <i class="far fa-copyright"></i> Made by Dawid Brodecki. All rights reserved.</span> </li>
									</ul>
								</div>
							</div>		
						</div>
						
						<div id="rightbar">
							
							<div id="WallText">
								<div style="float:left; padding-top:3.8px;">Moja tablica:</div>
								<div style="float:right;" class="walltext-filtr"><i class="fas fa-filter fa-xs"></i></div>
							</div>
				
								<div style="clear:both;"></div>
							
							<div id="MyPublications-container">
									<div id="MyPublications-content" >
										<table style="position:relative;" >
											<tr>
												<td style="display:block; width:55px; height:55px;"><td style="position:absolute; left:0; top: 0;">
														<a href="user-profile.php" >						
															<?php 
																if(@$_SESSION['zaktualizowano_avatar']!=TRUE)
																{
																	echo '<img class="borderradius" height="55px" width="55px"  src="data:image/jpeg;base64,'.base64_encode($_SESSION['user_avatar']).'">';
																}
																else
																{
																	echo '<img class="borderradius" height="55px" width="55px" src="data:image/jpeg;base64,'.base64_encode($_SESSION['new_avatar']).'">';
																}		
															?>
														</a>
												</td></td>
												<td style="padding:8px 0px 0px 5px; max-width:91.9%; overflow:hidden;">
													<div id="MyPublications-WhatsUp" class="textarea-div" > 
										<form enctype="multipart/form-data" action="php/posts.php" method="POST">
															<textarea id="autoresizing" name="textarea" rows="1"  Placeholder="Co słychać, <?php echo $_SESSION['imie'].'?';?>"></textarea>	
													</div>
														<div style="clear:both;"></div>
												</td>
											</tr>
											<tr>
												<td colspan="2" style="text-align:center;"><img id="preview4" style="padding-left:14px;"></td>
											</tr>
										</table>	
										<hr style="width:98%; margin-left:1px; border: 0; border-top: 1px solid DimGray; ">
											
										<div id="ShareOptions">
												  <input  type="file" name="post_photo" onchange="loadFile4(event)" style="display:none;" id="post_photo_btn"><label for="post_photo_btn" class="UploadPhoto"><i class="fas fa-image"></i><span style="padding-left:6px;">Wstaw zdjęcie</span></label>
												  <button class="ButtonGlobal share" name="publishbtn_start" >Opublikuj</button>
												 <div id="SharingOptions">

														<select id="visibility" name="visibility">
															  <option class="SharingOptions-show" value="everyone"><i class="fas fa-globe-europe fa-sm"></i><span style="margin-left:7px;">Wszyscy</span></option>
															  <option class="SharingOptions-show" value="friends"><i style="margin-left:-4px;"class="fas fa-user-friends fa-sm"></i><span style="margin-left:7px;">Znajomi</span></option>
															  <option class="SharingOptions-show" value="only-me"><i style="margin-left:-4px;" class="fa fa-lock fa-sm"></i><span style="margin-left:8px;">Tylko ja</span></option>
														</select>

												  </div>
										</form> 		  
										</div>	
									</div>
									<script src="js/autoresizing.js"></script>
									<script src="js/dropdown.js"></script>		
							</div>
							
								<div style="clear:both;"></div>
								
							<?php 
							
							require_once "php/connect.php";
									
									$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
									
									$current_user_id = $_SESSION['id_user'];
									$privewall_query = "SELECT * FROM posts WHERE id_user IN (SELECT id_friend FROM relations WHERE id_user = $current_user_id) OR id_user = $current_user_id AND (visibility = 'friends' OR visibility='everyone' OR visibility='only-me') ORDER BY time DESC, date DESC";
									$sql_privetwall_query = $conn->query($privewall_query);
									
						
									if ($sql_privetwall_query->num_rows > 0) 
										{
										while($row_privatewall = $sql_privetwall_query->fetch_assoc()) 
											{
											
											if (($row_privatewall['id_user'] == $current_user_id) && (($row_privatewall['visibility'] == 'friends') || ($row_privatewall['visibility'] == 'everyone')))
												{
												echo '
												<div id="feedbackwall">
													<div id="feedbackwall-container" class="feedbackwall-container-padding">
														
														<div id="feedbackwall-container-firstsection">
															<div style="display:inline-block; ">';
																
																	if(@$_SESSION['zaktualizowano_avatar']!=TRUE)
																		{
																			echo '<img class="borderradius" height="50px" width="50px" src="data:image/jpeg;base64,'.base64_encode($_SESSION['user_avatar']).'">';
																		}
																	else
																		{
																			echo '<img class="borderradius" height="50px" width="50px" src="data:image/jpeg;base64,'.base64_encode($_SESSION['new_avatar']).'">';
																		}		
														echo		
															'</div>
															<div style="display:inline-block; position: relative; top: -0.85rem; left:0.35rem;">	
																<div  style=" color: #E3E3E3 font-weight:550; font-size:18px; padding-left:0.2em; "><span>'.$row_privatewall['author_name'].' '.$row_privatewall['author_lastname'].'</span> <span style="margin-left:-8px; position: relative; top: -1.5px; ">'.$_SESSION['weryfikacja_konta'].'</span></div>
																<div  style=" color: #b0b3b8; font-size:14px; padding-left:0.1em; padding-top:0.3rem; "><span> @'.$row_privatewall['author_nickname'].'</span> <span style="padding-left:2px; padding-right:5px; font-weight:550;">&middot;</span><span>'.$row_privatewall['time'].' &middot; '.$row_privatewall['date'].'</span><span style="padding-left:2px; padding-right:5px; font-weight:550;"> &middot;</span><span>';
															
															if ($row_privatewall['visibility'] == "everyone")
																{
																	echo '<i class="fas fa-globe"></i>';
																}
																if ($row_privatewall['visibility'] == "friends")
																{
																	echo '<i class="fas fa-users"></i>';
																}
							
															echo	
																'</span></div>
															</div>	
														</div>
									
														<div id="feedbackwall-container-secondsection">
															<p>
																'.$row_privatewall['text'].'
															</p>
											
															<div class="PostPlaceholder">';
															
															if (empty($row_privatewall['image']))
															{
																echo '<div style="margin-top:5px;"></div>';
															}
															else
															{
																echo '<a class="example-image-link" href="data:image/jpeg;base64,'.base64_encode($row_privatewall['image']).'" data-lightbox="'.$row_privatewall['id_post'].'" data-title="&nbsp;"><img src="data:image/jpeg;base64,'.base64_encode($row_privatewall['image']).'" style="height:50rem; max-width:100%;"></a>';
															}
															
														echo
															'</div>
														</div>
														<hr style="width:100%;  border: 0; border-top: 1px solid DimGray; ">
														<div id="feedbackwall-container-thirdsection">
										
															<div class="Like-Share-Comment">
																<table style="width:99%;">
																	<tr>	
																		<td style="text-align:left; width:30%; "><span class="comment"><i class="fas fa-comments"></i><span> Komentarze </span></span ></td>
																		<td style="text-align:center; width:30%;"><span class="sharing"><i class="fas fa-retweet fa-xs"></i><span style="padding-left:4px;">Udostępnij</span></span></td>
																		<td style="text-align:right; width:30%;"><span class="like"><i class="fas fa-laugh-wink fa-1x"></i><span style="padding-left:1px;"> Lubię</span><span style="font-size:16px;"> 9</span></span></td>
																		</td>
																</table>
															</div>
														</div>
													</div>
												</div>';
												}
												
												if (($row_privatewall['id_user'] == $current_user_id) && ($row_privatewall['visibility'] == 'only-me'))
												{
												echo '
												<div id="feedbackwall">
													<div id="feedbackwall-container" class="feedbackwall-container-padding">
														
														<div id="feedbackwall-container-firstsection">
															<div style="display:inline-block; ">';
																
																	if(@$_SESSION['zaktualizowano_avatar']!=TRUE)
																		{
																			echo '<img class="borderradius" height="50px" width="50px" src="data:image/jpeg;base64,'.base64_encode($_SESSION['user_avatar']).'">';
																		}
																	else
																		{
																			echo '<img class="borderradius" height="50px" width="50px" src="data:image/jpeg;base64,'.base64_encode($_SESSION['new_avatar']).'">';
																		}		
														echo		
															'</div>
															<div style="display:inline-block; position: relative; top: -0.85rem; left:0.35rem;">	
																<div  style=" color: #E3E3E3 font-weight:550; font-size:18px; padding-left:0.2em; "><span>'.$row_privatewall['author_name'].' '.$row_privatewall['author_lastname'].'</span> <span style="margin-left:-8px; position: relative; top: -1.5px; ">'.$_SESSION['weryfikacja_konta'].'</span></div>
																<div  style=" color: #b0b3b8; font-size:14px; padding-left:0.1em; padding-top:0.3rem; "><span> @'.$row_privatewall['author_nickname'].'</span> <span style="padding-left:2px; padding-right:5px; font-weight:550;">&middot;</span><span>'.$row_privatewall['time'].' &middot; '.$row_privatewall['date'].'</span><span style="padding-left:2px; padding-right:5px; font-weight:550;"> &middot;</span><span>';
																
																if ($row_privatewall['visibility'] == "only-me")
																{
																	echo '<i class="fas fa-lock"></i>';
																}
																
														echo 	
															'</span></div>
															</div>	
														</div>
														<div id="feedbackwall-container-secondsection">
															<p>
																'.$row_privatewall['text'].'
															</p>
											
															<div class="PostPlaceholder">';
															
															if (empty($row_privatewall['image']))
															{
																echo '<div style="margin-top:5px;"></div>';
															}
															else
															{
																echo '<a class="example-image-link" href="data:image/jpeg;base64,'.base64_encode($row_privatewall['image']).'" data-lightbox="'.$row_privatewall['id_post'].'" data-title="&nbsp;"><img src="data:image/jpeg;base64,'.base64_encode($row_privatewall['image']).'" style="height:50rem; max-width:100%;"></a>';
															}
															
														echo
															'</div>
														</div>
														<hr style="width:100%;  border: 0; border-top: 1px solid DimGray; ">
														<div id="feedbackwall-container-thirdsection">
										
															<div class="Like-Share-Comment">
																<table style="width:99%;">
																	<tr>	
																		<td style="text-align:left; width:30%; "><span class="comment"><i class="fas fa-comments"></i><span> Komentarze </span></span ></td>
																		<td style="text-align:center; width:30%;"><span class="sharing"><i class="fas fa-retweet fa-xs"></i><span style="padding-left:4px;">Udostępnij</span></span></td>
																		<td style="text-align:right; width:30%;"><span class="like"><i class="fas fa-laugh-wink fa-1x"></i><span style="padding-left:1px;"> Lubię</span><span style="font-size:16px;"> 9</span></span></td>
																		</td>
																</table>
															</div>
														</div>
													</div>
												</div>';
												}
											} 
										}
							
							
										$conn->close();
							?>
					
						</div>
				
							<div style="clear:both;"></div>
</div>

<script src="js/modal.js"> </script>
<script src="js/modal2.js"> </script>
<script src="js/modal5.js"> </script>
<script src="js/preview.js"> </script>
<script src="js/preview3.js"> </script>
<script src="js/preview4.js"> </script>
<script src="js/dropdown.js"> </script>
<script src="js/autoresizing.js"> </script>
<script src="js/user_description.js"> </script>
<script src="js/text_clear.js"> </script>
<script src="dist/js/lightbox-plus-jquery.min.js"></script>
<script src="js/display_search_result_header.js"> </script>

</body>
</html>




