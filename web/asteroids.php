<!DOCTYPE html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="/web/javascript/games/asteroids/transformations.js"></script>
<script type="text/javascript" src="/web/javascript/games/asteroids/projectile.js"></script>
<script type="text/javascript" src="/web/javascript/games/asteroids/collision.js"></script>
<script type="text/javascript" src="/web/javascript/games/asteroids/health.js"></script>
<script type="text/javascript" src="/web/javascript/games/asteroids/ship.js"></script>
<script type="text/javascript" src="/web/javascript/games/asteroids/asteroid.js"></script>
<script type="text/javascript" src="/web/javascript/games/asteroids/randomAsteroid.js"></script>
<script type="text/javascript" src="/web/javascript/games/asteroids/healthbar.js"></script>
<script type="text/javascript" src="/web/javascript/games/asteroids/explosion.js"></script>
<script type="text/javascript" src="/web/javascript/games/asteroids/BulletBuster.js"></script>
<link rel="stylesheet" href="/web/css/game.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

</head>

<body>
	<div class="body">
		<audio id="laser">
			<source src="/web/javascript/games/asteroids/audio/laser.wav" type="audio/wav">
		</audio>
		<audio id="bang">
			<source src="/web/javascript/games/asteroids/audio/bang.mp3" type="audio/mpeg">
		</audio>
		<audio id="thrust">
			<source src="/web/javascript/games/asteroids/audio/thrust.mp3" type="audio/mpeg">
		</audio>
		<div>
			
		</div>

		<div class="container">
			<div class="row">
			<div class="col-sm-2">
				
			</div>
			<div class="col-sm-10">
					<div id="canvasContainer" class="col-sm-10" stye="display: none;">
					</div>
					<div id="description">
						<h2>
							Asteroids
						</h2>
						<div>
							The arcade classic with a few twists:
							<br>
							<ul>
								<li>
									Your lasers will damage your ship!
								</li>
								<li>
									Lasers are red until they destroy an astroid, 
									hen they turn white and will only damage your ship.
								</li> 
								<li>
									Purple laser disposal crates will appear. If you collect them, 
									they will create a temporary vortex sucking up excess white lasers.
								</li>
							</ul>
							<hr>
							<h3>
								Controls
							</h3>
							<ul>
								<li>
									Rotate: Left and right arrow keys
								</li>
								<li>
									Thrust: Up arroy key
								</li>
								<li>
									Fire: Spacebar
								</li>
							</ul>
							<h3></h3>
							<div class="row">
								<div class="col-sm-6">
									<button class="btn btn-success" id="start"> start game </button>
								</div>
								<div class="col-sm-6">
									<button class="btn btn-default" id="back"> back to games </button>
								</div>
							</div>
						</div>
					</div>
			</div>
				<div class="col-sm-2">
				</div>
			</div>
			<br>
			<div class="row">
			<div class="col-sm-2">
			</div>
			<div class="col-sm-2">
			<hr>
				<div style="color: white;" id="score">
					<?php
						echo $data["scoreMessage"];
					?>
				</div>
			</div>
			<div class="col-sm-2">
			</div>	
			</div>
		</div>
	</div>

<script>

$(document).ready(function() {
	
	$("#back").click(function() {
		
		window.location.href = "/games";
		
	});
	window.addEventListener("keydown", function(e) {

	
    if([32, 37, 38, 39, 40].indexOf(e.keyCode) > -1) {
        e.preventDefault();
    }
}, false);

	
});

$("#start").click(function() {
	
	$("#canvasContainer").html(
		'<canvas id="myCanvas" width="1000" height="600" style="border:1px solid #d3d3d3;"></canvas>'
	);
	
	game();
	
	$("#description").hide();
	
	
});

