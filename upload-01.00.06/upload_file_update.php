<?php // UPDATE 12-11-25
require_once("upload_inc.php");
isset($_POST['name'])?$name=$_POST['name']:$name=='';
isset($_POST['id'])?$id=$_POST['id']:$id=='';
isset($_POST['object'])?$object=$_POST['object']:$object=='NONE';

$MyUpload = new upload();// class
$final="";
$extension=$MyUpload->verify_extension_db();
$size=$MyUpload->authorised_size_db();// verify_size
	$the_extension=$extension['extension'];
	$the_size=$size['size'];
//echo $the_extension." - ".$the_size;
//exit();
if ($extension['authorised']==0) {// add this last function in class and put here only one function : $extension==FALSE
//echo "ERROR !";
//echo $lg_upload_extension;
//exit();
}
elseif($size['authorised_size']==0){// $extension!=FALSE AND : $size==FALSE
//echo "ERROR !";
//echo $lg_upload_size;
//exit();
//echo $size;
}
else{ // NEW begin
	if ($final==""){// if the form is used without relation with any module
	} // NEW end
	//echo "final ". $final;
//exit();
$success=$MyUpload->upload_file_db($object,$id,$final);// just upload file
	//print_r($success);
if (file_exists($directory.$name)){
unlink($directory.$name);// delete file on server
}	
	$the_name=$success['name'];
	//echo " - ".$the_name;
	//exit();
/// NEW : update and not insert
$query="UPDATE $upload_table SET $upload_name='$the_name', $upload_extension='$the_extension', $upload_size=$the_size 
WHERE $upload_id=$id";
//echo $query;
//exit();
$query=mysql_query($query)or die(mysql_error());
header('location:index.php');// to more possibility for the firsyt referrer
}
?>
