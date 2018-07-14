<?php
/*BFS ALGORITHM TO CHECK THE DISTANCE OF ALL THE TILES FROM THE TILE CLICKED*/
$vMovCount = new \Ds\Map();
$movArray = array();

//PATH GLOBALS
//$pathArray = array(); //starting point array with all their destinations

/*SEND MAP IN AN ARRAY TO JAVASCRIPT*/
//replaced with toArray()
function movDistance($v)
{

	//bfsMov($v);
	$valArray = array();
	global $vMovCount;
	global $total; 
	global $movArray;
	
	for($i = 0; $i < $total; $i++)
	{
		$valArray[$i] = $vMovCount->get($i);
	}
	$movArray[$v] = $valArray;
	
	//print_r($vMovCount->get($v));
	//print_r($vMovCount->get($v));
	//print_r($vMovCount->get($v));
}

function bfsMov()
{
	global $total;
	global $rows;
	global $columns;
	global $movArray;
	global $avMap;
	global $vMarked;
	global $vMovCount;
	global $vPointMap;
	
	for($i = 0; $i < $total; $i++)
	{
		$v = $i;
		
		//$queue = new \Ds\Queue();
		//$queue->push(...); //pushes an item to the tail or head if it's empty
		//$queue->peek(); //takes a look at the head value
		//$queue->pop(); //removes the head value
		//$queue->isEmpty(); //checks to see if the queue is empty or not
		//print_r($queue);
		
		$queue = new \Ds\Queue();
		$movCount = 0;
		$vMovCount->put($v, $movCount);
		$vMarked->put($v, 1);
		$queue->push($v);
		
		while(! $queue->isEmpty())
		{
			$v = $queue->pop();
			
			foreach($avMap->get($v) as $av)
			{
				if($vMarked->get($av) != 1)
				{
					$queue->push($av);
					$vMarked->put($av, 1);
					
					//DISTANCE BETWEEN V-ORIGIN AND AV
					$startVertex = $vPointMap->get($i);
					$endVertex = $vPointMap->get($av);
					$movCount = abs($startVertex[0] - $endVertex[0]) + abs($startVertex[1] - $endVertex[1]);
					$vMovCount->put($av, $movCount);
				}
			}
		}
		//movDistance($i);
		$movArray[$i] = $vMovCount->toArray();
		//n^2 make it better
		for($x = 0; $x < $rows; $x++)
		{
			for($y = $x*$columns; $y < ($x*$columns+$columns); $y++)
			{
				$vMarked->put($y, 0);
			}
		}
	}
	echo json_encode($movArray);
}

//LEFT RIGHT PATH
function dijkstra()
{
	
	global $avMap; //collection of all nodes and their adjacent nodes.
	global $vMarked; //this is where i store all the closed nodes.
	$pathArray = array(); //where we store all the destination paths for each node
	global $vPointMap; //holds all the vertex X, Y values
	global $rows;
	global $columns;
	global $total; //rows*columns

	for($i = 0; $i < $total; $i++)
	{//i = start node
		//create new destArray for the next node $i
		$destArray = array(); //end point array for all the destination arrays
		for($j = 0; $j < $total; $j++)
		{//j == goal node
			//print_r("total = " . $total);
			$start = $i;
			$goal = $j;
			$current = $i;
			$bestNode = $i; //start is always the best
			$queue = new \Ds\Queue(); //initialize q to go through all the vertices || ** try to optomize to priority queue in the future
			$destValues = array(); //array of all predecessor nodes			
			
			//A-Star calculations (heuristic)
			$startVertex = $vPointMap->get($start); //Point X, Y for start vertex
			$endVertex = $vPointMap->get($goal); //Point X, Y for goal vertex
			$currentVertex = $vPointMap->get($current); //Point X, Y for current vertex
			$distanceToSource = abs($currentVertex[0] - $startVertex[0]) + abs($currentVertex[1] - $startVertex[1]);
			$distanceToGoal = abs($currentVertex[0] - $endVertex[0]) + abs($currentVertex[1] - $endVertex[1]);
			$currentCost = $distanceToGoal;
			//print_r("current: " . $current . " cost = " . $currentCost . " | ");
			
			$vMarked->put($current, 1); //close the current node
			$queue->push($current);
			array_push($destValues, $current); //start is always a value in the destination
			
			while(! $queue->isEmpty())
			{
				
				$current = $queue->pop(); //current is = next in the queue
				if($current == $goal)
				{
					//finish
					//print_r(" | finish! goal = " . $current);
					if(end($destValues) != $current) //check incase dest = start = current;
					{
						array_push($destValues, $current);
					}
					
					//$queue = new \Ds\Queue(); // reset queue
					
					//clear all closed - fix this, it's n^2
					/*
					for($x = 0; $x < $rows; $x++)
					{
						for($y = $x*$columns; $y < ($x*$columns+$columns); $y++)
						{
							$vMarked->put($y, 0);
						}
					}
					*/
				}
				else
				{
					foreach($avMap->get($current) as $av)
					{
						if($vMarked->get($av) != 1)
						{
							$vMarked->put($av, 1); //close the adjacent node
							//A-Star calculations (heuristic)
							$startVertex = $vPointMap->get($start); //Point X, Y for start vertex
							$endVertex = $vPointMap->get($goal); //Point X, Y for goal vertex
							$currentVertex = $vPointMap->get($av); //Point X, Y for current vertex
							$distanceToSource = abs($currentVertex[0] - $startVertex[0]) + abs($currentVertex[1] - $startVertex[1]);
							$distanceToGoal = abs($currentVertex[0] - $endVertex[0]) + abs($currentVertex[1] - $endVertex[1]);
							$avCost = $distanceToGoal;
							//print_r(" av: " . $av . " current cost = " . $currentCost . " avCost = " . $avCost);
							if($avCost < $currentCost)
							{
								$queue->push($av);
								$bestNode = $av;
								//print_r(" | best node = " . $bestNode);
								$currentCost = $avCost;	
							}
						}
					}
					//$queue->push($bestNode);
					if(end($destValues) != $bestNode)//check, to eliminate duplicate insertions
					{
						array_push($destValues, $bestNode); //push the best adjacent vertex to values list	
					}
				}
			}
			//n^2, make it better if possible. look into map api for php \ds\map (not spl)
			for($x = 0; $x < $rows; $x++)
			{
				for($y = $x*$columns; $y < ($x*$columns+$columns); $y++)
				{
					$vMarked->put($y, 0);
				}
			}
			array_push($destArray, $destValues);
		}
		array_push($pathArray, $destArray);
	}
	echo json_encode($pathArray);
}

