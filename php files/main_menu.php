<?php require_once ('lib/session.php');?>
<?php require_once ('lib/helper_functions.php');?>
<?php if (!$ses->is_logged_in()) { Helper::redirect_to('index.php'); } ?>

<?php Helper::layout_template('head_common.php'); ?>

	<body>
			<div id="header">
				<h1>Main Menu</h1>
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
						<li><a class="taskselection" href="user_menu.php">User Menu</a></li>
						<li><a class="taskselection" href="admin_menu.php">Admin Menu</a></li>
						<li><a class="taskselection" href="logout.php">Logout</a></li>
					</ul>	
				</div>	
			</div>
<?php Helper::layout_template('foot_common.php'); ?>