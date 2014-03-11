<?php require_once ('database.php');?>
<?php
//class for handling calls from database
class CallRecord {	
	public $user_made_calls = array();
	public $userPreviousCalls = array();
	
	//count the number of record
	public function number_of_record($user) {
		global $database;
		
		$sql = "SELECT * FROM call_log_tb ";
		$sql .= "WHERE audit_ack = 'Y' ";
		$sql .= "AND show_log = 'Y' ";
		$sql .= "AND user_ack = 'N' ";
		$sql .= "AND user_info_id = ".$user;
		$result_set = $database->query($sql);
		
		return $database->num_rows($result_set);
	}
	
	//return number of previous calls made by user
	public function numberOfPreviousCalls($currentUserID, $callPurpose, $selectedBillNUmber)
	{
		global $database;
		
		$sql = "SELECT a.total_call_cost AS cost "; 
		$sql .= "FROM call_log_tb AS a ";
		$sql .= "CROSS JOIN tele_number_tb AS b ";
		$sql .= "ON a.tele_number_id = b.tele_number_id ";
		$sql .= "CROSS JOIN user_info_tb AS c ";
		$sql .= "ON a.user_info_id = c.user_info_id ";
		$sql .= "CROSS JOIN location_tb AS d ";
		$sql .= "ON b.location_id = d.location_id ";
		$sql .= "CROSS JOIN call_type_tb AS e ";
		$sql .= "ON d.call_type_id = e.call_type_id ";
		$sql .= "WHERE a.user_info_id = ".$currentUserID." ";
		$sql .= "AND a.call_purpose = '".$callPurpose."' ";
		$sql .= "AND a.bill_number = ".$selectedBillNUmber." ";
		$sql .= "AND a.user_ack = 'Y' ";
		$sql .= "ORDER BY a.bill_number ";
		$result_set = $database->query($sql);	

		return $database->num_rows($result_set);
	}

	//get all important record
	public function get_all_data($user, $offset) {
		global $database;
		
		$sql = "SELECT a.call_log_id, a.call_date, a.call_finish, a.call_duration, ";
		$sql .= "a.total_call_cost, b.tele_number, c.location_desc, a.call_purpose, a.remarks, a.user_ack ";
		$sql .= "FROM call_log_tb a, tele_number_tb b, location_tb c ";
		$sql .= "WHERE a.tele_number_id = b.tele_number_id ";
		$sql .= "AND b.location_id = c.location_id ";
		$sql .= "AND a.audit_ack = 'Y' ";
		$sql .= "AND a.show_log = 'Y' ";
		$sql .= "AND a.user_ack = 'N' ";
		$sql .= "AND a.user_info_id = ".$user;
		$sql .= " ORDER BY a.call_date, a.call_finish, c.location_desc ASC LIMIT 20 ";
		$sql .= "OFFSET ".$offset;
		$result_set = $database->query($sql);
		
		while ($row = mysql_fetch_array($result_set)) {
			$this->user_made_calls[] = $row;
		}
	}
	
	public function getAllPreviousCallOfCurrentUser($currentUserID, $callPurpose, $selectedBillNUmber, $offset) 
	{
		global $database;
		
		$sql = "SELECT a.call_date, a.call_finish, a.call_duration, ";
		$sql .= "a.total_call_cost, b.tele_number, d.location_desc  "; 
		$sql .= "FROM call_log_tb AS a ";
		$sql .= "CROSS JOIN tele_number_tb AS b ";
		$sql .= "ON a.tele_number_id = b.tele_number_id ";
		$sql .= "CROSS JOIN user_info_tb AS c ";
		$sql .= "ON a.user_info_id = c.user_info_id ";
		$sql .= "CROSS JOIN location_tb AS d ";
		$sql .= "ON b.location_id = d.location_id ";
		$sql .= "CROSS JOIN call_type_tb AS e ";
		$sql .= "ON d.call_type_id = e.call_type_id ";
		$sql .= "WHERE a.user_info_id = ".$currentUserID." ";
		$sql .= "AND a.call_purpose = '".$callPurpose."' ";
		$sql .= "AND a.bill_number = ".$selectedBillNUmber." ";
		$sql .= "AND a.user_ack = 'Y' ";
		$sql .= "ORDER BY a.call_date, a.call_finish, d.location_desc ASC LIMIT 20 ";
		$sql .= "OFFSET ".$offset;
		$result_set = $database->query($sql);	
		
		while ($row = mysql_fetch_array($result_set)) {
			$this->userPreviousCalls[] = $row;
		}
		
	}
	
	//get user dat for updating the record on db returns false if error encountered
	public function update_call_record($log_id, $purpose, $rem) {
		global $database;
		
		$call_log_id = (int)$log_id;
		$call_purpose = strtoupper($purpose);
		$remarks = trim($rem);
	
		//check if data is valid input
		if ($call_purpose == 'OB' || $call_purpose == 'PR' || $call_purpose == '') {
			$sql = "UPDATE call_log_tb ";
			$sql .= "SET call_purpose = '".$call_purpose."', user_ack = 'Y', ";
			$sql .= "remarks = '".$remarks."' WHERE call_log_id = ".$call_log_id;
			$database->query($sql);			
			$message = 'Record Updated';
		
		} else {
			$message = "OB/PR only on Purpose field ";
		}
		return $message;
	}
	
	//mark all call records as post = 'Y'
	public function mark_all_call_posted($user) {
		global $database;
		
		$sql = "UPDATE call_log_tb ";
		$sql .= "SET user_ack = 'Y' ";
		$sql .= "WHERE audit_ack = 'Y' ";
		$sql .= "AND show_log = 'Y' ";
		$sql .= "AND user_ack = 'N' ";
		$sql .= "AND user_info_id = ".$user;
		$result_set = $database->query($sql);
	}
}
?>