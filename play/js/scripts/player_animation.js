var moveCount = 0;
var movTag;
var moveArray;

function getMoves(first, second)
{
	var difference = second - first;
	console.log(difference);
	//console.log(tag);
	switch(difference)
	{
		case -columns:
			return "up";
		break;
		
		case columns:
			return "down";
		break;
		
		case 1:
			return "right";
		break;
		
		case -1:
			return "left";
		break;
	}
}

function movAnimate(moveArray, tag)
{
	console.log('in movAnimate');
	this.moveArray = moveArray;
	movTag = tag;
	switch(moveArray[moveCount])
	{
		case "up":
			var movF = new TimelineMax({onComplete:finishMovement});
				movF.to(tag, .15, {top: "-=81", ease:Linear.easeNone});
		break;
		
		case "down":
			var movB = new TimelineMax({onComplete:finishMovement});
				movB.to(tag, .15, {top: "+=81", ease:Linear.easeNone});
		break;
		
		case "left":
			var movB = new TimelineMax({onComplete:finishMovement});
				movB.to(tag, .15, {left: "-=81", ease:Linear.easeNone});
		break;
		
		case "right":
			var movB = new TimelineMax({onComplete:finishMovement});
				movB.to(tag, .15, {left: "+=81", ease:Linear.easeNone});
		break;
		
		default:
			finishMovement();
		break;
	}
	//console.log(moveArray);
}

//OTHER ANIMATIONS
function idleFull()
{
	console.log("full hp idle animation");
}

function idleLow()
{
	console.log("half hp idle animation");
}

function dead()
{
	console.log("dead af");
}

function finishMovement()
{
	console.log('moved');
	if(moveCount != moveArray.length)
	{
		moveCount++;
		movAnimate(moveArray, movTag);
	}
	else
	{
		moveCount = 0;
	}
	//console.log("Finish Movement");
}
