<?php
/*
UPDATE 12-11-21
*/
// connection
require_once("../config.php");
require_once("execution_config.php");
//$result = str_replace('/'.EXECUTION.'/','', ROOT);//in root, sustract current directory
//require_once($result."/".CORE."/lib_Mysql.php");
if (stripos(ROOT, SCENARIO)!==FALSE) {
	$result = str_replace('/'.SCENARIO.'/','', ROOT);// ANO-104 this path is allowed for target in scenario_steps_list_edt.php
	//echo "sc";
}
if (stripos(ROOT, EXECUTION)!==FALSE) {
	$result = str_replace('/'.EXECUTION.'/','', ROOT);
	//echo "exe";
}
require_once($result."/".CORE."/lib_Mysql.php");
require_once($result."/".CORE."/lib_Common.php");
include($result."/".CATEGORY."/category_config.php");// NEW
//$conn = mysql_connect($host, $user, $pass) or die(mysql_error());
//mysql_select_db($database) or die(mysql_error());
$conn = connect();

/* var act for submit label and target url
if update, field date, choice with action pause or close
form with : dt dd label fieldset
   label,size,value
   col size,number cols,
   type (hidden,text,textarea,password),checkbox,list
*/
function display_form_scenario($form_goto,$form_name,$form_submit,$number_submit,$get_id,$get_name){// $get,$fields

	global $lg_excution_label,$lg_execution_create_title;

	echo "<form method=\"POST\" action=\"".$form_goto."\" name=\"".$form_name."\" id=\"".$form_name."\">";
	echo "<fieldset style=\"width:700px;\">";
	echo "<input type=\"hidden\" value=\"$get_id\" name=\"scenario_id\" id=\"scenario_id\" />";
	echo "<legend align=top>".$lg_execution_create_title." : <i>".$get_name."</i></legend>";

	echo "<table>";
	if ($number_submit>1) {
	echo "<tr><td>";
		echo "<input type=\"submit\" value=\"".$form_submit."\">\r\n\r\n";
	echo "</td></tr>";
	}
	//foreach ($fields as $field){// print line
	//}
	echo "<tr><td>";
	echo "<label for=\"execution_scenario\">$lg_excution_label</label>&nbsp;&nbsp;";
	echo "<input type=\"text\" value=\"\" style=\"width:450px;\" name=\"execution_scenario\" id=\"execution_scenario\" />";
	echo "</td></tr>";

	echo "<tr><td>";
	echo "<input type=\"submit\" value=\"".$form_submit."\">\r\n\r\n";
	echo "</td></tr>";
	echo "</table>";
	echo "</fieldset>";

	echo "</form>";

}

function output_query_explanation_label($query,$field){// the two labels to explain what testor is doing
	global $execution_scenario_label,$category_label;
	$array = array();
	//while($row = mysql_fetch_assoc($query)){
	while($row = mysqli_fetch_assoc($query)){
		// retrieve all fields and name them automatically
		$array[$field] = array($execution_scenario_label=> output($row[$execution_scenario_label]),
		$category_label=>output($row[$category_label])
		);
	}
	return ($array);
}

function output_query_execution_step($query,$field){// same name as category_inc
	global $scenario_step_action,$scenario_step_expected,$scenario_step_order,$scenario_step_scenario_id,$scenario_step_id,
		$execution_step_id,$execution_step_obtained,$execution_step_status;
	$array = array();
	//while($row = mysql_fetch_assoc($query)){
	while($row = mysqli_fetch_assoc($query)){
		// retrieve all fields and name them automatically
		$array[$row[$field]] = array($scenario_step_id => output($row[$scenario_step_id]),
		$scenario_step_action => output($row[$scenario_step_action]),
		$scenario_step_expected => output($row[$scenario_step_expected]),
		$scenario_step_order => output($row[$scenario_step_order]),
		$scenario_step_scenario_id => output($row[$scenario_step_scenario_id]),
		$execution_step_id=> output($row[$execution_step_id]),
		$execution_step_obtained=> output($row[$execution_step_obtained]),
		$execution_step_status=> output($row[$execution_step_status])
		);
	}
	return ($array);
}

function output_query_execution_id_in_process($query){
global  $execution_scenario_id;
	$output='';
//while($row = mysql_fetch_assoc($query)){
while($row = mysqli_fetch_assoc($query)){
$output=output($row[$execution_scenario_id]);
}
return ($output);
}

function output_query_execution($query){
	global  $execution_scenario_id, $execution_scenario_parent_id, $execution_scenario_label, $execution_scenario_beginning, $category_label,$execution_scenario_end;
	// fields : exs_id, exs_category_id, exs_label, exs_create_date, category_label
	$array = array();
	$i=0;
	//while($row = mysql_fetch_assoc($query)){
	while($row = mysqli_fetch_assoc($query)){
		// retrieve all fields and name them automatically
		$array[$i] = array(
		$execution_scenario_id=>output($row[$execution_scenario_id]),
		$execution_scenario_parent_id=>output($row[$execution_scenario_parent_id]),
		$execution_scenario_label=>output($row[$execution_scenario_label]),
		$execution_scenario_beginning=>output($row[$execution_scenario_beginning]),
		$execution_scenario_end => output($row[$execution_scenario_end]),
		$category_label=>output($row[$category_label])
		);
		$i++;
		}
	return ($array);// execution scenario id in process
}

