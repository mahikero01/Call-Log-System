<?php require_once ('database.php');?>
<?php require_once ('export_excel_sheet_.php');?>
<?php 
//class for processing data for excel format per user
class ExportExcelPerUserProcess {
	 
	public $file_name;
	public $report_values = array();
	public $report_headers = array(
	 	"Call ID",
	 	"Call Date", 
	 	"Call Finish", 
	 	"Call Duration", 
	 	"Call Price",
	 	"Telephone Number",
		"Location",
	 	"User Initial",
	 	"OB/PR",
	 	"Remarks"
	 );
	 
	 function __construct($local) {
	 	global $database;
	 	
	 	$this->file_name = $local."_".$this->get_user_initial($local).".xls";
	 	$this->get_all_user_data($local);
	 	$database->close_connection();
	 }
	 
	 //get user intials
	 private function get_user_initial($local) {
	 	global $database;
	 	
	 	$sql = "SELECT user_initial ";
	 	$sql .= "FROM user_info_tb ";
	 	$sql .= "WHERE local_number = '".$local."'";
	 	$result_set = $database->query($sql);
	 	
	 	
	 	$row = mysql_fetch_array($result_set);
	 	return $row['user_initial'];
	 }
	 
	 //get all data of specified user
	 private function get_all_user_data($local) {
	 	global $database;
	 	$temp_array = array();
	 	
	 	$sql = "SELECT a.call_log_id, a.call_date, a.call_finish, a.call_duration, a.call_price, ";
	 	$sql .= "c.tele_number, d.location_desc, b.user_initial, a.call_purpose, a.remarks "; 
	 	$sql .= "FROM call_log_tb a, user_info_tb b, tele_number_tb c, location_tb d ";
	 	$sql .= "WHERE a.user_info_id = b .user_info_id ";
	 	$sql .= "AND a.tele_number_id = c.tele_number_id ";
	 	$sql .= "AND c.location_id = d.location_id ";
	 	$sql .= "AND a.call_payed = 'Y' ";
	 	$sql .= "AND a.show_log = 'Y' ";
	 	$sql .= "AND a.post = 'N' ";
	 	$sql .= "AND b.local_number = '".$local."' ";
		$sql .= "ORDER BY a.call_date, a.call_finish ";
	 	$result_set = $database->query($sql);
	 	
	 	while ($row = mysql_fetch_array($result_set)) {
			$temp_array[] = $row;
	 	}
	 	
	 	$last_index = count($temp_array);
	 	for ($index = 0; $index < $last_index; $index++) {
	 		for ($inner_index = 0; $inner_index < 10; $inner_index++) {
	 			$this->report_values[$index][] = $temp_array[$index][$inner_index];
	 		}
	 	}
	 }
}
$export_report_data = new ExportExcelPerUserProcess($_POST['local']);	

$excel_sheet = new ExportExcelSheet(
	$export_report_data->file_name, 
	$export_report_data->report_headers,
	$export_report_data->report_values 
);

unset($export_report_data);
unset($excel_sheet);
?>