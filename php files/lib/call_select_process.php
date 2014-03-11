<?php require_once ('session.php');?>
<?php require_once ('helper_functions.php');?>
<?php require_once ('database.php');?>
<?php
//$year = $_POST['year'];
//$month = $_POST['month'];
//$date_string = $year."-".$month;
//check if user has call on selected date
if (check_data_in_db($ses->user_id) > 0) {//if user has call log
	$ses->store_data($date_string);
	Helper::redirect_to('../call_select.php?page=1');
} else {//if user has no record
	Helper::redirect_to('../no_record.php');
}

//returns the number of rows of selected user and date
function check_data_in_db($user) {
	global $database;
	
	$sql = "SELECT * FROM call_log_tb ";
	$sql .= "WHERE audit_ack = 'Y' ";
	$sql .= "AND show_log = 'Y' ";
	$sql .= "AND user_ack = 'N' ";
	$sql .= "AND user_info_id = ".$user;
	$result_set = $database->query($sql);
	
	$database->close_connection();
	return $database->num_rows($result_set);
}
?>
