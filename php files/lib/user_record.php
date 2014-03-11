<?php require_once ('database.php');?>
<?php require_once ('session.php');?>
<?php
//class for handling user table
class UserRecord {
	public $all_users = array();
	public $all_locals = array();
	public $all_initials = array();
	
	//get all registered locals
	public function get_all_local() {
		global $database;
		
		$sql = "SELECT local_number FROM user_info_tb ";
		$sql .= "ORDER BY local_number ";
		$result_set = $database->query($sql);
		
		while ($row = mysql_fetch_array($result_set)) {
			$this->all_locals[] = $row['local_number'];
		}
	}
	
	//get all registered initials
	public function get_all_initial() {
		global $database;
		
		$sql = "SELECT user_initial FROM user_info_tb ";
		$sql .= "ORDER BY user_initial ";
		$result_set = $database->query($sql);
		
		while ($row = mysql_fetch_array($result_set)) {
			$this->all_initials[] = $row['user_initial'];
		}
	}
	
	//find user record by local number
	public function find_user_local($local_number) {
		global $database;
		
		$sql = "SELECT * FROM user_info_tb ";
		$sql .= "WHERE local_number = '".$local_number."'";
		$result_set = $database->query($sql);
		
		$data = array();
		while ($row = mysql_fetch_array($result_set)) {
			$data = $row;
		}
		
		return $data;
	}
	
	//find user record by initials
	public function find_user_initial($initial) {
		global $database;
		
		$sql = "SELECT * FROM user_info_tb ";
		$sql .= "WHERE user_initial = '".$initial."'";
		$result_set = $database->query($sql);
		
		$data = array();
		while ($row = mysql_fetch_array($result_set)) {
			$data = $row;
		}
		
		return $data;
	}
	
	//update user in db
	public function save_user_info($id, $last_name="", $first_name="", $middle_name="",
		$local_number="", $initial="", $admin = "N", $password ="", $company = 1) {
		
		global $database;
		
		if ($password == "") {
			$sql = "UPDATE user_info_tb ";
			$sql .= "SET last_name = '".$last_name."', company_id = ".$company.", ";
			$sql .= "first_name = '".$first_name."', middle_name = '".$middle_name."', ";
			$sql .= "local_number = '".$local_number."', user_initial = '".$initial."', ";
			$sql .= "admin = '".$admin."', pass_word = null ";
			$sql .= "WHERE user_info_id = ".$id;
		} else {
			$sql = "UPDATE user_info_tb ";
			$sql .= "SET last_name = '".$last_name."', company_id = ".$company.", ";
			$sql .= "first_name = '".$first_name."', middle_name = '".$middle_name."', ";
			$sql .= "local_number = '".$local_number."', user_initial = '".$initial."', ";
			$sql .= "admin = '".$admin."', pass_word = '".$password."' ";
			$sql .= "WHERE user_info_id = ".$id;
		}
		$database->query($sql);			
	}
	
	//save new user in db
	public function save_new_user($last_name="", $first_name="", $middle_name="",
		$local_number="", $initial="", $admin = "N", $password ="", $company = 1) {
		
		global $database;
		
		if ($password == "") {
			$sql  = "INSERT INTO user_info_tb ";
			$sql .= "(last_name, first_name, middle_name, ";
			$sql .= "local_number, user_initial, admin, ";
			$sql .= "company_id, pass_word )";
			$sql .= "VALUES ('".$last_name."', '".$first_name."', '".$middle_name."', ";
			$sql .= "'".$local_number."', '".$initial."', '".$admin."',";
			$sql .= " ".$company.", null)";
		} else {
			$sql  = "INSERT INTO user_info_tb ";
			$sql .= "(last_name, first_name, middle_name, ";
			$sql .= "local_number, user_initial, admin, ";
			$sql .= "company_id, pass_word )";
			$sql .= "VALUES ('".$last_name."', '".$first_name."', '".$middle_name."', ";
			$sql .= "'".$local_number."', '".$initial."', '".$admin."',";
			$sql .= " ".$company.", '".$password."')";
		}
		$database->query($sql);			
	}	
}
?>
