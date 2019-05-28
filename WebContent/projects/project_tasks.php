<?php
session_start();
require_once ('../start/connectDB.php');


if(isset($_SESSION['user_id'])){
    $u_mail = $_SESSION['user_id']->u_mail;
}else{
    header("location:../start/index.php");
}

$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();

$proj_id;
// project id is obtained from session or from page before
if (isset($_SESSION['proj_id'])) {
    $proj_id = $_SESSION['proj_id'];
}

$tasks;

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
    var tasks =  <?php echo json_encode($tasks);?>;
    $.each(tasks, function(idx, obj) {
    	$('<tr>').attr('id',obj.task_id).
		  append($('<td>').attr('id','proj_id').text(obj.proj_id)).
		  append($('<td>').attr('id','unit_name').text(obj.unit_name)).
		  append($('<td>').attr('id','build_level').text(obj.build_level)).
		  append($('<td>').attr('id','work_type').text(obj.work_type_id)).
		  append($('<td>').attr('id','quantity').text(obj.quantity)).
		  append($('<td>').attr('id','orientation').text(obj.orientation)).
			appendTo("#tasks_data tbody");
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
    	<h3>Tasks for project with id: '<?php echo($proj_id);?>'</h3>
    	<div>
			<form action="../projects/worker_controller.php" method="post">
				<div class="form-row">
					<div class="col-9">
						<input type="submit" class="btn btn-success" name="back"
							value="Back to project">
						
					</div>
				</div>
			</form>
		</div>
    	<div id="tasks">
    	<table class="table" id="tasks_data">
			<thead>
				<tr>

					<th data-field='proj_id'>Project ID</th>
					<th data-field='work_type_id'>Work type id</th>
					<th data-field='unit name'>Unit name</th>
					<th data-field='level'>Level</th>
					<th data-field='orientation'>Orientation</th>
					<th data-field='quantity'>Quantity</th>
					<th>Action</th>

				</tr>
			</thead>
			<tbody>

			</tbody>


		</table>
    	</div>


</body>
</html>