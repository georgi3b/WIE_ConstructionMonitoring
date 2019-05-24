<?php
require_once('connectDB.php');
$instance = ConnectDB::getInstance();
$conn = $instance->getConnection();

$c_query ="SELECT * FROM Countries";
$stmt = $conn->prepare($c_query);
$stmt->execute();
$countries = array(); 
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	$countries[] = $row;
}
echo json_encode($countries);
?>