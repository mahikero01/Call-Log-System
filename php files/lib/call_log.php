<?php require_once ('database.php');?>
<?php require_once ('helper_functions.php');?>
<?php
//class for handling call logs from text
class CallLog {
	//array of possible errors
	private $upload_errors = array( 
		UPLOAD_ERR_OK 				=> "No errors.",
		UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
	  UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
	  UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
	  UPLOAD_ERR_NO_FILE 		=> "No file selected.",
	  UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
	  UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
	  UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
	);	
	
	//call info needed for DB insertion
	protected	$call_date;
	protected $call_finish;
	protected $call_duration;	
	protected $call_price;
	protected $tele_number_id;
	protected $user_info_id;
	protected $call_status;
	
	//uploaded file info attribute
	private  $filename;
	//error logs
	public $errors = array();
	//directory used 
	private $upload_dir='temp_dir';
	private $temp_path;

	//unset selected attributes
	private function clear_att() {
		$this->call_date = null;
		$this->call_finish = null;
		$this->call_duration = null;	
		$this->call_price = null;
		$this->tele_number_id = null;
		$this->user_info_id = null;
		$this->call_status = null;
	} 

	//method for uploading file 
	public function attach_file($file) {
		if (!$file || empty($file) || !is_array($file)) {// Perform error checking on the form parameters
		  $this->errors[] = "No file was uploaded.";
		  return false;
		} elseif ($file['error'] != 0) { // error: report what PHP says went wrong
		  $this->errors[] = $this->upload_errors[$file['error']];
		  return false;
		} else {// Set object attributes to the form parameters.
			$this->temp_path  = $file['tmp_name'];
		  $this->filename   = basename($file['name']);
			return true;
		}
	}
	
	//method to save the upload file to temp dir 
	public function save() {
		// Can't save if there are pre-existing errors
  	if (!empty($this->errors)) { 
	  	return false; 
	  }
	
	  // Can't save without filename and temp location
	  if(empty($this->filename) || empty($this->temp_path)) {
	    $this->errors[] = "The file location was not available.";
	    return false;
	  }
	
		// Determine the target_path
	 $target_path = $this->upload_dir.'/'.$this->filename;
	  
	  // Make sure a file doesn't already exist in the target location
	  if(file_exists($target_path)) {
	    $this->errors[] = "The file {$this->filename} already exists.";
	    return false;
	  }
	
		// Attempt to move the file 
		if(move_uploaded_file($this->temp_path, $target_path)) {// File was moved 	
			unset($this->temp_path);
			return true;
		} else {// File was not moved.
	    $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
	    return false;
		}
	}
	
	//upload text file call log to database
	public function load_to_dbase() {
		// Determine location of text log
		$pabx_log_location = $this->upload_dir.'/'.$this->filename;

		//get content of file and place them in array
		$cleaned_pabx_log_string_array = array();
		$file = fopen($pabx_log_location,"r");
		$word = null;
		while (!feof($file)) {
  		$character = fgetc($file);
  		if ( $character != ' ' ) {
  			$word .= $character;	
  		} else {
  			if ($word != null ){
   			$cleaned_pabx_log_string_array[] = $word;
  			$word = null;
  			} 			
  		}
  	}
  	fclose($file);	
		
		foreach ($cleaned_pabx_log_string_array as $string_value) {
			$this->check_content($string_value);
			$this->check_att_for_db_insertion();
		}
	}
	
	//check content of the element of text_file_array
	private function check_content($string_value) {
		$character_count = strlen($string_value);
		
		switch ($character_count) {
			case 1://temp value of call status
				if ( $string_value != 'A' && isset($this->call_date) && isset($this->call_finish) && 
					isset($this->user_info_id) && isset($this->tele_number_id) &&
					isset($this->call_duration) ) {
					$this->call_status = $string_value;
				}
				break;
			case 2: //if 2 zeroes are met clear all attribute
				if ($string_value == '00') {
					$this->clear_att();;
				}
				break;
			case 3: //temp value of user_info_id
				if ( (isset($this->call_date)) && (isset($this->call_finish)) && ($this->user_info_id == null) ) {
					$this->user_info_id = $string_value;
				}
				break;
	    case 4: //temp value of call_finish
	    	if ( (isset($this->call_date)) && ($this->call_finish == null) ) {
		      $this->call_finish = $string_value;
	    	}
	    	break;
	    case 5: //temp value of call_duration
	    	if ( (isset($this->call_date)) && (isset($this->call_finish)) && ($this->call_duration == null) ) {
						$this->call_duration = $string_value;
	    	} 
	    	break;
	    case 6: //date
	    	if ( $this->call_date == null ) {
	    	 	$this->call_date = $string_value;
	    	} 
	    	break;
	    default :
	    	if ( $character_count >= 10 && $character_count <= 16 ) {
		    		if ( (isset($this->call_date)) && (isset($this->call_finish))
		    			&& (isset($this->user_info_id)) ) {
		    			$string_value = Helper::sanitized_string($string_value, "*");
		    			$string_value = Helper::sanitized_string($string_value, "#");
		    			$string_value = Helper::check_prefix($string_value);
		    			$prefix_code = substr($string_value, 0, 1);
		    			if ( $prefix_code == 0 ) {
		    				$this->tele_number_id = $string_value;
		    			}
	    			}	
	    	}     
		}	
	}

