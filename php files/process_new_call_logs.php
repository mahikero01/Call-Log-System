<?php require_once ('lib/session.php');?>
<?php require_once ('lib/helper_functions.php');?>
<?php require_once ('lib/call_log_status.php'); ?>
<?php 
if ( ($ses->is_logged_in()) && (!$ses->is_admin_logged_in()) ) { 
	$ses->message("Sorry you do not have Administrator Acess.");
	Helper::redirect_to('main_menu.php'); 
} else if ( (!$ses->is_logged_in()) && (!$ses->is_admin_logged_in()) ) { 
	Helper::redirect_to('index.php');
}
?>
<?php 
$current_call_log_status = new CallLogStatus();
if (isset($_POST['show_call_log']) ){
	$current_call_log_status->ready_bills_for_remarks($_POST['trunline_1'], $_POST['trunline_2']);
}
?>
<?php Helper::layout_template('head_common.php'); ?>
	
	<body>
			<div id="header">
				<h1>Process New Call Records</h1>
			</div>
			
			<div id="content">
				<div id="content_header">
					<?php echo $current_call_log_status->get_all_calls_with_no_show_log_but_payed(); ?>
					un-process calls
				</div>
				<div id="tasklist">
					<hr /><br />
					<form action="process_new_call_logs.php" method="post"> 
						<label for="trunline_1">Trunk Line 9763330</label>
						<select name="trunline_1" id="trunline_1">	
								<?php foreach ($current_call_log_status->get_bill_numbers_one_current() as $bill_number_one): ?>
									<option value=<?php echo $bill_number_one ?>><?php echo $bill_number_one ?></option>
								<?php endforeach; ?>
						</select>
						<label for="trunline_2">Trunk Line 9769060</label>
						<select name="trunline_2" id="trunline_2">	
								<?php foreach ($current_call_log_status->get_bill_numbers_two_current() as $bill_number_two): ?>
									<option value=<?php echo $bill_number_two ?>><?php echo $bill_number_two ?></option>
								<?php endforeach; ?>
						</select>
						<input type="submit" name="show_call_log" value="SHOW LOGS"/>
					</form>
				</div>		
				<?php echo Helper::output_message($current_message); ?>
			</div>
			
			<div id="task">
				<br />
				<a href="http://www.kgjs.no"><img src="stylesheets/kgjs_logo.jpg" /></a>
				<div id="taskheader">Task</div>	
				<div id="tasklist">		
					<ul>
						<li><a class="taskselection" href="main_menu.php">Return to Main Menu</a></li>
						<li><a class="taskselection" href="admin_menu.php">Return to Admin Menu</a></li>
						<br />
						<li><a class="taskselection" href="logout.php">Logout</a></li>
					</ul>	
				</div>	
			</div>
<?php Helper::layout_template('foot_common.php'); ?>
<?php unset($current_call_log_status); ?>