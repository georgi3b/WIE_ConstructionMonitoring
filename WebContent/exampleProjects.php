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
<script type="text/javascript" src="cover-functions.js"></script>
<link rel="stylesheet" href="style.css">
<title>Projects</title>
<script>
$(document).ready(function() {

        $("#new_proj_container").hide();
		
		$("#showForm").click(function(){
			$("#new_proj_container").toggle();
		});
	
		//show projects' information
		$.ajax({
			type:'post',
			url:'projects.php',
			dataType:'json',
			success: function(data, statusTxt, xmlht){
				if(statusTxt=="success"){
					$.each(data, function(idx, obj) {
						//append data to tbody with id "projects"
						 $('<tr>').attr('id',obj.proj_id).
						  append($('<td>').text(obj.proj_id)).
						  append($('<td>').append($('<div contentEditable="true" class="edit">').text(obj.proj_name))).
						  append($('<td>').text(obj.active)).
						  append($('<td>').text(obj.proj_type)).
						  append($('<td>').text(obj.company)).
							appendTo("tbody#projects");
						
						
				})}
				if(statusTxt == "error")
					alert("Error: " + xmlht.status + ": " + xmlht.statusText);
				}
		});
		

});
</script>
</head>
<body>

	<?php include 'navigationBar.php' ?>

	<div id="project-table">
		<h2>Projects</h2>
		<div id="table">
		<table class="table" id="data">
			<thead>
				<tr>
					<th data-field='proj_id'>Project Id</th>
					<th data-field='proj_name'>Project Name</th>
					<th data-field='active'>Active</th>
					<th data-field='proj_type'>Type</th>
					<th data-field='company'>Company</th>
					<th data-field='more' href="#">More information</th>
				</tr>
			</thead>
			<tbody id="projects">
			</tbody>
		</table>
		</div>
		</div>
		
		<button class="btn btn-outline-success" id="showForm" 
			onclick="window.location='new_project_form.php'" class="Redirect">New
			Project</button>
		<!--	
		<div id = "new_proj_container">
				<//?php include 'new_project_form.php' ?>
		</div>
		-->
	
</body>
</html>