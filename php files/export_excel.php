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
				<h1>Export to Excel</h1>
			</div>
			
			<div id="content">
				<div id="content_header">
					<p>Found <?php echo $_SESSION['recordcount']; ?> User's with Call Records </p>
				</div>
				<div id="tasklist">
					<hr /><br />
					<form action="lib/export_excel_per_user_process.php" method="post">
						<label for="local">Local Number</label>
						<select name="local" id="local">	
							<?php foreach ($_SESSION['locals'] as $local): ?>
								<option value=<?php echo $local ?>><?php echo $local ?></option>
							<?php endforeach; ?>
						</select>
						<input type="submit" name="localbutton" value="Export Record"/>
					</form>
					<br /><hr /><br />
					<form action="lib/export_excel_all_user_process.php" method="post">
						<input type="submit" name="allbutton" value="Export All User Record"/>
					</form>
					<br /><hr />
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
