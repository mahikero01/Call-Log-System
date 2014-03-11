<?php require_once ('call_record.php');?>
<?php require_once ('helper_functions.php');?>
<?php 
$user = new CallRecord();
$user->mark_all_call_posted($_POST['userid']);
Helper::redirect_to('../user_menu.php');
?>