function game() {
		
	console.log("game");	
		
	var laserSound = document.getElementById("laser");
	var bangSound = document.getElementById("bang");
	var thrustSound = document.getElementById("thrust");
	var c = document.getElementById("myCanvas");
	var ctx = c.getContext("2d");
	canvasWidth = parseInt(c.getAttribute("width"));
	canvasHeight = parseInt(c.getAttribute("height"));


	function startGame(canvasWidth, canvasHeight) {
		let position = new vector(canvasWidth/2, canvasHeight/2);
		let ship = new Game.Ship.ship(position, 40, canvasWidth, canvasHeight);
		
		let asteroids = [];
		
		for (var i = 0; i < 5; i++) {
			asteroids.push(randomAsteroid(canvasWidth, canvasHeight));
		}
		
		
		return [ship, asteroids];
	
		
	}
	
	
	function collisionResolution(asteroids, projectiles, ship, healthBar, healthBoost) {
		for (var i = 0; i < asteroids.length; i++) {
			for (var j = 0; j < asteroids.length; j++) {
				if (i != j) {
					asteroidCollision(asteroids[i], asteroids[j]);
				}
			}
		}
		
		for (var i = 0; i < asteroids.length; i++) {
			if (collision(ship, asteroids[i])) {
				//alert("Game over :( \n You were hit by an asteroid. \n Your final score is: " + Math.floor(score));
				//location.reload();
				let p = ship.position;
				let q = asteroids[i].position;
				let m = p.midpoint(q);

				let shipBoost = p.vectorAdd(m.multiply(-1)).unit().multiply(5);

				let asteroidBoost = q.vectorAdd(m.multiply(-1)).unit();

				ship.velocityVector = ship.velocityVector.vectorAdd(shipBoost);
				asteroids[i].velocity = asteroids[i].velocity.vectorAdd(asteroidBoost);

				healthBar.capacity -= 10;

			}
		}
		
		for (var i = 0; i < projectiles.length; i++) {
			proj = projectiles[i];
			
			for (var j = 0; j < asteroids.length; j++) {
				var asteroid = asteroids[j]; 
				if (collision(proj, asteroid) && proj.type == "live") {
					explosions.push(new Explosion(new vector(asteroid.position.x, asteroid.position.y)));
					bangSound.play();
					asteroids.splice(j, 1);
					//healthBar.capacity = Math.min(healthBar.maxCapacity, healthBar.capacity + healthBoost);
					asteroids.push(randomAsteroid(canvasWidth, canvasHeight));
					proj.type = "ghost";
					score += 100;
				}
			}
		}
		
		usedBusterIndices = [];
		for (var j = 0; j < bulletBusters.length; j++) {
			buster = bulletBusters[j];

			if (collision(ship, buster)) {
				busterExplosions.push(new BusterExplosion(buster.position));
				usedBusterIndices.push(j);
				console.log(busterExplosions);
			}
		}

		for (var j = 0; j < usedBusterIndices.length; j++) {
			bulletBusters.splice(usedBusterIndices[j], 1);
		}

		for (var j = 0; j < projectiles.length; j++) {
			var now = (new Date()).getTime();
			if (collision(ship, projectiles[j]) && now - proj.timeCreated >= 500) {
				//alert("Game over :(\n You were hit by your own laser. \n Your final score is: " + Math.floor(score));
				//location.reload();
				healthBar.capacity -= 10;
				projectiles.splice(j, 1);
			}
		}

		finishedProjectileIndices = [];

		for (var i = 0; i < projectiles.length; i++) {
			var proj = projectiles[i];
			for (var j = 0; j < busterExplosions.length; j++) {
				var bustExp = busterExplosions[j];
				//console.log("Hi");
				if (projectileExplosionCollision(proj, bustExp)) {
					finishedProjectileIndices.push(i);
				}
			}
		}

		for (var i = 0; i < finishedProjectileIndices.length; i++) {
			var index = finishedProjectileIndices[i];
			projectiles.splice(index, 1);
		}

	}
	
	
	
	var gameObjects = startGame(canvasWidth, canvasHeight);
	
	var ship = gameObjects[0];
	var asteroids = gameObjects[1];
	var projectiles = [];
	var healthBar = new HealthBar(new vector( (3/2) * canvasWidth / 10, 9 * canvasHeight / 10), 100, 25, 0.25);
	var healthBoost = 20;
	var healthTextPosition = new vector((3/2) * canvasWidth / 10 -  (9 / 10) * healthBar.width, 37 * canvasHeight / 40);
	var healthText = "Health: ";
	var score = 0;
	var explosions = [];
	var maxExplosionRadius = 100;
	var projectilesFired = 0;
	var bulletThreshold = 3;
	var bulletBusters = [];
	var busterExplosions = [];
	var maxBusterExplosionRadius = 150;
	var alive = true;

	$('body').on('keydown keypress keyup', function(e) {
			var pressed = e.type=='keydown' ? true : false;
			if(e.which == 38) {
				if(pressed) {
					thrustSound.play();
					ship.thrust = true;
				}	
				else {
					thrustSound.pause();
					ship.thrust = false;
				}	
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
					laserSound.play();
					projectiles.push(ship.fireProjectile());
					projectilesFired++;

					if (projectilesFired >= bulletThreshold) {
						projectilesFired = 0;
						bulletBusters.push(new BulletBuster(new vector(Math.floor(Math.random() * canvasWidth), Math.floor(Math.random() * canvasHeight))));
					}
					//if(projectiles.length > 5 && !projectilesThreshold)
						//projectilesThreshold = true;
				
				}	
			}
		})
	
	function update() {
				ship.update();
				for (var i = 0; i < asteroids.length; i++) {
					asteroids[i].update();
				}

				healthBar.update();
				
				score += 0.05;

				if (healthBar.capacity <= 0) {
					//alert("Game over :( \n You ran out of health. \n Your final score is: " + Math.floor(score));
						//location.window.href = "/games/asteroids";
					alive = false;
					$("#canvasContainer").html('');
					$("#description").show();
					
					$.ajax({
						url : '/gameover',
						type : 'POST',
						DataType : 'json',
						data : { score : parseInt(Math.floor(score)), game : 'asteroids' },
						success : function(d) {
							
							if ( d.score ) {
								
								$("#score").html(
									"Your highest score is"
								);
								
							}
							
						}
						
					});
					

					
				}

				finishedExplosionIndices = [];

				for (var i = 0; i < explosions.length; i++) {
					explosions[i].update();
					if (explosions[i].radius > 10) {
						finishedExplosionIndices.push(i);
					}
				}


				for (var i = 0; i < finishedExplosionIndices.length; i++) {
					explosions.splice(finishedExplosionIndices[i], 1);
				}

				for (var i = 0; i < bulletBusters.length; i++) {
					bulletBusters[i].update();
				}

				finishedBusterExplosionIndices = [];
				for (var i = 0; i < busterExplosions.length; i++) {

					busterExplosions[i].update();
					if (busterExplosions[i].radius > maxBusterExplosionRadius) {
						finishedBusterExplosionIndices.push(i);
					}
				}

				for (var i = 0; i < finishedBusterExplosionIndices.length; i++) {
					busterExplosions.splice(finishedBusterExplosionIndices[i], 1);
				}

				for ( var i = 0; i < projectiles.length; i++ ) {
					
										
					let proj = projectiles[i];
					
					if ( proj.type == 'ghost' ) {
						
						let boostMagnitude = 7;
						
					//	let projMagnitude = proj.velocity.magnitude;
						
						for ( var j = 0; j < busterExplosions.length; j++ ) {
							
							let posBuster = busterExplosions[j].position;
							let posProj = proj.position;
							
							let velocityUpdate = posBuster.vectorAdd( posProj.multiply( -1 ) ).unit();
							
							proj.position = proj.position.vectorAdd( velocityUpdate.multiply(boostMagnitude) );
							
		
							
						}
					}
					
				}

				collisionResolution(asteroids, projectiles, ship, healthBar, healthBoost);
	}

	function draw() {
		ctx.clearRect(0, 0, canvasWidth, canvasHeight);
		ctx.beginPath()
		ctx.rect(0, 0, canvasWidth, canvasHeight);
		ctx.fill()
		ctx.strokeStyle = "#999999";
		ship.draw(ctx);


		for (var j = 0; j < asteroids.length; j++) {
			asteroids[j].draw(ctx);
		}
		for (var j = 0; j < projectiles.length; j++) {
			projectiles[j].draw(ctx);
		}
		for (var j = 0; j < explosions.length; j++) {
			explosions[j].draw(ctx);
		}
		for (var j = 0; j < bulletBusters.length; j++) {
			bulletBusters[j].draw(ctx);
		}
		for (var j = 0; j < busterExplosions.length; j++) {
			busterExplosions[j].draw(ctx);
		}

		healthBar.draw(ctx);
		ctx.fillStyle = "green";
		ctx.font = "20px Courier New";
		ctx.fillText(healthText, healthTextPosition.x, healthTextPosition.y);
		ctx.fillText("Score: " + Math.floor(score), healthTextPosition.x + 200, healthTextPosition.y);
		ctx.fillStyle = "black";
		ctx.fillStyle = "#000000";
		ctx.strokeStyle = "#999999";

	}
	var FPS = 60;
	setInterval(function() {
		if ( alive ) {
			update();
			draw();
		}
	}, 1000/FPS);
}


</script>
</body>