	//method use for assigning found location code to attribute
	private function assign_local_code_to_attribute($location_code, $call_type_id) {
		global $database;
		
		$sql = "SELECT location_id FROM location_tb ";
		$sql .= "WHERE location_code = '".$location_code;
		$sql .= "' AND call_type_id = ".$call_type_id;
		$result_set = $database->query($sql);
		
		$row = mysql_fetch_array($result_set);
		
		$this->tel_num_loc = $row['location_id'];
	}
	
	//method use for inserting new location code on db
	private function register_location_code_on_db($location_code, $call_type_id) {
		global $database;
		
		$sql = "INSERT INTO location_tb ";
		$sql .= "(location_code, call_type_id ) ";
		$sql .= "VALUES ('".$location_code."', ".$call_type_id.")";
		$database->query($sql);
	}

	//method fo checking if all important att are set for
	//db insertion
	protected function check_att_for_db_insertion() {
		global $database;
		//check if 5 attribute are set before formating the values
		if ( isset($this->call_date) && isset($this->call_finish) && isset($this->call_duration)
			&& isset($this->user_info_id) && isset($this->tele_number_id) && isset($this->call_status) ) {

			//set call_date
			$this->call_date = $this->convert_to_string_date($this->call_date);
			
			//set call_finish
			$this->call_finish = $this->convert_to_string_time($this->call_finish);

			//set call_price
			$pay_code = $this->categorized_tel_num($this->tele_number_id);	
			$cost_minute = $this->get_call_type($pay_code);
			$this->call_price = Helper::total_cost_of_call($this->call_duration, $cost_minute);
//			if ( $pay_code == 3 ){
//				$this->call_price = true;
//			}
			unset($pay_code);
			unset($cost_minute);
			
			//set call_duration
			$this->call_duration = $this->convert_to_string_duration($this->call_duration);
			
			//set tele_number_id
			$found_record = $this->find_tele_number_on_db($this->tele_number_id);
			if ( $found_record != false ){
				$this->tele_number_id = $found_record;
			} else {
				$this->tele_number_id = $this->register_new_tele_number($this->tele_number_id);
			}
			unset($found_record);
			
			//set user_info_id
			$this->user_info_id = $this->find_user_info_on_db($this->user_info_id);
			unset($found_user);			

			if ( $this->check_process_attribute() ) {
				$sql = "INSERT INTO call_log_tb ";
				$sql .= "(call_date, call_finish, call_duration, ";
				$sql .= "total_call_cost, tele_number_id, user_info_id) ";
				$sql .= "VALUES ('".$this->call_date."', '".$this->call_finish."', '".$this->call_duration."',";
				$sql .= " ".$this->call_price.", ".$this->tele_number_id.", ".$this->user_info_id.")";
				$database->query($sql);
			}
			$this->clear_att();
		}
	}
	
	//convert date to SQL string format
	private   function convert_to_string_date($call_date) {
		$year = substr($call_date, 0, 2);
		$month = substr($call_date, 2, 2);
		$day = substr($call_date, 4, 2);
		$call_date = '20'.$year.'-'.$month.'-'.$day;
		unset($year);
		unset($month);
		unset($day);
		return $call_date;
	}
	
	//convert time to SQL string format
	private   function convert_to_string_time($call_finish) {
		$hour = substr($call_finish, 0, 2);
		$minute = substr($call_finish, 2, 2);
		$second = '00';
		$call_finish = $hour.':'.$minute.':'.$second;
		unset($hour);
		unset($minute);
		unset($second);
		return $call_finish;
	}	

	//method for converting duration to SQL string
	private  function convert_to_string_duration($call_duration) {
		$hour = substr($call_duration, 0, 1);
		$minute = substr($call_duration, 1, 2);
		$second = substr($call_duration, 3, 2);
		$call_finish = $hour.':'.$minute.':'.$second;
		unset($hour);
		unset($minute);
		unset($second);
		return $call_finish;		
	}
		
