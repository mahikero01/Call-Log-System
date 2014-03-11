<?php
//to be loaded in every page for security 
class Session {
	private $logged_in=false;
	public $admin_logged_in=false;
	public $audit_logged_in=false;
	public $user_id;
	public $date_selected;
	public $bill_number;
	public $callPurpose;
	public $selectedCallType;
	public $date_selected_from = "" ;
	public $date_selected_to = "" ;
	public $local_number = "";
	public $message;
	
	function __construct() {
		session_start();
		$this->check_message();
		$this->check_login();
		if (isset($_SESSION['date_selected'])) {
			$this->check_data();
		}
		if ( isset($_SESSION['date_selected_from']) ) {
			$this->check_data_user();
		}
		$this->checkDataUserPreviousBills();
	}
	
//check if there is a data store in the SESSION
	private function check_data() {
     $this->date_selected = $_SESSION['date_selected'];
     $this->bill_number = $_SESSION['bill_number'];
     $this->selectedCallType = $_SESSION['call_type_operator'];
	}
	
	private function check_data_user() {
     $this->date_selected_from = $_SESSION['date_selected_from'];
     $this->date_selected_to = $_SESSION['date_selected_to'];
     $this->local_number = $_SESSION['local_number'];
     $this->bill_number = $_SESSION['bill_number'];
     $this->selectedCallType = $_SESSION['call_type_operator'];
	}
	
	private function checkDataUserPreviousBills()
	{
		if ( isset($_SESSION['billNumber']) ) {
			$this->bill_number = $_SESSION['billNumber'];
		}
		
		if ( isset($_SESSION['callPurpose']) ) {
			$this->callPurpose = $_SESSION['callPurpose'];
		}
	}

	//check if there is a message store in the SESSION
	private function check_message() {
		if(isset($_SESSION['message'])) {//store the message in message attribute
      $this->message = $_SESSION['message'];
      unset($_SESSION['message']);
    } else {//no stored message in SESSION delete current value of message attribute
      $this->message = "";
    }
	}
	
	//check log on status
	private function check_login() {
    if(isset($_SESSION['user_id'])) {//user is log on
      $this->user_id = $_SESSION['user_id'];
      $this->logged_in = true;
       if ($_SESSION['admin_access'] == 'Y') {
      	$this->admin_logged_in = true;
      	$this->audit_logged_in = true;
       } elseif ($_SESSION['admin_access'] == 'A') {
       	$this->audit_logged_in = true;
       }
    } else {// no user log on
      unset($this->user_id);
      $this->logged_in = false;
      $this->admin_logged_in = false;
    }
  }
  
  //store data information to session
	public function store_data($date_selected="", $bill_number=0, $callTypeOperator ) {
	   $_SESSION['date_selected'] = $date_selected;
	   $_SESSION['bill_number'] = (int)$bill_number;
	   $_SESSION['call_type_operator'] = $callTypeOperator;
	}
	
	public function store_data_user($date_selected_from="", $date_selected_to="", 
		$local_number="", $bill_number=0, $callTypeOperator) {
			
	   $_SESSION['date_selected_from'] = $date_selected_from;
	   $_SESSION['date_selected_to'] = $date_selected_to;
	   $_SESSION['local_number'] = $local_number;
	   $_SESSION['bill_number'] = (int)$bill_number;
	   $_SESSION['call_type_operator'] = $callTypeOperator;
	}
	
	public function storeDataCurrentUserPreviousCalls(
	$selectedBillNumber, $selectedCallPurpose)
	{
		$_SESSION['billNumber'] = (int)$selectedBillNumber;
		$_SESSION['callPurpose'] = $selectedCallPurpose;
	}
  
  //store message in SESSION
	public function message($pre_message="") {
	  if(!empty($pre_message)) {//if there is a message store it in SESSION
	    $_SESSION['message'] = $pre_message;
	  } else {//if no message on SESSION return current value of message attribute
			return $this->message;
	  }
	}
  
  //returns the log in status
	public function is_logged_in() {
    return $this->logged_in;
  }
  
  //returns log in status of admin
  public function is_admin_logged_in() {
  	return $this->admin_logged_in;
  }
  
  //return if status of audit
  public function is_audit_logged_in() {
  	return $this->audit_logged_in;
  }
  
  //when logging this method will set logged_in attribute
	public function login($user) {
    if($user){ //if $user has value set SESSION['user_id']
      $this->user_id = $_SESSION['user_id'] = $user['user_info_id'];
      $_SESSION['admin_access'] = $user['admin'];
      if ($_SESSION['admin_access'] == 'Y') {
      	$this->admin_logged_in = true;
      	$this->audit_logged_in = true;
      } elseif ($_SESSION['admin_access'] == 'A') {
      	$this->audit_logged_in = true;
      }
      $this->logged_in = true;
    }
  }
  
  //when log out the method will be called unset user_id att and set logged_in false
	public function logout() {
    unset($_SESSION['user_id']);
    unset($this->user_id);
    $this->logged_in = false;
    $this->admin_logged_in = false;
    $this->audit_logged_in = false;
  }
}
$ses = new Session();
$current_message = $ses->message();
$current_id = $ses->user_id;
$current_date = $ses->date_selected;
$current_bill = $ses->bill_number;
if ( isset($ses->callPurpose) ) {
	$currentCallPurpose = $ses->callPurpose;
}
$current_call_type = $ses->selectedCallType;
$current_date_from = $ses->date_selected_from;
$current_date_to = $ses->date_selected_to;
$current_local = $ses->local_number;
?>