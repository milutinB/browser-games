function vector(x, y) {
	this.x = x;
	this.y = y;
	//v is a vector object
	this.vectorAdd = function(v) {
		return new vector(this.x + v.x, this.y + v.y);
	}
	//a is a number
	this.multiply = function(a) {
		return new vector(a*this.x, a*this.y);
	}
	//v is a vector object
	this.translate = function(v) {
		var x =  this.x;
		var y = this.y;
		x+=v.x;
		y+=v.y;
		return new vector(x, y);
	}
	//axis is a vector, angle is a number, 0 <= angle <= 360
	this.rotate = function(axis, angle) {
		var aux = this.translate(axis.multiply(-1));
		var auxX = aux.x; var auxY = aux.y;
		aux.x = auxX*Math.cos(angle) - auxY*Math.sin(angle);
		aux.y = auxX*Math.sin(angle) + auxY*Math.cos(angle);
		aux = aux.translate(axis);
		return aux;
	}
	this.draw = function(ctx, startVector) {
		if(startVector == 0) {
			var sx = 0; 
			var sy = 0;
		}
		else {
			var sx = startVector.x; 
			var sy = startVector.y;
		}
		ctx.beginPath()
		ctx.moveTo(sx,sy);
		ctx.lineTo(this.x,this.y);
		ctx.stroke();
	}
	
	this.length = function() {
		return Math.sqrt(this.x*this.x + this.y*this.y);
	}
	
	this.midpoint = function(v) {
		var x = (v.x + this.x)/2;
		var y = (v.y + this.y)/2;
		return new vector(x, y);
	}
	
	this.unit = function() {
		return new vector(this.x/this.length(), this.y/this.length());
	}
	this.wrap = function (w, h) {
		
		var outside = this.x > w || this.x < 0 || this.y > h || this.y < 0;
		if(outside){
			var X = this.x;
			var Y = this.y;
			if(X < 0)
				X+=parseInt(w);
			else if(X > w)
				X-= w;
			else if(Y < 0)
				Y += parseInt(h);	
			else if(Y > h)
				Y-= h;
			return new vector(X,Y);
		}
		else
			return this;
	}
}

