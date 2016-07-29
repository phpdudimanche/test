<?php
// UPDATE 12-10-10
require_once("scenario_inc.php");
require_once("../".CATEGORY."/category_inc.php");// ANO 101 before : $category."category_inc.php"
isset($_REQUEST["cat_id"])?$scenario_id=$_REQUEST["cat_id"]:$scenario_id=0;
isset($_REQUEST["cat_name"])?$scenario_name=$_REQUEST["cat_name"]:$scenario_name="test";


/* control if id has children, and get children : function category

*/

$result=category_children($scenario_id);//array of categories
//print_r($result);
$total=count($result);
//	echo $total;

/*foreach($result as $key=>$value){
echo $value[0]." - ".$value[1]." <br />";
}*/

//exit();
	if ($total!=0){
//	echo "yes";// multiple

// header for multiple
$file="scenario_$scenario_id.xls";// TODO add scenario name without space quote accent
$test="<table border=1>";
$test.="<tr><td>".$scenario_id."</td><td colspan=2 ><b>".$scenario_name."</b></td></tr>";//TODO if there is something, dispaly steps !

foreach($result as $key=>$value){
//echo $value." - ";// get the scenario-id
	$test.="<tr><td colspan=3 ></td></tr>";
	$test.="<tr><td>".$value[0]."</td><td colspan=2 ><b>".$value[1]."</b></td></tr>";
	$test.="<tr><td><i>".$scenario_steps_labels[sc_step_id]."</i></td><td><i>".$scenario_steps_labels[sc_step_action]."</i></td><td><i>".$scenario_steps_labels[sc_step_expected]."</i></td></tr>";// get fields of config "<tr><td><i>id</i></td><td><i>action</i></td><td><i>expected</i></td></tr>"
			//$query = mysql_query("SELECT * FROM $scenario_table WHERE $scenario_step_scenario_id=$value[0] ORDER BY $scenario_step_order");
			$query ="SELECT * FROM $scenario_table WHERE $scenario_step_scenario_id=$value[0] ORDER BY $scenario_step_order";
			$query=query_retrieve($query);
			$result=output_query_scenario($query, $scenario_step_id);
			foreach($result as $key=>$value){
				//echo $key." ligne <br/>";
				//echo "value ".$result[$key]['sc_step_action']." <br/>";
				$test.="<tr><td>".$result[$key]['sc_step_id']."</td><td>".$result[$key]['sc_step_action']."</td><td>".$result[$key]['sc_step_expected']."</td></tr>";
			}
}

	}
	else {
//	echo "no";// simple
// header for simple
		$file="scenario_$scenario_id.xls";
		$test="<table border=1>";
		$test.="<tr><td>".$scenario_id."</td><td colspan=2 ><b>".$scenario_name."</b></td></tr>";

		//$query = mysql_query("SELECT * FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id ORDER BY $scenario_step_order");
		$query="SELECT * FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id ORDER BY $scenario_step_order";
		$query=query_retrieve($query);
		$result=output_query_scenario($query, $scenario_step_id);

		$test.="<tr><td><i>".$scenario_steps_labels['sc_step_id']."</i></td><td><i>".$scenario_steps_labels['sc_step_action']."</i></td><td><i>".$scenario_steps_labels['sc_step_expected']."</i></td></tr>";// get fields of config <tr><td><i>id</i></td><td><i>action</i></td><td><i>expected</i></td></tr>

		foreach($result as $key=>$value){
			//echo $key." ligne <br/>";
			//echo "value ".$result[$key]['sc_step_action']." <br/>";
			$test.="<tr><td>".$result[$key]['sc_step_id']."</td><td>".$result[$key]['sc_step_action']."</td><td>".$result[$key]['sc_step_expected']."</td></tr>";
		}


	}


// footer for all
$test.="</table>";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");
echo $test;


/*
$query = mysql_query("SELECT * FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id ORDER BY $scenario_step_order");
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
*/
?>