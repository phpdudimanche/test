<?php
// connection UPDATE 12-09-08
//include("../config.php");
require_once("../config.php");
require_once("scenario_config.php");
//require_once(ROOT."/".CORE."/lib_Mysql.php");// yet in config

if (stripos(ROOT, EXECUTION)!==FALSE) { // used by execution_steps_create.php
	$result = str_replace('/'.EXECUTION.'/','', ROOT);
}
else{
	$result = str_replace('/'.SCENARIO.'/','', ROOT);//in root, sustract current directory ORIGINAL
}
	require_once($result."/".CORE."/lib_Mysql.php");
	require_once($result."/".CORE."/lib_Common.php");// function head
		//$conn = mysql_connect($host, $user, $pass) or die(mysql_error());
		//mysql_select_db($database) or die(mysql_error());
$conn =connect();

function output_query_scenario($query,$field){// same name as category_inc
	global $scenario_step_action,$scenario_step_expected,$scenario_step_order,$scenario_step_scenario_id,$scenario_step_id ;
	$array = array();
	//while($row = mysql_fetch_assoc($query)){
	while($row = mysqli_fetch_assoc($query)){
		// retrieve all fields and name them automatically
		$array[$row[$field]] = array($scenario_step_id => output($row[$scenario_step_id]),
		$scenario_step_action => output($row[$scenario_step_action]),
		$scenario_step_expected => output($row[$scenario_step_expected]),
		$scenario_step_order => output($row[$scenario_step_order]),
		$scenario_step_scenario_id => output($row[$scenario_step_scenario_id])
		);
	}
	return ($array);
}

function display_scenario_steps_list_edit($step_array){
global $scenario_debug,$steps_by_page,$scenario_steps_labels,$submit,$steps_to_add;
// $step_id,$step_action,$step_excepted,$step_order

if ($scenario_debug==1)
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

echo "<form method=\"POST\" action=\"scenario_steps_list_act.php\" name=\"form_scenario_steps\" id=\"form_scenario_steps\"><table><input type=\"submit\" value=\"$submit\">\r\n\r\n";

	echo "<THEAD><TR>";//HEADER
foreach ($scenario_steps_labels as $cle=>$value){
	echo "<TH>".$value."</TH>";
}
	echo "</TR></THEAD>\r\n\r\n";

$i=0;


foreach ($step_array as $key=>$value){// display all result : ignore steps by page // the key is the id !!! becareful
$i++;
	echo "<tr><td><input type=\"hidden\" name=\"steps[$i][step_id]\" value=\"".$step_array[$key]['sc_step_id']."\">".$step_array[$key]['sc_step_id']."</td>\r\n";
	echo "<td><input type=\"text\" value=\"".$step_array[$key]['sc_step_order']."\" name=\"steps[$i][step_order]\" size=\"1\" id=\"step_order\" /></td>\r\n";
	echo "<td><textarea  name=\"steps[$i][step_action]\" id=\"step_action\" value=\"\" cols=\"50\" rows=\"2\">".$step_array[$key]['sc_step_action']."</textarea></td>\r\n";
	echo "<td><textarea  name=\"steps[$i][step_expected]\" id=\"step_expected\" value=\"\" cols=\"50\" rows=\"2\">".$step_array[$key]['sc_step_expected']."</textarea></td>\r\n";
	echo "<td><input type=\"checkbox\" name=\"steps[$i][step_delete]\" id=\"step_delete\" value=\"true\"></td>";
	echo "</tr>\r\n\r\n";
if ($i >= $steps_by_page){break;}// take care about limit by page
}
$i++; //echo $i;


for ($i = $i; $i <= $steps_by_page; $i++) {// TODO use gblobals in row
	echo "<tr><td><input type=\"hidden\" name=\"steps[$i][step_id]\" value=\"\"></td>\r\n";//<input type=\"text\" value=\"\" name=\"steps[$i][step_id]\" readonly size=\"1\">
	echo "<td><input type=\"text\" value=\"\" name=\"steps[$i][step_order]\" size=\"1\" id=\"step_order\" /></td>\r\n";
	echo "<td><textarea  name=\"steps[$i][step_action]\" id=\"step_action\" value=\"\" cols=\"50\" rows=\"2\"></textarea></td>\r\n";
		echo "<td><textarea  name=\"steps[$i][step_expected]\" id=\"step_expected\" value=\"\" cols=\"50\" rows=\"2\"></textarea></td>\r\n";
	echo "<td><input type=\"checkbox\" name=\"steps[$i][step_delete]\" id=\"step_delete\" value=\"true\"></td>";
	echo "</tr>\r\n\r\n";
}
// if $result $i is less than steps_by_page : continue...

//if all is full, data can be added
for ($d=1 ; $d <= $steps_to_add; $d++){
	echo "<tr><td><input type=\"hidden\" name=\"steps[$i][step_id]\" value=\"\"></td>\r\n";
	echo "<td><input type=\"text\" value=\"\" name=\"steps[$i][step_order]\" size=\"1\" id=\"step_order\" /></td>\r\n";
	echo "<td><textarea  name=\"steps[$i][step_action]\" id=\"step_action\" value=\"\" cols=\"50\" rows=\"2\"></textarea></td>\r\n";
	echo "<td><textarea  name=\"steps[$i][step_expected]\" id=\"step_expected\" value=\"\" cols=\"50\" rows=\"2\"></textarea></td>\r\n";
	echo "<td><input type=\"checkbox\" name=\"steps[$i][step_delete]\" id=\"step_delete\" value=\"true\"></td>";
	echo "</tr>\r\n\r\n";
$i++;
}
/**/


	echo "<TFOOT><TR>";//FOOTER
foreach ($scenario_steps_labels as $cle=>$value){
	echo "<TD>".$value."</TD>";
}
	echo "</TR></TFOOT>\r\n\r\n";

echo "</table><input type=\"submit\" value=\"$submit\"></form>\r\n\r\n";

}

function compare(&$a,&$b) {// order first
    $ret=strnatcmp($a['step_order'], $b['step_order']);// target : becareful : strcasecmp is alphabetic and not numeric : strnatcmp natural order
    return ( $ret == 0 ? 0 : ($ret < 0 ? -1 : 1));// order
}

// head

function foot(){
}

function link_scenario_export_xls($scenario_id,$scenario_name){
global $link_export_xls;
echo " | <a href='scenario_steps_export_xls.php?cat_id=".$scenario_id."&cat_name=".$scenario_name."'>".$link_export_xls."</a>";
}
?>