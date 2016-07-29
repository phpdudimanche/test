<?php
/*
 the referrer page is category/category_delete_act.php
 for each category, delete steps
 then redirect to category/category_list_edt.php
*/
session_start();// get session
isset($_SESSION['todo'])?$todo=$_SESSION['todo']:$todo=='';
require_once("scenario_inc.php");
	if ($scenario_debug==1)
	{
	echo "<pre>";
	print_r($todo);
	echo "</pre>";
	exit();
	}
foreach ($todo as $cle=>$value ){// execute query
	//mysql_query("DELETE FROM $scenario_table WHERE $scenario_step_scenario_id = ".$value) or die(mysql_error());
	query_record("DELETE FROM $scenario_table WHERE $scenario_step_scenario_id = ".$value);
}
header("Location:../".CATEGORY."/category_list_edt.php");

?>