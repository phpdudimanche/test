<?php
/* UPDATE 12-10-15
delete part of array
*/
require_once("upload_inc.php");
session_start();// to retrieve data
isset($_SESSION["label"])?$label=$_SESSION["label"]:$label="";
isset($_SESSION["delete"])?$delete=$_SESSION["delete"]:$delete="";
isset($_SESSION["referer"])?$referer=$_SESSION["referer"]:$referer="upload_list_edt.php";
		if ($upload_debug==1)
		{
			echo "<pre>";
			echo "1/ Update :";
			print_r($label);
			echo "2/ Delete :";
			print_r($delete);		
			echo "</pre>";
		}
if ($delete!=''){	
	foreach($delete as $key=>$value)
	{		
	$key=input($key);
	
		$query="SELECT $upload_name FROM $upload_table WHERE $upload_id=$key";
		$query=query_retrieve($query);
		$query=mysqli_fetch_row($query);
		
		if ($upload_debug==1){
		echo "file ".$query[0];
		exit();
		}
		unlink($directory."".$query[0]);
		//echo $directory."".$query[0];exit();
		
		
	$query="DELETE FROM $upload_table WHERE upload_id=$key";// trait even if value is ''. The user may be want to clean.
		if ($upload_debug==1)
		{
			echo $query.'<br />';
		}
	//mysql_query($query)or die(mysql_error());
	query_record($query);

	}
}
else
{
		if ($upload_debug==1)
		{
			echo "nothing to delete : stop here";
		}
}
header('location:'.$referer.'');
?>