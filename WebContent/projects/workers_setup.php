<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $u_mail = $_SESSION['user_id']->u_mail;
} else {
    header("location:../start/index.php");
}

$proj_id;
// project id is obtained from session or from page before
if (isset($_SESSION['proj_id'])) {
    $proj_id = $_SESSION['proj_id'];
} else {
    header("location:../start/index.php");
}

require_once ('../start/connectDB.php');
$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();

// get the project I am adding workers for
$sql = "SELECT * FROM project WHERE proj_id = :proj_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':proj_id', $proj_id);
$stmt->execute();
$proj = $stmt->fetch(PDO::FETCH_ASSOC);

// get the workers that were inserted by this user (PRIVACY)
//and are not yet working on this project
$selWorkersUser = "SELECT * FROM worker as W1 WHERE W1.u_mail= :u_mail
EXCEPT
SELECT W.w_name, W.role,W.phone_no,W.mail,W.country,W.city,W.post_code,W.street,W.street_no, W.u_mail
FROM worker as W,project as P, worker_project as WP
WHERE P.proj_id= :proj_id 
AND P.proj_id=WP.proj_id 
AND WP.w_name = W.w_name
";
$stmt2 = $conn->prepare($selWorkersUser);
$stmt2->bindParam(':u_mail', $u_mail);
$stmt2->bindParam(':proj_id',$proj_id);
$stmt2->execute();
$workersUser = $stmt2->fetchAll();


// get the workers that were inserted by this user for this project
$selWorkersProj = "SELECT W.w_name,W.role,W.phone_no,W.mail,W.country,
W.city, W.post_code,W.street, W.street_no
FROM worker as W,project as P, worker_project as WP
WHERE P.proj_id= :proj_id 
AND P.proj_id=WP.proj_id 
AND WP.w_name = W.w_name";
$stmt3 = $conn->prepare($selWorkersProj);
$stmt3->bindParam(':proj_id', $proj_id);
$stmt3->execute();
$workersProj = $stmt3->fetchAll();

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
<script type="text/javascript"
	src="../scripts/form_validation_functions.js"></script>

