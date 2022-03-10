<?php

session_start();

	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: signin.php');
		exit();
	}
	
require_once "connect.php";
$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);

if (!empty ($_GET['q']))
{
	
	$q=$_GET['q'];
	$query="SELECT imie, nazwisko, nickname, user_avatar FROM users WHERE 
	imie LIKE '%$q%' OR
	nazwisko LIKE '%$q%' OR
	nickname LIKE '%$q%' 
	LIMIT 7
	";
	
	$result = mysqli_query ($conn, $query);

	if ($result->num_rows > 0) 
	{
		while ($output = mysqli_fetch_assoc($result))
		{
			echo '<a>'.
				'<div class="search_rows_style">
					<table>
						<tr>
							<td><img style="border-radius: 12px 12px;" height="42px" width="42px"  src="data:image/jpeg;base64,'.base64_encode($output['user_avatar']).'">'.
							'<td style="padding-left:0.5rem; position:relative; top:-1px;">'.
								'<div style="display:inline; font-size:15.5px;">'.$output['imie'].' '.$output['nazwisko'].'</div>'.' '.
								'<div style="font-size:13px; display:inline; color:#b0b3b8;">'.'@'.$output['nickname'].'</div>
							</td>
						</tr>
					</table>
				</div>
			</a>';
		}
	}
	else
	{
		echo '<a><div style="font-size:18px; padding:6px; color:#e3e3e3">Brak wyników</div> </a>';
	}
	
}

?>

<?php

require_once "connect.php";
$conn = @new mysqli($serverhost, $db_admin, $db_password, $database);

if (!empty ($_GET['list']))
{
	
	$list=$_GET['list'];
	$current_user_id = $_SESSION['id_user'];
	
	$query="SELECT users.imie, users.nazwisko, users.nickname, users.user_avatar FROM users, relations 
	WHERE relations.id_user=$current_user_id AND users.id_user=relations.id_friend AND 
	(users.imie LIKE '%$list%' OR
	users.nazwisko LIKE '%$list%' OR
	users.nickname LIKE '%$list%')
	LIMIT 5
	";

	
	$result = mysqli_query ($conn, $query);

	if ($result->num_rows > 0) 
	{
		while ($output = mysqli_fetch_assoc($result))
		{
			echo '<a>'.
				'<div class="search_rows_style">
					<table>
						<tr>
							<td><img style="border-radius: 12px 12px;" height="42px" width="42px"  src="data:image/jpeg;base64,'.base64_encode($output['user_avatar']).'">'.
							'<td style="padding-left:0.5rem; position:relative; top:-1px;">'.
								'<div style="display:inline; font-size:15.5px;">'.$output['imie'].' '.$output['nazwisko'].'</div>'.' '.
								'<div style="font-size:13px; display:inline; color:#b0b3b8;">'.'@'.$output['nickname'].'</div>
							</td>
						</tr>
					</table>
				</div>
			</a>';
		}
	}
	else
	{
		echo '<a><div style="font-size:18px; padding:6px; color:#e3e3e3">Brak wyników</div> </a>';
	}
	
}

?>


