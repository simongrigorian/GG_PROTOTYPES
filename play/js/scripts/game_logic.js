function clickTile(event, tile)
{
	if(clickActive != 1)
	{
		//player 1
		switch(tile)
		{
			case p1_pawn1.pos:
				pathing(tile);
			break;
			
			case p1_pawn2.pos:
				pathing(tile);
			break;
			
			case p1_pawn3.pos:
				pathing(tile);
			break;
			
			case p1_pawn4.pos:
				pathing(tile);
			break;
			
			case p1_pawn5.pos:
				pathing(tile);
			break;
			
			case p1_rook.pos:
				pathing(tile);
			break;
			
			case p1_knight.pos:
				pathing(tile);
			break;
			
			case p1_bishop.pos:
				pathing(tile);
			break;
			
			case p1_lord.pos:
				pathing(tile);
			break;
			
			default:
			
			break;
		}
		
		//player2
		switch(tile)
		{
			case p2_pawn1.pos:
				pathing(tile);
			break;
			
			case p2_pawn2.pos:
				pathing(tile);
			break;
			
			case p2_pawn3.pos:
				pathing(tile);
			break;
			
			case p2_pawn4.pos:
				pathing(tile);
			break;
			
			case p2_pawn5.pos:
				pathing(tile);
			break;
			
			case p2_rook.pos:
				pathing(tile);
			break;
			
			case p2_knight.pos:
				pathing(tile);
			break;
			 
			case p2_bishop.pos:
				pathing(tile);
			break;
			
			case p2_lord.pos:
				pathing(tile);
			break;
			
			default:
			
			break;
		}
	}
	else
	{
		move(tile);
	}
}