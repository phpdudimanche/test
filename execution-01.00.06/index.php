<?php
/* UPDATE 12-11-28
exist execution ?
NO : display link to scenario
YES : display list of execution in progress to finish, and alos part of finished execution list
*/
require_once("execution_inc.php");
head($lg_execution_title_01,$execution_css,'../public/'.$general_js.'',$execution_favico);
include('../public/_header.php');
// no scenario yet in scenario table
// no query on selection
echo "<a href='../".SCENARIO."'>".$lg_execution_scenario_select."</a>";// link to scenario
// execution in progress (with pagination V2) V1 add a limit by secure
$query="SELECT $execution_scenario_id, $execution_scenario_parent_id, $execution_scenario_label, $execution_scenario_beginning,$execution_scenario_end, 
$category_label
FROM $execution_scenario_table
JOIN $category_table ON $execution_scenario_parent_id=$category_id
WHERE $execution_scenario_end='2010-10-10'";
/*$query="SELECT $execution_scenario_id, $execution_scenario_parent_id, $execution_scenario_label, $execution_scenario_beginning, category_label
FROM $execution_scenario_table
JOIN $category_table ON $execution_scenario_parent_id=$category_id
WHERE $execution_scenario_end=2010-10-10";*/
//echo $query;

if ($execution_debug==1){
	echo $query;
}
//$query = mysql_query($query)or (FALSE);
$query=query_retrieve($query);
		//if ($query!=FALSE) {
$result=output_query_execution($query);
if ($execution_debug==1){
	echo "<pre>";
	print_r($result);
	echo "</pre>";
}
/* TODO mutualize outpout
- DONE
Notice: Undefined index: exs_close_date in E:\SITES\02_DEV\V.02.02.03\execution-01.00.05\execution_inc.php on line 198
[exs_close_date] is not here
add in : output_query_execution_in_process : general var, return array, query behind : OK
- TODO
must not have text "scenario N°" 
add pagination at least
*/
if (sizeof($result)!=0){
echo "<br /><br /> ".$lg_inprogress." : ";
display_execution_list($result);
echo "<br />";
}
/*
SELECT exs_id,exs_label,exs_create_date,exs_close_date, 
exs_category_id, category_label
FROM 005_execution_scenario 
JOIN 005_category ON exs_category_id=category_id
WHERE exs_close_date!=2010-10-10
*/



// without cat_id for all categories (difference with execution_scenario_list.php)
$query="SELECT $execution_scenario_id,$execution_scenario_label,$execution_scenario_beginning,$execution_scenario_end, 
$execution_scenario_parent_id, $category_label 
FROM $execution_scenario_table JOIN $category_table ON $execution_scenario_parent_id=$category_id WHERE $execution_scenario_end!='2010-10-10'";
if ($execution_debug==1){
	echo $query;
}
//$query = mysql_query($query)or (FALSE);
$query=query_retrieve($query);
$result=output_query_execution($query);
//$result=output_query_execution_in_process($query);// MODEL
//$result=output_query_execution_yet_closed($query);
if ($execution_debug==1){
	echo "<pre>";
	print_r($result);
	echo "</pre>";
}

if (sizeof($result)!=0){
echo "<br /><br /> ".$lg_close." : ";// change display : scenario n°
display_execution_list($result);
//display_execution_close_list($result);// MODEL
}
		//}	// first query diff false

// execution finished (with pagination)
include('../public/_footer.php');

?>