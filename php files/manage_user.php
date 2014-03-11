<?php require_once ('lib/session.php');?>
<?php require_once ('lib/user_record.php');?>
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
$registered_users = new UserRecord();
$registered_users->get_all_local();
$registered_users->get_all_initial();
?>
<?php Helper::layout_template('head_common.php'); ?>
	
	<body>
			<div id="header">
				<h1>Manage User's</h1>
			</div>
			
			<div id="content">
				<div id="tasklist">
					<br /><br />
					<form action="lib/edit_user_local.php" method="post">
						<label for="local">Local Number</label>
							<select name="local" id="local">	
							<?php foreach ($registered_users->all_locals as $local): ?>
								<option value=<?php echo $local ?>><?php echo $local ?></option>
							<?php endforeach; ?>
							</select>
							<input type="submit" name="localbutton" value="Edit User(Local)"/>
					</form>
					<br /><br />
					<form action="lib/edit_user_initial.php" method="post">
						<label for="initial">User Initial</label>
							<select name="initial" id="initial">	
							<?php foreach ($registered_users->all_initials as $initial): ?>
								<option value=<?php echo $initial ?>><?php echo $initial ?></option>
							<?php endforeach; ?>
							</select>
							<input type="submit" name="initialbutton" value="Edit User(Initials)"/>
					</form>
					<br /><br />
					<form action="new_user.php" method="post">
						<input type="submit" name="initialbutton" value="Enter New User"/>
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
<?php unset($registered_users); ?>