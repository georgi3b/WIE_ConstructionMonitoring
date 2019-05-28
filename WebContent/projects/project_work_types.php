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

// project id is obtained from session or from page before
// after inserting project the corresponding already defined data is retrieved
if (isset($_SESSION['proj_id'])) {
    $proj_id = $_SESSION['proj_id'];
}else{
    header("location:../projects/projects.php");
}

$sql2 = "SELECT WT.work_type_id,WT.description, WT.proj_type FROM work_type as WT, project as P WHERE
WT.proj_type = P.proj_type AND P.proj_id=:proj_id";
$stmt2 = $conn->prepare($sql2);
$stmt2->bindParam(':proj_id', $proj_id);

$stmt2->execute();
$work_types = $stmt2->fetchAll();

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
<title>Project Work Types</title>
<script>
$(document).ready(function() {
    var work_types =  <?php echo json_encode($work_types);?>;
    $.each(work_types, function(idx, obj) {
    	$('<tr>').attr('id',obj.work_type_id).
		  append($('<td>').attr('id','work_type').text(obj.work_type_id)).
		  append($('<td>').attr('id','description').text(obj.description)).
		  append($('<td>').attr('id','proj_type').text(obj.proj_type)).
			appendTo("#work_types tbody");
		});
});
</script>
</head>
<body>
		<?php include '../navbars/navbar_active.php';?>
		<br>
    	<br>
    	<br>
    	<div>
    		<form>
    			<div class="form-row">
    				<div class="col-md-9">
    					<table class="table" id="work_types">
    						<thead>
    							<tr>
    
    								<th data-field='id'>Id</th>
    								<th data-field='description'>Description</th>
    								<th data-field='proj_type'>Project Type</th>
    
    
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