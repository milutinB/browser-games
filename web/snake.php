<html>
	<head>
	<script type="text/javascript" src="/web/javascript/games/asteroids/transformations.js"></script>

	</head>
	<body>
		<canvas id="myCanvas" width="1000" height="600" style="border:1px solid #d3d3d3;"></canvas>
		
		<script type="text/javascript">
		
			function Segment ( position, next, direction, ctx ) {
				
				this.position = position;
				this.next = next;
				this.direction = direction;
				this.delta = 1;
				this.ctx = ctx;
				
				this.update = function() {
					
					this.position = this.position.vectorAdd(
					
												this.direction
												.unit()
												.mutiply( this.delta )
\												
										);
					
				}
				
				this.updateDirection = function( newDirection ) {
					
					this.direction = newDirection
					
				}
				
				
			
				
			}
		
			function Snake( position ) {
				
				this.position = position;
				
				this.getX = function() {
					
					return this.position.x
					
				}
				
			}
			
		
		</script>
	</body>
</html>