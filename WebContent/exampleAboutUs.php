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
<link rel="stylesheet" href="style.css">
<title>About us</title>
</head>
<body>

	<?php 

		if (isset($_SESSION['user_id'])){
		  include 'navbarActive.php';}
		else{
		  include 'navbarCover.php';
		}
	?>
	<main role="main">
	<div
		class="container d-flex align-items-center justify-content-center min-vh-100 about">
		<div class="row">
			<div class="col-lg-6">
				<div
					class="inner-about-anna align-items-center justify-content-center">
					<img class="rounded-circle" src="images/anna.jpg"
						alt="Image of Anna Debiasi" width="160" height="160">
					<h2 style="padding-top: 20px; padding-bottom: 20px">Anna
						Debiasi</h2>
					<p>Donec sed odio dui. Etiam porta sem malesuada magna mollis
						euismod. Nullam id dolor id nibh ultricies vehicula ut id elit.
						Morbi leo risus, porta ac consectetur ac, vestibulum at eros.
						Praesent commodo cursus magna.</p>
					<!-- <img src="i.jpg"
						alt="Signature of Anna Debiasi" width="220" height="120"> -->
				</div>
			</div>
			<!-- /.col-lg-4 -->
			<div class="col-lg-6">
				<div
					class="inner-about-geo align-items-center justify-content-center">
					<img class="rounded-circle" src="images/georgiana.jpg"
						alt="Image of Georgiana Bud" width="160" height="160">
					<h2 style="padding-top: 20px; padding-bottom: 20px">Georgiana
						Bud</h2>
					<p>Duis mollis, est non commodo luctus, nisi erat porttitor
						ligula, eget lacinia odio sem nec elit. Cras mattis consectetur
						purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo,
						tortor mauris condimentum nibh.</p>
				</div>
			</div>

		</div>
	</div>
	</main>
</body>
</html>
