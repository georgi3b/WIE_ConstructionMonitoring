<?php
session_start();

if(isset($_SESSION['user_id'])){
    $id = $_SESSION['user_id'];
}else{
    header("location:../start/index.php");
}

require_once ('../start/connectDB.php');
$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();

$stmt = $conn->prepare("SELECT * FROM project WHERE u_mail = :email");
$stmt->execute(array(':email' => $_SESSION['user_id']->u_mail));
$projects = $stmt->fetchAll();
	
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
<link rel="stylesheet" href="../styles/style.css">
<title>User profile</title>
</head>
<body>

	<?php include '../navbars/navbar_active.php';?>
	
	<div
		class="container d-flex align-items-center justify-content-center min-vh-100 profile">
		<div class="row">
			<div class="col-lg-5">
				<div
					class="user-img" style="text-align: center">
					<img class="rounded-circle" src="../images/user_icon.png"
						alt="User Image" width="350" height="350">

				</div>
			</div>
			<div class="col-lg-7">
				<div class="user-info">
					<h3 style="padding-top: 20px; padding-bottom: 20px">Personal
						information</h3>
					<hr></hr>
					<div class="row">
						<div class="col-lg-6">
							<h5>Name:</h5>
						</div>
						<div class="col-lg-5">
							<p><?php echo($id->u_name);?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<h5>Email:</h5>
						</div>
						<div class="col-lg-5">
							<p><?php echo($id->u_mail);?></p>
						</div>
					</div>
					<h3 style="padding-top: 20px; padding-bottom: 20px">Supervised Projects</h3>
					<hr></hr>
						<?php if (sizeof($projects)>0):?>
						<div class="col-lg-12" style="padding: -20px;">
							<ul>
								<?php foreach($projects as $proj): ?>
								<li class="list"><?php echo($proj[2]); ?>, <?php echo($proj[5]); ?></li>
								<?php endforeach;?>
							</ul>
						</div>
						<?php else:?>
						<p>You are not supervising any projects. <a href="../projects/new_project.php">Create a new Project</a></p>
						<?php endif?>
					<!--<button style="margin-top: 20px;"
						class="btn btn-outline-primary mr-1" type="button">edit
						info</button>-->
				</div>
			</div>

		</div>
	</div>
	
</body>
</html>
