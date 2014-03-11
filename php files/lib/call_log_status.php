<?php require_once ('database.php'); ?>
<?php 
//class for checking users call log status
class CallLogStatus {
	public $all_locals_with_record = array();
	public $all_user_initials_with_record = array();
	public $selected_user_un_posted_calls = array();
	public $current_user_id;
	private $trunk_line_one = array();
	private $trunk_line_two = array();
	public $userPostedBills = array();
	public $userSelectedPostedBills = array();
	public $userSelectedPostedBillsPurpose = array();
	
	//check if there calls that are ready for posting
	public function record_for_export() {
		global $database;
	
		$sql = "SELECT DISTINCT b.local_number "; 
		$sql .= "FROM call_log_tb a, user_info_tb b "; 
		$sql .= "WHERE a.user_info_id = b.user_info_id ";
		$sql .= "AND a.show_log = 'Y' AND a.audit_ack = 'Y' ";
		$sql .= "AND a.user_ack = 'N' AND b.company_id = 1 ";
		$sql .= "AND b.user_exec = 'N'";
		$result_set = $database->query($sql);
		
		if ($database->num_rows($result_set) > 0) {
			return true;
		} else {
			$this->date_string_from = false;
			return false;
		}
	}	
	
	//generate locals number who has calls for posting
	public function get_user_with_record() {
		global $database;
		
		$sql = "SELECT DISTINCT b.local_number "; 
		$sql .= "FROM call_log_tb a, user_info_tb b "; 
		$sql .= "WHERE a.user_info_id = b.user_info_id ";
		$sql .= "AND a.show_log = 'Y' AND a.audit_ack = 'Y' ";
		$sql .= "AND a.user_ack = 'N' AND b.company_id = 1 ";
		$sql .= "AND b.user_exec = 'N'";
		$result_set = $database->query($sql);
		
		while ($row = mysql_fetch_array($result_set)) {
			$this->all_locals_with_record[] = $row['local_number'];
		}
	}
	
	//generate user_initials number who has calls for posting
	public function get_users_initials_with_record() {
		global $database;
		
		$sql = "SELECT DISTINCT b.user_initial "; 
		$sql .= "FROM call_log_tb a, user_info_tb b "; 
		$sql .= "WHERE a.user_info_id = b.user_info_id ";
		$sql .= "AND a.show_log = 'Y' AND a.audit_ack = 'Y' ";
		$sql .= "AND a.user_ack = 'N' AND b.company_id = 1 ";
		$sql .= "AND b.user_exec = 'N' ";
		$sql .= "ORDER BY b.user_initial";
		$result_set = $database->query($sql);
		
		while ($row = mysql_fetch_array($result_set)) {
			$this->all_user_initials_with_record[] = $row['user_initial'];
		}
	}
	
	//close connection to db
	public function close_database() {
		global $database;
		
		$database->close_connection();
	}
	
	public function reset_selected_user_unposted_calls_array() {
		unset($this->selected_user_un_posted_calls);
	}
	
	public function reset_all_locals_with_record_array() {
		unset($this->all_locals_with_record);
	}
	//check if selected user has un posted calls
	public function check_selected_user_call_log($user) {
		global $database;
		
		$sql = "SELECT  a.call_log_id "; 
		$sql .= "FROM call_log_tb a, user_info_tb b "; 
		$sql .= "WHERE a.user_info_id = b.user_info_id ";
		$sql .= "AND a.show_log = 'Y' AND a.audit_ack = 'Y' ";
		$sql .= "AND a.user_ack = 'N' AND b.company_id = 1 ";
		$sql .= "AND b.user_exec = 'N' AND b.user_initial = '".$user."'";
		$result_set = $database->query($sql);
		
		if ($database->num_rows($result_set) > 0) {
			return true;
		} else {
			$this->date_string_from = false;
			return false;
		}
	}	
	
	//get all un posted call of selected user
	public function get_selected_user_un_posted_calls($user) {
		global $database;
		
		$sql = "SELECT  a.call_log_id "; 
		$sql .= "FROM call_log_tb a, user_info_tb b "; 
		$sql .= "WHERE a.user_info_id = b.user_info_id ";
		$sql .= "AND a.show_log = 'Y' AND a.audit_ack = 'Y' ";
		$sql .= "AND a.user_ack = 'N' AND b.company_id = 1 ";
		$sql .= "AND b.user_exec = 'N' AND b.user_initial = '".$user."'";
		$result_set = $database->query($sql);
		
		while ($row = mysql_fetch_array($result_set)) {
			$this->selected_user_un_posted_calls[] = $row['call_log_id'];
		}
	}
	
	//set selected call log to post PR
	public function post_selected_call_log($call_log_id) {
		global $database;
		
		$sql = "UPDATE call_log_tb "; 
		$sql .= "SET user_ack = 'Y', call_purpose = 'PR' "; 
		$sql .= "WHERE call_log_id = ".$call_log_id." ";
		$result_set = $database->query($sql);
	}
	
	//convert user intial to user id
	public function convert_intial_to_id($user) {
		global $database;
		$sql = "SELECT user_info_id FROM user_info_tb ";
		$sql .= "WHERE user_initial = '".strtoupper($user)."' ";
		$sql .= "LIMIT 1";
		$result_set = $database->query($sql);
		$row = mysql_fetch_array($result_set);
		$this->current_user_id = (int)$row['user_info_id'];
	}
	
