<?php
session_start();// get session
isset($_SESSION['todo'])?$todo=$_SESSION['todo']:$todo=='';

require_once("category_inc.php");
//echo "Location:../".SCENARIO."/category_steps_delete_act.php";
/*echo "<pre>";
print_r($todo);
echo "</pre>";
exit();
*/
//exit();
foreach ($todo as $cle=>$value ){// execute query
//mysql_query("DELETE FROM $category_table WHERE $category_id	 = ".$value) or die(mysql_error());
query_record("DELETE FROM $category_table WHERE $category_id = ".$value);
}

//header("Location:category_list_edt.php");// go to final page
// TODO if category is used with scenario, go to category_steps_delete_act.php (different as scenario_steps_delete_act.php, the redirection is different)
header("Location:../".SCENARIO."/category_steps_delete_act.php");
?>