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
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="cover-functions.js"></script>
<link rel="stylesheet" href="../styles/style.css">
<title>Projects</title>
<script>
$(document).ready(function() {
	
	//var json_proj = ?php echo json_encode($list_proj);?>;
	
	var json_proj;
	
	$.when(
			//get all the projects for the given user
			$.ajax({
				type:'post',
				url:'../projects/user_projects_controller.php',
				dataType:'json',
				success: function(data, statusTxt, xmlht){
					json_proj = data;
				}
		})
	).then(function(){

		if(window.location.hash == '#active'){
			$.each(json_proj, function(idx, obj) {
			//give only the results with active = true
			 if(obj.active==='true'||obj.active){
	    		 $('<tr>').attr('id',obj.proj_id).
	    		 append($('<td>').text(obj.proj_id)).
	    		  append($('<td>').text(obj.proj_name)).
	    		  append($('<td>').text(obj.active)).
	    		  append($('<td>').text(obj.proj_type)).
	    		  append($('<td>').text(obj.company)).
	    		  append($('<td>').
	    		  append($('<form>'). attr({'method':'post','action':'../projects/project_info.php'})
	    		  .append($('<input>').attr({'name':'id','value':obj.proj_id}))
	    		  .append($('<input>').attr({'name':'info','type': 'submit','class':'btn btn-outline-primary'}).val("more info"))
	    			 )).appendTo("tbody#projects");
	    		//append data to tbody with id "projects"
	        	$('<td>').
	        			append($('<form>').attr({'method':'post','action':'../monitoring/monitoring.php'})
	        			.append($('<input>').attr({'name':'id','value':obj.proj_id}))
	        			.append($('<input>').attr({'name':'mon','type': 'submit','class':'btn btn-outline-primary'}).val("monitor"))).
	        			appendTo("tr#"+obj.proj_id);
	    	
				}				
			});
		}
		else{
		
        	$.each(json_proj, function(idx, obj) {
    
        		 $('<tr>').attr('id',obj.proj_id).
        		 append($('<td>').text(obj.proj_id)).
        		  append($('<td>').text(obj.proj_name)).
        		  append($('<td>').text(obj.active)).
        		  append($('<td>').text(obj.proj_type)).
        		  append($('<td>').text(obj.company)).
        		  append($('<td>').
        		  append($('<form>'). attr({'method':'post','action':'../projects/project_info.php'})
        		  .append($('<input>').attr({'name':'id','value':obj.proj_id}))
        		  .append($('<input>').attr({'name':'info','type': 'submit','class':'btn btn-outline-primary'}).val("more info"))
        			 )).appendTo("tbody#projects");
        		//append data to tbody with id "projects"
        		if(obj.active==='true'||obj.active){
            		$('<td>').
            			append($('<form>').attr({'method':'post','action':'../monitoring/monitoring.php'})
            			.append($('<input>').attr({'name':'id','value':obj.proj_id}))
            			.append($('<input>').attr({'name':'mon','type': 'submit','class':'btn btn-outline-primary'}).val("monitor"))).
            			appendTo("tr#"+obj.proj_id);
        		} else {
        			$('<td>').text("Archived").appendTo("tr#"+obj.proj_id);
            	}
							
			});
		}
    	$('input[name="id"]').hide();
	});

	//$('input[name="id"]').hide();
	
	//var user = '?php echo $u_mail;?>';			

});
</script>
</head>
<body>

<?php include '../navbars/navbar_active.php';?>
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
						<th data-field='more'>More information</th>
						<th data-field='monitoring'>Monitoring</th>
					</tr>
				</thead>
				<tbody id="projects">
				</tbody>
			</table>
		</div>
	</div>

	<button class="btn btn-outline-success  Redirect" id="showForm"
		onclick="window.location='../projects/new_project.php'">New Project</button>


</body>
</html>