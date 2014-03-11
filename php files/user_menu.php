<?php require_once ('lib/session.php');?>
<?php require_once ('lib/helper_functions.php');?>
<?php if (!$ses->is_logged_in()) { Helper::redirect_to('index.php'); } ?>

<?php Helper::layout_template('head_common.php'); ?>

	<body>
			<div id="header">
				<h1>User Menu</h1>
			</div>
			
			<div id="content">
				<?php echo Helper::output_message($current_message); ?>
			</div>
			
			<div id="task">
				<br />
				<a href="http://www.kgjs.no"><img src="stylesheets/kgjs_logo.jpg" /></a>
				<div id="taskheader">Task</div>	
				<div id="tasklist">		
					<ul>
						<li><a class="taskselection" href="main_menu.php">Return to Main Menu</a></li>
						<br />
						<li><a class="taskselection" href="audit_calls.php">Audit Calls</a></li>
						<li><a class="taskselection" href="audit_user_calls.php">Audit User Calls</a></li>
						<br />
						<li><a class="taskselection" href="lib/call_select_process.php">Pending Calls</a></li>
						<li><a class="taskselection" href="previous_posted_calls_menu.php">Previous Posted Calls</a></li>
						<br />
						<li><a class="taskselection" href="logout.php">Logout</a></li>
					</ul>	
				</div>	
			</div>
<?php Helper::layout_template('foot_common.php'); ?>