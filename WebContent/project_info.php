<?php
session_start();

require_once('connectDB.php');
$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();

if(isset($_SESSION['user_id'])){
	$u_mail = $_SESSION['user_id']->email;
}else{
	$u_mail = 'budgeo@yaho.ro';
}

//I need to get the id of the project that was selected/inserted, in order to store it
//into a session variable and to access it from next file
//$proj_id='1';
$proj;
$err="";

if(isset($_SESSION['proj_id'])){
    $proj_id = $_SESSION['proj_id'];
    $stmt = $conn->prepare("SELECT * FROM project WHERE proj_id = :proj_id");
    $stmt->bindParam(':proj_id', $proj_id);
    try{
        $stmt->execute();
        $proj = $stmt ->fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        $err = $e->getMessage();
        echo("Error: ".$e->getMessage());
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(isset($_POST['info'])){
		$proj_id = $_POST['id'];
		$stmt = $conn->prepare("SELECT * FROM project WHERE proj_id = :proj_id");
		$stmt->bindParam(':proj_id', $proj_id);
		try{
			$stmt->execute();
			$proj = $stmt ->fetch(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			$err = $e->getMessage();
			echo("Error: ".$e->getMessage());
		}
	}
}
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
<link rel="stylesheet" href="style.css">
<title>Project information</title>
</head>

	<body>
		
		<?php include 'navbarActive.php';?>
	

		<main role="main">
			<div
			class="container d-flex align-items-center justify-content-center min-vh-100 profile">
			
			<div class="proj-info">
			
				<?php if($_SERVER["REQUEST_METHOD"] === "POST"||isset($_SESSION['proj_id'])):?>
					<?php if(isset($_POST['info'])||isset($_SESSION['proj_id'])): ?>
						<h5 style="padding-top: 20px; padding-bottom: 20px">Project <?php echo ($proj_id);?>
							information</h5>
						<span><?php echo($err);?></span>
						<div class="row">
							<div class="col-lg-1">
								<h6>Name:</h6>
							</div>
							<div class="col-lg-2">
								<p><?php echo($proj['proj_name']); ?></p>
							</div>
						
						
							<div class="col-lg-1">
								<h6>Company:</h6>
							</div>
							<div class="col-lg-2">
								<p><?php echo($proj['company']); ?></p>
							</div>
						
							<div class="col-lg-1">
								<h6>Type:</h6>
							</div>
							<div class="col-lg-2">
								<p><?php echo($proj['proj_type']); ?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-1">
								<h6>Description:</h6>
							</div>
							<div class="col-lg-5">
								<?php echo($proj['description']); ?>
							</div>
						</div>
						<div> 
							<button type="button" class="btn btn-primary" href="#"> Monitoring </button>
						</div>
						<h5 style="padding-top: 20px; padding-bottom: 20px">Location
							information</h5>
						<hr></hr>
						<div class="row">
							<div class="col-lg-1">
								<h6>Address:</h6>
							</div>
							<div class="col-lg-10">
								<span><?php echo($proj['street']); ?>, 
									<?php echo($proj['street_no']); ?>, 
									<?php echo($proj['city']); ?>, 
										<?php echo($proj['post_code']); ?>,
										<?php echo($proj['country']); ?></span>
							</div>
						</div>
						
						<h5 style="padding-top: 20px; padding-bottom: 20px">Workers</h5>
						<hr></hr>
						<div id="workers"> 
							<button type="submit" class="btn btn-primary"> Add </button>
						</div>
						<!-- -->
						
						<h5 style="padding-top: 20px; padding-bottom: 20px"> Work types </h5>
						<hr></hr>
						<div id="Main working areas/types"> 
							<button type="submit" class="btn btn-primary"> Add </button>
						</div>
						
						<h5 style="padding-top: 20px; padding-bottom: 20px"> Activities </h5>
						<hr></hr>
						<div id="activities"> 
							<button type="submit" class="btn btn-primary"> Add </button>
						</div>
						
						<h5 style="padding-top: 20px; padding-bottom: 20px"> Work units/Tasks </h5>
						<hr></hr>
						<div id="tasks"> 
							<button type="submit" class="btn btn-primary"> Define </button>
						</div>
	
	
					<?php endif?>
			    <?php endif?>
			</div>
		</main>

	</body>
</html>