//UP DOWN PATH
function dijkstra2()
{
	
	global $avMap2; //collection of all nodes and their adjacent nodes.
	global $vMarked; //this is where i store all the closed nodes.
	$pathArray2 = array(); //where we store all the destination paths for each node
	global $vPointMap; //holds all the vertex X, Y values
	global $rows;
	global $columns;
	global $total; //rows*columns

	for($i = 0; $i < $total; $i++)
	{//i = start node
		//create new destArray for the next node $i
		$destArray = array(); //end point array for all the destination arrays
		for($j = 0; $j < $total; $j++)
		{//j == goal node
			//print_r("total = " . $total);
			$start = $i;
			$goal = $j;
			$current = $i;
			$bestNode = $i; //start is always the best
			$queue = new \Ds\Queue(); //initialize q to go through all the vertices || ** try to optomize to priority queue in the future
			$destValues = array(); //array of all predecessor nodes			
			
			//A-Star calculations (heuristic)
			$startVertex = $vPointMap->get($start); //Point X, Y for start vertex
			$endVertex = $vPointMap->get($goal); //Point X, Y for goal vertex
			$currentVertex = $vPointMap->get($current); //Point X, Y for current vertex
			$distanceToSource = abs($currentVertex[0] - $startVertex[0]) + abs($currentVertex[1] - $startVertex[1]);
			$distanceToGoal = abs($currentVertex[0] - $endVertex[0]) + abs($currentVertex[1] - $endVertex[1]);
			$currentCost = $distanceToGoal;
			//print_r("current: " . $current . " cost = " . $currentCost . " | ");
			
			$vMarked->put($current, 1); //close the current node
			$queue->push($current);
			array_push($destValues, $current); //start is always a value in the destination
			
			while(! $queue->isEmpty())
			{
				
				$current = $queue->pop(); //current is = next in the queue
				if($current == $goal)
				{
					//finish
					//print_r(" | finish! goal = " . $current);
					if(end($destValues) != $current) //check incase dest = start = current;
					{
						array_push($destValues, $current);
					}
					
					//$queue = new \Ds\Queue(); // reset queue
					
					//clear all closed - fix this, it's n^2
					/*
					for($x = 0; $x < $rows; $x++)
					{
						for($y = $x*$columns; $y < ($x*$columns+$columns); $y++)
						{
							$vMarked->put($y, 0);
						}
					}
					*/
				}
				else
				{
					foreach($avMap2->get($current) as $av)
					{
						if($vMarked->get($av) != 1)
						{
							$vMarked->put($av, 1); //close the adjacent node
							//A-Star calculations (heuristic)
							$startVertex = $vPointMap->get($start); //Point X, Y for start vertex
							$endVertex = $vPointMap->get($goal); //Point X, Y for goal vertex
							$currentVertex = $vPointMap->get($av); //Point X, Y for current vertex
							$distanceToSource = abs($currentVertex[0] - $startVertex[0]) + abs($currentVertex[1] - $startVertex[1]);
							$distanceToGoal = abs($currentVertex[0] - $endVertex[0]) + abs($currentVertex[1] - $endVertex[1]);
							$avCost = $distanceToGoal;
							//print_r(" av: " . $av . " current cost = " . $currentCost . " avCost = " . $avCost);
							if($avCost < $currentCost)
							{
								$queue->push($av);
								$bestNode = $av;
								//print_r(" | best node = " . $bestNode);
								$currentCost = $avCost;	
							}
						}
					}
					//$queue->push($bestNode);
					if(end($destValues) != $bestNode)//check, to eliminate duplicate insertions
					{
						array_push($destValues, $bestNode); //push the best adjacent vertex to values list	
					}
				}
			}
			//n^2, make it better if possible. look into map api for php \ds\map (not spl)
			for($x = 0; $x < $rows; $x++)
			{
				for($y = $x*$columns; $y < ($x*$columns+$columns); $y++)
				{
					$vMarked->put($y, 0);
				}
			}
			array_push($destArray, $destValues);
		}
		array_push($pathArray2, $destArray);
	}
	echo json_encode($pathArray2);
}

#######################################################################################
$func = $_POST['data'];
switch($func) 
{
	case 'mov' :
		bfsMov(); 
	break;
	
	case 'path' :
		dijkstra();	
	break;

	default :
	break; // and do nothing else, as the response JSON will be default (0)
}
bfsMov($v);

$func    = $_GET['func'];
$tile    = $_GET['tile'];

error_log("func is $func and tile is $tile");

$response = -1;

switch($func) {
  case 'mov' :
	$response = movDistance($tile); break;

  default :
	break; // and do nothing else, as the response JSON will be default (0)
}

header('Content-Type: application/json; charset=utf-8');
$responseJSON = json_encode($response);

if($response != -1)
	echo $responseJSON;

?>