<?php require_once ('lib/session.php');?>
<?php require_once ('lib/call_rates.php');?>
<?php require_once ('lib/helper_functions.php');?>
<?php 
if ( ($ses->is_logged_in()) && (!$ses->is_admin_logged_in()) ) { 
	$ses->message("Sorry you do not have Administrator Acess.");
	Helper::redirect_to('main_menu.php'); 
} else if ( (!$ses->is_logged_in()) && (!$ses->is_admin_logged_in()) ) { 
	Helper::redirect_to('index.php');
}
?>
<?php 
$registeredCallRates = new CallRates();
if (isset($_POST['updateconfirm'])) {
	$registeredCallRates->setCurrentCallRates($_POST['gsmrate'],$_POST['nddrate'],$_POST['iddrate']);
	unset($_POST['updateconfirm']);
}
$registeredCallRates->getAllCallRates();
?>
<?php Helper::layout_template('head_common.php'); ?>
	
	<body>
			<div id="header">
				<h1>Adjust Call Rate</h1>
			</div>
			
			<div id="content">
				<div id="tasklist">
					<br /><br />
					<form action="adjust_call_rate.php" method="post">
						<label for="local">GSM Rate</label>
						<input type="text" name="gsmrate" size="4" maxlength="7" 
				    		value="<?php echo $registeredCallRates->getCurrentCallRates(0); ?>" />
				    	<br /><br />	
				    	<label for="local">NDD Rate</label>
						<input type="text" name="nddrate" size="4" maxlength="7" 
				    		value="<?php echo $registeredCallRates->getCurrentCallRates(1); ?>" />
				    	<br /><br />
				    	<label for="local">IDD Rate</label>
						<input type="text" name="iddrate" size="4" maxlength="7" 
				    		value="<?php echo $registeredCallRates->getCurrentCallRates(2); ?>" />
				    	<br /><br />
						<input type="submit" name="updateconfirm" value="Update Call Rates"/>
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
