function asteroid(position, velocity, radius, canvasWidth, canvasHeight) {
	
	this.position = position;
	this.velocity = velocity.multiply(0.75);
	this.cWidth = canvasWidth;
	this.cHeight = canvasHeight;
	this.radius = radius;
	this.lastCollision = 0;
	
	this.vertices = [];
	
	this.numberOfVertices = Math.floor(Math.random() * 5) + 5;
	
	this.averageAngle = 2 * Math.PI / this.numberOfVertices;
	
	sum = 0;
	
	for (var i = 0; i < this.numberOfVertices - 1; i++) {
		angle = this.averageAngle - 0.1 * this.averageAngle * Math.random();
		this.vertices.push(angle);
		sum += angle;
	}
	
	this.vertices.push(2 * Math.PI - sum);
	

	
	
	this.signs = [];
	
	for (var i = 0; i < this.vertices.length; i++) {
		var sign = 1;
		if (Math.random() < 0.5) {
			sign = -1;
		}	
		
		this.signs.push(sign);
		
	}
	
	
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
		points = []
		
		currentAngle = 0;
		
		for (var i = 0; i < this.vertices.length; i++) {
			currentAngle += this.vertices[i];
			
			p = this.position.vectorAdd(
					(new vector(0, 1))
					.multiply(this.radius + this.signs[i] * 0.1 * this.radius)
				)
				.rotate(this.position, currentAngle);
			points.push(p);
		}
		
		currentPoint = points[points.length - 1];
		
		for (var i = 0; i < points.length; i++) {
			p = points[i];
			p.draw(ctx, currentPoint);
			currentPoint = p;
		}
		
		
	}
}