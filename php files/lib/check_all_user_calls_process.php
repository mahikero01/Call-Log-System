<?php require_once ('session.php');?>
<?php require_once ('helper_functions.php');?>
<?php require_once ('database.php');?>
<?php
class ProcessAuditInput {
	public $date_string_from;
	public $date_string_to;
	private $trunkline;
	private $billnumber;
	public $billnumber_complete;
	public $local_number;
	public $callTypeOperator;
	
	function __construct(	$input_year_from, 
							$input_month_from, 
							$input_year_to, 
							$input_month_to,
							$input_trunkline, 
							$input_billnumber, 
							$input_local_number,
							$inputCallType
						 ) 
	{
		
		$this->date_string_from = $input_year_from."-".$input_month_from;
		$this->date_string_to = $input_year_to."-".$input_month_to;
		$this->trunkline = $input_trunkline;
		$this->billnumber = $input_billnumber;
		$this->local_number = $input_local_number;
		if ($inputCallType == 2) {
			$this->callTypeOperator = ' = ';
		} else {
			$this->callTypeOperator = ' < ';
		}
	}
	
	//returns true if there is record
	private function has_record($from_date, $to_date, $user) {
		global $database;
	
		$sql = "SELECT * FROM call_log_tb AS a CROSS JOIN user_info_tb AS b ";
		$sql .= "ON a.user_info_id = b.user_info_id ";
		$sql .= "CROSS JOIN tele_number_tb AS c ";
		$sql .= "on a.tele_number_id = c.tele_number_id ";
		$sql .= "CROSS JOIN location_tb AS d ";
		$sql .= "on c.location_id = d.location_id ";
		$sql .= "WHERE a.user_info_id = b.user_info_id ";
		$sql .= "AND b.local_number = '".$user."' ";
		$sql .= "AND call_date >= '".$from_date."-01' ";
		$sql .= "AND call_date <= '".$to_date."-31' ";
		$sql .= "AND d.call_type_id ".$this->callTypeOperator." 3";
		$result_set = $database->query($sql);
		
		$database->close_connection();
		
		if ($database->num_rows($result_set) > 0) {
			return true;
		} else {
			$this->date_string_from = false;
			return false;
		}
	}	
	
	//returns true if user input a trunkline and bil number
	private function has_entry($trunkline, $billnumber, $local_number) {
		if (isset($trunkline) && isset($billnumber) && isset($local_number)) {
			$this->billnumber_complete = ($trunkline * 100) + $billnumber;
			return true;
		} else {
			$this->billnumber_complete =false;
			return false;
		}
	}

	//returns true if user input a trunkline and ther is data on db
	public function check_data() {
		if ( $this->has_record($this->date_string_from, $this->date_string_to, $this->local_number) && 
			$this->has_entry($this->trunkline, $this->billnumber, $this->local_number) ) {
			
			return true;
		} else {
			return false;
		}
	}
}

$audit = new ProcessAuditInput(	$_POST['fromyear'], 
								$_POST['frommonth'], 
								$_POST['toyear'], 
								$_POST['tomonth'], 
								$_POST['trunkline'], 
								$_POST['billnumber'], 
								$_POST['user'],
								$_POST['calltype']
							);

if ( $audit->check_data() ) {
	$ses->store_data_user($audit->date_string_from, $audit->date_string_to,
		$audit->local_number, $audit->billnumber_complete, $audit->callTypeOperator);
	unset($audit);
	//Helper::redirect_to('test.php');
	Helper::redirect_to('../check_all_user_calls.php?page=1');
} elseif (!$audit->date_string_from) {
	$ses->message("There are no record on selected date");
	unset($audit);
	Helper::redirect_to('../audit_user_calls.php');
} elseif (!$audit->billnumber_complete ) {
	$ses->message("Please select a trunkline number, bill number and local number ");
	unset($audit);
	Helper::redirect_to('../audit_user_calls.php');
}
?>

