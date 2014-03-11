<?php require_once ('lib/session.php');?>
<?php require_once ('lib/helper_functions.php');?>
<?php if (!$ses->is_logged_in()) { Helper::redirect_to('index.php'); } ?>

<?php Helper::layout_template('head_common.php'); ?>

	<body>
			<div id="header">
				<h1>Under Development</h1>
			</div>
			
			<div id="content">
				<?php $current_message = 'Sorry Page Under Development'?>
				<?php echo Helper::output_message($current_message); ?>
			</div>
			
			<div id="task">
				<div id="taskheader">Task</div>	
				<div id="tasklist">		
					<ul>
						<li><a class="taskselection" href="main_menu.php">Return to Main Menu</a></li>
						<li><a class="taskselection" href="logout.php">Logout</a></li>
					</ul>	
				</div>	
			</div>
<?php Helper::layout_template('foot_common.php'); ?>