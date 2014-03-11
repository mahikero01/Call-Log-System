<?php require_once ('lib/session.php');?>
<?php require_once ('lib/helper_functions.php');?>
<?php require_once ('lib/call_record.php');?>
<?php require_once ('lib/pagination.php');?>
<?php if (!$ses->is_logged_in()) { Helper::redirect_to('index.php'); } ?>
<?php
//create an instance of CallRecord and initiate its variables
$current_page = $_GET['page'];
$user_call_record = new CallRecord();
$total_records = $user_call_record->number_of_record($current_id);
$page_call_record = new Pagination($current_page, 20, $total_records);
$post_message = "";
if ( $current_page > $page_call_record->total_pages()) {
	Helper::redirect_to('call_select.php?page=1');
} else {
	$user_call_record->get_all_data($current_id, $page_call_record->offset());
	for ($count=0; $count<=19; $count++) {
		$post_str_ok = 'ok'.$count;
		$post_str_pur = 'purpose'.$count;
		$post_str_rem = 'remark'.$count;
		if (isset($_POST[$post_str_ok])) {
			$post_message = $user_call_record->update_call_record($user_call_record->user_made_calls[$count]['call_log_id'], 
				$_POST[$post_str_pur], $_POST[$post_str_rem]);	
			$str = 	'call_select.php?page='.$current_page;
			$record_check = $user_call_record->number_of_record($current_id);
			if ( $record_check > 0 ) {
				Helper::redirect_to($str);
				break;
			} else {
				Helper::redirect_to('user_menu.php');
			}
		} 
  }
}
?>

