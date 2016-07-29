<?php
// UPDATE  12-09-08
require_once("upload_inc.php");
session_start();
$object_type='';
$id='';
isset($_SESSION['object_type'])?$object=$_SESSION['object_type']:$object_type=='category';
isset($_SESSION['object_id'])?$id=$_SESSION['object_id']:$id=='002';
/*$tmp_file = $_FILES['file']['tmp_name'];
$original_file = $_FILES['file']['name'];
echo "temporary name : ".$tmp_file."<br />";
echo "original name : ".$original_file."<br />";*/
//$wantedfile=$_FILES['wantedfile'];// Array ( [name] => cb-numero.jpg [type] => image/jpeg [tmp_name] => C:\Users\Julien\AppData\Local\Temp\phpB756.tmp [error] => 0 [size] => 38655 )
//print_r($wantedfile);// $POST['wantedfile']


$MyUpload = new upload();// $wantedfile


//$object="category";// relation with other application
//$id="002";
/*
$object=$object_type;
$id=$object_id;// add an increment 01-99
*/
$final="";

//$extension=$MyUpload->verify_extension();
$extension=$MyUpload->verify_extension_db();
$size=$MyUpload->authorised_size_db();// verify_size
	$the_extension=$extension['extension'];
	$the_size=$size['size'];
//echo $the_extension." - ".$the_size;
//exit();
//to do
if ($extension['authorised']==0) {// add this last function in class and put here only one function : $extension==FALSE
//echo "ERROR !";
echo $lg_upload_extension;
exit();
}
elseif($size['authorised_size']==0){// $extension!=FALSE AND : $size==FALSE
//echo "ERROR !";
echo $lg_upload_size;
exit();
//echo $size;
}
else{ // NEW begin
	if ($final==""){// if the form is used without relation with any module
	//$final=time();//
	} // NEW end
	//echo "final ". $final;
	//exit();
$success=$MyUpload->upload_file_db($object,$id,$final);
	//print_r($success);
	$the_name=$success['name'];
	//echo " - ".$the_name;
	//exit();
// NEW : insert in database with object's type : $the_name $the_extension $the_size
$query="INSERT INTO $upload_table ( $upload_number, $upload_label, $upload_name, $upload_extension, $upload_size, $upload_dimensions, $upload_object)
VALUES ('$id','','$the_name','$the_extension',$the_size,'','$object')"; // ($upload_id,)('',)
//echo $query;
//exit();
//$query=mysql_query($query)or die(mysql_error());
$query=query_record($query);
/*$query = mysql_query("INSERT INTO $upload_table ($upload_id, $upload_number, $upload_label, $upload_name, $upload_extension, $upload_size, $upload_dimensions, $upload_object)
VALUES ('',$id,'','$the_name','$the_extension ',$the_size,'','$object')") or die(mysql_error());// retrieve all fields (a return array)*/

//session_destroy();// doesn't work to unset variables

//session_start();  // YET DONE ?
unset($_SESSION['object_type']);
unset($_SESSION['object_id']);
}


// header ("Location:../".CATEGORY."/category_list_edt.php");//redirection to the referer application PB with second header
?>

<script type="text/javascript">
<!--
window.location = "../<?php echo CATEGORY."/category_list_edt.php";?>"
//-->
</script>

