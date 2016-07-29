<?php
// UPDATE 12-03-21
require_once("execution_inc.php");
isset($_REQUEST["execution_id"])?$execution_id=$_REQUEST["execution_id"]:$execution_id="";// to protect
$query ="UPDATE $execution_scenario_table SET $execution_scenario_end=NOW() WHERE $execution_scenario_id='$execution_id'";
//$update = mysql_query($query)or die(mysql_error());
$update=query_record($query);
header('location:../'.CATEGORY.'/');
?>