function randomAsteroid(canvasWidth, canvasHeight) {
			var x;
			var y;
		if (Math.random() < 0.5) {
			if (Math.random() < 0.5) {
				x = -5;
			}
			else {
				x = canvasWidth + 5;
			}
			y = Math.floor(Math.random() * canvasHeight);
		}
		else {
			if (Math.random() < 0.5) {
				y = -5;
			}
			else {
				y = canvasHeight + 5;
			}
			x = Math.floor(Math.random() * canvasWidth);
		}
		
		var xVelocity = Math.floor(Math.random() * 2) + 1;
		var yVelocity = Math.floor(Math.random() * 2) + 1;
		var velocity = new vector(xVelocity, yVelocity);
		
		return new asteroid(new vector(x, y), velocity, Math.floor(Math.random() * 40) + 20, canvasWidth, canvasHeight);
}