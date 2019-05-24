<?php 
// Singleton to connect db.
class ConnectDB {
  // Hold the class instance.
  private static $instance = null;
  private $conn;
  
  private $host = 'dumbo.db.elephantsql.com';
  private $user = 'ajuplode';
  private $pass = 'iU-Fy_Gx3BL7bXslEOBvslItAPO2xTaF';
  private $name = 'ajuplode';
   
  // The db connection is established in the private constructor.
  private function __construct()
  {
	try{
    $this->conn = new PDO("pgsql:host={$this->host};
    dbname={$this->name}", $this->user,$this->pass,
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
	} catch(PDOException $e){
		echo "Connection failed: ".$e->getMessage()."</br>";
	}
  }
  
  public static function getInstance()
  {
    if(!self::$instance)
    {
      self::$instance = new ConnectDB();
    }
   
    return self::$instance;
  }
  
  public function getConnection()
  {
    return $this->conn;
  }
  
  public function select($sql_query){
	  $sql_query->execute();
	  $result = array();
	  while($row = $stmt ->fetch(PDO::FETCH_ASSOC)){
		  $result[]=$row;
	  }
	  return $result;
  }
  
}
?>