	//method use for categorize phone call
	private function categorized_tel_num($tele_number_id) {
		$prefix_code = substr($tele_number_id, 0, 1);
		$prefix_code = (int)$prefix_code;
		
		if ($prefix_code == 0) {//check if call is pay-toll
			$prefix_code = substr($tele_number_id, 1, 1);
			$prefix_code = (int)$prefix_code;
			
			if ($prefix_code == 9) {
				return 1;
			} elseif ($prefix_code == 0) {
				return  3;
			} else {
			return 2;
			}
		} else {//call is ordinary
			return 3;
		}
	}	
	
	//get all call type
	private  function get_call_type($id) {
		global $database;
		$temp_array_container;
		
		$sql  = "SELECT call_per_minute ";
		$sql .= "FROM call_type_tb where call_type_id = ".$id;
		$result_set = $database->query($sql);

		$temp_array_container = mysql_fetch_array($result_set);
		
		$cost = $temp_array_container['call_per_minute'];
		return $cost;
	} 	

	//get registered telephone numbers
	private  function find_tele_number_on_db($telephone) {
		global $database;
		
		$sql  = "SELECT tele_number_id ";
		$sql .= "FROM tele_number_tb WHERE tele_number = '".$telephone."'";
		$result_set = $database->query($sql);

		$temp_array_container = mysql_fetch_array($result_set);
		if ($temp_array_container != false) {
			return $temp_array_container['tele_number_id'];
		} else {
			return false;
		}
	}

	//method in registering new tele_number
	private function register_new_tele_number($telephone) {
		global $database;
		$call_type_id = $this->categorized_tel_num($telephone);
		switch ($call_type_id) {
			case 1:
			$location_code = substr($telephone, 1, 3);
			$found_location_id = $this->find_location_id_on_db($location_code, 1);
			break;
			case 2:
			$location_code = substr($telephone, 1, 2);
			$found_location_id = $this->find_location_id_on_db($location_code, 2);			
			break;
			case 3:
			$location_code = substr($telephone, 2, 3);
			$found_location_id = $this->find_location_id_on_db($location_code, 3);
			break;	
		}
		if ( $found_location_id != false ) {
			$sql  = "INSERT INTO tele_number_tb ";
			$sql .= "(tele_number, location_id) ";
			$sql .= "VALUES ('".$telephone."', ".$found_location_id.")";
			$result_set = $database->query($sql);		

			return $this->count_all('tele_number_tb');
		}
		
	}
	
	//method for finding location code from existing record
	private function find_location_id_on_db( $location_code, $call_type_id) {
		global $database;
		$location_code_copy = $location_code;
		
		if ( $call_type_id == 1 ) {
			$end = 1;
			$digit = 3;
		} elseif ( $call_type_id == 2 ) {
			$end = 1;
			$digit = 2;
		} elseif ( $call_type_id == 3 ) {
			$end = 3;
			$digit = 1;
		}
		
		for ($count = 0; $count <= $end; $count++, $digit++) {
			$location_code = substr($location_code_copy, 0, $digit);
						
			$sql  = "SELECT location_id ";
			$sql .= "FROM location_tb ";
			$sql .= "WHERE location_code = '".$location_code."' ";
			$sql .= "AND call_type_id = ".$call_type_id;
			$result_set = $database->query($sql);
			$temp_array_container = mysql_fetch_array($result_set);
			if ($temp_array_container != false) {
				return $temp_array_container['location_id'];
			}
		}
		
		$sql  = "INSERT INTO location_tb ";
		$sql .= "(location_code, call_type_id) ";
		$sql .= "VALUES ('".$location_code."', ".$call_type_id.")";
		$result_set = $database->query($sql);		

		return $this->count_all('location_tb');
	}	
	
	//method for counting all the rows of the selected table
	private function count_all($table_name) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".$table_name;
    $result_set = $database->query($sql);
	  $row = mysql_fetch_array($result_set);
	  return $row[0];
	}

	//get registered users
	private  function find_user_info_on_db($user_local_number) {
		global $database;
		
		$sql  = "SELECT user_info_id ";
		$sql .= "FROM user_info_tb WHERE local_number = '".$user_local_number."'";
		$result_set = $database->query($sql);

		$temp_array_container = mysql_fetch_array($result_set);
		if ($temp_array_container != false) {
			return $temp_array_container['user_info_id'];
		} else {
			return false;
		}
	}

	//method for checking final result of process attribute
	private function check_process_attribute() {
		if ($this->call_date == false) {
			return false;
		}
		
		if ($this->call_finish == false) {
			return false;
		}

		if ($this->user_info_id == false) {
			return false;
		}
		
		if ($this->call_duration == false) {
			return false;
		}		
		
		if ($this->call_price == false) {
			return false;
		}	

		if ($this->tele_number_id == false) {
			return false;
		}
		
		return true;
	}
}
?>