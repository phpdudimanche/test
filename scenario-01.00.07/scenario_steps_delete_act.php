<?php
/*
UPDATE 12-10-10
   Verify if there is a session : delete_array.
   Yes, delete data.
   Location to "scenario_steps_update_act.php"
*/
session_start();
require_once("scenario_inc.php");
isset($_SESSION['result'])?$todo=$_SESSION['result']:$todo=='';
	if (isset($todo['delete'])){
	$count = count($todo['delete']);
	}
	else {
	$todo['delete']=0;
	}
$count = count($todo['delete']);
if ($scenario_debug==1)
{
	echo "<pre>";
	echo "delete :";
	print_r($todo['delete']);
	echo "number of array in array : ".$count;
	echo " <a href='scenario_steps_update_act.php'>back to form</a>";
	echo "</pre>";
	exit();
}

if ($todo['delete']!=0)
{
	foreach($todo['delete'] as $key=>$value)
	{
	
$id=input($todo['delete'][$key]['step_id']);//DELETE FROM category WHERE category_id = ".$value
//$query = mysql_query("DELETE FROM $scenario_table WHERE $scenario_step_id =".$id)or die(mysql_error());
$query=query_record("DELETE FROM $scenario_table WHERE $scenario_step_id =".$id);
	}
}

header('location:scenario_steps_update_act.php');
?>