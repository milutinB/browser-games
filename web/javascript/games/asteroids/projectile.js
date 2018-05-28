function projectile(position, velocity, radius, canvasWidth, canvasHeight, timeCreated) {
	this.position = position;
	this.velocity = velocity;
	this.cWidth = canvasWidth;
	this.cHeight = canvasHeight;
	this.radius = radius;
	this.timeCreated = timeCreated;
	this.type = "live";
	
	this.update = function() {
		
		var topology = document.getElementById('topology').value;
		
		if ( topology == "klein" && (this.position.y < 0 || this.position.y > this.cHeight)) {
			this.velocity = new vector(-this.velocity.x, this.velocity.y);
		}
		
		this.position = this.position.wrap(this.cWidth, this.cHeight);
		this.position = this.position.vectorAdd(this.velocity);
	}
	
	this.draw = function(ctx) {
		this.update();
		if ( this.type == "live" ) {
			ctx.fillStyle = "red";
		}
		else {
			ctx.fillStyle = "white";
		}
		ctx.beginPath();
		ctx.arc(this.position.x, this.position.y, this.radius+1, 0, 2*Math.PI);
		ctx.closePath();
		ctx.fill();
		ctx.fillStyle = "black";
	}
}