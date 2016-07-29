<?php
/* UPDATE 2012-04-02
see scenario_steps_export.xls 
*/
require_once("execution_inc.php");
$result = str_replace('/'.EXECUTION.'/','', ROOT);
require_once($result."/".SCENARIO."/scenario_inc.php");
require_once($result."/".CATEGORY."/category_config.php");
require_once("../".CATEGORY."/category_inc.php");// ANO 101 before : $category."category_inc.php"
isset($_REQUEST["cat_id"])?$execution_id=$_REQUEST["cat_id"]:$execution_id=0;
isset($_REQUEST["cat_name"])?$execution_name=$_REQUEST["cat_name"]:$execution_name="test";
isset($_REQUEST["category_id"])?$id=$_REQUEST["category_id"]:$id=0;
isset($_REQUEST["category_name"])?$name=$_REQUEST["category_name"]:$name="";
// unique response
$query="SELECT * FROM  $scenario_table, $execution_step_table WHERE $execution_step_fk_id=$scenario_step_id AND
$execution_fk_id=$execution_id ORDER BY $scenario_step_order";
	if ($execution_debug==1)
	{
	echo $query;
	}
//$query = mysql_query($query);
$query=query_retrieve($query);
$result=output_query_execution_step($query, $scenario_step_id);// TODO put the id of each execution step
	if ($execution_debug==1)
	{
	echo "<pre>";
	print_r($result);
	echo "</pre>";
	}
// header execution
$file="execution_$execution_id.xls";// TODO add scenario name without space quote accent (core/common)
$test="<table border=1>";
$test.="<tr><td>".$execution_id."</td><td><b>".$execution_name."</b></td><td colspan=2>".$name."</td><td>".$id."</td></tr>";// scenario_id and scenario_name
// select exs_category_id from execution_scenario WHERE  exs_id=5
// header data
$test.="<tr>";
foreach ($execution_steps_labels as $cle=>$value){//5
	$test.="<td>".$value."</td>";
}
$test.="</tr>";
// content
foreach($result as $key=>$value){


$status=$lg_execution_status[$result[$key]['exp_status']];

$test.="<tr><td>".$result[$key]['sc_step_id']."</td><td>".$result[$key]['sc_step_action']."</td><td>".$result[$key]['sc_step_expected']."</td><td>".$result[$key]['exp_obtained']."</td><td>".$status."</td></tr>";// translate exp_status - $result[$key]['exp_status']
}
// footer data
$test.="<tr>";
foreach ($execution_steps_labels as $cle=>$value){//5
	$test.="<td>".$value."</td>";
}
$test.="</tr>";
// footer for all
$test.="</table>";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");
echo $test;
?>