<?php
/* UPDATE 12-10-15
update part of array
*/
require_once("upload_inc.php");
session_start();// to retrieve data
isset($_SESSION["label"])?$label=$_SESSION["label"]:$label="";
isset($_SESSION["delete"])?$delete=$_SESSION["delete"]:$delete="";
	if ($upload_debug==1)
	{
		echo "<pre>";
		echo "1/ Update :";
		print_r($label);
		echo "2/ Delete :";
		print_r($delete);		
		echo "</pre>";
	}																																							
foreach($label as $key=>$value)
{
$value=input($value);
$query="UPDATE $upload_table SET upload_label= '$value' WHERE upload_id=$key";// trait even if value is ''. The user may be want to clean.
	if ($upload_debug==1)
	{
	echo $query.'<br />';
	}
//mysql_query($query)or die(mysql_error());
query_record($query);
}
header('location:upload_list_delete.php');
?>