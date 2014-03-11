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
$current_log_status = new CallLogStatus();
$current_log_status->get_user_with_record();
$current_users_with_unposted_calls = count($current_log_status->all_locals_with_record);
if (!isset($current_user)) {
	$current_user = ""; 
}
if (isset($_POST['check_user_button']) || isset($_POST['user_initial'])) {
	if ($current_log_status->check_selected_user_call_log($_POST['user_initial'])) {
		$current_user = $_POST['user_initial'];
		$current_log_status->get_selected_user_un_posted_calls($_POST['user_initial']);
		if (isset($_POST['post_button'])){
			$current_log_status->post_selected_call_log($_POST['call_log_id']);
			$current_log_status->reset_all_locals_with_record_array();
			$current_log_status->get_user_with_record();
			$current_users_with_unposted_calls = count($current_log_status->all_locals_with_record);
			if ($current_log_status->check_selected_user_call_log($current_user)){
				$current_log_status->reset_selected_user_unposted_calls_array();
				$current_log_status->get_selected_user_un_posted_calls($_POST['user_initial']);
			} else {
				$current_message = "User has no Un Posted Calls";
				$current_user = "";
			}
		} elseif (isset($_POST['post_all_button'])) {
			$current_log_status->convert_intial_to_id($current_user);
			$current_log_status->post_all_call_log_of_selected_user($current_log_status->current_user_id);
			$current_log_status->reset_all_locals_with_record_array();
			$current_log_status->get_user_with_record();
			$current_users_with_unposted_calls = count($current_log_status->all_locals_with_record);
			$current_user = "";
		}
	} else {
		$current_message = "User has no Un Posted Calls";
		$current_user = "";
	}
} 
?>
<?php Helper::layout_template('head_common.php'); ?>
	
	<body>
			<div id="header">
				<h1>Post Calls</h1>
			</div>
			
			<div id="content">
				<div id="content_header">
					<p>Found <?php echo $current_users_with_unposted_calls; ?> User's with Un Posted Calls </p>
					<?php  
					if ($current_user != ""){
						echo "<p>".strtoupper($current_user).
							" has ".count($current_log_status->selected_user_un_posted_calls). " Un Posted Calls</p>";
					}
					?>
				</div>
				<div id="tasklist">
					<hr />
					<form action="post_calls.php" method="post">
						<p>Select User For Posting Calls to PR </p>
						<label for="user_initial">User Initial</label>
						<select name="user_initial" id="user_initial">	
							<?php $current_log_status->get_users_initials_with_record(); ?>	
							<?php foreach ($current_log_status->all_user_initials_with_record as $initial): ?>
								<option value=<?php echo $initial; ?>
								<?php 
								if ($initial == strtoupper($current_user)){
									echo "selected=\"selected\"";
								} 
								?>
								><?php echo $initial ?></option>
							<?php endforeach; ?>
						</select>
	<!-- 			
						<input type="text" name="user_initial" id="user_initial" maxlength="3" size="1" 
							value="<?php echo $current_user; ?>" /> -->
						<input type="submit" name="check_user_button"  value="Check User" />
								
						<?php  
						if ($current_user != ""){
							echo "<label for=\"call_log_id\">Call Log ID</label>";
							echo "<select name=\"call_log_id\" id=\"call_log_id\">";	
							foreach ($current_log_status->selected_user_un_posted_calls as $call_id) {
									echo "<option value=".$call_id.">".$call_id."</option>";
							}
							echo "</select>";
							echo "<input type=\"submit\" name=\"post_button\"  value=\"POST\" />";	
							echo "<br /><br /><br />";
							echo "<input type=\"submit\" name=\"post_all_button\"  
								value=\"Post All Calls of ".strtoupper($current_user)." to OB\" />";
						}
						?>
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
<?php unset($current_log_status); ?>
