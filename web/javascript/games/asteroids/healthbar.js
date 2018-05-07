function HealthBar(position, width, height, decayRate) {
	this.position = position;
	this.width = width;
	this.height = height;
	this.capacity = 100;
	this.maxCapacity = 100;
	this.decayRate = decayRate;

	this.update = function() {
		//this.capacity -= this.decayRate/2;
	}

	this.draw = function(ctx) {
		ctx.strokeStyle = "green";
		ctx.rect(this.position.x, this.position.y, this.width, this.height);
		ctx.stroke();
		ctx.fillStyle = "green";
		ctx.fillRect(this.position.x + 5, this.position.y + 5, (this.width - 10) * (this.capacity / 100), this.height - 10);
		ctx.fillStyle = "#000000";
		//ctx.stroke();
		ctx.strokeStyle = "white";
	}
}