function UiRectangle(position, width, height, text, onClick, hover, primaryColor, secondaryColor) {
		this.position = position;
		this.text = text;
		this.onClick = onClick;
		this.hover = hover;
		this.primary = primaryColor;
		this.secondary = secondaryColor;
		this.currentColor = this.primary;


		this.update = function() {

		}

		this.draw = function(ctx) {
			ctx.fillStyle = this.currentColor;
			ctx.fillRect(this.position.x, this.position.y, this.width, this.height);
			ctx.fillStyle = "#000000";	
		}
}