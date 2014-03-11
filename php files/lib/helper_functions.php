<?php
//Helper functions
class Helper {
	//for layingout html templates
	public static function layout_template($template="") {
		include('stylesheets/'.$template);
	}
	
	//for page redirection
	public static function redirect_to( $location = NULL ) {
  	if ($location != NULL) {
    	header("Location: {$location}");
    	exit;
  	}
	}
	
	//method use for message output
	public static function output_message($message="") {
	  if (!empty($message)) { 
	    return "<p class=\"message\">{$message}</p>";
	  } else {
	    return "";
	  }
	}
	
	//method use for converting data to sql valid inputs
	public static function valid_for_sql_date_time($value, $class_attribute) {
		
		//do we need to convert date data?
		if ($class_attribute == "date") {//yes, convert date data
			$year = (int)substr($value, 0, 2);
			$year = $year + 2000;
			if ( ($year > 2099) || ($year < 2000) ){ //check if year is valid
				return false;
			}
			
			$month = (int)substr($value, 2, 2);
			if ( ($month > 12) || ($month < 1) ) {//check if month is valid
				return false;
			}
			
			$day = (int)substr($value, 4, 2);
			if ($day > 31) {
				return false;
			} elseif ($day > 30 ) {
				if ( !Helper::check_valid_day_in_month(31, $month, $day) ) {
					return false;
				}
			}	elseif ($day > 29 ) {
				if ( !Helper::check_valid_day_in_month(30, $month, $day) ) {
					return false;
				}
			}
			$converted_value = $year."-".$month."-".$day;
			return $converted_value;
		} else {//no, convert time data
			if (strlen($value) == 4) {//is this time attribute?
				//yes, time att
				$hour = (int)substr($value, 0, 2);
				$minute = (int)substr($value, 2, 2);
				$second = 0;
				if ( ($hour < 0) || ($hour > 23) || ($minute < 0) || ($minute > 59) ) {
					return false;
				}
			}	else {//no, duration att
				$hour = substr($value, 0, 1);
				$minute = substr($value, 1, 2);
				$second = substr($value, 3, 2);
				if ( ($hour < 0) || ($hour > 9) || ($minute < 0) || ($minute > 59)
					|| ($second < 0) || ($second > 59) ) {
					
					return false;
				}
			}
			$converted_value = $hour.":".$minute.":".$second;
			return $converted_value;
		}
		return false;
	}
	
	//method use for checking if day is valid on the said month
	public static function check_valid_day_in_month($month_category, $month_value, $day_value) {
		//set conditions for day comparing
		$month_30 = array(1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
		$month_31 = array(1, 3, 5, 7, 8, 10, 12);
		
		if ($month_category == 31) {
			foreach ($month_31 as $month_entry) {
						if ($month_entry == $month_value){
							return true;
						}
			}
			return false;
		} else {
			foreach ($month_30 as $month_entry) {
						if ($month_entry == $month_value){
							return true;
						}
			}	
		}
		return false;
	}

	//sanitized string removing certain characters not needed
	public static function sanitized_string($raw_string, $char_to_removed) {
		$temp_string_array = array();
		$strip_string = str_replace($char_to_removed, " ", $raw_string);
		$temp_string_array = explode(" ", $strip_string);
		$cleaned_string = implode($temp_string_array);
		$cleaned_string = trim($cleaned_string);
		
		return $cleaned_string;
	}

	//method use finding given location code from registered location code
	public static function find_tel_loc_code($reg_tel_locs, $tel_loc) {
		foreach ($reg_tel_locs as $element=>$reg_tel_loc) {
			if ($reg_tel_loc == $tel_loc) {
				return $tel_loc;
			}
		}
		return false;
	}

	//method for calculating total cost
	public static function total_cost_of_call($duration, $cost) {
		$value = 0;
		$value = 60 * substr($duration, 0, 1);
		$value += substr($duration, 1, 2);
		$value_int = (int)substr($duration, 3, 2);
		if ($value_int > 0) {
			++$value;
		}
		$total_cost = $value * $cost;
		if ($total_cost > 0) {
			return $total_cost;
		}
		return false;
	}
	
	//method for removing excess zero from prefix of tel_num
	public static function check_prefix($tel_number) {
		//do {
			$digit = substr($tel_number, 0, 1);
			if ($digit == 0){
				$digit = substr($tel_number, 1, 1);
				if($digit != 0) {
					return $tel_number;
				} else {
					$digit = substr($tel_number, 2, 1);
					if ($digit == 0) {
						$strip_string = substr_replace($tel_number, ' ', 2, 1);
						$temp_string_array = explode(' ', $strip_string);
						$cleaned_string = implode($temp_string_array);
						$tel_number = $cleaned_string;
					} else {
						return $tel_number;
					}
				}
			} else {
				return $tel_number;
			}
		//}while(true);
	}

	//fix string inputed by user
	public static function fix_string($string) {
		if (get_magic_quotes_gpc()) {
			$string = stripcslashes($string);
		}
		return htmlentities($string);
	}
	
	//method for validating username input
	public static function validate_username($field) {
		if ( $field == "" ) {
			return "No Username was entered<br/>";
		} elseif ( strlen($field) < 3 ) {	
			return "Username must be at least 3 chracters<br />";
		} elseif ( preg_match("/[^a-zA-Z]/", $field) ) {
			return "Only letters in username<br />";
		}
		return "";
	}
	
	//method for validating password input
	public static function validate_password($field) {
		if ( $field == "" ) {
			return "No Password was entered<br/>";
		} elseif ( strlen($field) < 3 ) {
			return "Password must be at least 3 chracters<br />";
		} elseif ( preg_match("/[^a-zA-Z0-9]/", $field) ) {
			return "Only letters and numbers in password and its case sensitive<br />";
		}
	}
}
?>