<?php 
session_start();

if(isset($_SESSION['user_id'])){
    $u_mail = $_SESSION['user_id']->u_mail;
}else{
    header("location:../start/index.php");
}

$proj_id;
require_once ('../start/connectDB.php');
$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();

//project id is obtained from session or from page before
if (isset($_SESSION['proj_id'])) {
    $proj_id = $_SESSION['proj_id'];
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['info'])){
        $proj_id = $_POST['id'];
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (!empty($_POST['back'])){
        header("location:../projects/project_info.php");
    }
}

//request of deleting an item is coming from the list of workers
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (!empty($_POST['deleteWP'])){
        $w_name = $_POST['name'];
        $delete_wp = $conn->prepare("DELETE from worker_project WHERE w_name=:w_name
            AND proj_id=:proj_id");
        $delete_wp->execute(array(':w_name'=> $w_name,':proj_id'=>$proj_id));
        header("location:../projects/workers_setup.php");
        
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (!empty($_POST['addToProject'])){
        $w_name = $_POST['name'];
        $insertWP = $conn->prepare("INSERT into worker_project(proj_id,w_name, contract) 
        VALUES(:proj_id, :w_name, 'full-time')");
        $insertWP->execute ( array (
            ':proj_id' => $proj_id, ':w_name' => $w_name)
        );
        header("location:../projects/workers_setup.php");
        
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
  
    if(!empty($_POST['save_worker'])){    //for POST you use the name attribute
        $w_name = clean_input($_POST['worker_name']);
        $role =  clean_input($_POST['role']);
        $contract= clean_input($_POST['contract']);
        $phone_no = clean_input($_POST['telephone']);
        $email = clean_input($_POST['email']);
        $street = clean_input($_POST['w_street']);
        $street_no = clean_input($_POST['w_street_no']);
        $city = clean_input($_POST['w_city']);
        $post_code = clean_input($_POST['w_post_code']);
        $country =  clean_input($_POST['w_country']);
        
        if (!is_numeric($phone_no)) {
            $phone_noErr = "Telephone must be a number.";
            header("location:../projects/workers_setup.php#phoneErr");
        } else{
            try{
            $done;
            $conn->beginTransaction();
            $insert_worker = $conn->prepare("INSERT INTO worker(w_name,u_mail,role,phone_no,mail,country,
            city,post_code,street,street_no) VALUES (:w_name,:u_mail,:role,:phone_no,:mail,:country,
            :city,:post_code,:street,:street_no)");
            $done = $insert_worker->execute(array(
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
            $done = $insert_wp->execute(array(':w_name'=> $w_name,':proj_id'=>$proj_id,
                    ':contract'=>$contract));
            if($done){
            $conn->commit();
            header("location:../projects/workers_setup.php");
            } else{
                header("location:../projects/workers_setup.php#retry");
            }
           // header("Location:../projects/project_info.php");
            } catch (PDOException $e) {
                $conn->rollBack();
                echo $e->getMessage();
                header("location:../projects/workers_setup.php#retry");
            }
            unset($_POST['save_worker']);
            
        }     
        
    }
  
}

?>