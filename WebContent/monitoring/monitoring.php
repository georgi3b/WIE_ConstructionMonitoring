<?php
session_start();

$u_mail;
if (isset($_SESSION['user_id'])) {
    $u_mail = $_SESSION['user_id']->u_mail;
} else {
    header("location:../start/index.php");
}

require_once ('../start/connectDB.php');
$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();


$proj_id;
// project id is obtained from session or from page before
if (isset($_SESSION['proj_id'])) {
    $proj_id = $_SESSION['proj_id'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['mon'])) {
        $proj_id = $_POST['id'];
        $_SESSION['proj_id'] = $proj_id;
    }
}

$tasks;
$proj;
$proj_type_query = "SELECT * FROM project P
WHERE P.proj_id= :proj_id";
$stmt = $conn->prepare($proj_type_query);
$stmt->bindParam(':proj_id', $proj_id);
$stmt->execute();
$proj = $stmt->fetch(PDO::FETCH_ASSOC);


$sql3 = "SELECT * FROM task WHERE proj_id= :proj_id";
$stmt3 = $conn->prepare($sql3);
$stmt3->bindParam(':proj_id', $proj_id);
$stmt3->execute();
$tasks = $stmt3->fetchAll();

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
<script type="text/javascript" src="../scripts/form_validation_functions.js"></script>
<script>
$(document).ready(function() {
	var tasks_json = <?php echo json_encode($tasks);?>;
	var proj_type = '<?php echo($proj['proj_type']);?>' ;
  //  alert(proj_type);

	
    $.each(tasks_json, function(idx, obj) {
    	$('#unit_dropd').append($('<option>', { 
			value: obj.unit_name,
			text : obj.unit_name
		}));
     });
});
</script>
<title>Tasks</title>

</head>
<body>
		<?php include '../navbars/navbar_active.php';?>
		<br>
	<br>
	<br>
	<?php if($proj['proj_type']=="BIM-FR"):?>
	<h3>Working units to be monitored for BIM model:</h3>
	<form>
		<div class="row">
			<div class="col-md-3 w-100">
			
				<label for="work_type">Type of work</label> <select
					id="work_type_dropd" name="work_type" class="form-control" required>
					<option>AB01</option>
					<option>AB02</option>
				</select>
			</div>
			<div class="col-md-3 w-100">
				<label for="units">Unit</label> <select id="unit_dropd" name="units"
					class="form-control" required>
					
				</select>
			</div>
			<div class="col-md-1 w-100">
				<label for="completed">Done</label> <input type="checkbox" 
					name="completed" value="ok">
			</div>
			<div class="col-md-1 w-100">
				<label for="progress">Active</label> <input type="checkbox" "
					name="progress" value="ok">
			</div>
			<div class="col-md-1 w-100">
				<label for="delay">Delay   </label> <input type="checkbox" name="delay" 
					value="ok">
			</div>
			<div class="col-md-1 w-100">
				<label for="ncr">NCR    </label> <input type="checkbox" name="ncr" 
					value="ok">
			</div>
			<div class="col-md-1 w-100">
				<label for="RNC">RNC    </label> <input type="checkbox" name="rnc" 
					value="ok">
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 w-100">
				<label for="date">Date</label> <input type="text" name="date"
					placeholder="" value="" class="form-control" required>
			</div>
			<div class="col-md-3 w-100">
				<label for="note">Note</label> <input type="text" name="note"
					placeholder="" value="" class="form-control" required>
			</div>
			<div class="col-md-3 w-100">
				<label for="website">Website</label> <input type="text"
					name="website" placeholder="" value="" class="form-control"
					required>
			</div>
		</div>
		<br>
		<div class="row">
			<input type="submit" class="btn btn-success" value="Save info">
		</div>
	</form>
	
	<?php else:?>
	<h3>Monitoring form under construction... We apologize for the inconvenience.</h3>
	<?php endif?>
</body>
</html>