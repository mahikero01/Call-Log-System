<?php require_once ('database.php'); ?>
<?php
class ReportGenerator {
	public $lineOneBillNumber = array();
	public $lineTwoBillNumber = array();
	public $totalCost;
	public $userWithPRCalls = array();
	
	public function getBillNumbers() 
	{
		global $database;
		
		$sql = "SELECT DISTINCT a.bill_number AS bill_number "; 
		$sql .= "FROM call_log_tb AS a ";
		$sql .= "CROSS JOIN tele_number_tb AS b ";
		$sql .= "ON a.tele_number_id = b.tele_number_id ";
		$sql .= "CROSS JOIN user_info_tb AS c ";
		$sql .= "ON a.user_info_id = c.user_info_id ";
		$sql .= "CROSS JOIN location_tb AS d ";
		$sql .= "ON b.location_id = d.location_id ";
		$sql .= "CROSS JOIN call_type_tb AS e ";
		$sql .= "ON d.call_type_id = e.call_type_id ";
		$sql .= "WHERE a.user_ack = 'Y' ";
		$sql .= "AND a.audit_ack = 'Y' ";
		$sql .= "AND a.show_log = 'Y' ";
		$sql .= "AND a.bill_number < 200 ";
		$sql .= "ORDER BY a.bill_number ";
		$result_set = $database->query($sql);	

		while ($row = mysql_fetch_array($result_set)) {
			$this->lineOneBillNumber[] = $row['bill_number'];
		}
		
		$sql = "SELECT DISTINCT a.bill_number AS bill_number "; 
		$sql .= "FROM call_log_tb AS a ";
		$sql .= "CROSS JOIN tele_number_tb AS b ";
		$sql .= "ON a.tele_number_id = b.tele_number_id ";
		$sql .= "CROSS JOIN user_info_tb AS c ";
		$sql .= "ON a.user_info_id = c.user_info_id ";
		$sql .= "CROSS JOIN location_tb AS d ";
		$sql .= "ON b.location_id = d.location_id ";
		$sql .= "CROSS JOIN call_type_tb AS e ";
		$sql .= "ON d.call_type_id = e.call_type_id ";
		$sql .= "WHERE a.user_ack = 'Y' ";
		$sql .= "AND a.audit_ack = 'Y' ";
		$sql .= "AND a.show_log = 'Y' ";
		$sql .= "AND a.bill_number > 199 ";
		$sql .= "ORDER BY a.bill_number ";
		$result_set = $database->query($sql);	

		while ($row = mysql_fetch_array($result_set)) {
			$this->lineTwoBillNumber[] = $row['bill_number'];
		}
	}
	
	public function getAllTransactCalls($purpose, $billOne, $billTwo)
	{
		global $database;

		$sql = "SELECT sum(a.total_call_cost) "; 
		$sql .= "FROM call_log_tb AS a ";
		$sql .= "CROSS JOIN tele_number_tb AS b ";
		$sql .= "ON a.tele_number_id = b.tele_number_id ";
		$sql .= "CROSS JOIN user_info_tb AS c ";
		$sql .= "ON a.user_info_id = c.user_info_id ";
		$sql .= "CROSS JOIN location_tb AS d ";
		$sql .= "ON b.location_id = d.location_id ";
		$sql .= "CROSS JOIN call_type_tb AS e ";
		$sql .= "ON d.call_type_id = e.call_type_id ";
		$sql .= "WHERE a.user_ack = 'Y' ";
		$sql .= "AND a.audit_ack = 'Y' ";
		$sql .= "AND a.show_log = 'Y' ";
		$sql .= "AND a.call_purpose = '".$purpose."' ";
		$sql .= "AND a.bill_number in ( ".$billOne.", ".$billTwo." )";
		$result_set = $database->query($sql);	
		
		$this->totalCost = mysql_fetch_array($result_set);		
	}
	
	public function getUserWithPRCalls($billOne, $billTwo)
	{
		global $database;

		$sql = "SELECT DISTINCT c.user_initial "; 
		$sql .= "FROM call_log_tb AS a ";
		$sql .= "CROSS JOIN tele_number_tb AS b ";
		$sql .= "ON a.tele_number_id = b.tele_number_id ";
		$sql .= "CROSS JOIN user_info_tb AS c ";
		$sql .= "ON a.user_info_id = c.user_info_id ";
		$sql .= "CROSS JOIN location_tb AS d ";
		$sql .= "ON b.location_id = d.location_id ";
		$sql .= "CROSS JOIN call_type_tb AS e ";
		$sql .= "ON d.call_type_id = e.call_type_id ";
		$sql .= "WHERE a.user_ack = 'Y' ";
		$sql .= "AND a.audit_ack = 'Y' ";
		$sql .= "AND a.show_log = 'Y' ";
		$sql .= "AND a.call_purpose = 'PR' ";
		$sql .= "AND a.bill_number in ( ".$billOne.", ".$billTwo." )";	
		$result_set = $database->query($sql);		
		
		while ($row = mysql_fetch_array($result_set)) {
			$this->userWithPRCalls[] = $row['user_initial'];
		}
	}
	
	public function getCurrentUserCallCost($userInitial, $billOne, $billTwo)
	{
		global $database;

		$sql = "SELECT sum(a.total_call_cost) "; 
		$sql .= "FROM call_log_tb AS a ";
		$sql .= "CROSS JOIN tele_number_tb AS b ";
		$sql .= "ON a.tele_number_id = b.tele_number_id ";
		$sql .= "CROSS JOIN user_info_tb AS c ";
		$sql .= "ON a.user_info_id = c.user_info_id ";
		$sql .= "CROSS JOIN location_tb AS d ";
		$sql .= "ON b.location_id = d.location_id ";
		$sql .= "CROSS JOIN call_type_tb AS e ";
		$sql .= "ON d.call_type_id = e.call_type_id ";
		$sql .= "WHERE a.user_ack = 'Y' ";
		$sql .= "AND a.audit_ack = 'Y' ";
		$sql .= "AND a.show_log = 'Y' ";
		$sql .= "AND a.call_purpose = 'PR' ";
		$sql .= "AND c.user_initial = '".$userInitial."' ";
		$sql .= "AND a.bill_number in ( ".$billOne.", ".$billTwo." )";	
		$result_set = $database->query($sql);		
		
		$this->totalCost = mysql_fetch_array($result_set);	
	}
}
?>
<?php 
//$test = new ReportGenerator();
//$test->getUserWithPRCalls(125, 218);
?>