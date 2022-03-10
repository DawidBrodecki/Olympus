<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: signin.php');
		exit();
	}
	
	@require_once "php/show_invitation.php";
	
	
	require_once "php/connect.php";
									
	$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
									
	$current_user_id = $_SESSION['id_user'];
	$wall_query = "SELECT * FROM posts WHERE id_user IN (SELECT id_friend FROM relations WHERE id_user = $current_user_id) OR id_user = $current_user_id AND (visibility = 'friends' OR visibility='everyone' OR visibility='only-me') ORDER BY time DESC, date DESC";
	$sql_wall_query = $conn->query($wall_query);



	
?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title> Olympus | Strona Główna</title>
	<meta name="description" content="Olympus - projekt serwisu społecznościowego jako propozycja pracy magisterskiej."/>
	<meta name="keywords" content="Portal spolecznosciowy, komunikator, znajomi, wiadomosci"/>
	<meta charset="utf-8">
	<meta name="author" content="Dawid Brodecki" />
	<meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1"/>
	<meta http-equiv="cache-control" content="no-cache">
	<link rel="stylesheet" href="css/index.css" type="text/css"/>
	<link rel="stylesheet" href="css/body.css" type="text/css"/>
	<link rel="stylesheet" href="css/header.css" type="text/css"/>
	<link rel="stylesheet" href="css/search.css" type="text/css"/>
	<link rel="stylesheet" href="css/content.css" type="text/css">
	<link rel="stylesheet" href="css/dropdown.css" type="text/css">
	<link rel="stylesheet" href="css/contacts_search.css" type="text/css">
	<link rel="stylesheet" href="css/invitation.css" type="text/css">
	<link rel="stylesheet" href="dist/css/lightbox.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css'>
	<script src="https://kit.fontawesome.com/b0413121fe.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/autoresizing.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">

</head>


<body>