function output_query_execution_in_process($query){
	global  $execution_scenario_id, $execution_scenario_parent_id, $execution_scenario_label, $execution_scenario_beginning, $category_label,$execution_scenario_end;
	// fields : exs_id, exs_category_id, exs_label, exs_create_date, category_label
	$array = array();
	$i=0;
	while($row = mysql_fetch_assoc($query)){
		// retrieve all fields and name them automatically
		$array[$i] = array(
		$execution_scenario_id=>output($row[$execution_scenario_id]),
		$execution_scenario_parent_id=>output($row[$execution_scenario_parent_id]),
		$execution_scenario_label=>output($row[$execution_scenario_label]),
		$execution_scenario_beginning=>output($row[$execution_scenario_beginning]),
		$execution_scenario_end => output($row[$execution_scenario_end]),
		$category_label=>output($row[$category_label])
		);
		$i++;
		}
	return ($array);// execution scenario id in process
}

function output_query_execution_yet_closed($query){
	global $execution_scenario_id,$execution_scenario_label,$execution_scenario_beginning,$execution_scenario_end;
	$array = array();
	$i=0;
	while($row = mysql_fetch_assoc($query)){
		// retrieve all fields and name them automatically
		$array[$i] = array($execution_scenario_id => output($row[$execution_scenario_id]),
		$execution_scenario_label => output($row[$execution_scenario_label]),
		$execution_scenario_beginning => output($row[$execution_scenario_beginning]),
		$execution_scenario_end => output($row[$execution_scenario_end])
			);
			$i++;
	}
	return ($array);
}

function display_execution_steps_create($step_array){// just retrieve steps's scenario
	global $execution_debug,$steps_by_page,$submit,$steps_to_add,$execution_steps_labels,$lg_execution_status;
	// $step_id,$step_action,$step_excepted,$step_order    $scenario_steps_labels

if ($execution_debug==1)
{
	echo "labels to use for the table display";
	echo "<pre>";
	print_r($scenario_steps_labels);
	echo "</pre>";

	echo "data to use for the table display";
	echo "<pre>";
	print_r($step_array);
	echo "</pre>";
}

	echo "<form method=\"POST\" action=\"execution_steps_create_act.php\" name=\"form_execution_steps\" id=\"form_execution_steps\"><table><input type=\"submit\" value=\"$submit\">\r\n\r\n";
// submit page : execution_steps_update.php : script
	echo "<THEAD><TR>";//HEADER
foreach ($execution_steps_labels as $cle=>$value){
	echo "<TH>".$value."</TH>";
}
	echo "</TR></THEAD>\r\n\r\n";
	$i=0;

foreach ($step_array as $key=>$value){// display all result : ignore steps by page // the key is the id !!! becareful
	$i++;
	echo "<tr><td width=40><input type=\"hidden\" name=\"steps[$i][exp_id]\" value=\"".$step_array[$key]['exp_id']."\">".$step_array[$key]['sc_step_id']."</td>\r\n";// TODO id of execution
//	echo "<td>".$step_array[$key]['sc_step_order']."</td>\r\n";// no use
	echo "<td width=400>".$step_array[$key]['sc_step_action']."</td>\r\n";
	echo "<td width=200>".$step_array[$key]['sc_step_expected']."</td>\r\n";
	echo "<td><textarea  name=\"steps[$i][step_obtained]\" id=\"step_obtained\" value=\"\" cols=\"50\" rows=\"2\">".$step_array[$key]['exp_obtained']."</textarea></td>\r\n";
		echo "<td width=50>";
		select_list($lg_execution_status,"steps[$i][step_status]",$step_array[$key]['exp_status']);
		echo "</td>\r\n";// print_r($lg_execution_status)
	echo "</tr>\r\n\r\n";
if ($i >= $steps_by_page){break;}// take care about limit by page
}
	$i++; //echo $i;

	echo "<TFOOT><TR>";//FOOTER
foreach ($execution_steps_labels as $cle=>$value){
	echo "<TD>".$value."</TD>";
}
	echo "</TR></TFOOT>\r\n\r\n";

	echo "</table><input type=\"submit\" value=\"$submit\"></form>\r\n\r\n";

}

function display_execution_list($result){
global $lg_execution_report_label, $cat_id, $cat_name, $lg_execution_begin, $lg_execution_end;
//echo "Scenario num ".$cat_id." :  ".$cat_name;
$i=0;
	foreach ($result as $cle){
		echo "<br />";
		echo "Scenario num ".$result[$i]['exs_category_id']." :  ".$result[$i]['category_label']." : ";
		echo "execution num ".$result[$i]['exs_id']." : ";
		echo " <i>".$result[$i]['exs_label']."</i>";
		echo " | ".$lg_execution_begin." ".$result[$i]['exs_create_date']." | ".$lg_execution_end." ";
		echo $result[$i]['exs_close_date'];
		echo " | <a href=\"execution_steps_export_xls.php?cat_id=".$result[$i]['exs_id']."&cat_name=".$result[$i]['exs_label']."&category_id=".$cat_id."&category_name=".$cat_name."\">export</a>";
		echo " | <a href=\"execution_steps_report.php?cat_id=".$result[$i]['exs_id']."&cat_name=".$result[$i]['exs_label']."&category_id=".$cat_id."&category_name=".$cat_name."\">".$lg_execution_report_label."</a>";// TODO include report summary, or export link, or link to module report
$i++;
	}

}


?>