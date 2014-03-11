<?php require_once ('lib/session.php');?>
<?php require_once ('lib/helper_functions.php');?>
<?php require_once ('lib/call_log_status.php'); ?>
<?php if (!$ses->is_logged_in()) { Helper::redirect_to('index.php'); } ?>
<?php 
$currentUserCallStatus = new CallLogStatus();

?>
<?php Helper::layout_template('head_common.php'); ?>

	<body>
			<div id="header">
				<h1>Previous Posted Calls Menu</h1>
			</div>
			
			<div id="content">
				<div id="tasklist">
					<br />
					<form action="previous_posted_calls_menu.php" method="post">
						<input type="radio" name="callpurpose" id="obcalls" value="OB" checked />
 						<label for="obcalls">OB (Business Calls)</label>
  						<input type="radio" name="callpurpose" id="prcalls" value="PR" />
  						<label for="prcalls">PR (Personal Calls)</label>
  						<br /><br />
  						<label for="ackbills">Bill Number</label>
  						<select name="ackbills" id="ackbills">	
							<?php $currentUserCallStatus->getBillNumbersOfAckCalls($ses->user_id); ?>	
							<?php foreach ($currentUserCallStatus->userPostedBills as $billNumber): ?>
								<option value=<?php echo $billNumber; ?>>
									<?php echo $billNumber ?>
								</option>
							<?php endforeach; ?>
						</select>
						<input type="submit" name="viewbillbutton"  value="SHOW" />
					</form>
					<hr />
					<?php if( isset($_POST['viewbillbutton']) ):?>
						<?php $ses->storeDataCurrentUserPreviousCalls($_POST['ackbills'], $_POST['callpurpose'])?>
						<?php $currentUserCallStatus->getSelectedBillNumbersOfAckCalls($ses->user_id, $_POST['callpurpose'], $_POST['ackbills']); ?>
						<?php $currentUserCallStatus->getSelectedPurposeOfAckCalls($ses->user_id, $_POST['callpurpose']); ?>
						<?php echo count($currentUserCallStatus->userSelectedPostedBills)." ".$_POST['callpurpose']; ?> Calls in Bill 
							<?php echo $_POST['ackbills']; ?>
						<br />
						Total Cost of Calls: Php <?php echo number_format(array_sum($currentUserCallStatus->userSelectedPostedBills), 2, '.', ',');?>
						<br /><br />
						Accumulated <?php echo $_POST['callpurpose']; ?> Calls: <?php echo count($currentUserCallStatus->userSelectedPostedBillsPurpose); ?>
						<br />
						Accumulated Total Cost of <?php echo $_POST['callpurpose']; ?> Calls: Php 
							<?php echo number_format(array_sum($currentUserCallStatus->userSelectedPostedBillsPurpose), 2, '.', ','); ?>
						<hr />
						<?php if( count($currentUserCallStatus->userSelectedPostedBills) > 0 ): ?>
							<form action="view_previous_posted_calls_menu.php?page=1" method="post">
								<input type="submit" name="viewdetailsbutton"  value="View Details" />
							</form>
						<?php endif; ?>
					<?php endif;?>
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