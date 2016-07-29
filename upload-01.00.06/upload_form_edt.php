<?php
/* 12-11-19
   Upload class, what for :
   upload lots of type of files (USER PARAM : list of authorized files, param by application)
   move file of tmp directory to final directory (USER PARAM : final directory)
   rename file if necessary (USER PARAM, rename yes or no, forced name, renamde by rule
   delete file of server
   display file by type of files
   Class extension for database :
   insert file name, extension, size, dimensions in database
   insert in relation table
   */
	session_start();
require_once("upload_inc.php");
// get params : object_type,object_id
isset($_REQUEST["object_type"])?$object_type=input($_REQUEST["object_type"]):$object_type="";
isset($_REQUEST["object_id"])?$object_id=input($_REQUEST["object_id"]):$object_id="";
isset($_REQUEST["object_name"])?$object_name=input($_REQUEST["object_name"]):$object_name="";
	$_SESSION['object_type']=$object_type;
	$_SESSION['object_id']=$object_id;

head($upload_list_edt_title,$upload_design,'../public/'.$general_js.'',$upload_favico);// specific
include('../public/_header.php');// specific

echo '<br /><a href="'.$_SERVER['HTTP_REFERER'].'">'.$lg_back.'</a><br /><br />';
echo $form_title."".$object_type ." id ".$object_id." : <i>".$object_name."</i><br />";//"upload media for "

$MyUpload = new upload();
$MyUpload->display_authorised_extension();
echo "<br />";
echo $max_size;
$MyUpload->display_size($size_authorised);
$MyUpload->display_form();

include('../public/_footer.php');// specific
?>