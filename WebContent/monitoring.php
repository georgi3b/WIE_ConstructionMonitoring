<?php
session_start();

require_once('connectDB.php');
$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();

if(isset($_SESSION['user_id'])){
	$u_mail = $_SESSION['user_id'];
}else{
	$u_mail = 'budgeo@yaho.ro';
}

//I need to get the id of the project that was selected, in order to store it
//into a session variable and to access it from next file
$proj_id='1';
$proj;
if($_SERVER["REQUEST_METHOD"] === "POST"){
	if(isset($_POST['info'])){
		$id = $_POST['id'];
		$stmt = $conn->prepare("SELECT * FROM project WHERE proj_id = :proj_id");
		$stmt->bindParam(':proj_id', $proj_id);
		$stmt->execute();
		$proj = $stmt ->fetch(PDO::FETCH_ASSOC);
		
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
	<br><br>
	<div>
	<h2>MONITORING</h2>
	</div>
	
	</body>
</html>