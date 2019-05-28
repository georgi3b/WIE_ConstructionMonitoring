<?php
session_start();

require_once ('../start/connectDB.php');
$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();

$u_mail;
if(isset($_SESSION['user_id'])){
    $u_mail = $_SESSION['user_id']->u_mail;
}else{
    header("location:../start/index.php");
}

$stmt = $conn->prepare("SELECT * FROM project
WHERE u_mail =:u_mail");
$stmt->bindParam(':u_mail', $u_mail);
$stmt->execute();
$list_proj = $stmt->fetchAll();
echo json_encode($list_proj);
?>