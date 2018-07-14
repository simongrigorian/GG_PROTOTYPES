<?php
//manual insertions...

//insert into champions_info (champions, hp, mov) values ("ranged_pawn", 10, 4);
//insert into champions_info (champions, hp, mov) values ("soldier_pawn", 20, 3);
//insert into champions_info (champions, hp, mov) values ("default_rook", 30, 5);
//insert into champions_info (champions, hp, mov) values ("default_knight", 60, 4);
//insert into champions_info (champions, hp, mov) values ("default_bishop", 40, 4);
//insert into champions_info (champions, hp, mov) values ("ranged_lord", 40, 6);
//insert into champions_info (champions, hp, mov) values ("soldier_lord", 60, 6);

//insert into users_setup (username, pawn1, pawn2, pawn3, pawn4, pawn5, bishop, knight, rook, lord) values ("Rambo", "soldier_pawn", "soldier_pawn", "soldier_pawn", "soldier_pawn", "soldier_pawn", "default_bishop", "default_knight", "default_rook", "soldier_lord");
//insert into users_setup (username, pawn1, pawn2, pawn3, pawn4, pawn5, bishop, knight, rook, lord) values ("Juju", "ranged_pawn", "ranged_pawn", "ranged_pawn", "ranged_pawn", "ranged_pawn", "default_bishop", "default_knight", "default_rook", "ranged_lord");

//update users_setup set pawn1_pos = 96, pawn2_pos = 97, pawn3_pos = 98, pawn4_pos = 99, pawn5_pos = 100, rook_pos = 109, knight_pos = 110, bishop_pos = 111, lord_pos = 113 where username = "Juju";
//update users_setup set pawn1_pos = 107, pawn2_pos = 106, pawn3_pos = 105, pawn4_pos = 104, pawn5_pos = 103, rook_pos = 118, knight_pos = 117, bishop_pos = 116, lord_pos = 114 where username = "Rambo";

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

function changePosition()
{
	$relay = -1;
	
	return $relay;
}
//############################################## MAIN WEB SERVICE CODE ###################################################\\
connect();

$pos = isset(mysqli_real_escape_string($conn, $_POST['pos']));
$func = isset(mysqli_real_escape_string($conn, $_POST['func']));

error_log("something is $something");

$response = 0;

switch($func)
{
    case 'changePos':
      $response = changePosition($pos);
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
