<?php
	if(!isset($columns) || !isset($rows))
	{
		exit("Missing Matrix Parameters");
	}
?>

<table id = "tileTable" onmouseup = "return false;">
	<?php 
	for($x = 0; $x < $rows; $x++)
	{?>
    	<tr class = "tileRow">
            <?php
			for($y = 0; $y < $columns; $y++)
            {
			?>
            	<td class = "tileData" onmouseover="hoverTile(<?php echo $x*$columns+$y?>)" onmousedown = "return clickTile(event, <?php echo $x*$columns+$y?>)">
                	<div class = "tileDiv" id = "tile-<?php echo $x*$columns+$y?>">
                    	<div class = "selectionTiles" id = "selectTile-<?php echo $x*$columns+$y?>"></div>
                    	<img class = "charPosition" id = "tileChar-<?php echo $x*$columns+$y?>" src="" />
                    </div>
				</td>
			<?php
			}?>
		</tr>
	<?php
	}?>
</table>
<div id = "copyright"><p>&copy; 2015-2017 GrigorianGames.com</p></div>
