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

//function to process input data and clean it
function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//POST method of form --> INSERT project into DB
$done=false;
$proj_name = $company = $proj_type = $country = $city = $post_code = $street = $street_no = $description = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(!empty($_POST['save_proj'])){
		
			
			$proj_name = clean_input($_POST['proj_name']);
			$company = clean_input($_POST['company']);
			$proj_type = clean_input($_POST['proj_type']);
			$_SESSION['proj_type'] = $proj_type;
			$country = clean_input($_POST['country']);
			$city = clean_input($_POST['city']);
			$post_code = clean_input($_POST['post_code']);
			$street = clean_input($_POST['street']);
			$street_no = clean_input($_POST['street_no']);
			$description = clean_input($_POST['description']);
			$active="true";
			
		
			$insert_query = $conn->prepare("INSERT INTO project(u_mail,proj_name,active,proj_type,company		
			,country,city,post_code,street,street_no,description) 
			VALUES(:u_mail,:proj_name,:active,:proj_type,:company		
			,:country,:city,:post_code,:street,:street_no,:description)");
			$insert_query->bindParam(':u_mail',$u_mail);
			$insert_query->bindParam(':proj_name',$proj_name);
			$insert_query->bindParam(':active',$active);
			$insert_query->bindParam(':proj_type',$proj_type);
			$insert_query->bindParam(':company',$company);
			$insert_query->bindParam(':country',$country);
			$insert_query->bindParam(':city',$city);
			$insert_query->bindParam(':post_code',$post_code);
			$insert_query->bindParam(':street',$street);
			$insert_query->bindParam(':street_no',$street_no);
			$insert_query->bindParam(':description',$description);
			try{
				$insert_query->execute();
				$proj_id = $conn->lastInsertId();
				$done = true;
				$_SESSION['proj_id']=$proj_id;
				header("Location:project_info.php");
			} catch(PDOException $e){
				$done = false;
				echo "Insertion failed: ".$e->getMessage()."</br>";
			}
		
	
	$proj_name = $company = $proj_type = $country = $city = $post_code = $street = $street_no = $description = "";
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
		<script type="text/javascript" src="form-validation.js"></script>
		<script type="text/javascript" src="new_proj_functions.js">
			var done = <?php echo($done) ?>;
		</script>
		<title>New Project</title>

	</head>
	<body>
		<?php include 'navbarActive.php'; ?>
		<br><br><br>
		<div id = "new_project">
			<h2>Insert here the details of the project</h2>
			<h3><?php if($done){echo($proj_id);}?></h3>
			
			<form  class="needs-validation" novalidate method="post" 
				action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<div class="form-row">
						<div class="col-md-3 w-100">
							<label for="proj_name">Name</label> <input type="text"
								name="proj_name" placeholder="" maxlength="32" value="" class="form-control"
								required>
								<div class="invalid-feedback">Please insert a name.</div>
						</div>
						<div class="col-md-3 w-100">
							<label for="company">Company</label> <input type="text"
								 name="company" placeholder="" value="" class="form-control"
								required>
						</div>
						
						<div class="col-md-3 w-100">
							<label for="proj_type">Type of project</label> <select
								id ="proj_type_dropd" name="proj_type" class="form-control" required>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-9 w-100">
						<label for="description">Description</label>
						<textarea name = "description" placeholder="" value="" class="form-control"
							maxlength="512"	rows="2" required></textarea>
						</div>
						
					</div>
					<br/>
					<h3>Address</h3>
					<div class="form-row">
							<div class="col-md-6 w-100">
								<label for="street">Street</label> <input id="p_street" type="text"
									 name="street" placeholder="" value="" class="form-control"
									required />
							</div>
							<div class="col-md-3 w-100">
								<label for="street_no">Street no</label> <input id="p_street_no" type="text"
									 name="street_no" placeholder="" value="" class="form-control"
									required />
							</div>
					</div>
					<div class="form-row">
							<div class="col-md-3 w-100">
								<label for="city">City</label> <input id="p_city" type="text"
									 name="city" placeholder="" value="" class="form-control"
									required />
							</div>
							<div class="col-md-3 w-100">
								<label for="post_code">Post code</label> <input id="p_post" type="text"
									 name="post_code" placeholder="" value="" class="form-control"
									required />
							</div>
							
							<div class="col-md-3 w-100">
								<label for="country">Country</label> <select 
								onmousedown="if(this.options.length>5){this.size=5;}"
								onchange='this.size=0;' onblur="this.size=0;"
								id="countries" name="country" placeholder="" value="" class="form-control"
									required>
									<!--datalist id="countries">								
									</datalist -->
								</select>
							</div>
					</div>
				
					<br/>
					<div class="form-row">
						<div class="col-9">
							<div class="btn-group" role="group">
							
								<input type ="submit"  name="save_proj" class="btn btn-success mr-1 ml-1" value="Save" >
								
								<input type ="reset" name="reset_proj" class="btn btn-danger mr-1 ml-5"   value="Cancel">
								
							</div>
						</div>
					</div>
			</form>
			
		</div>
	</body>
</html>
		