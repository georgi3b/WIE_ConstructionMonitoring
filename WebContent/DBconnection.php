<?php
$servername = "dumbo.db.elephantsql.com";
$dbname = "ajuplode";
$username = "ajuplode";
$password = "iU-Fy_Gx3BL7bXslEOBvslItAPO2xTaF";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password,
	array(PDO::ATTR_PERSISTENT => true));
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully</br>"; 
    }
catch(PDOException $e)
    {
   // echo "Connection failed: " . $e->getMessage()."</br>";
    }

$sql="SELECT * FROM activity";
$stmt = $conn->prepare($sql);
$stmt->execute();
$no_rec = $stmt->rowCount();
$data = array();
$i=0;
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	array_push($data,  array('id' => $row['activity_id'],
		'description' =>$row['description'];
	
}
echo json_encode($data);


?>