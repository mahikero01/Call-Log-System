<?php require_once ('lib/session.php');?>
<?php require_once ('lib/helper_functions.php');?>
<?php require_once ('lib/call_log.php');?>
<?php
 if ( ($ses->is_logged_in()) && (!$ses->is_admin_logged_in()) ) { 
	$ses->message("You are not an Administrator.");
	Helper::redirect_to('main_menu.php'); 
} else if ( (!$ses->is_logged_in()) && (!$ses->is_admin_logged_in()) ) { 
	Helper::redirect_to('index.php');
}

$max_file_size = 10485760;   // expressed in bytes
	                            //     10240 =  10 KB
	                            //    102400 = 100 KB
	                            //   1048576 =   1 MB
	                            //  10485760 =  10 MB
	if(isset($_POST['submit'])) {
			
			$call_data = new CallLog();
			if ($call_data->attach_file($_FILES['file_upload'])) {//check file if ok for upload
				if($call_data->save()) { // Success
					$call_data->load_to_dbase();
					unset($call_data);
					$ses->message("Log File uploaded successfully.");
					Helper::redirect_to('admin_menu.php');
				} else {
					$current_message = join("<br />", $call_data->errors);
				}
			} else {
				$current_message = join("<br />", $call_data->errors);
			}
	}
?>

<?php Helper::layout_template('head_common.php'); ?>
	
	<body>
			<div id="header">
				<h1>Import File</h1>
			</div>
			
			<div id="content">
				<div id="content_header" >
					Select a File to Import<br />
					Note: Select the log file only of PABX<br />
								This may take long depending on the size of the file.<br />
								(approx 15 seconds per 1Mb file)
				</div>
				<div id="content_list">	
					<form action="import.php" enctype="multipart/form-data" method="POST">
						<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
   				 	<p><input type="file" name="file_upload" /></p>
   				 	<p><input type="submit" name="submit" value="Import" />	</p>
					</form>
				</div> 	
				<p><?php echo Helper::output_message($current_message); ?></p>	
			</div>
			
			<div id="task">
				<br />
				<a href="http://www.kgjs.no"><img src="stylesheets/kgjs_logo.jpg" /></a>
				<div id="taskheader">Task</div>
				<div id="tasklist">
					<ul>
						<li><a class="taskselection" href="main_menu.php"><b>Return to Main Menu</b></a></li>
						<li><a class="taskselection" href="admin_menu.php">Return to Admin Menu</a></li>
						<br />
						<li><a class="taskselection" href="logout.php">Logout</a></li>
					</ul>
				</div>
			</div>

<?php Helper::layout_template('foot_common.php'); ?>