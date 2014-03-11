<?php require_once ('session.php');?>
<?php require_once ('helper_functions.php');?>
<?php require_once ('database.php');?>
<?php
class ProcessAuditInput 
{
	public $date_string;
	private $trunkline;
	private $billnumber;
	public $callTypeOperator;
	public $billnumber_complete;
	
	public function __construct(
		$input_year, 
		$input_month, 
		$input_trunkline, 
		$input_billnumber, 
		$inputCallType
	) 
	{
		$this->date_string = $input_year."-".$input_month;
		$this->month = $input_month;
		$this->trunkline = $input_trunkline;
		$this->billnumber = $input_billnumber;
		if ($inputCallType == 2) {
			$this->callTypeOperator = ' = ';
		} else {
			$this->callTypeOperator = ' < ';
		}
	}
	
	//returns true if there is record
	private function has_record($date) 
	{
		global $database;
	
		$sql = "SELECT * FROM call_log_tb as a CROSS JOIN tele_number_tb as b ";
		$sql .= "on a.tele_number_id = b.tele_number_id ";
		$sql .= "CROSS JOIN location_tb as c ";
		$sql .= "on b.location_id = c.location_id ";
		$sql .= "WHERE a.call_date >= '".$date."-01' ";
		$sql .= "AND a.call_date <= '".$date."-31' ";
		$sql .= "AND c.call_type_id ".$this->callTypeOperator." 3";
		$result_set = $database->query($sql);
		
		$database->close_connection();
		
		if ($database->num_rows($result_set) > 0) {
			return true;
		} else {
			$this->date_string = false;
			return false;
		}
	}	
	
	//returns true if user input a trunkline and bil number
	private function has_entry($trunkline, $billnumber) 
	{
		if (isset($trunkline) && isset($billnumber)) {
			$this->billnumber_complete = ($trunkline * 100) + $billnumber;
			return true;
		} else {
			$this->billnumber_complete =false;
			return false;
		}
	}

	//returns true if user input a trunkline and ther is data on db
	public function check_data() 
	{
		if ( $this->has_record($this->date_string) && $this->has_entry($this->trunkline, $this->billnumber) ) {
			return true;
		} else {
			return false;
		}
	}
}

$audit = new ProcessAuditInput(	
	$_POST['year'], 
	$_POST['month'], 
	$_POST['trunkline'], 
	$_POST['billnumber'],
	$_POST['calltype']
);

if ( $audit->check_data() ) {
	$ses->store_data($audit->date_string, $audit->billnumber_complete, $audit->callTypeOperator);
	unset($audit);
	Helper::redirect_to('../check_all_calls.php?page=1');
} elseif (!$audit->date_string) {
	$ses->message("There are no record on selected date");
	unset($audit);
	Helper::redirect_to('../audit_calls.php');
} elseif (!$audit->billnumber_complete ) {
	$ses->message("Please select a trunkline number and bill number");
	unset($audit);
	Helper::redirect_to('../audit_calls.php');
}
?>
