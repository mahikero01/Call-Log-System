<?php require_once ('lib/session.php');?>
<?php require_once ('lib/helper_functions.php');?>
<?php
//if if user has auditor acces 
if ( ($ses->is_logged_in()) && (!$ses->is_audit_logged_in())  ) { 
	$ses->message("Sorry you do not have Auditor Access.");
	Helper::redirect_to('user_menu.php'); 
} else if ( (!$ses->is_logged_in()) && (!$ses->is_admin_logged_in()) && (!$ses->is_audit_logged_in()) ) { 
	Helper::redirect_to('index.php');
}
?>
<?php Helper::layout_template('head_common.php'); ?>

	<body>
			<div id="header">
				<h1>Audit Calls</h1>
			</div>
			
			<div id="content">
				<div id="content_header" >
					Select call data you want to audit.<br />
				</div>
				<div id="tasklist">	
					<form action="lib/check_all_calls_process.php" method="POST">
						<br />
						<label for="year">Year</label>
						<select name="year" id="year">
							<option value=2009>2009</option>
							<option value=2010>2010</option>
<!--  						<option value=2011>2011</option>
							<option value=2012>2012</option>
							<option value=2013>2013</option>
							<option value=2014>2014</option>
							<option value=2015>2015</option>		-->								
						</select>
						<label for="month">Month</label>
						<select name="month" id="month">
							<option value=1>January</option>
							<option value=2>February</option>
							<option value=3>March</option>
							<option value=4>April</option>
							<option value=5>May</option>
							<option value=6>June</option>
							<option value=7>July</option>
							<option value=8>August</option>
							<option value=9>September</option>
							<option value=10>October</option>
							<option value=11>November</option>
							<option value=12>December</option>
						</select>
						<label for="trunk1">9763330</label>
 						<input type="radio" name="trunkline" id="trunk1" value=1 />
  					<label for="trunk2">9769060</label>
  					<input type="radio" name="trunkline" id="trunk2" value=2 />
  					<label for="billnumber">Bill # </label>
						<input type="text" name="billnumber" id="billnumber"size="1" maxlength="2" value=""></input>							
   				 	<label for="calltype">Call Type</label>
						<select name="calltype" id="calltype">
							<option value=1>NDD</option>
							<option value=2>IDD</option>
						</select>
   				 	<input type="submit" name="submit" value="Go" />
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
						<li><a class="taskselection" href="user_menu.php">Return to User Menu</a></li>
						<br />
						<li><a class="taskselection" href="logout.php">Logout</a></li>
					</ul>	
				</div>	
			</div>
<?php Helper::layout_template('foot_common.php'); ?>