<div id="container" class="modal">


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
					<div style="float:left"><input  id="search" class="search" name="search" type="search" placeholder="Przeszukaj Olympusa..." autocomplete="off" novalidate /></div>
					<div style="clear:both;"></div>
				<div id="display_search"></div>
			</div>
		</div>
		
		<div class="header-middle_section">
			<div class="MainPageBtn">
				<div class="tooltip"><a href="index.php"><i class="fas fa-home fa-6x" id="MainButton" ></i></a><span class="tooltiptext">Strona Główna</span></div>
			</div>
		</div>
		
		<div class="header-right_section">
			
			<div id="nav">
				<ul>
					<li class="linav"><a class="NavStyle" href="user-profile.php"><i class="fas fa-house-user"></i>&nbsp;Profil</a></li><span style="color:white; cursor:default;">|</span>
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


	<div id="leftbar"  class="sticky">
		
			<a href="user-profile.php"><div class="leftbaroptions">
					<div class="thumbnail">					
						<?php 
							if(@$_SESSION['zaktualizowano_avatar']!=TRUE)
							{
								echo '<img class="borderradius" height="50px" width="50px"  src="data:image/jpeg;base64,'.base64_encode($_SESSION['user_avatar']).'">';
							}
							else
							{
								echo '<img class="borderradius" height="50px" width="50px" src="data:image/jpeg;base64,'.base64_encode($_SESSION['new_avatar']).'">';
							}		
						?>
					</div>
					<div class="thumbnailcontent">
						<ul >
							<li class="thumbnailcontentstyle"><span><?php echo $_SESSION['imie']." ".$_SESSION['nazwisko'];?></span></li>
							<li class="thumbnailcontentstyle"><span><?php echo "@".$_SESSION['nickname']; ?></span></li>
						<ul>
					</div>	
			</div></a>
			
			<div class="leftbaroptions">
					
					<div class="thumbnail"  id="fafa"><i class="fas fa-envelope fa-5x" ></i></div>
					<div class="thumbnailcontent" id="thumbnailpush"	>
						<ul >
							<li class="thumbnailcontentstyle"  ><span>Wiadomości</span></li>
						<ul>
					</div>	
			</div>
			
				<a href="friends-list.php"><div class="leftbaroptions">
				<div class="thumbnail" id="fafa"><i class="fas fa-users fa-4x"></i></div>
					<div class="thumbnailcontent" id="thumbnailpush">
						<ul >
							<li class="thumbnailcontentstyle" ><span>Znajomi</span></li>
						<ul>
					</div>
			</div>	</a>
			
			<a href="likes-list.php"><div class="leftbaroptions">
						<div class="thumbnail" id="fafa"><i class="fas fa-laugh-wink fa-5x"></i></div>
					<div class="thumbnailcontent" id="thumbnailpush">
						<ul >
						<li class="thumbnailcontentstyle" ><span>Polubienia</span></li>
						<ul>
					</div>
			</div>	</a>
			
			<a href="gallery.php"><div class="leftbaroptions">
					<div class="thumbnail" id="fafa"><i class="fas fa-images fa-4x"></i></div>
					<div class="thumbnailcontent" id="thumbnailpush" >
						<ul >
							<li class="thumbnailcontentstyle"  style="margin-top:-6px; margin-left:2.9px;"><span>Galeria</span></li>
						<ul>
					</div>	
			</div></a>
			
			<div class="Leftbarbottom">
					<ul >
						<li class="leftbarbottomstyle"><a href=""><span> Regulamin</span></a><span style="padding-left:4px; padding-right:4px;">&middot;</span><a href=""><span>Kontakt</span></a></li>
						<li class="leftbarbottomstyle"><span> Olympus 2022 <i class="far fa-copyright"></i> Made by Dawid Brodecki. All rights reserved.</span> </li>
					</ul>
		</div>
		<div style="clear:both;"></div>
	</div>
	
	<div id="mainbar">
		<div id="WallText">
			<div style="float:left; padding-top:3.8px;">Przeglądaj tablice</div>
			<div class="walltext-filtr"><i class="fas fa-filter fa-xs"></i></div>
		</div>
		
		<div id="MyPublications-container" style="padding-bottom:2.7rem;">
				<div id="MyPublications-content">
					<table>
						<tr>
							<td>
								<div>
									<a href="user-profile.php">						
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
								</div>
							</td>
							<td>
								<div id="MyPublications-WhatsUp"> 
					<form action="" >
										<textarea id="autoresizing" name="textarea" rows="1"  Placeholder="Co słychać, <?php echo $_SESSION['imie'].'?';?>"></textarea>	
								</div>
							</td>
						</tr>
					</table>	
					<hr style="width:98%; margin-left:1px; border: 0; border-top: 1px solid DimGray;">
						</form> 
					<div id="ShareOptions">
							  <div class="UploadPhoto"><i class="fas fa-image"></i><span style="padding-left:6px;">Wstaw zdjęcie</span></div>
							  <div class="share">Opublikuj</div>
							 
							 <div id="SharingOptions"><button onclick="myFunction()" class="dropbtn">&#127757;</button>
								<div id="myDropdown" class="SharingOptions-Toggle">
									<div class="SharingOptions-show"><i class="fas fa-globe-europe fa-sm"></i><span style="margin-left:7px;">Wszyscy</span></div>
									<div class="SharingOptions-show"><i style="margin-left:-4px;"class="fas fa-user-friends fa-sm"></i><span style="margin-left:7px;">Znajomi</span></div>
									<div class="SharingOptions-show"><i style="margin-left:-4px;" class="fa fa-lock fa-sm"></i><span style="margin-left:8px;">Tylko ja</span></div>
								</div>
							  </div>
							  
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

									if ($sql_wall_query->num_rows > 0) 
										{
										while($row_wall = $sql_wall_query->fetch_assoc()) 
											{
												
											if (($row_wall['visibility'] == 'everyone') || ($row_wall['visibility'] == 'friends'))
											{
												echo '
												<div id="feedbackwall">
													<div id="feedbackwall-container" class="">
														
														<div id="feedbackwall-container-firstsection">
															<div style="display:inline-block; ">';
																
																			echo '<img class="borderradius" height="50px" width="50px" src="data:image/jpeg;base64,'.base64_encode($row_wall['author_avatar']).'">';
																			
														echo		
															'</div>
															<div style="display:inline-block; position: relative; top: -0.85rem; left:0.35rem;">	
																<div  style=" color: #E3E3E3 font-weight:550; font-size:18px; padding-left:0.2em; "><span>'.$row_wall['author_name'].' '.$row_wall['author_lastname'].'</span> <span style="margin-left:-8px;">';
			
																	if ($row_wall['veryfication'] == "tak")
																	{
																		echo '<span style="position: relative; top: -1.5px; margin-left:10px; padding-right:3px;"><i class="fas fa-check-circle fa-xs"></i></span>';
																	}
																	else
																	{
																		echo ' ';
																	}
																
															echo
																'</span></div>
																<div  style=" color: #b0b3b8; font-size:14px; padding-left:0.1em; padding-top:0.3rem; "><span> @'.$row_wall['author_nickname'].'</span> <span style="padding-left:2px; padding-right:5px; font-weight:550;">&middot;</span><span>'.$row_wall['time'].' &middot; '.$row_wall['date'].'</span><span style="padding-left:2px; padding-right:5px; font-weight:550;"> &middot;</span><span>';
																
																if ($row_wall['visibility'] == "everyone")
																{
																	echo '<i class="fas fa-globe"></i>';
																}
																if ($row_wall['visibility'] == "friends")
																{
																	echo '<i class="fas fa-users"></i>';
																}
															
															echo
																'</div>
															</div>	
														</div>
									
														<div id="feedbackwall-container-secondsection">
															<p>
																'.$row_wall['text'].'
															</p>
											
															<div style="text-align:center;">';
															
															if (empty($row_wall['image']))
															{
																echo '<div style="margin-top:5px;"></div>';
															}
															else
															{
																echo '<a class="example-image-link" href="data:image/jpeg;base64,'.base64_encode($row_wall['image']).'" data-lightbox="'.$row_wall['id_post'].'" data-title="&nbsp;"><img src="data:image/jpeg;base64,'.base64_encode($row_wall['image']).'" style="height:50rem; max-width:100%;"></a>';
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
		
	<div id="rightbar" class="sticky">
		
		
		<div id="rightbar-uppersection"> 
			<div class="iconscolumn" style="margin-top:9px; width:38%;">
				<div>Kontakty:</div>
			</div>
			<div class="rightbar-icons" style="padding: 3px 4px 3px 4px;"><i class="fas fa-users-cog fa-sm"></i></div>	
				<div class="iconscolumn" style="">
					<div id="sb-search" class="sb-search">
							<form>
								<input class="sb-search-input" placeholder="Wyszukaj znajomych" type="text" value="" name="csearch" id="csearch" autocomplete="off">
								<input class="sb-search-submit" type="submit" value="">
								<span class="sb-icon-search"  style="padding: 6px 7px 6px 7px;"><i class="fas fa-search fa-sm"></i></span>
							</form>
							
							<script src="js/classie.js"></script>
							<script src="js/uisearch.js"></script>
							<script src="js/modernizr.custom.js"></script>
							<script>
								new UISearch( document.getElementById( 'sb-search' ) );
							</script>
					</div>
				</div>	
		</div>
		
		<div style="clear:both;"></div>
		
		<div id="rightbar-contentbar">
			
			<?php 
			
				require_once "php/connect.php";
				$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);
				
				$current_user_id = $_SESSION['id_user'];
				$sql = "SELECT users.imie, users.nazwisko, users.nickname, users.user_avatar, users.id_user FROM users, relations WHERE relations.id_user=$current_user_id  and relations.id_friend=users.id_user ORDER BY users.id_user ASC";
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) 
				{

			while($row = $result->fetch_assoc()) 
				{
					
					echo
					"<div class='rightbar-contacts'>".
					'<div class="rightbar-contacts-image">'.'<img class="borderradius" height="42px" width="42px"  src="data:image/jpeg;base64,'.base64_encode($row['user_avatar']).'">'."</div>".'<div class="rightbar-contacts-user">'.$row["imie"]." ".$row["nazwisko"]."</div>"."<br>".
					"</div>";
					

				}
	
				} 

			
			$conn->close();
				
			?>
			
		</div>
		
		
	
	</div>

</div>

	
<script src="js/modal.js"> </script>
<script src="js/display_search_result_header.js"> </script>
<script src="dist/js/lightbox-plus-jquery.min.js"></script>
</body>
</html>




