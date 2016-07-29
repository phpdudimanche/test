<?php
/* UPDATE 12-03-21

   Array
   (

   [1] => Array
   (
   [exp_id] => 9
   [step_obtained] => crer
   [step_status] => 2
   )

   [2] => Array
   (
   [exp_id] => 10
   [step_obtained] =>
   [step_status] => null
   )

   )

*/
require_once("execution_inc.php");
isset($_REQUEST["steps"])?$steps=$_REQUEST["steps"]:$steps="";

if ($execution_debug==1)
{
echo "<pre>";
print_r($steps);
echo "</pre>";
}

foreach($steps as $key=>$value)
{
$id=$steps[$key]['exp_id'];
$obtained=$steps[$key]['step_obtained'];
$status=$steps[$key]['step_status'];

	$query="UPDATE $execution_step_table SET $execution_step_obtained='$obtained', $execution_step_status=$status WHERE $execution_step_id='$id'";
	//echo $query;
	//echo $id."<br />";
	//$update=mysql_query($query) or die(mysql_error());
	$query=query_record($query);
}

// TODO redirect to referer page : http://www.php.net/manual/fr/reserved.variables.server.php
header('location:'.$_SERVER['HTTP_REFERER'].'');// include : 'QUERY_STRING' 'SCRIPT_NAME' 
?>