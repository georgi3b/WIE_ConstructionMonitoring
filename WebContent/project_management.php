<?php
session_start();

require_once('connectDB.php');
$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();

if(isset($_SESSION['user_id'])){
	$u_mail = $_SESSION['user_id']->u_mail;
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
				$done = $insert_query->execute();
				$proj_id = $conn->lastInsertId();
				if($done){
    				$_SESSION['proj_id']=$proj_id;
    				header("Location:project_info.php");
				} else{
				    echo "Insertion failed</br>";
				    header("Location:new_project.php");
				}
			} catch(PDOException $e){
				$done = false;
				echo "Insertion failed: ".$e->getMessage()."</br>";
				header("Location:new_project.php");
			}
		
	$proj_name = $company = $proj_type = $country = $city = $post_code = $street = $street_no = $description = "";
	}
}
?>