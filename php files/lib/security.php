<?php require_once ('lib/database.php');?>
<?php
//handles security related functions
class Security {
	//check if user is registered
	public static function check_user($username, $password) {
		global $database;
		
		$username = $database->escape_value($username);
    $password = $database->escape_value($password);
    
    $sql  = "SELECT * FROM user_info_tb ";
    $sql .= "WHERE user_initial = '{$username}' ";
    $sql .= "AND pass_word = '{$password}' ";
    $sql .= "LIMIT 1";
    
    $result_array = self::find_by_sql($sql);
    
    return !empty($result_array) ? $result_array : false;
	}
	
	//pass sql statement to SQL
	public static function find_by_sql($sql="") {
		global $database;
    $result_set = $database->query($sql);
    $user_data = array();
    $user_data = mysql_fetch_array($result_set);
    return $user_data;
  }
}
?>