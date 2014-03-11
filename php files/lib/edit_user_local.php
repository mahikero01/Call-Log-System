<?php session_start() ?>
<?php require_once ('user_record.php');?>
<?php require_once ('helper_functions.php');?>
<?php 
$local = $_POST['local'];
$user = new UserRecord();
$user_data = array();
$user_data = $user->find_user_local($local);
$_SESSION['user_info_id'] = $user_data['user_info_id'];
$_SESSION['local_number'] = $user_data['local_number'];
$_SESSION['user_initial'] = $user_data['user_initial'];
$_SESSION['last_name'] = $user_data['last_name'];
$_SESSION['first_name'] = $user_data['first_name'];
$_SESSION['middle_name'] = $user_data['middle_name'];
$_SESSION['admin'] = $user_data['admin'];
$_SESSION['pass_word'] = $user_data['pass_word'];
$_SESSION['company_id'] = $user_data['company_id'];
Helper::redirect_to('../edit_user.php')
?>