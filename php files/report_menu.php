<?php require_once ('lib/session.php');?>
<?php require_once ('lib/helper_functions.php');?>
<?php require_once ('lib/report_generator.php');?>
<?php 
if ( ($ses->is_logged_in()) && (!$ses->is_admin_logged_in()) ) { 
	$ses->message("Sorry you do not have Administrator Acess.");
	Helper::redirect_to('main_menu.php'); 
} else if ( (!$ses->is_logged_in()) && (!$ses->is_admin_logged_in()) ) { 
	Helper::redirect_to('index.php');
}
?>
<?php 
$currentReport = new ReportGenerator();
$currentReport->getBillNumbers();
?>
<?php Helper::layout_template('head_common.php'); ?>

	<body>
			<div id="header">
				<h1>Reports Menu</h1>
			</div>
			
			<div id="content">
				<div id="tasklist">
					<br /><br />
					<form action="report_summary.php" method="post">
						<label for="available_bills">Available Bills for Report</label>
						<select name="available_bills" id="available_bills">	
								<?php foreach ($currentReport->lineOneBillNumber as $key => $value): ?>
									<?php if ( (isset($currentReport->lineOneBillNumber[$key]) && isset($currentReport->lineTwoBillNumber[$key])) ): ?>
										<option value=<?php echo $currentReport->lineOneBillNumber[$key];echo $currentReport->lineTwoBillNumber[$key]; ?>>
											<?php echo $currentReport->lineOneBillNumber[$key]; ?> and <?php echo $currentReport->lineTwoBillNumber[$key];?>
										</option>
									<?php endif;?>
								<?php endforeach; ?>
						</select>	
						<br /><br />
						<input type="submit" name="generatereport" value="Generate Report"/>
					</form>				
				</div>
				<?php echo Helper::output_message($current_message); ?>
			</div>
			
			<div id="task">
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