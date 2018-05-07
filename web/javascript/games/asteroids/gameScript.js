

		var c = document.getElementById("myCanvas");
		var ctx = c.getContext("2d");
		canvasWidth = parseInt(c.getAttribute("width"));
		canvasHeight = parseInt(c.getAttribute("height"));
	
		var position = new vector(canvasWidth/2, canvasHeight/2);
		var ship = new ship(position, 40, canvasWidth, canvasHeight);
		ship.draw(ctx);
		ctx.beginPath();
		ctx.arc(position.x, position.y, 2, 0, 2*Math.PI);
		ctx.stroke();
	
		var projectiles = [];
		$('body').on('keydown keypress keyup', function(e) {
		var pressed = e.type=='keydown' ? true : false;
		if(e.which == 38){
			if(pressed )
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
			}	
		}
	})
	
	
		function draw() {
		
		ctx.clearRect(0, 0, canvasWidth, canvasHeight);
		ctx.beginPath()
		ship.draw(ctx);
		for(var i = 0; i < projectiles.length; i++){
			projectiles[i].draw(ctx);
			if(collision(ship, projectiles[i])){
				distance(ship, projectiles[i], ctx);
				alert('you lose!')
			}	
		}	

		requestAnimationFrame(draw);
	}

	requestAnimationFrame(draw);
	




