//var char1 = character({pos:50, hp: 10, mov:5});
/*
char1.setPos(10);
console.log("position = " + char1.pos);
char1.setPos(16);
console.log("new position = " + char1.pos);
char1.setHp(15);
console.log("health = " + char1.hp);
*/
//GLOBAL CHARACTER INITIALIZATIONS
//PLAYER 1 PIECES
var p1_pawn1 = character({});
var p1_pawn2 = character({});
var p1_pawn3 = character({});
var p1_pawn4 = character({});
var p1_pawn5 = character({});
var p1_bishop = character({});
var p1_rook = character({});
var p1_knight = character({});
var p1_lord = character({});

//PLAYER 2 PIECES
var p2_pawn1 = character({});
var p2_pawn2 = character({});
var p2_pawn3 = character({});
var p2_pawn4 = character({});
var p2_pawn5 = character({});
var p2_bishop = character({});
var p2_rook = character({});
var p2_knight = character({});
var p2_lord = character({});

//AI PIECES
var ai_pawn1 = character({});
var ai_pawn2 = character({});
var ai_pawn3 = character({});
var ai_pawn4 = character({});
var ai_pawn5 = character({});
var ai_pawn6 = character({});
var ai_pawn7 = character({});
var ai_pawn8 = character({});
var ai_pawn9 = character({});
var ai_pawn10 = character({});
var ai_pawn11 = character({});
var ai_pawn12 = character({});
var ai_pawn13 = character({});
var ai_pawn14 = character({});
var ai_pawn15 = character({});
var ai_bishop = character({});
var ai_rook = character({});
var ai_knight = character({});
var ai_lord = character({});

var getArray;

$.ajax({type: "POST", url:"db/get.php", data: {func:"setup", player1:"Juju", player2:"Rambo"}, success: function(result)
{
	getArray = result;
	if(result != -1)
	{
		var p1 = result.player1;
		var p2 = result.player2;

		//SET PLAYER 1 CHAMPION STATS
		p1_pawn1.setPos(p1.player_pawn1_pos);
		p1_pawn2.setPos(p1.player_pawn2_pos);
		p1_pawn3.setPos(p1.player_pawn3_pos);
		p1_pawn4.setPos(p1.player_pawn4_pos);
		p1_pawn5.setPos(p1.player_pawn5_pos);
		p1_bishop.setPos(p1.player_bishop_pos);
		p1_knight.setPos(p1.player_knight_pos);
		p1_rook.setPos(p1.player_rook_pos);
		p1_lord.setPos(p1.player_lord_pos);

		p1_pawn1.setHp(p1.player_pawn1_hp);
		p1_pawn2.setHp(p1.player_pawn2_hp);
		p1_pawn3.setHp(p1.player_pawn3_hp);
		p1_pawn4.setHp(p1.player_pawn4_hp);
		p1_pawn5.setHp(p1.player_pawn5_hp);
		p1_bishop.setHp(p1.player_bishop_hp);
		p1_knight.setHp(p1.player_knight_hp);
		p1_rook.setHp(p1.player_rook_hp);
		p1_lord.setHp(p1.player_lord_hp);
		
		p1_pawn1.setMov(p1.player_pawn1_mov);
		p1_pawn2.setMov(p1.player_pawn2_mov);
		p1_pawn3.setMov(p1.player_pawn3_mov);
		p1_pawn4.setMov(p1.player_pawn4_mov);
		p1_pawn5.setMov(p1.player_pawn5_mov);
		p1_bishop.setMov(p1.player_bishop_mov);
		p1_knight.setMov(p1.player_knight_mov);
		p1_rook.setMov(p1.player_rook_mov);
		p1_lord.setMov(p1.player_lord_mov);
		
		//SET PLAYER 2 CHAMPION STATS
		p2_pawn1.setPos(p2.player_pawn1_pos);
		p2_pawn2.setPos(p2.player_pawn2_pos);
		p2_pawn3.setPos(p2.player_pawn3_pos);
		p2_pawn4.setPos(p2.player_pawn4_pos);
		p2_pawn5.setPos(p2.player_pawn5_pos);
		p2_bishop.setPos(p2.player_bishop_pos);
		p2_knight.setPos(p2.player_knight_pos);
		p2_rook.setPos(p2.player_rook_pos);
		p2_lord.setPos(p2.player_lord_pos);
		
		p2_pawn1.setHp(p2.player_pawn1_hp);
		p2_pawn2.setHp(p2.player_pawn2_hp);
		p2_pawn3.setHp(p2.player_pawn3_hp);
		p2_pawn4.setHp(p2.player_pawn4_hp);
		p2_pawn5.setHp(p2.player_pawn5_hp);
		p2_bishop.setHp(p2.player_bishop_hp);
		p2_knight.setHp(p2.player_knight_hp);
		p2_rook.setHp(p2.player_rook_hp);
		p2_lord.setHp(p2.player_lord_hp);
		
		p2_pawn1.setMov(p2.player_pawn1_mov);
		p2_pawn2.setMov(p2.player_pawn2_mov);
		p2_pawn3.setMov(p2.player_pawn3_mov);
		p2_pawn4.setMov(p2.player_pawn4_mov);
		p2_pawn5.setMov(p2.player_pawn5_mov);
		p2_bishop.setMov(p2.player_bishop_mov);
		p2_knight.setMov(p2.player_knight_mov);
		p2_rook.setMov(p2.player_rook_mov);
		p2_lord.setMov(p2.player_lord_mov);
	}
}}).done(update);

