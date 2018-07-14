<?php //ENABLE in this order to populate paths: adjacentCollection.php, path.php, bfsMov(), dijkstra(), dijkstra2()?>
<!--INITIALIZE VERTEX ADJACENT NODES-->
<?php require("assets/algorithms/adjacentCollection.php"); ?> 
<!--BFS MOVEMENT ALGORITHMS-->
<?php require("assets/algorithms/path.php"); ?>
<script>
var v = <?php bfsMov(); ?>; //double array matrix containing all tile movement measurements
var dijkstra = <?php dijkstra(); ?>; //three dimensional array matrix containing pre programmed paths (a star heuristic)
var dijkstra2 = <?php dijkstra2(); ?>;
var movement = 5;
var char = -1;
var flag = 0;
var prevTag;
var tagSelect;
var clickActive = 0;
var firstTile;
var path2;
var tempPath;
var right = 0;
var left = 0;
var up = 0;
var down = 0;

//variables for mobile touch
var xDown = null;                                                        
var yDown = null;   
//Arrays to show directional pathing possibilites
//when hovering over directional arrows
var firstArray = [];
var directionalArray = [];

//console.log(star[210][0]);
function clickTile(event, tile)
{
	if(flag == 1 || char == -1) //if character isn't clicked yet
	{
		char = tile;
	}
	//console.log("tile = " + tile);	
	//console.log(v[tile]);
	
	//this is the tile you just clicked
	var tag = ("#tileChar-" + tile);
	
	if(tile == char)
	{	
		clickActive = 1;
		firstTile = tile;
		prevTag = tag = ("#tileChar-" + tile); // preserve original tile tag
		tagSelect = ("#selectTile-" + tile);
		$(tag).attr("src", "../../images/game/character/character.png"); //set the image in the tile you just clicked
		flag = 0; // we have now clicked on the character
		right = 0;
		left = 0;
		up = 0;
		down = 0;
		//var v = $.ajax({type: "POST", url: "bfs.php", data: {data:tile}, complete: function(data){console.log("done");}});;
		//$.ajax({type: "POST", url: "assets/algorithms/path.php", data: {data:'mov'}, complete: function(data){console.log("done");}});
		for(var i = 0; i < <?php echo $rows*$columns; ?>; i++) //clear all tiles to transparent again
		{
			var tileTag = ("#selectTile-" + i);
			$(tileTag).css("background-color", "transparent");	
		}
		//if the movement is within range of tile clicked, color it green
		for(var i = 0; i < v.length; i++)
		{
			if(v[tile][i] < movement && v[tile][i] >= 0)
			{
				firstArray[i] = v[tile][i]; // store all the start position tiles in array. used to calculate movement changes when hover over direction.
				var tag = ("#selectTile-" + i);
				$(tag).css("background-color", "#30dcda");
				//$(tagSelect).css("background-color", "green");
			}
			else
			{
				//color all the other tiles #222222
				/*
				var tag = ("#selectTile-" + i);
				$(tag).css("background-color", "#8b0000");
				*/
			}
		}
	}
	else
	{	
		if(v[firstTile][tile] >= movement)
		{
			clickActive = 0;
			flag = 1; // we are clicking on a square that is not the original square
			$(prevTag).attr("src", ""); //clear the original character that was drawn.
			for(var i = 0; i < <?php echo $rows*$columns; ?>; i++) //clear all tiles to transparent again
			{
				var tileTag = ("#selectTile-" + i);
				$(tileTag).css("background-color", "transparent");	
			}
		}
		else if(up == 0 && down == 0 && left == 0 && right == 0)
		{
			alert("Please Select a Direction...");
			//console.log("nope");
		}
		else
		{
			if(v[tempPath][tile] >= movement-1)
			{
				clickActive = 0;
				flag = 1; // we are clicking on a square that is not the original square
				$(prevTag).attr("src", ""); //clear the original character that was drawn.
				for(var i = 0; i < <?php echo $rows*$columns; ?>; i++) //clear all tiles to transparent again
				{
					var tileTag = ("#selectTile-" + i);
					$(tileTag).css("background-color", "transparent");	
				}
			}
			else
			{
				clickActive = 0;
				flag = 1; // we are clicking on a square that is not the original square
				$(prevTag).attr("src", ""); //clear the original character that was drawn.
				for(var i = 0; i < <?php echo $rows*$columns; ?>; i++) //clear all tiles to transparent again
				{
					var tileTag = ("#selectTile-" + i);
					$(tileTag).css("background-color", "transparent");	
				}
				
				if(path2 == 1)
				{
					var firstRow = Math.floor((firstTile+<?php echo $columns; ?>) / <?php echo $columns; ?>) - 1;
					var tileRow = Math.floor((tile+<?php echo $columns; ?>) / <?php echo $columns; ?>) - 1;
					var firstColumn =  firstTile - (firstRow*<?php echo $columns; ?>);
					var tileColumn =  tile - (tileRow*<?php echo $columns; ?>);
					
					var tileTag = ("#selectTile-" + firstTile);
					$(tileTag).css("background-color", "green");
					firstTile = tempPath;
					
					//if top direction looping right and left
					if(tile > (firstTile + 1) && tileRow >= firstRow && up == 1)
					{
						for(var i = 0; i < dijkstra2[firstTile][tile].length; i++)
						{
							tileTag = ("#selectTile-" + dijkstra[firstTile][tile][i]);
							$(tileTag).css("background-color", "green");
						}
					}
					else if(tile < (firstTile - 1) && tileRow <= firstRow && down == 1)
					{
						for(var i = 0; i < dijkstra2[firstTile][tile].length; i++)
						{
							tileTag = ("#selectTile-" + dijkstra[firstTile][tile][i]);
							$(tileTag).css("background-color", "green");
						}
					}
					else
					{
						for(var i = 0; i < dijkstra2[firstTile][tile].length; i++)
						{
							tileTag = ("#selectTile-" + dijkstra2[firstTile][tile][i]);
							$(tileTag).css("background-color", "green");
						}					
					}
					
					up = 0;
					down = 0;
				}
				else
				{
					var firstRow = Math.floor((firstTile+<?php echo $columns; ?>) / <?php echo $columns; ?>) - 1;
					var tileRow = Math.floor((tile+<?php echo $columns; ?>) / <?php echo $columns; ?>) - 1;
					var firstColumn =  firstTile - (firstRow*<?php echo $columns; ?>);
					var tileColumn =  tile - (tileRow*<?php echo $columns; ?>);
					
					var tileTag = ("#selectTile-" + firstTile);
					$(tileTag).css("background-color", "green");
					firstTile = tempPath;
					
					//if right direction looping bottom
					if(tile > (firstTile + 10) && tileColumn <= firstColumn && right == 1)
					{
						for(var i = 0; i < dijkstra[firstTile][tile].length; i++)
						{
							tileTag = ("#selectTile-" + dijkstra2[firstTile][tile][i]);
							$(tileTag).css("background-color", "green");
						}				
					}
					//if right direction looping top
					else if(tile < (firstTile - 10) && tileColumn <= firstColumn && right == 1)
					{
						for(var i = 0; i < dijkstra[firstTile][tile].length; i++)
						{
							tileTag = ("#selectTile-" + dijkstra2[firstTile][tile][i]);
							$(tileTag).css("background-color", "green");
						}				
					}
					//else if left direction looping bottom
					else if(tile > (firstTile + 10) && tileColumn >= firstColumn && left == 1)
					{
						for(var i = 0; i < dijkstra[firstTile][tile].length; i++)
						{
							tileTag = ("#selectTile-" + dijkstra2[firstTile][tile][i]);
							$(tileTag).css("background-color", "green");
						}				
					}
					//else if left direction looping top
					else if(tile < (firstTile - 10) && tileColumn >= firstColumn && left == 1)
					{
						for(var i = 0; i < dijkstra[firstTile][tile].length; i++)
						{
							tileTag = ("#selectTile-" + dijkstra2[firstTile][tile][i]);
							$(tileTag).css("background-color", "green");
						}				
					}
					//not looping around going left or right
					else
					{
						for(var i = 0; i < dijkstra2[firstTile][tile].length; i++)
						{
							tileTag = ("#selectTile-" + dijkstra[firstTile][tile][i]);
							$(tileTag).css("background-color", "green");
						}	
					}
					
					//reset flags
					right = 0;
					left = 0;
				}
			}
		}
	}
}

