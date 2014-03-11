<?php require_once ('lib/session.php');?>
<?php require_once ('lib/helper_functions.php');?>
<?php 
if ( ($ses->is_logged_in()) && (!$ses->is_admin_logged_in()) ) { 
	$ses->message("Sorry you do not have Administrator Acess.");
	Helper::redirect_to('main_menu.php'); 
} else if ( (!$ses->is_logged_in()) && (!$ses->is_admin_logged_in()) ) { 
	Helper::redirect_to('index.php');
}
?>

<?php Helper::layout_template('head_common.php'); ?>
	
	<body>
			<div id="header">
				<h1>Admin Menu</h1>
			</div>
			
			<div id="content">
				<?php echo Helper::output_message($current_message); ?>
			</div>
			
			<div id="task">
				<br />
				<a href="http://www.kgjs.no"><img src="stylesheets/kgjs_logo.jpg" /></a>
				<div id="taskheader">Task</div>	
				<div id="tasklist">		
					<ul>
						<li><a class="taskselection" href="main_menu.php">Return to Main Menu</a></li>
						<br />
						<li><a class="taskselection" href="manage_user.php">Manage User's</a></li>
						<li><a class="taskselection" href="adjust_call_rate.php">Adjust Call Rate</a></li>
						<li><a class="taskselection" href="import.php">Import File</a></li>
						<li><a class="taskselection" href="input_new_record.php">Input New Call Record</a></li>
						<li><a class="taskselection" href="process_new_call_logs.php">Process New Call Logs</a></li>
						<!-- <li><a class="taskselection" href="lib/export_excel_process.php">Export Record to Excel</a></li> -->
						<!-- <li><a class="taskselection" href="post_calls.php">Posting Calls</a></li> -->
						<li><a class="taskselection" href="report_menu.php">Reports</a></li>
						<br />
						<li><a class="taskselection" href="logout.php">Logout</a></li>
					</ul>	
				</div>	
			</div>
<?php Helper::layout_template('foot_common.php'); ?>