<?php require_once ('lib/session.php');?>
<?php require_once ('lib/helper_functions.php');?>
<?php	
//page use for login out
$ses->logout();
Helper::redirect_to('index.php');
?>