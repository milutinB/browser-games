function collision(ship, projectile){
	return Math.sqrt(Math.pow(ship.position.x - projectile.position.x, 2) 
	+ Math.pow(ship.position.y - projectile.position.y, 2)) 
	< ship.radius/3 + projectile.radius+1;
}

function asteroidCollision(asteroidA, asteroidB) {
	var collision = Math.sqrt(Math.pow(asteroidA.position.x - asteroidB.position.x, 2) 
	+ Math.pow(asteroidA.position.y - asteroidB.position.y, 2)) 
	< asteroidA.radius/3 + asteroidB.radius+1;
	
	if (collision) {
		var p = asteroidA.position;
		var q = asteroidB.position;
		
		var aVelocity = p.vectorAdd(q.multiply(-1));
		var aVelocity = aVelocity.multiply(1/aVelocity.length()).multiply(asteroidA.velocity.length());
		var bVelocity = q.vectorAdd(p.multiply(-1));
		var bVelocity = bVelocity.multiply(1/bVelocity.length()).multiply(asteroidB.velocity.length());
		
		asteroidA.velocity = aVelocity;
		asteroidB.velocity = bVelocity;
	}
}

function projectileExplosionCollision(projectile, explosion) {
	var distVec = projectile.position.multiply(-1).vectorAdd(explosion.position);
	var dist = distVec.length();

	return dist < projectile.radius + explosion.radius;
}