function hoverTile(tile)
{
	if(clickActive == 1)
	{
		if((tile + <?php echo $columns; ?>) == firstTile)
		{
			var tileTag1 = ("#selectTile-" + (firstTile+<?php echo $columns; ?>));
			var tileTag2 = ("#selectTile-" + (firstTile-<?php echo $columns; ?>));
			var tileTag3 = ("#selectTile-" + (firstTile+1));
			var tileTag4 = ("#selectTile-" + (firstTile-1));
			var row = Math.floor((firstTile+<?php echo $columns; ?>) / <?php echo $columns; ?>) - 1;
			if(firstTile-<?php echo $columns; ?> > 0)
			{			
				movDifference(tile);
				$(tileTag2).css("background-color", "green");
				
				if(firstTile+<?php echo $columns; ?> < <?php echo $total; ?>)
					$(tileTag1).css("background-color", "#30dcda");
				
				if(firstTile+1 < (row*<?php echo $columns; ?> + <?php echo $columns; ?>))
					$(tileTag3).css("background-color", "#30dcda");
					
				if(firstTile-1 >= (row*<?php echo ($columns); ?>))
					$(tileTag4).css("background-color", "#30dcda");
				
				//console.log("path == 1");
				tempPath = firstTile-<?php echo $columns; ?>;
				path2 = 1;
				up = 1;
				left = 0;
				right =0;
				down =0;	
			}
		}
		if((tile - <?php echo $columns; ?>) == firstTile)
		{
			var tileTag1 = ("#selectTile-" + (firstTile+<?php echo $columns; ?>));
			var tileTag2 = ("#selectTile-" + (firstTile-<?php echo $columns; ?>));
			var tileTag3 = ("#selectTile-" + (firstTile+1));
			var tileTag4 = ("#selectTile-" + (firstTile-1));
			var row = Math.floor((firstTile+<?php echo $columns; ?>) / <?php echo $columns; ?>) - 1;

			if(firstTile+<?php echo $columns; ?> < <?php echo $total; ?>)
			{
				movDifference(tile);
				$(tileTag1).css("background-color", "green");
					
				if(firstTile-<?php echo $columns; ?> > 0)
					$(tileTag2).css("background-color", "#30dcda");
				
				if(firstTile+1 < (row*<?php echo $columns; ?> + <?php echo $columns; ?>))
					$(tileTag3).css("background-color", "#30dcda");
					
				if(firstTile-1 >= (row*<?php echo ($columns); ?>))
					$(tileTag4).css("background-color", "#30dcda");
				
				//console.log("path == 1");
				tempPath = firstTile+<?php echo $columns; ?>;
				path2 = 1;
				down = 1;
				left = 0;
				right = 0;
				up = 0;			
			}
		}
		if((tile - 1) == firstTile)
		{
			var tileTag1 = ("#selectTile-" + (firstTile-1));
			var tileTag2 = ("#selectTile-" + (firstTile+1));
			var tileTag3 = ("#selectTile-" + (firstTile-<?php echo $columns; ?>));
			var tileTag4 = ("#selectTile-" + (firstTile+<?php echo $columns; ?>));
			var row = Math.floor((firstTile+<?php echo $columns; ?>) / <?php echo $columns; ?>) - 1;
			//console.log(row);

			if(firstTile+1 < (row*<?php echo $columns; ?> + <?php echo $columns; ?>))
			{
				movDifference(tile);
				$(tileTag2).css("background-color", "green");
			
				if(firstTile-1 >= (row*<?php echo ($columns); ?>))
					$(tileTag1).css("background-color", "#30dcda");
				
				if(firstTile-<?php echo $columns; ?> > 0)
					$(tileTag3).css("background-color", "#30dcda");
					
				if(firstTile+<?php echo $columns; ?> < <?php echo $total; ?>)
					$(tileTag4).css("background-color", "#30dcda");
			
				//console.log("path == 2");
				//this is what I want evidentally.
				//tempPath = firstTile-1;
				//path2 = 1;
				tempPath = firstTile+1;
				path2 = 0;
				right = 1;
				left = 0;
				up = 0;
				down = 0;
			}
		}
		if((tile + 1) == firstTile)
		{
			
			
			var tileTag1 = ("#selectTile-" + (firstTile-1));
			var tileTag2 = ("#selectTile-" + (firstTile+1));
			var tileTag3 = ("#selectTile-" + (firstTile-<?php echo $columns; ?>));
			var tileTag4 = ("#selectTile-" + (firstTile+<?php echo $columns; ?>));
			var row = Math.floor((firstTile+<?php echo $columns; ?>) / <?php echo $columns; ?>) - 1;
			//console.log(row);
			if(firstTile-1 >= (row*<?php echo ($columns); ?>))
			{
				movDifference(tile);
				$(tileTag1).css("background-color", "green");
					
				if(firstTile+1 < (row*<?php echo $columns; ?> + <?php echo $columns; ?>))
					$(tileTag2).css("background-color", "#30dcda");
					
				if(firstTile-<?php echo $columns; ?> > 0)
					$(tileTag3).css("background-color", "#30dcda");
					
				if(firstTile+<?php echo $columns; ?> < <?php echo $total; ?>)
					$(tileTag4).css("background-color", "#30dcda");
					
				tempPath = firstTile-1;
				path2 = 0;
				left = 1;
				right = 0;
				up = 0;
				down = 0;
			}
		}
		
	}
}                                                     

