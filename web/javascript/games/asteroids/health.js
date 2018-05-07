function health(position, radius) {
	this.position = position;
	this.radius = radius;
	this.axis = position.vectorAdd(new vector(0, this.radius*2));
	
	this.update = function() {
		this.position = this.position.rotate(this.axis, Math.PI/60);
	}
	
	this.draw = function(ctx) {
		this.update();
		ctx.beginPath();
		ctx.strokeStyle = "#32cd32";
		ctx.arc(this.position.x, this.position.y, this.radius+1, 0, 2*Math.PI);
		ctx.stroke();
		ctx.strokeStyle = "#999999";
		ctx.closePath();
	}
}