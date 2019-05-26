<?php 
session_start();
require_once ('connectDB.php');
$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();

if (isset($_SESSION['user_id'])) {
    $u_mail = $_SESSION['user_id'];
} else {
    $u_mail = 'budgeo@yaho.ro';
}

$proj_id = 80;
//project id is obtained from session or from page before
if (isset($_SESSION['proj_id'])) {
    $proj_id = $_SESSION['proj_id'];
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['info'])){
        $proj_id = $_POST['id'];
    }
}


//function to process input data and clean it
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$w_name = $role = $contract= $phone_no = $email = $country = $city = $post_code = $street = $street_no = "";
$phone_noErr;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (!empty($_POST['back'])){
        header("Location:project_info.php");
    }
    if(!empty($_POST['save_worker'])){    //for POST you use the name attribute
        $w_name = clean_input($_POST['worker_name']);
        $role =  clean_input($_POST['role']);
        $contract= clean_input($_POST['contract']);
        $phone_no = clean_input($_POST['telephone']);
        $email = clean_input($_POST['email']);
        $street = clean_input($_POST['street']);
        $street_no = clean_input($_POST['street_no']);
        $city = clean_input($_POST['city']);
        $post_code = clean_input($_POST['post_code']);
        $country =  clean_input($_POST['country']);
        
        if (!is_numeric($phone_no)) {
            $phone_noErr = "Telephone must be a number.";
            header("Location:workers_setup.php#phoneErr");
        } else{
            try{
            $conn->beginTransaction();
            $insert_worker = $conn->prepare("INSERT INTO worker(w_name,u_mail,role,phone_no,mail,country,
            city,post_code,street,street_no) VALUES (:w_name,:u_mail,:role,:phone_no,:mail,:country,
            :city,:post_code,:street,:street_no)");
            $insert_worker->execute(array(
                ':w_name'   => $w_name,
                ':u_mail'   => $u_mail,
                ':role'     => $role,
                ':phone_no' => $phone_no,
                ':mail'     => $email,
                ':country'  => $country,
                ':city'     => $city,
                ':post_code'=> $post_code,
                ':street'   => $street,
                ':street_no'=> $street_no
            ));
            $insert_wp = $conn->prepare("INSERT INTO worker_project(w_name,proj_id,contract)
            VALUES(:w_name,:proj_id,:contract)");
            $insert_wp->execute(array(':w_name'=> $w_name,':proj_id'=>$proj_id,
                    ':contract'=>$contract));
   
            $conn->commit();
            header("Location:workers_setup.php");
           // header("Location:project_info.php");
            } catch (PDOException $e) {
                $conn->rollBack();
                echo $e->getMessage();
                
            }
            
        }
        
        
    }
    
    else 
        //request of deleting an item is coming from the list of workers
        if (!empty($_POST['delete'])){
            $w_name = $_POST['name'];
            $delete_wp = $conn->prepare("DELETE from worker_project WHERE w_name=:w_name
            AND proj_id=:proj_id");
            $delete_wp->execute(array(':w_name'=> $w_name,':proj_id'=>$proj_id));
            header("Location:workers_setup.php");
            
        }
    
  
}

?>