function handleTouchStart(evt) {                                         
	xDown = evt.touches[0].clientX;                                      
	yDown = evt.touches[0].clientY;                                      
};                                                


function handleTouchMove(evt) {
	if ( ! xDown || ! yDown ) {
		return;
	}

	var xUp = evt.touches[0].clientX;                                    
	var yUp = evt.touches[0].clientY;

	var xDiff = xDown - xUp;
	var yDiff = yDown - yUp;
	
	if(clickActive == 1)
	{
		if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) 
		{/*most significant*/
			if ( xDiff > 0 ) //swipe left
			{						
				var tileTag1 = ("#selectTile-" + (firstTile-1));
				var tileTag2 = ("#selectTile-" + (firstTile+1));
				var tileTag3 = ("#selectTile-" + (firstTile-<?php echo $columns; ?>));
				var tileTag4 = ("#selectTile-" + (firstTile+<?php echo $columns; ?>));
				var row = Math.floor((firstTile+<?php echo $columns; ?>) / <?php echo $columns; ?>) - 1;
				//console.log(row);
				
				if(firstTile-1 >= (row*<?php echo ($columns); ?>))
				{
					movDifference(firstTile-1);
					$(tileTag1).css("background-color", "green");
					
					if(firstTile+1 < (row*<?php echo $columns; ?> + <?php echo $columns; ?>))
						$(tileTag2).css("background-color", "#30dcda");
					
					if(firstTile-<?php echo $columns; ?> > 0)
						$(tileTag3).css("background-color", "#30dcda");
						
					if(firstTile+<?php echo $columns; ?> < <?php echo $total; ?>)
						$(tileTag4).css("background-color", "#30dcda");
						
					tempPath = firstTile-1;
					path2 = 0;
					left = 1;
					right = 0;
					up = 0;
					down = 0;
				}
			} 
			else //swipe right
			{
				var tileTag1 = ("#selectTile-" + (firstTile-1));
				var tileTag2 = ("#selectTile-" + (firstTile+1));
				var tileTag3 = ("#selectTile-" + (firstTile-<?php echo $columns; ?>));
				var tileTag4 = ("#selectTile-" + (firstTile+<?php echo $columns; ?>));
				var row = Math.floor((firstTile+<?php echo $columns; ?>) / <?php echo $columns; ?>) - 1;
				//console.log(row);
	
				if(firstTile+1 < (row*<?php echo $columns; ?> + <?php echo $columns; ?>))
				{
					movDifference(firstTile+1);
					$(tileTag2).css("background-color", "green");

					if(firstTile-1 >= (row*<?php echo ($columns); ?>))
						$(tileTag1).css("background-color", "#30dcda");
					
					if(firstTile-<?php echo $columns; ?> > 0)
						$(tileTag3).css("background-color", "#30dcda");
						
					if(firstTile+<?php echo $columns; ?> < <?php echo $total; ?>)
						$(tileTag4).css("background-color", "#30dcda");
				
					//console.log("path == 2");
					//this is what I want evidentally.
					//tempPath = firstTile-1;
					//path2 = 1;
					tempPath = firstTile+1;
					path2 = 0;
					right = 1;
					left = 0;
					up = 0;
					down = 0;
				}
			}                       
		} 
		else 
		{
			if ( yDiff > 0 ) //swipe up
			{
				var tileTag1 = ("#selectTile-" + (firstTile+<?php echo $columns; ?>));
				var tileTag2 = ("#selectTile-" + (firstTile-<?php echo $columns; ?>));
				var tileTag3 = ("#selectTile-" + (firstTile+1));
				var tileTag4 = ("#selectTile-" + (firstTile-1));
				var row = Math.floor((firstTile+<?php echo $columns; ?>) / <?php echo $columns; ?>) - 1;
					
				if(firstTile-<?php echo $columns; ?> > 0)
				{
					movDifference(firstTile-<?php echo $columns; ?>);
					$(tileTag2).css("background-color", "green");
					
					if(firstTile+<?php echo $columns; ?> < <?php echo $total; ?>)
						$(tileTag1).css("background-color", "#30dcda");

					if(firstTile+1 < (row*<?php echo $columns; ?> + <?php echo $columns; ?>))
						$(tileTag3).css("background-color", "#30dcda");
						
					if(firstTile-1 >= (row*<?php echo ($columns); ?>))
						$(tileTag4).css("background-color", "#30dcda");
					
					//console.log("path == 1");
					tempPath = firstTile-<?php echo $columns; ?>;
					path2 = 1;
					up = 1;
					left = 0;
					right =0;
					down =0;
				}	
			} 
			else //swipe down
			{ 
				var tileTag1 = ("#selectTile-" + (firstTile+<?php echo $columns; ?>));
				var tileTag2 = ("#selectTile-" + (firstTile-<?php echo $columns; ?>));
				var tileTag3 = ("#selectTile-" + (firstTile+1));
				var tileTag4 = ("#selectTile-" + (firstTile-1));
				var row = Math.floor((firstTile+<?php echo $columns; ?>) / <?php echo $columns; ?>) - 1;
	
				if(firstTile+<?php echo $columns; ?> < <?php echo $total; ?>)
				{
					movDifference(firstTile+<?php echo $columns; ?>);
					$(tileTag1).css("background-color", "green");

					if(firstTile-<?php echo $columns; ?> > 0)
						$(tileTag2).css("background-color", "#30dcda");
					
					if(firstTile+1 < (row*<?php echo $columns; ?> + <?php echo $columns; ?>))
						$(tileTag3).css("background-color", "#30dcda");
						
					if(firstTile-1 >= (row*<?php echo ($columns); ?>))
						$(tileTag4).css("background-color", "#30dcda");
					
					//console.log("path == 1");
					tempPath = firstTile+<?php echo $columns; ?>;
					path2 = 1;
					down = 1;
					left = 0;
					right = 0;
					up = 0;
				}
			}                                                                 
		}
	}
	/* reset values */
	xDown = null;
	yDown = null;                                             
};

//display difference in movement when direction is chosen
function movDifference(tile)
{
	for(var i = 0; i < v.length; i++)
	{
		var tag = ("#selectTile-" + i);
		if(v[firstTile][i] < movement && v[tile][i] >= movement-1)
		{
			$(tag).css("background-color", "transparent");
		}
		else if(v[firstTile][i] < movement && v[tile][i] < movement)
		{
			$(tag).css("background-color", "#30dcda");
		}
	}
	$(tagSelect).css("background-color", "green");
}

document.addEventListener('contextmenu', event => event.preventDefault());

//mobile swipe code
document.addEventListener('touchstart', handleTouchStart, false);        
document.addEventListener('touchmove', handleTouchMove, false);
</script>