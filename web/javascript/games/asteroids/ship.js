var Game = Game || {};
Game.Ship = Game.Ship || {};

Game.Ship.ship = function(position, radius, canvasWidth, canvasHeight) {
	this.position = position;
	this.radius = radius;
	this.cWidth = canvasWidth;
	this.cHeight = canvasHeight;
	this.angle = 0;
	this.acceleration = 1;
	this.velocityVector = new vector(0, 0);
	this.forwardUnitVector = new vector(0,-1);
	this.thrust = false;
	this.readyToFire = true;
	this.cooldown = 1000;
	this.lastShot = 0;
	this.shotsFired = 0;
	
	this.readyToFire = function() {
		return Math.abs((new Date()).getTime()-this.lastShot) > this.cooldown;
	}
	
	this.fireProjectile = function() {
		var proj = new projectile(this.position.vectorAdd(this.forwardUnitVector.multiply(this.shotsFired+2+this.radius/3+5)), 
				this.forwardUnitVector.multiply(5), 
				this.shotsFired, 
				this.cWidth, 
				this.cHeight, 
				(new Date()).getTime()
			);
		this.lastShot = (new Date()).getTime();
		this.shotsFired++;
		return proj;
	}

	this.update = function() {
		
		this.position = this.position.wrap(this.cWidth, this.cHeight); 			
		
		this.forwardUnitVector = this.forwardUnitVector.rotate(new vector(0,0), this.angle*2);
		this.velocityVector  = this.velocityVector.multiply(0.95);
		
		if(this.thrust) {
			this.velocityVector = this.velocityVector.vectorAdd(this.forwardUnitVector.multiply(this.acceleration));
		}
		this.position = this.position.vectorAdd(this.velocityVector);
		
	}
	
	this.draw = function(ctx) {
		//this.update();
		
		var yellow = "#FFFF00";
		var white = "#999999";
		
		
		var p1 = this.position.vectorAdd(this.forwardUnitVector.multiply(this.radius));
		var p2 = p1.rotate(this.position, 2*Math.PI/3);
		var p3 = p2.rotate(this.position, 2*Math.PI/3);
		var p4 = p2.vectorAdd(p3).multiply(0.5);
		p4 = p1.multiply(0.25).vectorAdd(p4.multiply(0.75));
		
		var p5 = p4.multiply(0.75).vectorAdd(p2.multiply(0.25));
		var p6 = p4.multiply(0.75).vectorAdd(p3.multiply(0.25));
		var p7 = p4.multiply(2).vectorAdd(p1.multiply(-1));
		// Old way
		/*p1.draw(ctx, p3);
		p2.draw(ctx, p1);
		p3.draw(ctx, p2);*/
		
		
		
		p1.draw(ctx, p3);
		p3.draw(ctx, p4);
		p4.draw(ctx, p2);
		p2.draw(ctx, p1);
		
		if (this.thrust) {
			ctx.strokeStyle = yellow;
			p5.draw(ctx, p4);
			p4.draw(ctx, p6);
			p6.draw(ctx, p7);
			p7.draw(ctx, p5);
			ctx.strokeStyle = white;
		}
		
		//ctx.beginPath();
		//ctx.arc(this.position.x, this.position.y, this.radius/3, 0, 2*Math.PI);
		//ctx.stroke();
	}
	
}


