<?php
/* UPLOAD 12-11-28
Upload class, what for :
   upload lots of type of files (USER PARAM : list of authorized files, param by application)
   move file of tmp directory to final directory (USER PARAM : final directory)
   rename file if necessary (USER PARAM, rename yes or no, forced name, renamde by rule
   delete file of server
   display file by type of files
   Class extension for database :
   insert file name, extension, size, dimensions in database
   insert in relation table

   index :
   list wwhat exist
   how to group and to sort ?
   by typologie : requirements, prooves... ?
   */
require_once("upload_inc.php");
head($lg_upload_title_01,$upload_design,'../public/'.$general_js.'',$upload_favico);
include('../public/_header.php');
require_once('../config.php');

isset($_REQUEST["object_type"])?$object_type=input($_REQUEST["object_type"]):$object_type="all";
isset($_REQUEST["object_id"])?$object_id=input($_REQUEST["object_id"]):$object_id="all";
isset($_REQUEST["object_name"])?$object_name=input($_REQUEST["object_name"]):$object_name="";
isset($_REQUEST["begin"])?$begin=$_REQUEST["begin"]:$begin=0;// for pagination

/* SIMPLE FORM
$MyUpload = new upload();
$MyUpload->display_authorised_extension();
echo "<br />";
echo $max_size;
$MyUpload->display_size($size_authorised);
$MyUpload->display_form();
*/

$steps_by_page=$upload_list_number;
$MyUpload = new upload();
$query=$MyUpload->list_upload_file_db($object_type,$object_id,$begin,$steps_by_page);
$link='upload_list_edt.php?&object_id='.$object_id.'&object_type='.$object_type;
$total= $query[1];
$result=$MyUpload->output_upload_file_db($query[0]);
if ($upload_debug==1)
{
echo "total ".$total;
	echo "<pre>";
	print_r($result);
	echo "</pre>";
}
if ($total!=0){
// pagination
echo "<div id='pagination'>";
pagination($total, $steps_by_page, $begin, $link);
echo "</div>";
// pagination
$MyUpload->form_update_db($result);// list
// pagination
echo "<div id='pagination'>";
pagination($total, $steps_by_page, $begin, $link);
echo "</div>";
// pagination
}
include('../public/_footer.php');
?>