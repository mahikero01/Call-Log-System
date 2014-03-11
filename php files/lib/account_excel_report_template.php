<?php require_once ('database.php'); ?>
<?php
//template class for excel report
class AccountExcelReportTemplate {
	private $filename;
	private $report_headers = array(
	 	"Call Date", 
		"Call Finish", 
	 	"Call Duration", 
	 	"Total Call Cost",
		"Telephone Number",
		"Location",
	 	"User Initial",
	 	"Remarks"
	);
	private $report_values = array();
	
	private $company_id;
	private $company_name;
	private $call_purpose;
	public $trunk_line_one;
	public $trunk_line_two;
	 
	function __construct($company_id_input, $call_purpose_input, $company_name_input) {
		$this->company_name = $company_name_input;
		$this->company_id = (int)$company_id_input;
		$this->call_purpose = $call_purpose_input;
		$this->get_bill_numbers(1);
		$this->get_bill_numbers(2);
	}
	
	private  function get_bill_numbers($trunk_line_input){
		global $database;
		
		if ($trunk_line_input == 1) {
			$sql = "SELECT DISTINCT a.bill_number ";
			$sql .= "FROM call_log_tb a, user_info_tb b ";
			$sql .= "WHERE a.user_info_id = b.user_info_id ";
			$sql .= "AND a.audit_ack = 'Y' ";
			$sql .= "AND a.show_log = 'Y' ";
			$sql .= "AND a.user_ack = 'Y' ";
			$sql .= "AND b.company_id = ".$this->company_id." ";	
			$sql .= "AND a.bill_number < 200 ";
			$sql .= "AND a.call_purpose = '".$this->call_purpose."' ";
			$sql .= "ORDER BY bill_number";
			$result_set = $database->query($sql);
			
			while ($row = mysql_fetch_array($result_set)) {
				$this->trunk_line_one[] = $row['bill_number'];
			}
		} elseif ($trunk_line_input == 2) {
			$sql = "SELECT DISTINCT bill_number ";
			$sql = "SELECT DISTINCT a.bill_number ";
			$sql .= "FROM call_log_tb a, user_info_tb b ";
			$sql .= "WHERE a.user_info_id = b.user_info_id ";
			$sql .= "AND a.audit_ack = 'Y' ";
			$sql .= "AND a.show_log = 'Y' ";
			$sql .= "AND a.user_ack = 'Y' ";
			$sql .= "AND b.company_id = ".$this->company_id." ";	
			$sql .= "AND a.bill_number > 199 ";
			$sql .= "AND a.call_purpose = '".$this->call_purpose."' ";
			$sql .= "ORDER BY bill_number";
			$result_set = $database->query($sql);
			
			while ($row = mysql_fetch_array($result_set)) {
				$this->trunk_line_two[] = $row['bill_number'];
			}
		}
	}
	
	//method for getting all necessary data 
	public function get_all_data($bill_number_input_one, $bill_number_input_two) {
		global $database;
		if ( !$bill_number_input_one >= 100   ){
			$bill_number_input_one = 0;
		}
		if ( !$bill_number_input_two >= 200   ){
			$bill_number_input_two = 0;
		}
	 	$temp_array = array();
	 	
	 	$sql = "SELECT a.call_date, a.call_finish, a.call_duration, a.total_call_cost, ";
	 	$sql .= "c.tele_number, d.location_desc, b.user_initial, a.remarks "; 
	 	$sql .= "FROM call_log_tb a, user_info_tb b, tele_number_tb c, location_tb d ";
	 	$sql .= "WHERE a.user_info_id = b .user_info_id ";
	 	$sql .= "AND a.tele_number_id = c.tele_number_id ";
	 	$sql .= "AND c.location_id = d.location_id ";
	 	$sql .= "AND a.audit_ack = 'Y' ";
	 	$sql .= "AND a.show_log = 'Y' ";
	 	$sql .= "AND a.user_ack = 'Y' ";
	 	$sql .= "AND b.company_id = ".$this->company_id." ";
	 	$sql .= "AND a.call_purpose = '".$this->call_purpose."' ";
	 	$sql .= "AND (a.bill_number = ".$bill_number_input_one." or "; 
	 	$sql .= "a.bill_number = ".$bill_number_input_two.") ";
	 	$sql .= "ORDER BY b.user_initial, a.call_date, a.call_finish, a.call_duration ";
	 	$result_set = $database->query($sql);
	 	
	 	while ($row = mysql_fetch_array($result_set)) {
			$temp_array[] = $row;
	 	}
	 	
	 	$last_index = count($temp_array);
	 	for ($index = 0; $index < $last_index; $index++) {
	 		for ($inner_index = 0; $inner_index < 8; $inner_index++) {
	 			$this->report_values[$index][] = $temp_array[$index][$inner_index];
	 		}
	 	}
	}
	
	//set file name
	public function create_file_name($bill_number_input_one="", $bill_number_input_two="") {
		$this->filename = $this->company_name."_".$this->call_purpose."_".
			$bill_number_input_one."_".$bill_number_input_two.".xls";
	}
	
	//generate excel report
	public function export_report() {
		$_SESSION['filename'] = $this->filename;
		$_SESSION['headers'] = $this->report_headers;
		$_SESSION['values'] = $this->report_values;
		
		Helper::redirect_to('lib/process_report.php');
	}
}
?>
