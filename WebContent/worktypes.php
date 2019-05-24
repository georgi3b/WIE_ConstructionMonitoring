<?php 
require_once('connectDB.php');
$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();

$type_query = "SELECT distinct proj_type FROM work_type";
$stmt = $conn->prepare($type_query);
//$u_mail='budgeo@yaho.ro';
//stmt->bind_param(u_mail. $u_mail);

$stmt->execute();
$list_type = array();
while($row = $stmt ->fetch(PDO::FETCH_ASSOC)){
	array_push($list_type, array(
	'proj_type'=>$row['proj_type']));
}
echo json_encode($list_type);

?>