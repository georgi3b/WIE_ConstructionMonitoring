<?php
session_start();

require_once ('connectDB.php');
$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();

if(isset($_SESSION['user_id'])){
    $u_mail = $_SESSION['user_id']->u_mail;
}else{
    header("location:index.php");
}

// I need to get the id of the project that was selected/inserted, in order to store it
// into a session variable and to access it from next file
// $proj_id='1';
$proj_id;
$err = "";


// the user is in this page because he/she has just created a project
if (isset($_SESSION['proj_id'])) {
    $proj_id = $_SESSION['proj_id'];
    $stmt = $conn->prepare("SELECT * FROM project WHERE proj_id = :proj_id");
    $stmt->bindParam(':proj_id', $proj_id);
    try {
        $stmt->execute();
        $proj = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $err = $e->getMessage();
        echo ("Error: " . $e->getMessage());
    }
}

// the user is in this page because he chosed the project from the list of projects
//or from the link on the Home page
//or from the link in the navbar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['info'])) {
        $proj_id = $_POST['id'];
        $_SESSION['proj_id'] = $proj_id;
        $stmt = $conn->prepare("SELECT * FROM project WHERE proj_id = :proj_id");
        $stmt->bindParam(':proj_id', $proj_id);
        try {
            $stmt->execute();
            $proj = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $err = $e->getMessage();
            echo ("Error: " . $e->getMessage());
        }
    }
}

//Activation and archiviation of project

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['archive'])){
        $update_query = $conn->prepare("UPDATE project SET active='false' WHERE proj_id=:proj_id");
        $update_query->bindParam(':proj_id', $proj_id);
        try{
            $update_query->execute();
        }catch(PDOException $e){
            $err = $e->getMessage();
            echo ("Error: " . $e->getMessage());
        }
        unset($_POST['archive']);
    }
    if (isset($_POST['activate'])){
        $update_query = $conn->prepare("UPDATE project SET active='true' WHERE proj_id=:proj_id");
        $update_query->bindParam(':proj_id', $proj_id);
        try{
            $update_query->execute();
        }catch(PDOException $e){
            $err = $e->getMessage();
            echo ("Error: " . $e->getMessage());
        }
        unset($_POST['activate']);
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
<link rel="stylesheet" href="style.css">
<title>Project information</title>
</head>

<body>
		
	<?php include 'navbarActive.php';?>

	<br><br><br>
	<div class="container d-flex align-items-center justify-content-center min-vh-100 profile">

		<div class="proj-info">
			
				<?php if($_SERVER["REQUEST_METHOD"] === "POST"||isset($_SESSION['proj_id'])):?>
					<?php if(isset($_POST['info'])||isset($_SESSION['proj_id'])): ?>
						<h5 style="padding-top: 20px; padding-bottom: 20px">Project <?php echo ($proj_id);?>
							information</h5>
			<span><?php echo($err);?></span>
			<hr></hr>
			<div class="row">
				<div class="col-lg-1">
					<p>Name:
					<p>
				
				</div>
				<div class="col-lg-2">
					<p><?php echo($proj['proj_name']); ?></p>
				</div>
				<div class="col-lg-1">
					<p>Company:
					<p>
				
				</div>
				<div class="col-lg-2">
					<p><?php echo($proj['company']); ?></p>
				</div>
				<div class="col-lg-1">
					<p>Type:
					<p>
				
				</div>
				<div class="col-lg-2">
					<p><?php echo($proj['proj_type']); ?></p>
				</div>
				
				<div class="col-lg-1 ">
					<p>Status:<p>
				
				</div>
				<div class="col-lg-2">
    				<?php if($proj['active']=="true"):?>
    					<p>Active</p>
    				<?php else:?>
    					<p>Archived</p>
    				<?php endif?>
					
				</div>
			</div>
			<div class="row pt-4 pt-lg-0">
				<div class="col-lg-1 ">
					<p>Description:
					<p>
				
				</div>
				<div class="col-lg-5">
								<?php echo($proj['description']); ?>
				</div>
			</div>
			
			<div class="row pt-4 pt-lg-0">
    			
    			<div class="col-md-6">
    				<button type="button" class="btn btn-primary" 
        					onclick="window.location.href = 'monitoring.php'">Monitor</button>
        		</div>
        		<div class="col-md-6 pt-4 pt-md-0">		
        			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">	
        			<?php if($proj['active']=="true"):?>
    				
        			 	<input type="submit" name="archive" class="btn btn-primary" 
        			 		value =	"Archive">
        			 		
        			 		<?php else:?>
        			 	
        			 	<input type="submit" name="activate" class="btn btn-primary" 
        			 		value =	"Reactivate">
        			 	
        			 	<?php endif?>
					</form>		
				</div>
			</div>
			<h5 style="padding-top: 20px; padding-bottom: 20px">Location
				information</h5>
			<hr></hr>
			<div class="rowpt-4 pt-lg-0">
				<div class="col-lg-1">
					<p>Address:
					
					
					<p>
				
				</div>
				<div class="col-lg-10">
					<span><?php echo($proj['street']); ?>, 
									<?php echo($proj['street_no']); ?>, 
									<?php echo($proj['city']); ?>, 
										<?php echo($proj['post_code']); ?>,
										<?php echo($proj['country']); ?></span>
				</div>
			</div>
			<div class="row pt-4 pt-lg-0">

				<div class="col-lg-3">
					<h5 style="padding-top: 20px; padding-bottom: 20px"></h5>
					<hr></hr>
					<div id="workers">
						<button type="submit" name="workers" class="btn btn-primary"
							onclick="window.location.href = 'workers_setup.php';">Workers</button>
					</div>
				</div>
				<div class="col-lg-3">
					<h5 style="padding-top: 20px; padding-bottom: 20px"></h5>
					<hr></hr>
					<div id="Main working areas/types">
						<button type="submit" name="work_types" class="btn btn-primary" 
						onclick="window.location.href = 'proj_work_types.php'">Work
							types</button>
					</div>
				</div>
				<div class="col-lg-3">
					<h5 style="padding-top: 20px; padding-bottom: 20px"></h5>
					<hr></hr>
					<div id="activities">
						<button type="submit" name="activities" class="btn btn-primary" 
						onclick="window.location.href = 'proj_activities.php'">Activities</button>
					</div>
				</div>
				<div class="col-lg-3">
					<h5 style="padding-top: 20px; padding-bottom: 20px"></h5>
					<hr></hr>
					<div id="tasks">
						<button type="submit" name="tasks" class="btn btn-primary"
						onclick="window.location.href = 'proj_tasks.php'">Work
							units/Tasks</button>
					</div>
				</div>
			</div>
					<?php endif?>
			    <?php endif?>
			</div>
	</div>

</body>
</html>
