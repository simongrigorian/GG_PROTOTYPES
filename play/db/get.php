<?php
/* create table champions_info (champions varchar(20) not null primary key, hp int, mov int); */

/*create table users_setup(username varchar(16) primary key, pawn1 varchar(20) not null, pawn1_pos int not null default 0, pawn2 varchar(20) not null, pawn2_pos int not null default 0, pawn3 varchar(20) not null, pawn3_pos int not null default 0, pawn4 varchar(20) not null, pawn4_pos int not null default 0, pawn5 varchar(20) not null, pawn5_pos int not null default 0, bishop varchar(20) not null, bishop_pos int not null default 0, knight varchar(20) not null, knight_pos int not null default 0, rook varchar(20) not null, rook_pos int not null default 0, lord varchar(20) not null, lord_pos int not null default 0, foreign key(username) references users_table(username), foreign key(pawn1) references champions_info(champions), foreign key(pawn2) references champions_info(champions), foreign key(pawn3) references champions_info(champions), foreign key(pawn4) references champions_info(champions), foreign key(pawn5) references champions_info(champions), foreign key(bishop) references champions_info(champions), foreign key(knight) references champions_info(champions), foreign key(rook) references champions_info(champions), foreign key(lord) references champions_info(champions));
*/
//create table users_table (email VARCHAR(50) NOT NULL PRIMARY KEY, username VARCHAR(16) UNIQUE NOT NULL, password VARCHAR(255) NOT NULL, regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP);

/*//GAME STATE TABLES
create table games_state (id int primary key auto_increment not null, player1 varchar(16) not null, player2 varchar(16) not null, turn tinyint default 0 not null, state tinyint default 0 not null, foreign key(player1) references users_table(username), foreign key(player2) references users_table(username));
*/
/*//FIELD RECORD TABLE
create table field_recorder (id int primary key not null, tile int not null default 0, direction int not null default 0, goal int not null default 0, p1_animated tinyint not null default 1, p2_animated tinyint not null default 1, foreign key(id) references games_state(id));
*/
/*//CHARACTER STATES -HP, MOV, POS , ETC (NEED TO ADD MORE LATER)
create table users_state (id int not null, player varchar(16) primary key not null, pawn1_pos int not null, pawn1_hp int not null, pawn1_mov int not null, pawn2_pos int not null, pawn2_hp int not null, pawn2_mov int not null, pawn3_pos int not null, pawn3_hp int not null, pawn3_mov int not null, pawn4_pos int not null, pawn4_hp int not null, pawn4_mov int not null, pawn5_pos int not null, pawn5_hp int not null, pawn5_mov int not null, bishop_pos int not null, bishop_hp int not null, bishop_mov int not null, knight_pos int not null, knight_hp int not null, knight_mov int not null, rook_pos int not null, rook_hp int not null, rook_mov int not null, lord_pos int not null, lord_hp int not null, lord_mov int not null, foreign key(id) references games_state(id), foreign key(player) references users_table(username));
*/

$conn = 0;

//########################################
//### CONNECT AND DISCONNECT FUNCTIONS ###
//########################################

function connect()
{
  global $conn;
  $servername = "";
  $username = "";
  $password = "";
  $dbname = "";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error)
	die("Connection failed: " . $conn->connect_error);

}

function disconnect()
{
  global $conn;
  $conn->close();
}

