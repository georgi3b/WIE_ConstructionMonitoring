<?php
session_start();


if(isset($_SESSION['user_id'])){
    $u_mail = $_SESSION['user_id']->u_mail;
}else{
    header("location:../start/index.php");
}

require_once('../start/connectDB.php');
$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();

$c_query ="SELECT * FROM Countries";
$stmt = $conn->prepare($c_query);
$stmt->execute();
$countries = $stmt->fetchAll();
echo json_encode($countries);
?>