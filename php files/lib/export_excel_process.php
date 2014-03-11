<?php require_once ('session.php');?>
<?php require_once ('helper_functions.php');?>
<?php require_once ('call_log_status.php'); ?>
<?php
$export_users = new CallLogStatus();
echo hello;
if ( $export_users->record_for_export() ) {
	$export_users->get_user_with_record();
	$_SESSION['locals'] = $export_users->all_locals_with_record;
	$_SESSION['recordcount'] = count($export_users->all_locals_with_record);
	$export_users->close_database();
	unset($export_users);
	Helper::redirect_to('../export_excel.php');
} else {
	$export_users->close_database();
	$ses->message("There are no record for export");
	unset($export_users);
	Helper::redirect_to('../admin_menu.php');
} 
?>