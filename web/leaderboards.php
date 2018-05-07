<html>
	<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="web/javascript/home.js"></script>
		<link  href="web/css/home.css" rel="stylesheet" />
		<style>
		table {
			border-collapse: collapse;
			width: 100%;
		}

		td, th {
			border: 2px solid #dddddd;
			text-align: left;
			padding: 10px;
		}

		tr:nth-child(even) {
			background-color: green;
		}
		</style>
	</head>
	
	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-dark">
		  <a class="navbar-brand" style="color: white;" href="/">Minimal Browser Games</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
			  <li class="nav-item active">
				<a class="nav-link" style="color: white;" href="/games">Games <span class="sr-only">(current)</span></a>
			  </li>
			  <li class="nav-item active">
				<a class="nav-link" style="color: white;" href="/leaderboards">Leaderboards</a>
			  </li>
			</ul> <?php if (!$_SESSION["user"]) { ?>
			<a class = "nav-link" href="/signin" style="color: white;"> Login </a> 
			 <button id="signupButton" style = "color: white;" class="btn btn-outline-success my-2 my-sm-0" href="/signup">Sign up</button> 
			 <?php
				} else {
			 ?>
				<div style="color: white;"> Welcome, <?php echo $_SESSION["user"]; ?> </div>
				<a class = "nav-link" href="/logout" style="color: white;"> Log Out </a> 
			 <?php
				}
			 ?>
		  </div>
	</nav>
	<div class="container buffer">
	</div>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-2">
			</div>
			<div class="col-sm-10">
				<h3>
					Asteroids Leaderboard
				</h3>
				<table>
					<tr>
						<th>
							User
						</th>
						<th>
							Score
						</th>
					</tr>
					<?php 
						foreach ( $data as $score ) {
					?>
						<tr>
							<td>
								<?php echo $score["username"] ?>
							</td>
							<td>
								<?php echo $score["score"] ?>
							</td>
						</tr>
					<?php
						}
					?>	
				</table>
			</div>
			<div class="col-sm-2">
			</div>
		</div>
	</div>
	</body>
</html>