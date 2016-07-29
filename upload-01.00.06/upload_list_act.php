<?php
/* UPDATE 12-10-15
trait the listing form : retrieve array, redirect to update, delete, then listing
*/
require_once("upload_inc.php");
isset($_REQUEST["label"])?$label=$_REQUEST["label"]:$label="";
isset($_REQUEST["delete"])?$delete=$_REQUEST["delete"]:$delete="";
session_start();// to transmit data
$_SESSION['label']=$label;
$_SESSION['delete']=$delete;
$_SESSION['referer']=$_SERVER['HTTP_REFERER'];
if ($upload_debug==1)
{
	echo "<pre>";
	echo "1/ Update :";
	print_r($label);
	echo "2/ Delete :";
	print_r($delete);		
	echo "</pre>";
	echo "referrer :";
	echo $_SERVER['HTTP_REFERER'];// possibly wrong with hacker
}
header('location:upload_list_update.php');
?>