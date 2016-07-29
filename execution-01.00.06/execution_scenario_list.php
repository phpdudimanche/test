<?php
/*
UPDATE 12-08-01
   list categories : by line : execution label | link to modify by the form ? | link to see all steps
   var type=pause|close id=cat_id
   list of execution closed
   for a category (not for all categories group by category)
*/
require_once("execution_inc.php");
head($lg_execution_title_02,$execution_css,'../public/'.$general_js.'',$execution_favico);
include('../public/_header.php');
isset($_REQUEST["cat_id"])?$cat_id=input($_REQUEST["cat_id"]):$cat_id="";
isset($_REQUEST["cat_name"])?$cat_name=input($_REQUEST["cat_name"]):$cat_name="";
$query="SELECT $execution_scenario_id,$execution_scenario_label,$execution_scenario_beginning,$execution_scenario_end
	,$execution_scenario_parent_id,$category_label 
FROM $execution_scenario_table 
	JOIN $category_table ON $execution_scenario_parent_id=$category_id 
WHERE $execution_scenario_parent_id=$cat_id AND $execution_scenario_end!='2010-10-10'";
if ($execution_debug==1)
{
echo $query;
}
//$query = mysql_query($query);
$query=query_retrieve($query);
$result=output_query_execution($query);// _yet_closed
if ($execution_debug==1)
{
	echo "<pre>";
	print_r($result);
	echo "</pre>";

}

printf($lg_execution_list_closed, $lg_execution_yet_closed, $cat_name);// title
echo "<br /><br />";
// list of link : export xls, see without modification ?
display_execution_list($result);// _close_list
include('../public/_footer.php');
?>