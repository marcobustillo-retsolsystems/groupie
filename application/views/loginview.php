<!DOCTYPE html>
<html>
<head>
	<title>Groupie</title>
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css');?>">
	<script type="text/javascript">
	</script>
	<style>
	 	html {font-family: GillSans, Calibri, Trebuchet, sans-serif;}
        
		body {background-image: url("assets/images/tupbackground.jpg");background-size: cover;}

	</style>
</head>
<body>
	<div id="wrapper_top" style="height: 100%; width: 100%; position: relative; z-index: 0">
		<div id="#content" style="position: absolute; z-index: 2; color: #ffffff;">
			<div class="container">
				<div class="login-body">
					<div class="row">
						<div class="col l8">
							<div class="card n/a transparent z-depth-0 ">
								<div class="card-content white-text">
									<span class="card-title1">Welcome to Groupie!</span>
									<p class="p1 hide-on-small-only">
										  Groupie is a web-based social network exclusively for the TUP community. Groupie will function like other social networking sites but with specific functions to solve the TUP community’s dilemma. It aims to alleviate these problems by creating a more systematic administration of groups for each courses/sections inside TUP.
									</p>
								</div>
							</div>
						</div>
						<div class="col l4 s12">	
							<div class="card-panel grey lighten-4">
								<div class="row">
									<form class="login-form" method="POST" action="<?php echo base_url('newsfeed');?>">
										<?php
											echo "<div class='error_msg'>";
											if (isset($error_message)) {
											echo '<label class="red-text text-darken-2">'.$error_message.'	</label>';
											}
											echo validation_errors();
											echo "</div>";
										?>
										<div class="row">
											<div class="input-field">
												<input name ="studentID" id="studentID" type="text" class="validate black-text">
												<label for="studentID" class="active">ID</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field">
												<input name ="password" id="password" type="password" class=" black-text">
												<label for="password" class="active">Password</label>
											</div> 
										</div>
										<div class="row">
											<button class="btn waves-effect waves-light red col s12" type="submit" name="action">Sign In
												<i class="material-icons right">send</i>	
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	  	</div>
		  	<div id="wrapper_bottom" style="z-index: -1; top: 0; height: 100%; position: absolute; width: 100%;">
		  	</div>
	</div>
</body>
</html>