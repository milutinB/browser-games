<html>
	<head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link  href="web/css/home.css" rel="stylesheet" />
		<link href="web/css/form.css" rel="stylesheet" />
	</head>
	<body>
		<?php $errorMessages = $data["errorMessages"];
			foreach ($errorMessages as $error) {
		?>
		
			<div style="color: red;"><?php echo $error; ?></div>
		
		<?php } ?>
		<div class="container buffer">
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-4"></div>
				<div class="col-sm-4 form">
		<form method="post">
			<div style="color: white;"> Username </div>
			<input type="text" name="username">
			<div style="color: white;"> Email </div>
			<input type="text" name="email">
			<div style="color: white;"> Password </div>
			<input type="password" name="password">
			<div style="color: white;"> Repeat Password </div>
			<input type="password" name="repeatPassword">
			<br>
			<div style= "padding-top : 10px;">
								<input type="submit">
							</div>
		</form>
		</div>	
				<div class="col-sm-4"></div>
			</div>
		</div>
	</body>
</html>