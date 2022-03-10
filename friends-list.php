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
	<link rel="stylesheet" href="css/friends&gallery.css" type="text/css"/>
	<link rel="stylesheet" href="css/invitation.css" type="text/css">
	<link rel="stylesheet" href="css/modal.css" type="text/css">
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
								$_SESSION['weryfikacja_konta'] = '<span style="margin-left:5px; padding-right:3px;"></span>';
							}
						?>
						<div id="my-username" style="float:left;">
							<div  class="textwrap my-username_padding"><span ><?php echo $_SESSION['imie']." ".$_SESSION['nazwisko'];?></span><?php echo $_SESSION['weryfikacja_konta']; ?></div>
							<div class="textwrap  my-username_padding" style="margin-top:5px; margin-left:1px;"> <?php echo '@'.$_SESSION['nickname']; ?></div>
						</div>		
							
					</div>
					<div style="clear:both;"></div>
			</div>
			
			<div style="float:left; width:81%; overflow:hidden;">
				
					<div id="userinfo">
						<table class="textwrap" style="position:relative; width:65%; max-width:65%; margin-left:25.5rem; ">
								<tr style="background-color:;">
									<td class="userinfo"> <div class="textwrap" style="max-width:28rem;  text-align: left;">Data dołączenia:  brak danych</div></td> 
									<td class="userinfo"> <div class="textwrap" style="max-width:22rem; margin-right:4rem;">Kraj:  brak danych</div></td> 
								<td style=""> 
										<div class="textwrap" style="max-width:35rem; display:inline-block; text-decoration:underline; ">Zamieszkuje:   brak danych</div>
										<div class="kog" style="display:inline-block;"><i style="position:relative; left: 10px; top:-6px;" class="fas fa-cog"></i></div>
									</td> 
								
								</tr>
								
								<tr style="background-color:;">
								<td class="userinfo"> <div  class="textwrap" style="max-width:28rem; text-align: left; ">Data urodzenia:  brak danych</div></td> 
								<td class="userinfo"> <div  class="textwrap" style="max-width:22rem;  margin-right:4rem;">Płeć:  brak danych</div></td> 
								<td class="userinfo" > <div  class="textwrap" style="max-width:40rem;   text-decoration:underline;">Pracuje/Uczy się: brak danych</div></td> 
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
					
			<div id="Mainbar">
			
				<div id="NavOptions" style="padding-bottom:3rem;">
					<div class="NavOptions">Moi znajomi:</div> 
					<?php
					
					require_once "php/connect.php";
					$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);		
					
					$current_user_id = $_SESSION['id_user'];				
					
					$result = $conn->query("SELECT COUNT('id_friend') FROM relations WHERE id_user=$current_user_id");
						while ($row = $result->fetch_assoc()) 
						{
							$_SESSION['number_of_friends'] = $row["COUNT('id_friend')"];
						}
		
					echo 
					'<div class="NavOptions" style="margin-left:3px;">&nbsp;'. $_SESSION['number_of_friends']. '</div>';
					?>
					
					<div id="search_friend_list"  style="float:right; margin-top:2px;">
							<div style="float:left"><i class="fas fa-search fa-2x" style="margin-left:8px; padding-top:1rem; color: #818181;"></i></div>
							<div style="float:left"><input  id="search_my_friends" class="search_my_friends" name="search_my_friends" type="search" placeholder="Znajdź znajomych..."   autocomplete="off" novalidate /></div>
							<div style="clear:both;"></div>
						<div id="display_list_of_friends" ></div>
					</div>
					<div style="clear:both;"></div>
				</div>
				
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
				'<div id="list-of-friends" >'.
					
					'<div class="columnleft">'.
						'<div class="friend" >'.
							'<table style="float:left;">'.
								'<tr >'.
									'<td >.<img class="friendsphoto" class="borderradius" src="data:image/jpeg;base64,'.base64_encode($row['user_avatar']).'" width="90px" height="90px"></td> <td><div class="friend-style">'.$row["imie"]." ".$row["nazwisko"].'</div> <div class="friend-style" style="color:#b0b0b0; font-weight:100;">@'.$row["nickname"].'</div> </td>'.
								'</td>'.
							'</table>'.
						'<div style="float:right; font-size:16.5px; color:#e3e3e3e3; position:relative; top: 36px; right:5px;" class="icononclick"><i class="fas fa-ellipsis-h"></i></div>'.
						'</div>'.
						'<div style="clear:both;"></div>'.
					'</div>'.
					
				'</div>';
				}
				} 

				$conn->close();		
			?>
			</div>
			
			
			<div style="float:left; width:18.8%; height:122px; background-color:blue; visibility:hidden;"></div>	


</div>

<script src="js/modal.js"> </script>
<script src="js/modal2.js"> </script>
<script src="js/modal5.js"> </script>
<script src="js/preview.js"> </script>
<script src="js/preview3.js"> </script>
<script src="dist/js/lightbox-plus-jquery.min.js"></script>
<script src="js/display_search_result_header.js"> </script>
<script src="js/display_search_result_my_friends.js"> </script>

</body>
</html>




