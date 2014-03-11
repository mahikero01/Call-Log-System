<?php require_once ('session.php');?>
<?php require_once ('call_log.php');?>
<?php require_once ('database.php');?>
<?php
class ProcessNewRecordInput extends CallLog{

	function __construct($year, $month, $date, $finish, $duration, $local, $telephone) {
		$this->call_date = $year.$month.$date;
		
		$this->call_finish = $finish;
		
		$hour = 0;
		$minute = (int)$duration;
		$second = '00';
		do{
			if ($minute > 60) {
				++$hour;
				$minute -= 60;
			}
			if ($minute <= 60) {
				break;
			}
		}while(true);
		if ( $minute < 10 ) {
			$temp = $minute;
			$minute = '0'.$temp;
		}
		$this->call_duration = $hour.$minute.$second;
		
		$this->tele_number_id = $telephone;
		$this->user_info_id = $local;
		$this->call_status = 'a';
		
		$this->check_att_for_db_insertion();
	}
}
if (isset($_POST['year']) && isset($_POST['month']) && isset($_POST['date']) &&
	$_POST['callfinish'] != "" && $_POST['duration'] != "" && $_POST['local']!= "" &&
	$_POST['telephone'] != "" ) {
		
	$new_record = new ProcessNewRecordInput($_POST['year'], $_POST['month'], $_POST['date'],
		$_POST['callfinish'], $_POST['duration'], $_POST['local'], $_POST['telephone']);
		$ses->message('Record Succesfully Inserted');
}  else {
	$ses->message('Incomplete Data input');
}
Helper::redirect_to('../input_new_record.php');
?>