<title>Workers</title>
<script>
$(document).ready(function() {

	var hash=location.hash;
	if (hash == "#phoneErr"){
		alert("Phone must be a number");
	}

	if (window.location.hash == '#retry') {
		alert("An error occured while creating the project"+ 
				"\nPerhaps the worker name is already in database."+
				"\nPlease try again.");
	} 
	
	$('#new_worker_div').hide();
	$('#new_worker').click(function() {
		  $('#workers').toggle("slide");
	      $('#new_worker_div').toggle("slide");
	      if (this.value=="Add New Worker") this.value = "Workers";
	      else this.value = "Add New Worker";
	});

	var workersProj = <?php echo json_encode($workersProj);?>;
	if (workersProj.length!=0){

			$('#empty_wp').hide();
			$('#workers_proj').show();
        	$.each(workersProj, function(id, obj){
            	var id = obj.w_name;
            	$('<tr>').attr('id',id).
            		  append($('<td>').attr('id','w_name').text(obj.w_name)).
            		  append($('<td>').attr('id','role').text(obj.role)).
            		  append($('<td>').attr('id','phone_no').text(obj.phone_no)).
            		  append($('<td>').attr('id','mail').text(obj.mail)).
            		  append($('<td>').attr('id','address').text(obj.street+", "+
            		  obj.street_no +", " + obj.city+", " + obj.post_code+", "+obj.country)).
            		  append($('<td>').
            		  append($('<form>'). attr({'method':'post','action':'../projects/worker_controller.php'})
            				  .append($('<input>').attr({'name':'name','value':obj.w_name,'type':'hidden'}))
            				  .append($('<input>').attr({'name':'deleteWP','type': 'submit','class':'btn btn-danger'}).val("Remove")
            						  ))).
            			appendTo("#workers_proj tbody");
        	});
	}
	
	var workersUser = <?php echo json_encode($workersUser);?>;
	if(workersUser.length != 0){

		$('#empty_workers').hide();
		$('#workers_user').show();
    	$.each(workersUser, function(id, obj){
    		//if workersUser is in WorkersProje, don't show it here
    		
        	var id = obj.w_name;
        	$('<tr>').attr('id',id).
        		  append($('<td>').attr('id','w_name').text(obj.w_name)).
        		  append($('<td>').attr('id','role').text(obj.role)).
        		  append($('<td>').attr('id','phone_no').text(obj.phone_no)).
        		  append($('<td>').attr('id','mail').text(obj.mail)).
        		  append($('<td>').attr('id','address').text(obj.street+", "+
        		  obj.street_no +", " + obj.city+", " + obj.post_code+", "+obj.country)).
        		  append($('<td>').
        		  append($('<form>'). attr({'method':'post','action':'../projects/worker_controller.php'})
        				  .append($('<input>').attr({'name':'name','value':obj.w_name,'type':'hidden'}))
        				  .append($('<input>').attr({'name':'addToProject','type': 'submit','class':'btn btn-success'}).val("Add to project")
        						  ))).
        			appendTo("#workers_user tbody");
    	});
	}
	

	var countries;
	$.when($.ajax({
				type:'post',
				url:'../projects/countries.php',
				dataType:'json',
				success: function(data, statusTxt, xmlht){
					countries = data;
				}
		})
	).then(function(){
        //alert(countries);
		$.each(countries, function(idx, obj) {
			$('#countries').append($('<option>', { 
				value: obj.iso_code,
				text : obj.country_name
			}));	
		});
	});
});
</script>
</head>
<body>
		<?php
        if (isset($_SESSION['user_id'])) {
           include '../navbars/navbar_active.php';
        } else {
           include '../navbars/navbar_cover.php';
        } ?>
	<br>
	<br>
	<br>
	<div style = "margin:10px">
		
		<form action="../projects/worker_controller.php" method="post">
			<div class="form-row">
				<div class="col-md-1">
					<input type="submit" class="btn btn-success" name="back"
						value="❮ Back">
				</div>
				<div class="col-md-9">
					<h3><?php echo($proj['proj_name']); ?>: Workers</h3>
				</div>
				
				<div class="col-md-2">
					<input type="button" class="btn btn-success btn_new_worker" id="new_worker" 
					value="Add New Worker"/>
				</div>
			</div>
		</form>

	</div>
	<br>
	<div id="workers"  style = "margin:20px">
		<h4>Workers for <?php echo($proj['proj_name']);?> project:</h4>

			<h5 id="empty_wp">You have currently no workers for this project.</h5>
			<table class="table" id="workers_proj" style="display:none">
				<thead>
					<tr>

						<th data-field='name'>Name</th>
						<th data-field='role'>Role</th>
						<th data-field='phone_no'>Phone number</th>
						<th data-field='mail'>Mail</th>
						<th data-field='address'>Address</th>
						<th>Action</th>

					</tr>
				</thead>
				<tbody>

				</tbody>

			</table>
			
	<br/> <br>
	<h4>All workers:</h4>
			<h5 id="empty_workers">You didn't add any workers yet. Please add a worker.</h5>
			<table class="table" id="workers_user" style="display:none">
				<thead>
					<tr>
						<th data-field='name'>Name</th>
						<th data-field='role'>Role</th>
						<th data-field='phone_no'>Phone number</th>
						<th data-field='mail'>Mail</th>
						<th data-field='address'>Address</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>

				</tbody>

			</table>
		
		
	</div>
		<div class="container justify-content-center align-items-center">
		<div id="new_worker_div" >
			<form action="../projects/worker_controller.php" method="post"
				class="needs-validation" novalidate>
				<h3>New worker information</h3>
				<div class="form-row">
					<div class="col-md-6 w-100 pt-4 pt-lg-2">
						<label for="worker_name">Name*</label> <input type="text"
							name="worker_name" placeholder="" maxlength="64" value=""
							class="form-control" required>
					</div>
					<div class="col-md-6 w-100 pt-4 pt-lg-2" >
						<label for="role">Role*</label> <input type="text" name="role"
							placeholder="" maxlength="64" value="" class="form-control"
							required>
					</div>
				<!-- 	<div class="col-md-3 w-100 pt-4 pt-lg-2">
						<label for="contract">Type of contract</label> <input type="text"
							name="contract" placeholder="" maxlength="32" value=""
							class="form-control" required>

					</div> -->
				</div>
				<div class="form-row">
					<div class="col-md-6 w-100 pt-4 pt-lg-2">
						<label for="telephone">Telephone*</label> <input type="text"
							name="telephone" placeholder="" maxlength="10" value=""
							class="form-control" required>

					</div>
					<div class="col-md-6 w-100 pt-4 pt-lg-2">
						<label for="email">Email</label> <input type="text" name="email"
							placeholder="" maxlength="32" value="" class="form-control">
					</div>
				</div>
				<br>
				<h3>Address</h3>
				<div class="form-row">
					<div class="col-md-8 w-100 pt-4 pt-lg-2">
						<label for="w_street">Street*</label> <input id="w_street"
							type="text" name="w_street" placeholder="" value=""
							maxlength="32" class="form-control" required />
					</div>
					<div class="col-md-4 w-100 pt-4 pt-lg-2">
						<label for="w_street_no">Street no*</label> <input id="w_street_no"
							type="text" name="w_street_no" placeholder="" value=""
							maxlength="8" class="form-control" required />
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 w-100 pt-4 pt-lg-2">
						<label for="w_city">City*</label> <input id="w_city" type="text"
							name="w_city" placeholder="" value="" class="form-control"
							maxlength="32" required />
					</div>
					<div class="col-md-4 w-100 pt-4 pt-lg-2">
						<label for="w_post_code">Post code*</label> <input id="w_post"
							type="text" name="w_post_code" placeholder="" value=""
							maxlength="8" class="form-control" required />
					</div>

					<div class="col-md-4 w-100 pt-4 pt-lg-2">
						<label for="w_country">Country*</label> <select
							onmousedown="if(this.options.length>5){this.size=5;}"
							onchange="this.size=0;" onblur="this.size=0;" id="countries"
							name="w_country" class="form-control" required>
						</select>
					</div>
				</div>
				<br>
				<div class="form-row">
					<div class="col-12">
						<div class="btn-group" role="group">
							<input type="submit" class="btn btn-success mr-1 ml-1"
								name="save_worker" value="Save"> <input type="reset"
								class="btn btn-danger mr-1 ml-5" name="reset" value="Cancel">
						</div>
					</div>
				</div>
			</form>
		</div>
		</div>

</body>
</html>