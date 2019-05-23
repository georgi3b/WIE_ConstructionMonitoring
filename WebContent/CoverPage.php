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
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="cover-functions.js"></script>
<link rel="stylesheet" href="cover-styles.css">
<title>Cover Page</title>
</head>
<body>

	<header>
		<nav class="navbar navbar-expand-md navbar-dark fixed-top">
			<a class="navbar-brand" href="#" onclick="gotoCover()">BuildUp</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse"
				data-target="#navbarCollapse" aria-controls="navbarCollapse"
				aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="navbar-collapse collapse" id="navbarCollapse" style="">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active"><a class="nav-link" href="#" onclick="gotoCover()">Home<span
							class="sr-only">(current)</span></a></li>
					<li class="nav-item"><a class="nav-link" href="#">About Us</a></li>

				</ul>
				<div class="form-inline mt-2 mt-md-0">
					<form>
						<button class="btn btn-outline-light" type="button" onclick="gotoRegister()" >Register</button>
						<button class="btn btn-light" type="button" onclick="gotoLogin()">Login</button>
					</form>
				</div>
			</div>
		</nav>
	</header>

	
	
	
	<div id="home">
		
		<div class="inner-cover" id="cover">
			<h1 class="cover-heading">BuildUp</h1>
			<h3>Insert info about BuildUp here.</h3>
			<p class="lead">
				<a href="#" class="btn btn-lg btn-secondary" onclick="gotoRegister()">Get Started</a>
			</p>
		</div>
		
		<div id="register">
			<form class="form-cover form-register" action="user_register.php" method="post">
				<h1 class="h3 mb-3 font-weight-normal">Register</h1>
				<label for="inputName" class="sr-only">Username</label> <input
					type="text" name="username" id="inputName" class="form-control"
					placeholder="Username" required autofocus>
				
				<label for="inputEmail" class="sr-only">Email address</label> <input
					type="email" name="email" id="inputEmail" class="form-control"
					placeholder="Email address" required autofocus>
					
				<label for="inputPassword" class="sr-only">Password</label> <input
					type="password" name="password" id="inputPassword" class="form-control"
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
			<form class="form-cover form-login" action="user_login.php" method="post">
				<h1 class="h3 mb-3 font-weight-normal">Log In</h1>
				<label for="inputEmail" class="sr-only">Email address</label> <input
					type="email" name="email" id="inputMail" class="form-control"
					placeholder="Username" required autofocus> <label
					for="inputPassword" class="sr-only">Password</label> <input
					type="password" name="password" id="inputPassword" class="form-control"
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
	
<?php if (isset($_SESSION['coverError'])):?> 

		<?php if ($_SESSION['coverError']=="login"):?>
		<script type="text/javascript">gotoLogin();</script>
		<?php else: ?>
		<script type="text/javascript">gotoRegister();</script>
		<?php endif; ?>
	<?php else: ?>
	
	<script type="text/javascript">gotoCover();</script>
	<?php endif; ?>
	
</body>
</html>