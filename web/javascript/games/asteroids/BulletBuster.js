function BulletBuster(position) {
	this.refPoint = position.vectorAdd(new vector(22.5, 22.5));
	this.axis = this.refPoint.vectorAdd(new vector(-5, -5));
	this.radius = 15;
	this.corner = position;
    this.position = position;
	
	this.update = function() {
		this.corner = this.corner.rotate(this.axis, Math.PI/60);
		this.position = this.corner.vectorAdd( new vector( 15, 15 ) );
	}

	this.draw = function(ctx) {
		ctx.fillStyle = "purple";
		ctx.fillRect(this.corner.x, this.corner.y, 30, 30);
		ctx.fillStyle = "black";
	}
}