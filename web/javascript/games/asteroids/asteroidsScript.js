$(document).ready(function() {
	
	var velocity = {
		x:0, 
		y:0
	};

	$("#move").click(function(){
		
	})
	
	var c = document.getElementById("myCanvas");
	var ctx = c.getContext("2d");
	var shipDimension = 20;
	var canvasWidth = c.getAttribute("width");
	var canvasHeight = c.getAttribute("height");
	var centerX = canvasWidth/2;
	var centerY = canvasHeight/2; 
	var maxSpeed = 5;
	var projectileRadius = 5;
	var projectileCooldown = 500;
	var theta = 0.5;

	
	
	
	p1 = {
		x:centerX,
		y:centerY - shipDimension
	};

	function vector(X, Y) {
		this.x = X;
		this.y = Y;
	}
	
	p2 = {
		x:centerX - shipDimension,
		y:centerY + shipDimension
	};

	p3 = {
		x:centerX + shipDimension,
		y:centerY + shipDimension
	};

	velocity = {
		x: 0,
		y: 0
	};

	function projectile(position, velocity) {
		this.position = {
			x: position.x,
			y: position.y
		}
		this.velocity = velocity;
		this.update = function() {
			this.position.x+=velocity.x;
			this.position.y+=velocity.y;
		};
		this.draw = function(ctx) {
			ctx.beginPath();
			ctx.arc(this.position.x, this.position.y, projectileRadius, 0, 2*Math.PI);
			ctx.stroke();
			this.update();
		};
	}	
	
	var projectiles = [];
	
	var ship = {
		point1: p1,
		point2: p2,
		point3: p3,
		cooldown: projectileCooldown,
		lastShot: 0,
		velocity: velocity,
		velocityMagnitude: 0,
		draw: function(ctx) {
			this.update()
			ctx.moveTo(this.point1.x,this.point1.y);
			ctx.lineTo(this.point2.x,this.point2.y);
			ctx.stroke();
			ctx.moveTo(this.point2.x,this.point2.y);
			ctx.lineTo(this.point3.x,this.point3.y);
			ctx.stroke();
			ctx.moveTo(this.point3.x,this.point3.y);
			ctx.lineTo(this.point1.x,this.point1.y);
			ctx.stroke();
		},
		update: function() {
			if(this.outsideMap()) {
				this.point1.x = Math.abs(canvasWidth - this.point1.x);
				this.point2.x = Math.abs(canvasWidth - this.point2.x);
				this.point3.x = Math.abs(canvasWidth - this.point3.x);
				this.point1.y = Math.abs(canvasHeight - this.point1.y);
				this.point2.y = Math.abs(canvasHeight - this.point2.y);
				this.point3.y = Math.abs(canvasHeight - this.point3.y);
			}
			if(this.velocityMagnitude > 0 )
					this.velocityMagnitude-=0.05;	
			var velX = this.point1.x - (this.point2.x+this.point3.x)/2;
			var velY = this.point1.y - (this.point2.y+this.point3.y)/2;
			var len = Math.sqrt(velX*velX + velY*velY);
			velX = this.velocityMagnitude*velX/len;
			velY = this.velocityMagnitude*velY/len;
			this.velocity = {
				x: velX,
				y: velY
			}
		//	if(this.velocityMagnitude > 0)
				//alert(this.velocity.y);
			this.shift(this.point1);
			this.shift(this.point2);
			this.shift(this.point3);
			//alert(this.point1.x, this.point1.y)
		},
		shift: function(p) {
			//var yBefore = p.y;
			p.x = p.x + this.velocity.x;
			p.y = p.y + this.velocity.y;
			yAfter = p.y;
			//if(yAfter != yBefore)
				//alert('moved');
		},
		outsideMap: function() {
			var result1 = this.point1.x > canvasWidth || this.point1.x < 0 || this.point1.y > canvasHeight || this.point1.y < 0;
			var result2 = this.point2.x > canvasWidth || this.point2.x < 0 || this.point2.y > canvasHeight || this.point2.y < 0;
			var result3 = this.point3.x > canvasWidth || this.point3.x < 0 || this.point3.y > canvasHeight || this.point3.y < 0;
			return result1 && result2 && result3;
		},
		fireProjectile: function() {
			var velX = this.point1.x - (this.point2.x+this.point3.x)/2;
			var velY = this.point1.y - (this.point2.y+this.point3.y)/2;
			var initialVelocity = new vector(velX/10, velY/10);
			var newProjectile = new projectile(this.point1, initialVelocity);
			projectiles.push(newProjectile);
			this.lastShot = (new Date()).getTime();
		},
		readyToFire: function() {
			return Math.abs((new Date()).getTime()-this.lastShot) > this.cooldown;
		},
		rotate: function(direction) {
			var x = this.point1.x; var y = this.point1.y;
			this.translate(this.point1,x,y);
			this.point1.x = Math.cos(direction*theta)*this.point1.x - Math.sin(direction*theta)*this.point1.y;
			this.point1.y = Math.sin(direction*theta)*this.point1.x + Math.cos(direction*theta)*this.point1.y;
			this.translate(this.point1,-x,-y);
			x = this.point2.x; y = this.point2.y;
			this.translate(this.point2, x, y);
			this.point2.x = Math.cos(direction*theta)*this.point2.x - Math.sin(direction*theta)*this.point2.y;
			this.point2.y = Math.sin(direction*theta)*this.point2.x + Math.cos(direction*theta)*this.point2.y;
			this.translate(this.point2, -x, -y);
			x = this.point3.x; y = this.point3.y;
			this.translate(this.point3, x, y);
			this.point3.x = Math.cos(direction*theta)*this.point3.x - Math.sin(direction*theta)*this.point3.y;
			this.point3.y = Math.sin(direction*theta)*this.point3.x + Math.cos(direction*theta)*this.point3.y;
			this.translate(this.point3, -x,-y);
		},
		translate: function(p, x,y) {
			p.x-= x; p.y-=y;	
		}
	};
	
	
	$('body').on('keydown keypress keyup', function(e) {
		var pressed = e.type=='keydown' ? true : false;
		if(e.which == 38){
			if(pressed && ship.velocityMagnitude < maxSpeed){
				ship.velocityMagnitude+=0.3;
				//alert(ship.velocityMagnitude);
			}	
		}
		if(e.which == 39){
			if(pressed)
				ship.rotate(-1);
		}
		if(e.which == 37)
			if(pressed)
				ship.rotate(1);
		if(e.which == 32 && pressed){
			if(ship.readyToFire())
				ship.fireProjectile();
		}
				
	})

	var l = 0;
	function draw() {
		
		ctx.clearRect(0, 0, canvasWidth, canvasHeight);
		ctx.beginPath()
		ship.draw(ctx);
		for(var i = 0; i < projectiles.length; i++)
			projectiles[i].draw(ctx);

		requestAnimationFrame(draw);
		//ctx.clearRect(0, 0, canvasWidth, canvasHeight);
	}

	requestAnimationFrame(draw);

	


})