	//set all call of selected user to post OB
	public function post_all_call_log_of_selected_user($id) {
		global $database;
		
		$sql = "UPDATE call_log_tb "; 
		$sql .= "SET user_ack = 'Y' "; 
		$sql .= "WHERE user_info_id = ".$id." ";
		$sql .= "AND show_log = 'Y' AND audit_ack = 'Y' ";
		$sql .= "AND user_ack = 'N'";
		$result_set = $database->query($sql);
	}
	
	//get all calls with status of no show but payed
	public function get_all_calls_with_no_show_log_but_payed() {
		global $database;
		
		$sql = "SELECT * ";
		$sql .= "FROM call_log_tb ";
		$sql .= "WHERE audit_ack = 'Y' ";
		$sql .= "AND show_log = 'N' ";
		$result_set = $database->query($sql);
		
		return $database->num_rows($result_set);
	}
	
	//get bill numbers for trunk 1 with no show status
	public function get_bill_numbers_one_current(){
		$this->get_bill_numbers_one();
		
		return $this->trunk_line_one;
	}
	
	private  function get_bill_numbers_one(){
		global $database;
		
		$sql = "SELECT DISTINCT bill_number ";
		$sql .= "FROM call_log_tb ";
		$sql .= "WHERE audit_ack = 'Y' ";
		$sql .= "AND show_log = 'N' ";
		$sql .= "AND bill_number < 200 ";
		$sql .= "ORDER BY bill_number";
		$result_set = $database->query($sql);
		
		while ($row = mysql_fetch_array($result_set)) {
			$this->trunk_line_one[] = $row['bill_number'];
		}
	}
	
	//get bill numbers for trunk 2 with no show status
	public function get_bill_numbers_two_current(){
		$this->get_bill_numbers_two();
		
		return $this->trunk_line_two;
	}
	
	private  function get_bill_numbers_two(){
		global $database;
		
		$sql = "SELECT DISTINCT bill_number ";
		$sql .= "FROM call_log_tb ";
		$sql .= "WHERE audit_ack = 'Y' ";
		$sql .= "AND show_log = 'N' ";
		$sql .= "AND bill_number > 199 ";
		$sql .= "ORDER BY bill_number";
		$result_set = $database->query($sql);
		
		while ($row = mysql_fetch_array($result_set)) {
			$this->trunk_line_two[] = $row['bill_number'];
		}
	}
	
	public function ready_bills_for_remarks($bill_one, $bill_two) {
		$this->set_post_on_exec_and_other_company();
		$this->set_show_logs_to_yes($bill_one, $bill_two);
	}
	
	//set status of show log to yes
	private function set_show_logs_to_yes($bill_one, $bill_two) {
		global $database;
		
		$sql = "UPDATE call_log_tb "; 
		$sql .= "SET show_log = 'Y' "; 
		$sql .= "WHERE audit_ack = 'Y' ";
		$sql .= "AND ( bill_number = ".$bill_one." or bill_number = ".$bill_two.")";
		$result_set = $database->query($sql);
	}
	
	//mark calls as posted if exec and other company has made calls
	private function set_post_on_exec_and_other_company() {
		global $database;
		
		$sql = "UPDATE call_log_tb a, user_info_tb b ";
		$sql .= "SET a.user_ack = 'Y' "; 
		$sql .= "WHERE (b.company_id = 2 or (b.company_id = 1 and b.user_exec = 'Y')) "; 
		$sql .= "AND a.user_info_id = b.user_info_id ";
		$sql .= "AND a.audit_ack = 'Y' ";
		$sql .= "AND a.user_ack ='N' ";
		$sql .= "AND a.show_log = 'N' ";
		$result_set = $database->query($sql);
	}
	
	//check for calls which are acknowledge by user
	public function getBillNumbersOfAckCalls($currentUserID)
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
		$sql .= "WHERE a.user_info_id = ".$currentUserID." ";
		$sql .= "AND a.user_ack = 'Y' ";
		$sql .= "ORDER BY a.bill_number ";
		$result_set = $database->query($sql);
		
		while ($row = mysql_fetch_array($result_set)) {
			$this->userPostedBills[] = $row['bill_number'];
		}
	}
	
	//check calls which are OB or PR
	public function getSelectedBillNumbersOfAckCalls($currentUserID, $callPurpose, $selectedBillNUmber)
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
		
		while ($row = mysql_fetch_array($result_set)) {
			$this->userSelectedPostedBills[] = $row['cost'];
		}
	}
	
	public function getSelectedPurposeOfAckCalls($currentUserID, $callPurpose)
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
		$sql .= "AND a.user_ack = 'Y' ";
		$sql .= "ORDER BY a.bill_number ";
		$result_set = $database->query($sql);
		
		while ($row = mysql_fetch_array($result_set)) {
			$this->userSelectedPostedBillsPurpose[] = $row['cost'];
		}		
	}
}
?>
<?php 
//$test = new CallLogStatus();
//$test->getSelectedBillNumbersOfAckCalls(29,OB,125);
//print_r ($test->userSelectedPostedBills);
?>