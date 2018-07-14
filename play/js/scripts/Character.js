const character = function (init)
{
	var that = {};
	
	that.pos = init.pos;
	
	that.hp = init.hp;
	
	that.mov = init.mov;
	
	that.setPos = function(position)
	{
		that.pos = position;
	};
	
	that.setHp = function(health)
	{
		that.hp = health;
	};
	
	that.setMov = function(movement)
	{
		that.mov = movement;
	};
	
	return that;
};