function placeChampions()
{
	var tag;
	
// PLAYER 1 SETUP:
	//######## PLAYER 1 PAWN_1 ########\\
	tag = ("#tileChar-" + p1_pawn1.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 1, pawn 1, placed at position: " + tag);
	
	//######## PLAYER 1 PAWN_2 ########\\
	tag = ("#tileChar-" + p1_pawn2.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 1, pawn 2, placed at position: " + tag);
	
	//######## PLAYER 1 PAWN_3 ########\\
	tag = ("#tileChar-" + p1_pawn3.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 1, pawn 3, placed at position: " + tag);
	
	//######## PLAYER 1 PAWN_4 ########\\
	tag = ("#tileChar-" + p1_pawn4.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 1, pawn 4, placed at position: " + tag);
	
	//######## PLAYER 1 PAWN_5 ########\\
	tag = ("#tileChar-" + p1_pawn5.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 1, pawn 5, placed at position: " + tag);
	
	//######## PLAYER 1 ROOK ########\\
	tag = ("#tileChar-" + p1_rook.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 1, rook, placed at position: " + tag);
	
	//######## PLAYER 1 KNIGHT ########\\
	tag = ("#tileChar-" + p1_knight.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 1, knight, placed at position: " + tag);
	
	//######## PLAYER 1 BISHOP ########\\
	tag = ("#tileChar-" + p1_bishop.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 1, bishop, placed at position: " + tag);
	
	//######## PLAYER 1 LORD ########\\
	tag = ("#tileChar-" + p1_lord.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 1, lord, placed at position: " + tag);

//PLAYER 2 SETUP:
	//######## PLAYER 2 PAWN_1 ########\\
	tag = ("#tileChar-" + p2_pawn1.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 2, pawn 1, placed at position: " + tag);
	
	//######## PLAYER 2 PAWN_2 ########\\
	tag = ("#tileChar-" + p2_pawn2.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 2, pawn 2, placed at position: " + tag);
	
	//######## PLAYER 2 PAWN_3 ########\\
	tag = ("#tileChar-" + p2_pawn3.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 2, pawn 3, placed at position: " + tag);
	
	//######## PLAYER 2 PAWN_4 ########\\
	tag = ("#tileChar-" + p2_pawn4.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 2, pawn 4, placed at position: " + tag);
	
	//######## PLAYER 2 PAWN_5 ########\\
	tag = ("#tileChar-" + p2_pawn5.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 2, pawn 5, placed at position: " + tag);
	
	//######## PLAYER 2 ROOK ########\\
	tag = ("#tileChar-" + p2_rook.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 2, rook, placed at position: " + tag);
	
	//######## PLAYER 2 KNIGHT ########\\
	tag = ("#tileChar-" + p2_knight.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 2, knight, placed at position: " + tag);
	
	//######## PLAYER 2 BISHOP ########\\
	tag = ("#tileChar-" + p2_bishop.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 2, bishop, placed at position: " + tag);
	
	//######## PLAYER 2 LORD ########\\
	tag = ("#tileChar-" + p2_lord.pos);
	$(tag).attr("src", "../../images/game/character/character.png");
	$(tag).css("visibility", "visible");
	//console.log("player 2, lord, placed at position: " + tag);
}

function update()
{
	console.log(getArray);
	placeChampions();
	//setInterval(function(){placeChampions()}, 1000);
}