//reset tables before you can get a result in the console
//truncate users_state; truncate field_recorder;
function getUserSetup($player1,$player2)
{
	global $conn;
	
	$player_pawn1; $player_pawn2; $player_pawn3; $player_pawn4; $player_pawn5; $player_bishop; $player_knight; $player_rook; $player_lord;
	$player_pawn1_pos; $player_pawn2_pos; $player_pawn3_pos; $player_pawn4_pos; $player_pawn5_pos; $player_bishop_pos; $player_knight_pos; $player_rook_pos; $player_lord_pos;
	$player_pawn1_hp; $player_pawn2_hp; $player_pawn3_hp; $player_pawn4_hp; $player_pawn5_hp; $player_bishop_hp; $player_knight_hp; $player_rook_hp; $player_lord_hp;
	$player_pawn1_mov; $player_pawn2_mov; $player_pawn3_mov; $player_pawn4_mov; $player_pawn5_mov; $player_bishop_mov; $player_knight_mov; $player_rook_mov; $player_lord_mov;
	
	$setup = -1;
	
	$stmt = $conn->prepare("SELECT users_setup.username,
	users_setup.pawn1, users_setup.pawn1_pos, c1.hp, c1.mov,
	users_setup.pawn2, users_setup.pawn2_pos, c2.hp, c2.mov,
	users_setup.pawn3, users_setup.pawn3_pos, c3.hp, c3.mov,
	users_setup.pawn4, users_setup.pawn4_pos, c4.hp, c4.mov,
	users_setup.pawn5, users_setup.pawn5_pos, c5.hp, c5.mov,
	users_setup.bishop, users_setup.bishop_pos, c6.hp, c6.mov,
	users_setup.knight, users_setup.knight_pos, c7.hp, c7.mov,
	users_setup.rook, users_setup.rook_pos, c8.hp, c8.mov,
	users_setup.lord, users_setup.lord_pos, c9.hp, c9.mov
	FROM users_setup
	LEFT OUTER JOIN champions_info c1 on users_setup.pawn1 = c1.champions
	LEFT OUTER JOIN champions_info c2 on users_setup.pawn2 = c2.champions
	LEFT OUTER JOIN champions_info c3 on users_setup.pawn3 = c3.champions
	LEFT OUTER JOIN champions_info c4 on users_setup.pawn4 = c4.champions
	LEFT OUTER JOIN champions_info c5 on users_setup.pawn5 = c5.champions
	LEFT OUTER JOIN champions_info c6 on users_setup.bishop = c6.champions
	LEFT OUTER JOIN champions_info c7 on users_setup.knight = c7.champions
	LEFT OUTER JOIN champions_info c8 on users_setup.rook = c8.champions
	LEFT OUTER JOIN champions_info c9 on users_setup.lord = c9.champions
	where users_setup.username = ? OR users_setup.username = ?");
							
	$stmt->bind_param('ss', $player1, $player2);
	if($stmt->execute())
	{
		$stmt->bind_result($playerName,
			$player_pawn1, $player_pawn1_pos, $player_pawn1_hp, $player_pawn1_mov, 
			$player_pawn2, $player_pawn2_pos, $player_pawn2_hp, $player_pawn2_mov, 
			$player_pawn3, $player_pawn3_pos, $player_pawn3_hp, $player_pawn3_mov, 
			$player_pawn4, $player_pawn4_pos, $player_pawn4_hp, $player_pawn4_mov,
			$player_pawn5, $player_pawn5_pos, $player_pawn5_hp, $player_pawn5_mov,
			$player_bishop, $player_bishop_pos, $player_bishop_hp, $player_bishop_mov,
			$player_knight, $player_knight_pos, $player_knight_hp, $player_knight_mov,
			$player_rook, $player_rook_pos, $player_rook_hp, $player_rook_mov,
			$player_lord, $player_lord_pos, $player_lord_hp, $player_lord_mov
		);
		
		while($stmt->fetch())
		{		
			if($playerName == $player1)
			{
				$setup = array("player1" => array("player" => $playerName,
				"player_pawn1" => $player_pawn1, "player_pawn1_pos" => $player_pawn1_pos, "player_pawn1_hp" => $player_pawn1_hp, "player_pawn1_mov" => $player_pawn1_mov,
				"player_pawn2" => $player_pawn2, "player_pawn2_pos" => $player_pawn2_pos, "player_pawn2_hp" => $player_pawn2_hp, "player_pawn2_mov" => $player_pawn2_mov,
				"player_pawn3" => $player_pawn3, "player_pawn3_pos" => $player_pawn3_pos, "player_pawn3_hp" => $player_pawn3_hp, "player_pawn3_mov" => $player_pawn3_mov,
				"player_pawn4" => $player_pawn4, "player_pawn4_pos" => $player_pawn4_pos, "player_pawn4_hp" => $player_pawn4_hp, "player_pawn4_mov" => $player_pawn4_mov,
				"player_pawn5" => $player_pawn5, "player_pawn5_pos" => $player_pawn5_pos, "player_pawn5_hp" => $player_pawn5_hp, "player_pawn5_mov" => $player_pawn5_mov,
				"player_bishop" => $player_bishop, "player_bishop_pos" => $player_bishop_pos, "player_bishop_hp" => $player_bishop_hp, "player_bishop_mov" => $player_bishop_mov,
				"player_knight" => $player_knight, "player_knight_pos" => $player_knight_pos, "player_knight_hp" => $player_knight_hp, "player_knight_mov" => $player_knight_mov,
				"player_rook" => $player_rook, "player_rook_pos" => $player_rook_pos, "player_rook_hp" => $player_rook_hp, "player_rook_mov" => $player_rook_mov,
				"player_lord" => $player_lord, "player_lord_pos" => $player_lord_pos, "player_lord_hp" => $player_lord_hp, "player_lord_mov" => $player_lord_mov));
			}
			
			else if($playerName == $player2)
			{
				$setup["player2"] = array("player" => $playerName,
				"player_pawn1" => $player_pawn1, "player_pawn1_pos" => $player_pawn1_pos, "player_pawn1_hp" => $player_pawn1_hp, "player_pawn1_mov" => $player_pawn1_mov, 
				"player_pawn2" => $player_pawn2, "player_pawn2_pos" => $player_pawn2_pos, "player_pawn2_hp" => $player_pawn2_hp, "player_pawn2_mov" => $player_pawn2_mov,
				"player_pawn3" => $player_pawn3, "player_pawn3_pos" => $player_pawn3_pos, "player_pawn3_hp" => $player_pawn3_hp, "player_pawn3_mov" => $player_pawn3_mov,
				"player_pawn4" => $player_pawn4, "player_pawn4_pos" => $player_pawn4_pos, "player_pawn4_hp" => $player_pawn4_hp, "player_pawn4_mov" => $player_pawn4_mov,
				"player_pawn5" => $player_pawn5, "player_pawn5_pos" => $player_pawn5_pos, "player_pawn5_hp" => $player_pawn5_hp, "player_pawn5_mov" => $player_pawn5_mov,
				"player_bishop" => $player_bishop, "player_bishop_pos" => $player_bishop_pos, "player_bishop_hp" => $player_bishop_hp, "player_bishop_mov" => $player_bishop_mov,
				"player_knight" => $player_knight, "player_knight_pos" => $player_knight_pos, "player_knight_hp" => $player_knight_hp, "player_knight_mov" => $player_knight_mov,
				"player_rook" => $player_rook, "player_rook_pos" => $player_rook_pos, "player_rook_hp" => $player_rook_hp, "player_rook_mov" => $player_rook_mov,
				"player_lord" => $player_lord, "player_lord_pos" => $player_lord_pos, "player_lord_hp" => $player_lord_hp, "player_lord_mov" => $player_lord_mov);
			}
		}
		$stmt->close();
		
		$stmt_insert_p1 = $conn->prepare("INSERT INTO users_state 
		(id, player, 
		pawn1_pos, pawn1_hp, pawn1_mov, 
		pawn2_pos, pawn2_hp, pawn2_mov, 
		pawn3_pos, pawn3_hp, pawn3_mov, 
		pawn4_pos, pawn4_hp, pawn4_mov, 
		pawn5_pos, pawn5_hp, pawn5_mov, 
		bishop_pos, bishop_hp, bishop_mov, 
		knight_pos, knight_hp, knight_mov, 
		rook_pos, rook_hp, rook_mov, 
		lord_pos, lord_hp, lord_mov) 
		VALUES(1, '" . $setup['player1']['player'] . "', "
		. $setup['player1']['player_pawn1_pos'] . ", " . $setup['player1']['player_pawn1_hp'] . ", " . $setup['player1']['player_pawn1_mov'] .", " 
		. $setup['player1']['player_pawn2_pos'] . ", " . $setup['player1']['player_pawn2_hp'] . ", " . $setup['player1']['player_pawn2_mov'] .", "
		. $setup['player1']['player_pawn3_pos'] . ", " . $setup['player1']['player_pawn3_hp'] . ", " . $setup['player1']['player_pawn3_mov'] .", "
		. $setup['player1']['player_pawn4_pos'] . ", " . $setup['player1']['player_pawn4_hp'] . ", " . $setup['player1']['player_pawn4_mov'] .", "
		. $setup['player1']['player_pawn5_pos'] . ", " . $setup['player1']['player_pawn5_hp'] . ", " . $setup['player1']['player_pawn5_mov'] .", "
		. $setup['player1']['player_bishop_pos'] . ", " . $setup['player1']['player_bishop_hp'] . ", " . $setup['player1']['player_bishop_mov'] .", "
		. $setup['player1']['player_knight_pos'] . ", " . $setup['player1']['player_knight_hp'] . ", " . $setup['player1']['player_knight_mov'] .", "
		. $setup['player1']['player_rook_pos'] . ", " . $setup['player1']['player_rook_hp'] . ", " . $setup['player1']['player_rook_mov'] .", "
		. $setup['player1']['player_lord_pos'] . ", " . $setup['player1']['player_lord_hp'] . ", " . $setup['player1']['player_lord_mov'] .")");
		
		if($stmt_insert_p1->execute())
		{
			$stmt_insert_p1->close();
	
			$stmt_insert_p2 = $conn->prepare("INSERT INTO users_state 
			(id, player, 
			pawn1_pos, pawn1_hp, pawn1_mov, 
			pawn2_pos, pawn2_hp, pawn2_mov, 
			pawn3_pos, pawn3_hp, pawn3_mov, 
			pawn4_pos, pawn4_hp, pawn4_mov, 
			pawn5_pos, pawn5_hp, pawn5_mov, 
			bishop_pos, bishop_hp, bishop_mov, 
			knight_pos, knight_hp, knight_mov, 
			rook_pos, rook_hp, rook_mov, 
			lord_pos, lord_hp, lord_mov) 
			VALUES(1, '" . $setup['player2']['player'] . "', "
			. $setup['player2']['player_pawn1_pos'] . ", " . $setup['player2']['player_pawn1_hp'] . ", " . $setup['player2']['player_pawn1_mov'] .", " 
			. $setup['player2']['player_pawn2_pos'] . ", " . $setup['player2']['player_pawn2_hp'] . ", " . $setup['player2']['player_pawn2_mov'] .", "
			. $setup['player2']['player_pawn3_pos'] . ", " . $setup['player2']['player_pawn3_hp'] . ", " . $setup['player2']['player_pawn3_mov'] .", "
			. $setup['player2']['player_pawn4_pos'] . ", " . $setup['player2']['player_pawn4_hp'] . ", " . $setup['player2']['player_pawn4_mov'] .", "
			. $setup['player2']['player_pawn5_pos'] . ", " . $setup['player2']['player_pawn5_hp'] . ", " . $setup['player2']['player_pawn5_mov'] .", "
			. $setup['player2']['player_bishop_pos'] . ", " . $setup['player2']['player_bishop_hp'] . ", " . $setup['player2']['player_bishop_mov'] .", "
			. $setup['player2']['player_knight_pos'] . ", " . $setup['player2']['player_knight_hp'] . ", " . $setup['player2']['player_knight_mov'] .", "
			. $setup['player2']['player_rook_pos'] . ", " . $setup['player2']['player_rook_hp'] . ", " . $setup['player2']['player_rook_mov'] .", "
			. $setup['player2']['player_lord_pos'] . ", " . $setup['player2']['player_lord_hp'] . ", " . $setup['player2']['player_lord_mov'] .")");
			
			if($stmt_insert_p2->execute())
			{
			
				$stmt_insert_p2->close();
				
				$stmt_insert_field = $conn->prepare("INSERT INTO field_recorder (id) VALUES (1)");
				
				if($stmt_insert_field->execute())
				{
					$stmt_insert_field->close();
					
					$stmt_ready_game = $conn->prepare("UPDATE games_state SET turn = 1, state = 1 WHERE id = 1 AND player1 = '$player1' AND player2 = '$player2'");
					
					if($stmt_ready_game->execute())
					{
						$stmt_ready_game->close();	
					}
					else
					{
						$stmt_ready_game->close();
						$setup = -1;
					}
				}
				else
				{
					$stmt_insert_field->close();
					$setup = -1;
				}
			}
			else
			{
				$stmt_insert_p2->close();
				$setup = -1;
			}
		}
		else
		{
			$stmt_insert_p1->close();
			$setup = -1;
		}
	}
	else
	{
		$stmt->close();
		$setup = -1;
	}
	return $setup;
}
//############################################## MAIN WEB SERVICE CODE ###################################################\\
connect();

$func = mysqli_real_escape_string($conn, $_POST['func']);
$player1 = mysqli_real_escape_string($conn, $_POST['player1']);
$player2 = mysqli_real_escape_string($conn, $_POST['player2']);


error_log("func is $func and player1 is $player1");

$response = 0;

switch($func) 
{
    case 'setup':
      $response = getUserSetup($player1,$player2); 
	break;
	
	default:
		//nada
	break;
}

header('Content-Type: application/json; charset=utf-8');
$responseJSON = json_encode($response);

echo $responseJSON;

disconnect(); // from DB
?>
