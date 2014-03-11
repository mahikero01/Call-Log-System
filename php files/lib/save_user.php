<?php require_once ('session.php');?>
<?php require_once ('user_record.php');?>
<?php require_once ('helper_functions.php');?>
<?php
$user = new UserRecord();
if ( isset($_POST['userid']) ) {
	$user->save_user_info($_POST['userid'], $_POST['lastname'], $_POST['firstname'],
		$_POST['midlename'], $_POST['localnumber'], $_POST['initial'],
	 	$_POST['admin'], $_POST['password'], $_POST['company']);
	 	$ses->message('Update User Info');
} else {
	$user->save_new_user($_POST['lastname'], $_POST['firstname'],
		$_POST['midlename'], $_POST['localnumber'], $_POST['initial'],
	 	$_POST['admin'], $_POST['password'], $_POST['company']);
	 	$ses->message('Entered New User');	
}
Helper::redirect_to('../manage_user.php')
?>