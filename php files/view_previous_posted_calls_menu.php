<?php require_once ('lib/session.php');?>
<?php require_once ('lib/helper_functions.php');?>
<?php require_once ('lib/call_record.php');?>
<?php require_once ('lib/pagination.php');?>
<?php if (!$ses->is_logged_in()) { Helper::redirect_to('index.php'); } ?>
<?php 
$currentPage = $_GET['page'];
$userPreviousCallRecord = new CallRecord();
$totalPreviousCallRecord = $userPreviousCallRecord->numberOfPreviousCalls($current_id, $currentCallPurpose, $current_bill);
$userPreviousCallRecordPager = new Pagination($currentPage, 20, $totalPreviousCallRecord);
//$userPreviousCallRecord->getAllPreviousCallOfCurrentUser($current_id, $currentCallPurpose, $current_bill, $userPreviousCallRecordPager->offset());
if ( $currentPage > $userPreviousCallRecordPager->total_pages() ) {
	Helper::redirect_to('view_previous_posted_calls_menu.php?page=1');
} else {
	$userPreviousCallRecord->getAllPreviousCallOfCurrentUser($current_id, $currentCallPurpose, $current_bill, $userPreviousCallRecordPager->offset());
}
?>
<?php Helper::layout_template('head_common.php'); ?>
	<body>
			<div id="header">
				<h1>View Previous Calls</h1>
			</div>
			
			<div id="content">
				<div id="content_header">
					Bill <?php echo $ses->bill_number; ?> <?php echo $ses->callPurpose; ?> Calls
					<br />
					<?php 
					$message_report = 'Page '.$_GET['page'].' of ';
					$message_report .= $userPreviousCallRecordPager->total_pages();
					echo $message_report; 
					$message_report = 'Found '.$totalPreviousCallRecord.' Total Records';
					echo "&#09;";
					echo $message_report; 
					?>
				</div>
				<br />
				<table id="call_view_result" >
					<tr>
						<th>Call Date</th>
					 	<th>Call End</th>
					    <th>Duration</th>
					    <th>Price</th>
					    <th>Tel. Num.</th>
					    <th>Location</th>
					</tr>
					<?php $flag = false; ?>
					<?php foreach ($userPreviousCallRecord->userPreviousCalls as $previousCall): ?>
					<tr <?php if ( $flag == true ) { echo "class=\"alt\""; $flag = false; } else { $flag = true; }; ?> >
						<td><?php echo $previousCall['call_date']; ?></td>
						<td><?php echo $previousCall['call_finish']; ?></td>
						<td><?php echo $previousCall['call_duration']; ?></td>
						<td><?php echo $previousCall['total_call_cost']; ?></td>
						<td><?php echo $previousCall['tele_number']; ?></td>
						<td><?php echo $previousCall['location_desc']; ?></td>
					</tr>
					<?php endforeach;?>
				</table>
			</div>
			
			<div id="task">
				<div id="taskheader">Task</div>	
				<div id="tasklist">		
					<ul>
						<li><a class="taskselection" href="main_menu.php">Return to Main Menu</a></li>
						<li><a class="taskselection" href="user_menu.php">Return to User Menu</a></li>
						<br />
						<li><a class="taskselection" href="previous_posted_calls_menu.php">Return  to Previous Posted Calls Menu</a></li>
						<br />
						<br />
						<li><a class="taskselection" href="logout.php">Logout</a></li>
					</ul>	
				</div>	
				<br />
				<div class="task_select_head">				
					<?php 
					if ($userPreviousCallRecordPager->has_previous_page()) {
						$url_page = 'view_previous_posted_calls_menu.php';
						$param = $userPreviousCallRecordPager->previous_page();

						$url = rawurlencode($url_page);
						$url .= "?page=".urlencode($param);
						$selector = "<a class=\"taskselection\" href='".$url."'>&laquo Prev</a>";
						echo $selector;
					}
					?>&nbsp;
					<?php 
					if ($userPreviousCallRecordPager->has_next_page()) {
						$url_page = 'view_previous_posted_calls_menu.php';
						$param = $userPreviousCallRecordPager->next_page();

						$url = rawurlencode($url_page);
						$url .= "?page=".urlencode($param);
						$selector = "<a class=\"taskselection\" href='".$url."'>Next &raquo</a>";
						echo $selector;
					}
					?>	
				</div>	
				<?php echo Helper::output_message($post_message); ?>
			</div>
<?php Helper::layout_template('foot_common.php'); ?>