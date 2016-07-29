<?php
/* UPDATE 12-11-03
   Verify if there is a session : update_array.
   Yes, update data.
   Location to "scenario_steps_create_act.php"
*/
session_start();
require_once("scenario_inc.php");
isset($_SESSION['result'])?$todo=$_SESSION['result']:$todo=='';
//print_r($_SESSION['result']);
if (isset($todo['update'])){// no array update
$count = count($todo['update']);

if ($scenario_debug==1)
{
	echo "<pre>";
	echo "update :";
	print_r($todo['update']);
	echo "number of array in array : ".$count;
	echo " <a href='scenario_steps_create_act.php'>then create</a>";
	echo "</pre>";
}
						
if ($todo['update']!=0)
{
	foreach($todo['update'] as $key=>$value)
	{
	//echo "update this element : ".$todo['update'][$key]['step_order']."<br />";

$id=input($todo['update'][$key]['step_id']);
$action=input($todo['update'][$key]['step_action']);
$expected=input($todo['update'][$key]['step_expected']);
$order=input($todo['update'][$key]['step_order']);	
	
	/*$update=mysql_query("UPDATE $scenario_table SET $scenario_step_order = '$order',$scenario_step_action = '$action',  $scenario_step_expected = '$expected'
 WHERE $scenario_step_id = '$id'") or die(mysql_error());*/
$update=query_record("UPDATE $scenario_table SET $scenario_step_order = '$order',$scenario_step_action = '$action',  $scenario_step_expected = '$expected'
 WHERE $scenario_step_id = '$id'");
	
	}
}
							}// no array upadte
header('location:scenario_steps_create_act.php');
?>