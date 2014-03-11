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
				<h1>Input New Call Record</h1>
			</div>
			
			<div id="content">
				<div id="content_header" >
				</div>
				<div id="content_list">	
					<form action="lib/input_new_record_process.php" method="POST" >
						<label for="year">Year</label>
						<select name="year" id="year">
							<option value=09>2009</option>
							<option value=10>2010</option>
<!--							<option value=11>2011</option>
  						<option value=12>2012</option>
							<option value=13>2013</option>
							<option value=14>2014</option>
							<option value=15>2015</option>	-->								
						</select>	
						<label for="month">Month</label>
						<select name="month" id="month">
							<option value=01>January</option>
							<option value=02>February</option>
							<option value=03>March</option>
							<option value=04>April</option>
							<option value=05>May</option>
							<option value=06>June</option>
							<option value=07>July</option>
							<option value=08>August</option>
							<option value=09>September</option>
							<option value=10>October</option>
							<option value=11>November</option>
							<option value=12>December</option>
						</select>
						<label for="date">Date</label>	
						<select name="date" id="date">
							<option value=01>1</option>
							<option value=02>2</option>
							<option value=03>3</option>
							<option value=04>4</option>
							<option value=05>5</option>
							<option value=06>6</option>
							<option value=07>7</option>
							<option value=08>8</option>
							<option value=09>9</option>
							<option value=10>10</option>
							<option value=11>11</option>
							<option value=12>12</option>
							<option value=13>13</option>
							<option value=14>14</option>
							<option value=15>15</option>
							<option value=16>16</option>
							<option value=17>17</option>
							<option value=18>18</option>
							<option value=19>19</option>
							<option value=20>20</option>
							<option value=21>21</option>
							<option value=22>22</option>
							<option value=23>23</option>
							<option value=24>24</option>
							<option value=25>25</option>
							<option value=26>26</option>
							<option value=27>27</option>
							<option value=28>28</option>
							<option value=29>29</option>
							<option value=30>30</option>
							<option value=31>31</option>
						</select>													
						<label for="callfinish">Call Finish</label>						
						<input type="text" name="callfinish" id ="callfinish" size="2" maxlength="4"/>		
						<br /><br />
						<label for="duration">Call Duration(in minutes)</label>						
						<input type="text" name="duration" id ="duration" size="1" maxlength="3"/>	
						<label for="local">Local</label>						
						<input type="text" name="local" id ="local" size="1" maxlength="3"/>		
						<br /><br />
						<label for="telephone">Telephone</label><br />		
						<label for="telephone">(IDD access code + country code + telephone)</label><br />	
						<label for="telephone">(NDD access code + area code + telephone)</label><br />	
						<label for="telephone">(GSM access code + GSM code + telephone)</label><br />												
						<input type="text" name="telephone" id ="telephone" size="16" maxlength="16"/>	
						<br /><br />
						<input type="submit" name="enter" value="Enter New Record"/>																														
					</form>
				</div> 				
				<p><?php echo Helper::output_message($current_message); ?></p>
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