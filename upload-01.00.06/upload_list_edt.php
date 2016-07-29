<?php
/* UPDATE 12-11-25
   What for :
   list media(s) for : object_id, object_type
   each element has : name, label, extension
   each data has :
   delete file of server
   */
	session_start();
require_once("upload_inc.php");
// get params : object_type,object_id
isset($_REQUEST["object_type"])?$object_type=input($_REQUEST["object_type"]):$object_type="";
isset($_REQUEST["object_id"])?$object_id=input($_REQUEST["object_id"]):$object_id="";
isset($_REQUEST["object_name"])?$object_name=input($_REQUEST["object_name"]):$object_name="";
	$_SESSION['object_type']=$object_type;
	$_SESSION['object_id']=$object_id;
isset($_REQUEST["begin"])?$begin=$_REQUEST["begin"]:$begin=0;// for pagination
head($upload_list_edt_title,$upload_design,'../public/'.$general_js.'',$upload_favico);// specific
include('../public/_header.php');// specific

echo '<br /><a href="'.$_SERVER['HTTP_REFERER'].'">'.$lg_back.'</a><br /><br />';
echo $list_title."".$object_type ." id ".$object_id." : <i>".$object_name."</i>";
 echo " <br />";//"update all media for "
 
$MyUpload = new upload();

//echo 'id equals to '.$object_id;
$steps_by_page=$upload_list_number;
$query=$MyUpload->list_upload_file_db($object_type,$object_id,$begin,$steps_by_page);
$link='upload_list_edt.php?&object_id='.$object_id.'&object_type='.$object_type;
$total= $query[1];
$result=$MyUpload->output_upload_file_db($query[0]);// add upload_object
if ($upload_debug==1)
{
	echo "<pre>";
	print_r($result);
	echo "</pre>";
}

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

include('../public/_footer.php');// specific
?>


</body></html>