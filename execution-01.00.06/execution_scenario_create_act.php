<?php
/* UPDATE 12-03-18
   script for create execution scenario
get title
get scenario_id from scenario
put date now
insert in database
go to category_list_edt.php
*/
require_once("execution_inc.php");
isset($_REQUEST["scenario_id"])?$scenario_id=input($_REQUEST["scenario_id"]):$scenario_id="";
isset($_REQUEST["execution_scenario"])?$execution_scenario=input($_REQUEST["execution_scenario"]):$execution_scenario="";
if ($execution_debug==1)
{
echo "scenario source ".$scenario_id. " and execution target ".$execution_scenario;
}

   $result = str_replace('/'.EXECUTION.'/','', ROOT);
   require_once($result."/".SCENARIO."/scenario_config.php");

/*

   */

// create execution
/*$query = mysql_query("INSERT INTO $execution_scenario_table ($execution_scenario_id,$execution_scenario_parent_id,$execution_scenario_label,$execution_scenario_beginning)
VALUES ('','$scenario_id','$execution_scenario',NOW())")or die(mysql_error());*/
$query="INSERT INTO $execution_scenario_table ($execution_scenario_parent_id,$execution_scenario_label,$execution_scenario_beginning)
VALUES ('$scenario_id','$execution_scenario',NOW())";
//echo $query;
$query=query_record($query);// enlever id : $execution_scenario_id, -> '',

//$execution_id = mysql_insert_id();
$execution_id = mysqli_insert_id($conn);
//echo $execution_id;//----------- PB
// create steps
/*$query="INSERT INTO $execution_step_table ($execution_step_fk_id ,$execution_fk_id,$execution_step_id)
SELECT $scenario_step_id, $execution_id, ''
   FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id
   ORDER BY $scenario_step_order
";*/
$query="INSERT INTO $execution_step_table ($execution_step_fk_id ,$execution_fk_id)
SELECT $scenario_step_id, $execution_id
   FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id
   ORDER BY $scenario_step_order
";// ,$execution_step_id -> ,''
//echo $query;
//$query = mysql_query($query)or die(mysql_error());
$query=query_record($query);

header('location:execution_steps_create.php?execution_id='.$execution_id.'&scenario_id='.$scenario_id.'');
?>