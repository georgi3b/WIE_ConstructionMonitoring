<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="Anna Debiasi, Georgiana Bud">
<link rel="stylesheet" href="../styles/cover_styles.css">
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


<title>Cover Page</title>
</head>
<body>



	<?php include '../navbars/navbar_cover.php';?>
	
	
	<div id="home">
		
		<div class="inner-cover" id="cover">
			<h1 class="cover-heading">BuildUp</h1>
			<h3>Company description under construction.</h3>
			<p class="lead">
				<a href="#" class="btn btn-lg btn-secondary" onclick="gotoRegister()">Get Started</a>
			</p>
		</div>
		
		<div id="register">
			<form class="form-cover form-register" action="../user/user_register_controller.php" method="post">
				<h1 class="h3 mb-3 font-weight-normal">Register</h1>
				<label for="inputName" class="sr-only">Username</label> <input
					type="text" name="username" id="inputName" class="form-control"
					placeholder="Username" required autofocus>
				
				<label for="inputEmail" class="sr-only">Email address</label> <input
					type="email" name="email" id="inputEmail" class="form-control"
					placeholder="Email address" required autofocus>
					
				<label for="inputPassword" class="sr-only">Password</label> <input
					type="password" name="password" id="inputPasswordReg" class="form-control"
					placeholder="Password" required>
					
				<?php if (isset($_SESSION['coverError'])&&$_SESSION['coverError']=="register"): ?>
    <div class="form-errors">
        
            <p style="color:red;">The inserted email is already in use by another user. Please choose another email.</p>
        
    </div>
	<?php endif; ?>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Sign
					up</button>
					
				<p class="lead"> Already have an account? 
					<a href="#" onclick="gotoLogin()">Log In</a>
				</p>
				
			</form>
		</div>

		<div id="login" class="text-center">
			<form class="form-cover form-login" action="../user/user_login_controller.php" method="post">
				<h1 class="h3 mb-3 font-weight-normal">Log In</h1>
				<label for="inputEmail" class="sr-only">Email address</label> <input
					type="email" name="email" id="inputMail" class="form-control"
					placeholder="Email" required autofocus> <label
					for="inputPassword" class="sr-only">Password</label> <input
					type="password" name="password" id="inputPasswordlog" class="form-control"
					placeholder="Password" required>
				<?php if (isset($_SESSION['coverError'])&& $_SESSION['coverError']=="login"): ?>
    <div class="form-errors">
        
            <p style="color:red;">Wrong email or password.</p>
        
    </div>
	
<?php endif; ?>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Log
					in</button>
					
				<p class="lead"> New to BuildUp? 
					<a href="#" onclick="gotoRegister()">Sign Up</a>
				</p>
				
			</form>
		</div>
		
	</div>
	
	<script type="text/javascript">if (window.location.hash == '#login') {gotoLogin();} else if (window.location.hash === '#register') {gotoRegister();}</script>
<?php if (isset($_SESSION['coverError'])):?> 

		<?php if ($_SESSION['coverError']=="login"):?>
		<script type="text/javascript">gotoLogin();</script>
		<?php else: ?>
		<script type="text/javascript">gotoRegister();</script>
		<?php endif; ?>
	<?php else: ?>
<?php endif; ?>
	
</body>
</html>