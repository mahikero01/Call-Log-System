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
$currentBillOne = substr($_POST['available_bills'], 0, 3);
$currentBillTwo = substr($_POST['available_bills'], 3, 3);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=8" />
		<title>Call Log System</title>
		<link href="stylesheets/report.css" media="all" 
			rel="stylesheet" type="text/css" />
	</head>
	
	<body>
		<div id="header">
			TELEPHONE CHARGES SUMMARY
			<BR >
			OF BILL <?php echo $currentBillOne; ?> AND BILL <?php echo $currentBillTwo; ?>
		</div>
		<br /><br /><br />
		<div id="content">
			<table>
				<tr>
					<?php 
					$currentReport->getAllTransactCalls(OB, $currentBillOne, $currentBillTwo);
					$grandTotal = 0;
					$grandTotal += $currentReport->totalCost[0];
					?>
					<td width="20"></td>
					<td>Total Cost of Business Calls</td>
					<td width="200" align="right">Php </td>
					<td width="120" align="right"><?php echo number_format($currentReport->totalCost[0], 2, '.', ','); ?></td>
				</tr>
				<tr>
					<?php 
					$currentReport->getAllTransactCalls(PR, $currentBillOne, $currentBillTwo);
					$grandTotal += $currentReport->totalCost[0];
					?>				
					<td></td>
					<td>Total Cost of Personal Calls</td>
					<td align="right">Php </td>
					<td align="right"><?php echo number_format($currentReport->totalCost[0], 2, '.', ','); ?></td>
				</tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr>			
					<td></td>
					<td>Total Amount Due</td>
					<td align="right">Php </td>
					<td align="right"><?php echo number_format($grandTotal, 2, '.', ','); ?></td>
				</tr>
			</table>
			<br/><br/>
			<table>
				<tr>
					<?php $currentReport->getUserWithPRCalls($currentBillOne, $currentBillTwo)?>
					<td width="20"></td>
					<td>Detailed Personal Calls for Deductions</td>
					</tr>
			</table>
			<table>
				<?php foreach ($currentReport->userWithPRCalls as $user): ?>
					<tr>
						<td width="50"></td>
						<td><?php echo $user; ?></td>
						<td width="393" align="right">Php </td>
						<?php $currentReport->getCurrentUserCallCost($user, $currentBillOne, $currentBillTwo)?>
						<td width="120" align="right"><?php  echo number_format($currentReport->totalCost[0], 2, '.', ','); ?></td>
					</tr>
				<?php endforeach;?>
			</table>
		</div>
	</body>
</html>