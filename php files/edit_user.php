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
				<h1>Edit User</h1>
			</div>
			
			<div id="content">
				<div id="tasklist">
					<br /><br />
					<form action="lib/save_user.php" method="post">
						<input type="hidden" name="userid" 
							value="<?php echo $_SESSION['user_info_id']; ?>"/>
						<label for="lastname">Last Name</label>
				    	<input type="text" name="lastname" size="20" maxlength="20" 
				    		value="<?php echo $_SESSION['last_name']; ?>" />
						<label for="firstname">First Name</label>
				    	<input type="text" name="firstname" size="20" maxlength="20" 
				    		value="<?php echo $_SESSION['first_name']; ?>" />	
						<label for="firstname">Middle Name</label>
				    	<input type="text" name="midlename" size="20" maxlength="20" 
				    		value="<?php echo $_SESSION['middle_name']; ?>" />	
				    	<br /><br />	
				    	<label for="initial">Initials</label>	
				    	<input type="text" name="initial" size="1" maxlength="3" 
				    		value="<?php echo $_SESSION['user_initial']; ?>" />		
				    	<label for="localnumber">Local Number</label>
				    	<input type="text" name="localnumber" size="1" maxlength="3" 
				    		value="<?php echo $_SESSION['local_number']; ?>" />
				    	<label for="admin">Admin ?</label>	
				    	<input type="text" name="admin" size="1" maxlength="1" 
				    		value="<?php echo $_SESSION['admin']; ?>" />
				    	<label for="company">Company ID</label>
				    	<input type="text" name="company" size="1" maxlength="1" 
				    		value="<?php echo $_SESSION['company_id']; ?>" />
				    	<br /><br />
				    	<label for="password">Password</label>
				    	<input type="password" name="password" size="10" maxlength="10" 
				    		value="<?php echo $_SESSION['pass_word']; ?>" />	
				    	<br /><br />
				    	<input type="submit" name="savebutton" value="Save User"/>		    				    		
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
						<li><a class="taskselection" href="manage_user.php">Return to Manage User Menu</a></li>
						<br />
						<li><a class="taskselection" href="logout.php">Logout</a></li>
					</ul>	
				</div>	
			</div>
<?php Helper::layout_template('foot_common.php'); ?>
