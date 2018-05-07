function Explosion(position) {
	this.position = position;
	this.radius = 0;

	this.update = function() {
		this.radius++;
	}

	this.draw = function(ctx) {
		ctx.strokeStyle = "yellow";
		ctx.beginPath();
		ctx.arc(this.position.x, this.position.y, this.radius+1, 0, 2*Math.PI);
		ctx.stroke();
		ctx.strokeStyle = "white";
	}
}

function BusterExplosion(position) {
	this.position = position;
	this.radius = 1;

	this.update = function() {
		this.radius+=0.5;
	}

	this.draw = function(ctx) {
		ctx.strokeStyle = "purple";
		ctx.beginPath();
		ctx.arc(this.position.x, this.position.y, this.radius+1, 0, 2*Math.PI);
		ctx.stroke();
		ctx.strokeStyle = "white";
	}
}