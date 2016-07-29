<?php
/*
UPDATE 12-10-10
   Verify if there is a session : create_array.
   Yes, create data.
   Location to "scenario_steps_create_act.php"
*/
session_start();
require_once("scenario_inc.php");
isset($_SESSION['result'])?$todo=$_SESSION['result']:$todo=='';
	if (isset($todo['create'])){
$count = count($todo['create']);
	}
isset($_SESSION['increment'])?$increment=$_SESSION['increment']:$increment==0;// for redirection
isset($_SESSION['scenario'])?$scenario=$_SESSION['scenario']:$scenario=='';
$scenario_id=$scenario['id'];
$scenario_name=$scenario['name'];
if ($scenario_id==''){
	$scenario_name="test";
	$scenario_id=0;
}

if ($scenario_debug==1)
{
	echo "<pre>";
	echo "create :";
		if (isset($todo['create'])){
	print_r($todo['create']);
		}
	echo "number of array in array : ".$count;
	echo " <a href='scenario_steps_list_edt.php'>back to form</a>";
	echo "</pre>";
	exit();
}

if (isset($todo['create']))// $todo['create']!=0   CHANGE  isset($todo['create']) &  $todo['create']!=0         
{
	foreach($todo['create'] as $key=>$value)
	{
	//echo "create this element : ".$todo['create'][$key]['step_action']."<br />";

$action=input($todo['create'][$key]['step_action']);
$expected=input($todo['create'][$key]['step_expected']);
$order=input($todo['create'][$key]['step_order']);
//$query = mysql_query("INSERT INTO $scenario_table ($scenario_step_action,$scenario_step_expected, $scenario_step_order,$scenario_step_scenario_id) VALUES ('$action','$expected','$order','$scenario_id')")or die(mysql_error());
$query=query_record("INSERT INTO $scenario_table ($scenario_step_action,$scenario_step_expected, $scenario_step_order,$scenario_step_scenario_id) VALUES ('$action','$expected','$order','$scenario_id')");
//echo "INSERT INTO $scenario_table ($scenario_step_action,$scenario_step_expected, $scenario_step_order) VALUES ('$action','$expected','$order'";
	//echo $scenario_step_action.",".$scenario_step_expected.",".$scenario_step_order;
	//echo "<br/>".$expected;
	}
}

$togo= "scenario_steps_list_edt.php?&begin=".$increment;// to put on the last page to do redirection
header('location:'.$togo.'');
?>