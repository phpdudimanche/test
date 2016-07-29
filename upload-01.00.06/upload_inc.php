	<?php
/* UPDATE 12-12-05
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
require_once("../config.php");
require_once("upload_config.php");
//require_once(ROOT."/".CORE."/lib_Mysql.php");
	$result = str_replace('/'.UPLOAD.'/','', ROOT);//in root, sustract current directory
if (stripos(ROOT, SCENARIO)!==FALSE) { // used by SCENARIO NEW
	$result = str_replace('/'.SCENARIO.'/','', ROOT);
}
	require_once($result."/".CORE."/lib_Mysql.php");
	require_once($result."/".CORE."/lib_Common.php");// head
	require_once($result."/".CORE."/lib_Pagination.php");
//$conn = mysql_connect($host, $user, $pass) or die(mysql_error());
//mysql_select_db($database) or die(mysql_error());
$conn=connect();
//$_FILES['wantedfile']['tmp_name']='';
//$_FILES['wantedfile']['name']='';

class Upload {
	//private $TempName="";
	//private $OriginalName="";
	//$_FILES['wantedfile']=array();

function __construct(){
	//$_FILES['wantedfile']['tmp_name']="";
	//$_FILES['wantedfile']['name']="";
	//$this->TempName = $_FILES['wantedfile']['tmp_name'];
	//$this->OriginalName = $_FILES['wantedfile']['name'];
}

function display_the_media($data){// double with category_inc.php : TODO put this in common function
global $directory, $opt_upload_scenario;// from upload_config.php
			//echo $category['doc'];
			foreach($data as $key=>$value){
			$sub_value=explode (":",$value);
echo "<a href=".$directory;// open in a new window
			//echo "id".$key."-";// .$value;."<br />";
			//echo "name ".$sub_value[0]."-";
			echo $sub_value[0];
echo " target=_blank>";
				$sub_value[1]!=""?$sub_value[1]=$sub_value[1]:$sub_value[1]=$opt_upload_scenario;// $opt_upload_scenario or other : TODO : detect appli
						//echo "label ".$sub_value[1];// ."-"
						echo $sub_value[1];
echo "</a>";
			//echo "extension ".$sub_value[2];
			//echo "<br />";
			echo " - ";
			}
}

function display_form(){
global $upload_the_label,$upload,$lg_upload_select;
	echo "<form method='POST' enctype='multipart/form-data' action='upload_form_act.php' name='formulaire'>";
	echo "<div align='left'><font face='Arial, Helvetica, sans-serif' size='2' color='black'>";
	echo "$upload_the_label : <input type='file' name='wantedfile' value=\"'$lg_upload_select'\">";
	echo "<input type='submit' value='$upload'>";
}

function display_form_choice($page_act){// NEW
global $upload_the_label,$upload,$lg_upload_select;
	echo "<form method='POST' enctype='multipart/form-data' action='$page_act' name='formulaire'>";
	echo "<div align='left'><font face='Arial, Helvetica, sans-serif' size='2' color='black'>";
	echo "$upload_the_label : <input type='file' name='wantedfile' value=\"'$lg_upload_select'\">";
	echo "<input type='submit' value='$upload'>";
}

function display_authorised_extension(){
	global $extensions_authorised,$format_file;
	echo $format_file."<br />";
	foreach ( $extensions_authorised as $value){
		echo $value." - ";
	}
}

function display_authorised_extension_choice($extensions){// NEW
	global $format_file;
	echo $format_file."<br />";
	foreach ( $extensions as $value){
		echo $value." - ";
	}
}

function verify_extension(){
	$original_file = $_FILES['wantedfile']['name'];
	//echo $original_file;
$extension=$this->get_extension($original_file);
$authorised=$this->authorised_extension($extension);
return $authorised;
	//echo $extension;
	/*if($authorised==FALSE){
		echo "ERROR";
	}*/
	}

function verify_extension_db(){
	$original_file = $_FILES['wantedfile']['name'];
	//echo $original_file;
$extension=$this->get_extension($original_file);
$authorised=$this->authorised_extension($extension);
$result['extension']=$extension;
$result['authorised']=$authorised;//0 FALSE, 1 TRUE
//return $authorised;
	//echo $extension;
	//print_r($result);
	return($result);
	}

