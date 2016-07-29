<?php
require_once("scenario_inc.php");
isset($_REQUEST["cat_id"])?$scenario_id=$_REQUEST["cat_id"]:$scenario_id=0;
isset($_REQUEST["cat_name"])?$scenario_name=$_REQUEST["cat_name"]:$scenario_name="test";

//$query = mysql_query("SELECT * FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id ORDER BY $scenario_step_order");
$query="SELECT * FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id ORDER BY $scenario_step_order";
$result=output_query_scenario($query, $scenario_step_id);
if ($scenario_debug==1)
{
	echo "all fields of the scenario";
	echo "<pre>";
	print_r($result);
	echo "</pre>";

}

$file="scenario_$scenario_id.xls";
$test="<table border=1>";
$test.="<tr><td>".$scenario_id."</td><td colspan=2 ><b>".$scenario_name."</b></td></tr>";
$test.="<tr><td><i>id</i></td><td><i>action</i></td><td><i>expected</i></td></tr>";// get fields of config

 	foreach($result as $key=>$value){	
		//echo $key." ligne <br/>";
				//echo "value ".$result[$key]['sc_step_action']." <br/>";
$test.="<tr><td>".$result[$key]['sc_step_id']."</td><td>".$result[$key]['sc_step_action']."</td><td>".$result[$key]['sc_step_expected']."</td></tr>";				
	}

$test.="<tr><td><i>id</i></td><td><i>action</i></td><td><i>expected</i></td></tr>";
$test.="</table>";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");
echo $test;	

?>