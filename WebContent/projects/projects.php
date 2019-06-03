<?php
session_start();
if (!isset($_SESSION['user_id'])){
	header("location:../start/index.php");
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
	href="../styles/project_style.css">
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../styles/style.css">
<title>Projects</title>
<script type="text/javascript" src="../scripts/projects_functions.js" >
</script>
</head>
<body>

<?php include '../navbars/navbar_active.php';?>
<br>
<br>
<div class="full-table">
		<div class="projects">
			<h2>Projects</h2>
			<button class="btn btn-success  Redirect" id="showForm" onclick="window.location='../projects/new_project.php'">New Project</button>
		</div>
		
		<div id="table">
			<table class="table" id="data">
				<thead>
					<tr>
						<th data-field='proj_id'>Project Id</th>
						<th data-field='proj_name'>Project Name</th>
						<th data-field='active'>Active</th>
						<th data-field='proj_type'>Type</th>
						<th data-field='company'>Company</th>
						<th data-field='more'>More information</th>
						<th data-field='monitoring'>Monitoring</th>
					</tr>
				</thead>
				<tbody id="projects">
				</tbody>
			</table>
		</div>
	

	
</div>

</body>
</html>