function get_extension($file_name){// last element
	$extension = strrchr($file_name, '.');
	//$extension=$_FILES['wantedfile']['type'];// image/jpeg
	//echo $extension;
	return $extension;
	}

function authorised_extension($extension){// TODO : the max file size should be different by format file
global $extensions_authorised;
	if(!in_array($extension, $extensions_authorised)){
	return FALSE;
	}
	else{
	 return TRUE;
	}
}
//----- FOR REUSE
function verify_extension_db_choice($ext_authorized){
	$original_file = $_FILES['wantedfile']['name'];
	//echo $original_file;
$extension=$this->get_extension($original_file);
$authorised=$this->authorised_extension($extension,$ext_authorized);
$result['extension']=$extension;
$result['authorised']=$authorised;//0 FALSE, 1 TRUE
//return $authorised;
	//echo $extension;
	//print_r($result);
	return($result);
	}

function authorised_extension_choice($extension,$ext_authorized){// TODO : the max file size should be different by format file
//global $extensions_authorised;
	if(!in_array($extension, $ext_authorised)){
	return FALSE;
	}
	else{
	 return TRUE;
	}
}
//---- 
function display_size($taille){// http://www.commentcamarche.net/forum/affich-55146-renvoyer-taille-fichier-php
	if ($taille >= 1073741824)
		{$taille = round($taille / 1073741824 * 100) / 100 . " Go";}
	elseif ($taille >= 1048576)
		{$taille = round($taille / 1048576 * 100) / 100 . " Mo";}
	elseif ($taille >= 1024)
		{$taille = round($taille / 1024 * 100) / 100 . " Ko";}
	else
		{$taille = $taille . " o";}
	if($taille==0)
		{$taille="NULL";}
		echo $taille;
}

function authorised_size(){
global $size_authorised;
	$actual_size=$_FILES['wantedfile']['size'];
	//echo $actual_size. " octets";
		if($actual_size<=$size_authorised)
	{
		return TRUE;
	//return $actual_size;
	}
	else{
		return FALSE;
	}
}

function authorised_size_db(){
global $size_authorised;
	$actual_size=$_FILES['wantedfile']['size'];
$result['size']=$actual_size;
		if($actual_size<=$size_authorised)
	{
$result['authorised_size']=TRUE;
		//return TRUE;
	//return $actual_size;
	}
	else{
$result['authorised_size']=FALSE;
		//return FALSE;
	}
return($result);
//print_r($result);
}

function rename_file($temporary,$original,$object,$id,$final){
	if ($final =="") {
		// execute a rule
		$extension=$this->get_extension($original);
		$final=$object."_".$id."_".time()."".$extension;
		//echo $final;
		//exit();//$authorised=$this->authorised_extension($extension);
		//$final=$object."_".$id."".$extension;
		}
	else {
		$final=$final;
	}
	return $final;
	}

function upload_file($object,$id,$final){//nothing to put in variable
global $directory;
	$tmp_file = $_FILES['wantedfile']['tmp_name'];
	$original_file = $_FILES['wantedfile']['name'];
	if(is_uploaded_file($tmp_file))
	{
		//echo "temporary name : ".$tmp_file."<br />";
		//echo "original name : ".$original_file."<br />";// has extension
		$name=$this->rename_file($tmp_file,$original_file,$object,$id,$final);

			if(move_uploaded_file($tmp_file, $directory . $name)) // TRUE = OK
			{
				return TRUE;
			}
			else{
				return FALSE;
			}
		//echo $name;
		//exit("Le fichier est trouvé");
	}
	else{
		return FALSE;
	}
}

function upload_file_db($object,$id,$final){//nothing to put in variable
global $directory;
	$tmp_file = $_FILES['wantedfile']['tmp_name'];
	$original_file = $_FILES['wantedfile']['name'];
	if(is_uploaded_file($tmp_file))
	{
		//echo "temporary name : ".$tmp_file."<br />";
		//echo "original name : ".$original_file."<br />";// has extension
		$name=$this->rename_file($tmp_file,$original_file,$object,$id,$final);
		//echo "name is ".$name;
$result['name']=$name;
			if(move_uploaded_file($tmp_file, $directory . $name)) // TRUE = OK
			{
				$result['move']=TRUE;
				//return TRUE;
			}
			else{
				$result['move']=FALSE;
				//return FALSE;
			}
		//echo $name;
		//exit("Le fichier est trouvé");
	}
	else{
		//return FALSE;
		$result['move']=FALSE;
	}
	return($result);
	//print_r($result);
}

