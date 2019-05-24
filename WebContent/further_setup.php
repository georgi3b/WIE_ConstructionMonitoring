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

if(isset($_SESSION['proj_id'])){
	$proj_id = $_SESSION['proj_id'];
}


$sql3="SELECT * FROM worker
WHERE u_mail= :u_mail";
$stmt3 = $conn->prepare($sql3);
$stmt3->bindParam(':u_mail', $u_mail);
$stmt3->execute();
$workers = array();
while($row = $stmt3->fetch(PDO::FETCH_ASSOC)){
	$workers[] = $row;
}

//after inserting project the corresponding data is retrieved
if(isset($_SESSION['proj_type'])){
	$sql2="SELECT * FROM work_type WHERE
	proj_type=:proj_type";
	$stmt2 = $conn->prepare($sql2);
	$stmt2->bindParam(':proj_type',$_SESSION['proj_type']);
}else{
	$sql2="SELECT * FROM work_type";
	$stmt2 = $conn->prepare($sql2);
}
$stmt2->execute();
$work_types = array();
while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
	$work_types[] = $row;
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
		<script type="text/javascript" src="form-validation.js"></script>
		<title>New Project</title>
		<script>
		$(document).ready(function() {
			var workers = <?php echo json_encode($workers);?>;
			$.each(workers, function(id, obj){
			var id = obj.w_name;
			$('<tr>').attr('id',id).
				  append($('<td>').attr('id','w_name').text(obj.w_name)).
				  append($('<td>').attr('id','role').text(obj.role)).
				  append($('<td>').attr('id','b_day').text(obj.b_day)).
				  append($('<td>').attr('id','phone_no').text(obj.phone_no)).
				  append($('<td>').attr('id','mail').text(obj.mail)).
				  append($('<td>').attr('id','address').text(obj.street+", "+
				  obj.street_no +", " + obj.city+", " + obj.post_code+", "+obj.country)).
					appendTo("#w_data tbody");
			});
			
			var work_types =  <?php echo json_encode($work_types);?>;
			$.each(work_types, function(idx, obj) {
				$('#work_types').append($('<option>', { 
					value: obj.work_type_id,
					text : obj.work_type_id + ": " +obj.description
				}));	
			});
			
			var proj = <?php echo($proj_id);?>;
			alert("Working on project id " + proj);
			
		});
		</script>
		</head>
	<body>
	<?php include 'navigationBar.php' ?>
		<br><br><br>
		<div id = "workers"> 
		<table class="table" id="w_data">
			<thead>
				<tr>
				
				<th data-field='name'>Name</th>
				<th data-field='role'>Role</th>
				<th data-field='b_day'>Born</th>
				<th data-field='phone_no'>Phone number</th>
				<th data-field='mail'>Mail</th>
				<th data-field='street'>Address</th>
				<th>Action</th>
				
				 </tr>
			</thead>
			<tbody>
			
			</tbody>
			
					
		</table>
		<div class="text-center">
				<span class="btn btn-primary btn_new_worker">Add New Worker</span>
		</div>
	<!--
		<div class="form-row">
					<div class="col-md-3 w-100">
						<label for="worker_name">Name</label> <input type="text"
							name="worker_name" placeholder="" maxlength="64" value="" class="form-control"
							required>
					</div>
					<div class="col-md-3 w-100">
						<label for="role">Role</label> <input type="text"
							name="role" placeholder="" maxlength="32" value="" class="form-control"
							required>
					</div>
					<div class="col-md-3 w-100">
						<label for="telephone">Telephone</label> <input type="text"
							name="telephone" placeholder="" maxlength="10" value="" class="form-control"
							required>
					</div>
		</div>
		<h3>Address</h3>
		<div class="form-row">
						<div class="col-md-6 w-100">
							<label for="street">Street</label> <input id="w_street"
							type="text"  name="street" placeholder="" value="" class="form-control"
								required />
						</div>
						<div class="col-md-3 w-100">
							<label for="street_no">Street no</label> <input id="w_street_no"
							type="text"
								 name="street_no" placeholder="" value="" class="form-control"
								required />
						</div>
				</div>
				<div class="form-row">
						<div class="col-md-3 w-100">
							<label for="city">City</label> <input id="w_city"
							type="text"
								 name="city" placeholder="" value="" class="form-control"
								required />
						</div>
						<div class="col-md-3 w-100">
							<label for="post_code">Post code</label> <input id="w_post"
							type="text"
								 name="post_code" placeholder="" value="" class="form-control"
								required />
						</div>
						
						<div class="col-md-3 w-100">
							<label for="country">Country</label> <select  id="w_country"
							onmousedown="if(this.options.length>5){this.size=5;}"
							onchange='this.size=0;' onblur="this.size=0;"
							id="countries" name="country" placeholder="" value="" class="form-control"
								required>
								<!--datalist id="countries">								
								</datalist >
							</select>
						</div>
				</div> -->
			
		
	
	</div>
		
		<div id = "proj_setup"> 
		<h2> A few more information </h2>
		<form class="needs-validation" novalidate> 
			<div class="form-row">
	
				<div class="col-md-2 w-100">
					<label for="work_type">Main work types</label>
<!--					<select id="work_types"
					onmousedown="if(this.options.length>5){this.size=5;}" onchange='this.size=0;'
					onblur="this.size=0;"
						name="work_type" class="form-control"  required>
					</select>  -->
					<input type="text" list = "work_types" name="work_type" 
					class="form-control"  required><datalist id="work_types"></datalist>
				</div>
				<div class="col-md-2 w-100">
					<label for="activity">Activities</label> <select id="activities" 
					onmousedown="if(this.options.length>5){this.size=5;}"
							onchange='this.size=0;' onblur="this.size=0;"
					name="activity" class="form-control" required>
						<!-- I want the options to be taken from DB based on the indicated work_type -->
						
				</select>
				</div>
			</div>
			<br>
			<div class="form-row">
					<div class="col-12">
						<div class="btn-group" role="group">
						
							<input id = "save_setup" type ="submit" class="btn btn-success mr-1 ml-1"  name="save_proj" value="Save">
								
							<input id= "next" type="submit" class="btn btn-success mr-1 ml-1" name="next" value="Next">
								
							<input id = "reset_setup" type ="reset"  class="btn btn-danger mr-1 ml-5"  name="reset" value="Cancel">
							
						</div>
					</div>
				</div>
			
		</form>	
	</div>
	</body>
</html>