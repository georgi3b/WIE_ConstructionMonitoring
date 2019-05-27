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

// $proj_query = "SELECT * FROM project WHERE u_mail =?";
$stmt = $conn->prepare("SELECT * FROM project
WHERE u_mail =:u_mail");
// $u_mail='budgeo@yaho.ro'; $_SESSION['user_id']
$stmt->bindParam(':u_mail', $u_mail);
$stmt->execute();
$list_proj = $stmt->fetchAll();
echo json_encode($list_proj);
?>