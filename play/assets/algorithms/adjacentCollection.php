<?php 
/*GLOBAL VERTEX MAP COLLECTION VARIABLES*/
$vPointMap = new \Ds\Map();
$vCoords = array();

/*GLOBAL ADJACENT VERTEX MAP COLLECTION VARIABLES*/
$avMap = new \Ds\Map();
$avMap2 = new \Ds\Map();
$vMarked = new \Ds\Map();
$values = array();

/*STORE ALL COORDS OF THE TILES IN POINT MAP */
for($x = 0; $x < $rows; $x++)
{
	for($y = 0; $y < $columns; $y++)
	{
		$xCoord = $x;
		$yCoord = $y;
		array_push($vCoords, $xCoord);
		array_push($vCoords, $yCoord);
		
		$vPointMap->put($x*$columns+$y, $vCoords);
		$vCoords = array();
	}
}

/*GET ALL THE ADJACENT VERTICES OF EACH VERTEX*/
for($x = 0; $x < $rows; $x++)
{
	for($y = $x*$columns; $y < ($x*$columns+$columns); $y++)
	{
		$vMarked->put($y, 0);
		//COUNTER CLOCKWIZE ORGANIZED
		if(($y-1) >= ($x*$columns))
			array_push($values, $y-1); //adjacent left node
		
		if(($y+1) < ($x*$columns+$columns))
			array_push($values, $y+1);  //adjacent right node

		if(($y+$columns) < ($total))
			array_push($values, $y+$columns); //adjacent bottom node

		if(($y-$columns) > 0)
			array_push($values, $y-$columns); //adjacent top node
		
		$avMap->put($y, $values); //adjacent nodes inserted into vertex key
		//print_r($avMap[$y]);
		//print_r($vMarked[$y]);
		$values = array(); // clear values to prepare insertions for next vertex
	}
}

/*GET ALL THE ADJACENT VERTICES OF EACH VERTEX*/
for($x = 0; $x < $rows; $x++)
{
	for($y = $x*$columns; $y < ($x*$columns+$columns); $y++)
	{
		$vMarked->put($y, 0);
		//COUNTER CLOCKWIZE ORGANIZED
		if(($y+$columns) < ($total))
			array_push($values, $y+$columns); //adjacent bottom node

		if(($y-$columns) > 0)
			array_push($values, $y-$columns); //adjacent top node
			
		if(($y-1) >= ($x*$columns))
			array_push($values, $y-1); //adjacent left node
		
		if(($y+1) < ($x*$columns+$columns))
			array_push($values, $y+1);  //adjacent right node
		
		$avMap2->put($y, $values); //adjacent nodes inserted into vertex key
		//print_r($avMap[$y]);
		//print_r($vMarked[$y]);
		$values = array(); // clear values to prepare insertions for next vertex
	}
}
?>