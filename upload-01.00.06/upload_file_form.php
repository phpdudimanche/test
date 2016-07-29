<?php
/* UPDATE 12-11-25
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
isset($_REQUEST["object"])?$object=input($_REQUEST["object"]):$object="";
isset($_REQUEST["id"])?$object_id=input($_REQUEST["id"]):$object_id="";
isset($_REQUEST["name"])?$object_name=$_REQUEST["name"]:$object_name="";


head($upload_list_edt_title,$upload_design,'../public/'.$general_js.'',$upload_favico);// specific
include('../public/_header.php');// specific

printf($lg_file_update,"<a href='".$directory."".$object_name."' target='_blank'>".$object_name."</a>","<a href=".$_SERVER['HTTP_REFERER'].">","</a>");// display, sprint just output

echo "<br /><br />";
$MyUpload = new upload();
$MyUpload->display_authorised_extension();
echo "<br />";
echo $max_size;
$MyUpload->display_size($size_authorised);
function add($buffer,$replacement)
{
global $object_id,$object_name,$object;
  // replace : add id and change destination file : erase on disk and update on base : not create
  return (ereg_replace("<form method='POST' enctype='multipart/form-data' action='upload_form_act.php' name='formulaire'>","<form method='POST' enctype='multipart/form-data' action='upload_file_update.php' name='formulaire'><input type='hidden' name='id' value='".$object_id."'><input type='hidden' name='name' value='".$object_name."'><input type='hidden' name='object' value='".$object."'>", $buffer));
}
ob_start("add");
$MyUpload->display_form();
ob_end_flush();



include('../public/_footer.php');// specific
?>