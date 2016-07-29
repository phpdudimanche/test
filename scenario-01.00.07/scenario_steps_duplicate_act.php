<?php
/*
   step 3/4
   select all data of the steps which have this id as father
   insert as father the new father id
   redirect to category list
*/
require_once("scenario_inc.php");
isset($_REQUEST['scenario'])?$scenario=input($_REQUEST["scenario"]):$scenario=='';
isset($_REQUEST['old_scenario'])?$old_scenario=input($_REQUEST["old_scenario"]):$old_scenario=='';
$directory=CATEGORY;

/*
   INSERT INTO scenario_step SELECT '', sc_step_action, sc_step_expected, sc_step_order, 31
   FROM scenario_step WHERE sc_step_scenario_id=3
*/


$query="INSERT INTO $scenario_table SELECT  $scenario_step_action, $scenario_step_expected, $scenario_step_order, $scenario FROM $scenario_table WHERE $scenario_step_scenario_id=$old_scenario";
$query="INSERT INTO $scenario_table ($scenario_step_action, $scenario_step_expected, $scenario_step_order, $scenario_step_scenario_id)SELECT  $scenario_step_action, $scenario_step_expected, $scenario_step_order, $scenario FROM $scenario_table WHERE $scenario_step_scenario_id=$old_scenario";
// category_id must be null, this field is an auto increment // mysqli remove after SELECT '',
if ($scenario_debug==1)
{
	echo $query;
	exit();
}
//$query = mysql_query($query) or die(mysql_error());
$query=query_record($query);

header("location:../$directory/category_list_edt.php");
?>