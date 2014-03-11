<?php require_once ('lib/session.php');?>
<?php require_once ('lib/helper_functions.php');?>
<?php require_once ('lib/account_excel_report_template.php');?>
<?php 
if ( ($ses->is_logged_in()) && (!$ses->is_admin_logged_in()) ) { 
	$ses->message("Sorry you do not have Administrator Acess.");
	Helper::redirect_to('main_menu.php'); 
} else if ( (!$ses->is_logged_in()) && (!$ses->is_admin_logged_in()) ) { 
	Helper::redirect_to('index.php');
}
?>
<?php 
$kgjs_report = new AccountExcelReportTemplate(2, "OB", "kgjs");
$kgjsm_ob_report = new AccountExcelReportTemplate(1, "OB", "kgjsm");
$kgjsm_pr_report = new AccountExcelReportTemplate(1, "PR", "kgjsm");

if ($_POST['generate_report_kgjsm_ob']){
	$kgjsm_ob_report->get_all_data($_POST['trunk_one_kgjsm_ob'], $_POST['trunk_two_kgjsm_ob']);
	$kgjsm_ob_report->create_file_name($_POST['trunk_one_kgjsm_ob'], $_POST['trunk_two_kgjsm_ob']);
	$kgjsm_ob_report->export_report();
} elseif ($_POST['generate_report_kgjsm_pr']) {
	$kgjsm_pr_report->get_all_data($_POST['trunk_one_kgjsm_pr'], $_POST['trunk_two_kgjsm_pr']);
	$kgjsm_pr_report->create_file_name($_POST['trunk_one_kgjsm_pr'], $_POST['trunk_two_kgjsm_pr']);
	$kgjsm_pr_report->export_report();
} elseif ($_POST['generate_report_kgjs']) {
	$kgjs_report->get_all_data($_POST['trunk_one_kgjs'], $_POST['trunk_two_kgjs']);
	$kgjs_report->create_file_name($_POST['trunk_one_kgjs'], $_POST['trunk_two_kgjs']);
	$kgjs_report->export_report();
}
?>
<?php Helper::layout_template('head_common.php'); ?>
	
	<body>
			<div id="header">
				<h1>Export Report for Accounting </h1>
			</div>
			
			<div id="content">
				<div id="content_header">
				</div>
				<div id="tasklist">
					<br /><hr />
					<form action="export_report_accounting.php" method="post">
						KGJSM - OB Calls
						<br /><br />
						<label for="trunk_one_kgjsm_ob">Trunk Line 9763330</label>
						<select name="trunk_one_kgjsm_ob" id="trunk_one_kgjsm_ob">	
								<?php foreach ($kgjsm_ob_report->trunk_line_one as $bill_number_one_kgjsm_ob): ?>
									<option value=<?php echo $bill_number_one_kgjsm_ob ?>><?php echo $bill_number_one_kgjsm_ob ?></option>
								<?php endforeach; ?>
						</select>
						<label for="trunk_two_kgjsm_ob">Trunk Line 9769060</label>
						<select name="trunk_two_kgjsm_ob" id="trunk_two_kgjsm_ob">	
								<?php foreach ($kgjsm_ob_report->trunk_line_two as $bill_number_two_kgjsm_ob): ?>
									<option value=<?php echo $bill_number_two_kgjsm_ob ?>><?php echo $bill_number_two_kgjsm_ob ?></option>
								<?php endforeach; ?>
						</select>
						<input type="submit" name="generate_report_kgjsm_ob" value="Generate Report KGJSM OB"/>
						<br /><hr />
						KGJSM - PR Calls
						<br /><br />
						<label for="trunk_one_kgjsm_pr">Trunk Line 9769330</label>
						<select name="trunk_one_kgjsm_pr" id="trunk_one_kgjsm_pr">	
								<?php foreach ($kgjsm_pr_report->trunk_line_one as $bill_number_one_kgjsm_pr): ?>
									<option value=<?php echo $bill_number_one_kgjsm_pr ?>><?php echo $bill_number_one_kgjsm_pr ?></option>
								<?php endforeach; ?>
						</select>
						<label for="trunk_two_kgjsm_pr">Trunk Line 9769060</label>
						<select name="trunk_two_kgjsm_pr" id="trunk_two_kgjsm_pr">	
								<?php foreach ($kgjsm_pr_report->trunk_line_two as $bill_number_two_kgjsm_pr): ?>
									<option value=<?php echo $bill_number_two_kgjsm_pr ?>><?php echo $bill_number_two_kgjsm_pr ?></option>
								<?php endforeach; ?>
						</select>
						<input type="submit" name="generate_report_kgjsm_pr" value="Generate Report KGJSM PR"/>
						<br /><hr />
						KGJS(Manila) - Calls
						<br /><br />
						<label for="trunk_one_kgjs">Trunk Line 9769330</label>
						<select name="trunk_one_kgjs" id="trunk_one_kgjs">	
								<?php foreach ($kgjs_report->trunk_line_one as $bill_number_one_kgjs): ?>
									<option value=<?php echo $bill_number_one_kgjs ?>><?php echo $bill_number_one_kgjs ?></option>
								<?php endforeach; ?>
						</select>
						<label for="trunk_two_kgjs">Trunk Line 9769060</label>
						<select name="trunk_two_kgjs" id="trunk_two_kgjs">	
								<?php foreach ($kgjs_report->trunk_line_two as $bill_number_two_kgjs): ?>
									<option value=<?php echo $bill_number_two_kgjs ?>><?php echo $bill_number_two_kgjs ?></option>
								<?php endforeach; ?>
						</select>
						<input type="submit" name="generate_report_kgjs" value="Generate Report KGJS (Manila)"/>	
						<br /><hr />			
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
<?php 
unset($kgjs_manila_report);
unset($kgjsm_ob_report);
unset($kgjsm_pr_report);
?>
