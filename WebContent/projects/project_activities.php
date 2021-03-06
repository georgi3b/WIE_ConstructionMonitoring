<?php
session_start();
if(isset($_SESSION['user_id'])){
	$u_mail = $_SESSION['user_id']->u_mail;
}else{
	header("location:../start/index.php");
}
require_once ('../start/connectDB.php');
$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();



$proj_id;
// project id is obtained from session or from page before
// after inserting project the corresponding already defined data is retrieved
if (isset($_SESSION['proj_id'])) {
    $proj_id = $_SESSION['proj_id'];
}

$sql = "
SELECT A.activity_id,A.code, A.description, A.work_type_id, WT.description as w_description
FROM activity A, work_type WT, project P
WHERE A.work_type_id = WT.work_type_id 
    AND WT.proj_type = P.proj_type 
    AND P.proj_id=:proj_id";


$stmt = $conn->prepare($sql);
$stmt->bindParam(':proj_id', $proj_id);

$stmt->execute();
$activities= $stmt->fetchAll();

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
	href="../styles/project_style.css">
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../scripts/form_validation_functions.js"></script>
<title>Project Activities</title>
<script>
$(document).ready(function() {
    var activities =  <?php echo json_encode($activities);?>;
    $.each(activities, function(idx, obj) {
    	$('<tr>').attr('id',obj.work_type_id).
		  append($('<td>').attr('id','id').text(obj.activity_id)).
		  append($('<td>').attr('id','code').text(obj.code)).
		  append($('<td>').attr('id','description').text(obj.description)).
		  append($('<td>').attr('id','work_type').text(obj.work_type_id)).
		  append($('<td>').attr('id','work_description').text(obj.w_description)).
			appendTo("#activities tbody");
		});
});
</script>
</head>
<body>
		<?php include '../navbars/navbar_active.php';?>
		<br>
    	<br>
    	<br>
    	<div class="full-table">
		
			<form action="../projects/worker_controller.php" method="post">
				<div class="form-row">
					<div class="col-1">
						<input type="submit" class="btn btn-success" name="back"
							value="❮ Back">
					</div>
					<div class="col-11">
						<h2>Activities</h2>
					</div>
				</div>
			</form>
		
	</div>
    	<div class="full-table">
    		<form>
    			<div class="form-row">
    				<div class="col-md-12">
    					<table class="table" id="activities">
    						<thead>
    							<tr>
    
    								<th data-field='id'>Id</th>
    								<th data-field='code'>Code</th>
    								<th data-field='description'>Description</th>
    								<th data-field='work_type'>Work Type id</th>
    								<th data-field='work_description'>Work Description</th>
    
    							</tr>
    						</thead>
    						<tbody>
    
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</form>
    	</div>

</body>
</html>