function list_upload_file_db($object,$id,$begin,$steps_by_page){
global $upload_table,$upload_number,$upload_object,$upload_id;
//$begin=0;$steps_by_page=1;
//echo 'id equals to '.$id;
	$query ="SELECT * FROM $upload_table ";
if ($id!="all"){
	$query.="WHERE  $upload_number=$id ";
}
else{
	$query.="WHERE  $upload_number!='' ";
}
if ($object!="all"){
	$query.="AND $upload_object='$object' ";// OPTION
}
	$query.="ORDER BY $upload_id";
	//print_r($query);
//$query2 = mysql_query($query);
//$total = mysql_num_rows($query2);// total for pagination

$query2 = query_retrieve($query);
$total = mysqli_num_rows($query2);
//echo "total ".$total;		
	$query.=" LIMIT $begin,$steps_by_page";
	//print_r($query);
	//$query = mysql_query($query);
	$query =query_retrieve($query);
	return array($query,$total);// two returns by this way
	}

function output_upload_file_db($query){
//global $upload_number,$upload_label,$upload_name,$upload_extension;
	$array_doc = array ();
	//while($row = mysql_fetch_assoc($query)){// upload_name upload_label upload_extension upload_object
	while($row = mysqli_fetch_assoc($query)){
	$array_doc[$row['upload_id']]=output($row['upload_name']).':'.output($row['upload_label']).':'.output($row['upload_extension']).':'.output($row['upload_object']);
	//$i++;
	}
	return $array_doc;
}

function form_update_db($result){
global $update,$lg_upload_form_labels,$directory;
		echo "<form method=\"POST\" action=\"upload_list_act.php\" name=\"upload_list\" id=\"upload_list\">";
		echo "<table><input type=\"submit\" value=\"$update\">\r\n\r\n";

		/*echo "<THEAD><TR>";//HEADER
		echo "<TH>ID</TH><TH>name</TH><TH>label</TH><TH>delete</TH>";
		echo "</TR></THEAD>\r\n\r\n";*/


		echo "<THEAD><TR>";//HEADER
			foreach ($lg_upload_form_labels as $cle=>$value){
		echo "<TH>".$value."</TH>";
			}
		echo "</TR></THEAD>\r\n\r\n";



	foreach ($result as $key=>$value){
	//$i++;
	//echo "data ".$i;
		$sub_value=explode (":",$value);
		list($name,$label,$extension,$object)=$sub_value;
		//echo $sub_value[0];
		echo "<tr>";
		echo "<td>".$key."</td>";
		echo "<td><a href='upload_file_form.php?id=".$key."&name=".$name."&object=".$object."'>".$name."</a></td>";// NEW
		echo "<td><input type=\"text\" value=\"$label\" name=\"label[$key]\" size=\"50\" id=\"label\" /></td>";//
		echo "<td><input type=\"checkbox\" name=\"delete[$key]\" id=\"media_delete\" value=\"true\"></td>";
		echo "<td>";
	$file='<a href='.$directory.''.$name.' target="_blank">go</a>';
	echo $file;
		//display_the_media()
		echo "</td>";
		echo "</tr>";
	}

			/*echo "<TFOOT><TR>";//FOOTER
			echo "<TD>ID</TD><TD>name</TD><TD>label</TD><TD>delete</TD>";
			echo "</TR></TFOOT>\r\n\r\n";*/

		echo "<TFOOT><TR>";//FOOTER
			foreach ($lg_upload_form_labels as $cle=>$value){
		echo "<TD>".$value."</TD>";
			}
		echo "</TR></TFOOT>\r\n\r\n";

			echo "</table><input type=\"submit\" value=\"$update\"></form>\r\n\r\n";
}

}
?>