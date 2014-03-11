<?php require_once ('database.php');?>
<?php require_once ('session.php');?>
<?php 
//class for handling call rates
class CallRates 
{
	private $currentCallRates = array();
	
	public function getAllCallRates() 
	{
		global $database;
		
		$sql = "SELECT call_per_minute FROM call_type_tb ";
		$result_set = $database->query($sql);
		
		while ($row = mysql_fetch_array($result_set)) {
			$this->currentCallRates[] = $row['call_per_minute'];
		}
	}
	
	//getter method 
	public function getCurrentCallRates($index) 
	{
		return $this->currentCallRates[$index];
	}
	
	//setter method
	public function setCurrentCallRates($decGSM, $decNDD, $decIDD)
	{
		global $database;
		
		$sql = "UPDATE call_type_tb ";
		$sql .= "SET call_per_minute = ".$decGSM." ";
		$sql .= "WHERE call_type_id = 1";
		$result_set = $database->query($sql);
		
		$sql = "UPDATE call_type_tb ";
		$sql .= "SET call_per_minute = ".$decNDD." ";
		$sql .= "WHERE call_type_id = 2";
		$result_set = $database->query($sql);
		
		$sql = "UPDATE call_type_tb ";
		$sql .= "SET call_per_minute = ".$decIDD." ";
		$sql .= "WHERE call_type_id = 3";
		$result_set = $database->query($sql);
	}
}
?>