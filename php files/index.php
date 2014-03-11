<?php require_once ('lib/session.php');?>
<?php require_once ('lib/security.php');?>
<?php require_once ('lib/helper_functions.php');?>
<?php 
if($ses->is_logged_in()) {
	if ($ses->admin_logged_in == true || $ses->audit_logged_in == true) {
		Helper::redirect_to('main_menu.php');
	} else {
		Helper::redirect_to('logout.php');
	}
}
?>
<?php
$username = ""; 
$password = "";

if (isset($_POST['submit'])) { //check if form is submitted

	
	//if form submitted format all inputed data
	if ( isset($_POST['username']) ) {
		$username = Helper::fix_string($_POST['username']);
	}
	if ( isset($_POST['password']) ) {
		$password = Helper::fix_string($_POST['password']);
	}
	
	//check the value of data inputed
	$fail  = Helper::validate_username($username);
	$fail .= Helper::validate_password($password);

	if ($fail == "") {
		$found_user = Security::check_user($username, $password);
	 	if ($found_user) { //direct registered user to main page
   			$ses->login($found_user);
	   		if ($ses->admin_logged_in == true || $ses->audit_logged_in == true) {
	   			Helper::redirect_to('main_menu.php');
	   		} else {
	   			//Helper::redirect_to('lib/call_select_process.php');
	   			Helper::redirect_to('user_menu.php');
	   		}
   		
	 	} else {
	 		$current_message  = "User ".$username." is not registered in the system.<br />";
	 		$current_message .= "Or Username and Password Combination was incorrect";
	 	}
	} elseif($fail != "") {
		$current_message = $fail;
	}
	
}
?>
<html>
	<head>
		<title>Call Log System</title>
		<link href="stylesheets/main.css" media="all" 
			rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="javascripts/login_check.js">
		</script>
	</head>

	<body>
		<div id="header">
			<h1>Call Log System</h1>
		</div>
		
		<div id="loginbackup">
			<br /><br / >
			<a href="http://www.kgjs.no"><img src="stylesheets/kgjs_logo.jpg" /></a>
			<br /><br />
			<?php echo Helper::output_message($current_message); ?>
		</div>
		
		<div id="loginbackcr">
			<div style="font-family:times; font-size:20px"><b>Login User</b></div>
			<br />
			<form action="index.php" method="post" onsubmit="return validate(this)" >
				<div style="font-family:times; font-size:20px">
				Username:
					<input type="text" name="username" maxlength="3" size="10" value=""/>
				<br /><br />
				Password:
					<input type="password" name="password" maxlength="10" size="10" />	
				<br /><br />		
					<input type="submit" name="submit" value="Login" />	
				</div>		
			</form>	
		</div>
		
		<div id="loginbackdn">
				
		</div>
		
		<?php Helper::layout_template('foot_common.php'); ?>		