<?php Helper::layout_template('head_common.php'); ?>

	<body>
			<div id="header">
				<h1>Call Record</h1>
			</div>
			
			<div id="content">
				<div id="content_header">
					<?php 
						$message_report = 'Page '.$_GET['page'].' of ';
						$message_report .= $page_call_record->total_pages();
						echo $message_report; 
						$message_report = 'Found '.$total_records.' Total Records';
						echo "&#09;";
						echo $message_report; 
					?>

				</div>
				<br />
				<?php $page_str = "call_select.php?page=".$_GET['page']; 
				echo "<form action={$page_str} method=\"POST\">";
				?>
				<table id="call_view_result" >
					<?php
					  echo "<tr>";
					    echo "<th>Call Date</th>";
					    echo "<th>Call End</th>";
					    echo "<th>Duration</th>";
					    echo "<th>Price</th>";
					    echo "<th>Tel. Num.</th>";
					    echo "<th>Location</th>";
					    echo "<th>Purpose</th>";
					    echo "<th>Remarks</th>"; 
					    echo "<th>Confirm</th>";  
					  echo "</tr>";
					  if (isset($user_call_record->user_made_calls[0])) {					  
					  echo "<tr>";
				    	echo "<td>{$user_call_record->user_made_calls[0]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[0]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[0]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[0]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[0]['tele_number']}</td>";
						echo "<td>{$user_call_record->user_made_calls[0]['location_desc']}</td>";
						echo "<td><input type=\"radio\" name=\"purpose0\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose0\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark0\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[0]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok0\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[1])) {					  
					  echo "<tr class=\"alt\" >";
				    	echo "<td>{$user_call_record->user_made_calls[1]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[1]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[1]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[1]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[1]['tele_number']}</td>";
						echo "<td>{$user_call_record->user_made_calls[1]['location_desc']}</td>";				    	
				    	echo "<td><input type=\"radio\" name=\"purpose1\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose1\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark1\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[1]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok1\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[2])) {					  
					  echo "<tr>";
				    	echo "<td>{$user_call_record->user_made_calls[2]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[2]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[2]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[2]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[2]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[2]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose2\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose2\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark2\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[2]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok2\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[3])) {					  
					  echo "<tr class=\"alt\" >";
				    	echo "<td>{$user_call_record->user_made_calls[3]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[3]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[3]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[3]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[3]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[3]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose3\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose3\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark3\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[3]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok3\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[4])) {					  
					  echo "<tr>";
				    	echo "<td>{$user_call_record->user_made_calls[4]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[4]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[4]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[4]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[4]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[4]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose4\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose4\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark4\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[4]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok4\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[5])) {					  
					  echo "<tr class=\"alt\" >";
				    	echo "<td>{$user_call_record->user_made_calls[5]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[5]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[5]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[5]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[5]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[5]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose5\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose5\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark5\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[5]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok5\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[6])) {					  
					  echo "<tr>";
				    	echo "<td>{$user_call_record->user_made_calls[6]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[6]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[6]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[6]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[6]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[6]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose6\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose6\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark6\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[6]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok6\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[7])) {					  
					  echo "<tr class=\"alt\" >";
				    	echo "<td>{$user_call_record->user_made_calls[7]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[7]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[7]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[7]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[7]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[7]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose7\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose7\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark7\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[7]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok7\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[8])) {					  
					  echo "<tr>";
				    	echo "<td>{$user_call_record->user_made_calls[8]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[8]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[8]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[8]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[8]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[8]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose8\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose8\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark8\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[8]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok8\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[9])) {					  
					  echo "<tr class=\"alt\" >";
				    	echo "<td>{$user_call_record->user_made_calls[9]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[9]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[9]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[9]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[9]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[9]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose9\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose9\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark9\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[9]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok9\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[10])) {					  
					  echo "<tr>";
				    	echo "<td>{$user_call_record->user_made_calls[10]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[10]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[10]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[10]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[10]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[10]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose10\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose10\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark10\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[10]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok10\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[11])) {					  
					  echo "<tr class=\"alt\" >";
				    	echo "<td>{$user_call_record->user_made_calls[11]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[11]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[11]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[11]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[11]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[11]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose11\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose11\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark11\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[11]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok11\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[12])) {					  
					  echo "<tr>";
				    	echo "<td>{$user_call_record->user_made_calls[12]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[12]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[12]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[12]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[12]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[12]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose12\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose12\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark12\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[12]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok12\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[13])) {					  
					  echo "<tr class=\"alt\" >";
				    	echo "<td>{$user_call_record->user_made_calls[13]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[13]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[13]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[13]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[13]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[13]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose13\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose13\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark13\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[13]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok13\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[14])) {					  
					  echo "<tr>";
				    	echo "<td>{$user_call_record->user_made_calls[14]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[14]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[14]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[14]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[14]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[14]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose14\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose14\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark14\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[14]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok14\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[15])) {					  
					  echo "<tr class=\"alt\" >";
				    	echo "<td>{$user_call_record->user_made_calls[15]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[15]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[15]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[15]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[15]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[15]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose15\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose15\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark15\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[15]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok15\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[16])) {					  
					  echo "<tr>";
				    	echo "<td>{$user_call_record->user_made_calls[16]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[16]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[16]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[16]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[16]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[16]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose16\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose16\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark16\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[16]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok16\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[17])) {					  
					  echo "<tr class=\"alt\" >";
				    	echo "<td>{$user_call_record->user_made_calls[17]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[17]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[17]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[17]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[17]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[17]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose17\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose17\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark17\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[17]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok17\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[18])) {					  
					  echo "<tr>";
				    	echo "<td>{$user_call_record->user_made_calls[18]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[18]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[18]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[18]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[18]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[18]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose18\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose18\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark18\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[18]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok18\" value=\"OK\"/></td>";
						echo "</tr>";
					  }
					  if (isset($user_call_record->user_made_calls[19])) {					  
					  echo "<tr class=\"alt\" >";
				    	echo "<td>{$user_call_record->user_made_calls[19]['call_date']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[19]['call_finish']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[19]['call_duration']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[19]['total_call_cost']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[19]['tele_number']}</td>";
				    	echo "<td>{$user_call_record->user_made_calls[19]['location_desc']}</td>";		
				    	echo "<td><input type=\"radio\" name=\"purpose19\" value=\"OB\" checked=\"checked\" />OB 
							<input type=\"radio\" name=\"purpose19\" value=\"PR\" />PR</td>"; 
				    	echo "<td><input type=\"text\" name=\"remark19\" size=\"10\" maxlength=\"25\" 
				    		value=\"{$user_call_record->user_made_calls[19]['remarks']}\"/></td>";
						echo "<td><input type=\"submit\" name=\"ok19\" value=\"OK\"/></td>";
						echo "</tr>";
					  }  
					?>
					</table>
				</form>
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
				<br />
				<div class="task_select_head">				
					<?php 
					if ($page_call_record->has_previous_page()) {
						$url_page = 'call_select.php';
						$param = $page_call_record->previous_page();

						$url = rawurlencode($url_page);
						$url .= "?page=".urlencode($param);
						$selector = "<a class=\"taskselection\" href='".$url."'>&laquo Prev</a>";
						echo $selector;
					}
					?>&nbsp;
					<?php 
					if ($page_call_record->has_next_page()) {
						$url_page = 'call_select.php';
						$param = $page_call_record->next_page();

						$url = rawurlencode($url_page);
						$url .= "?page=".urlencode($param);
						$selector = "<a class=\"taskselection\" href='".$url."'>Next &raquo</a>";
						echo $selector;
					}
					?>	
					<br /><br /><br /><br /><br /><br /><br />
					<form action="lib/all_calls_checked.php" method="post">
						<input type="hidden" name="userid" value="<?php echo $current_id; ?>" />
						<input type="submit" name="allcheckbutton" value="Finish Viewing Calls"/>		
					</form>
				</div>	
				<?php echo Helper::output_message($post_message); ?>
			</div>
<?php Helper::layout_template('foot_common.php'); ?>
<?php unset($user_call_record); ?>
<?php unset($page_call_record); ?>