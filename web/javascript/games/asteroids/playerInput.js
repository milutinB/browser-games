$('body').on('keydown keypress keyup', function(e) {
		var pressed = e.type=='keydown' ? true : false;
		if(e.which == 38){
			if(pressed)
				ship.thrust = true;
			else
				ship.thrust = false;
		}
		if(e.which == 39){
			if(pressed){
				ship.angle = Math.PI/60;
			}
			else
				ship.angle = 0;
		}
		if(e.which == 37)
			if(pressed)
				ship.angle = -Math.PI/60;
			else
				ship.angle = 0; 
		if(e.which == 32){
			if(ship.readyToFire()){
				projectiles.push(ship.fireProjectile());
				score++;
				if(projectiles.length > 5 && !projectilesThreshold)
					projectilesThreshold = true;
				$("#score").html("Score: "+score);
			
			}	
		}
	})