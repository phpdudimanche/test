<?php // UPDATE 12-11-26
/* scenario_steps_import_csv.php
Have a form before
Format with header to display :  category;category;action;expected
Control the header names fields are correct
If category is 'alpahabetic' create category, else if 'numeric' rely to existant category, else no category
Control to have just one category with 'numeric' (do not indicate parent)
*/
require_once("scenario_inc.php");
require_once("../".CATEGORY."/category_inc.php");
require_once("../".UPLOAD."/upload_config.php");
// Have a form before : test : article de test tentative 11 
$parent_id=0;
$filename = $directory.'import.csv';// $directory comes from upload_config.php

if (file_exists($filename)) {// test existence file

	$fisopen = fopen("$filename", "r");// open file
	$breakline = chr(13).chr(10);
	$tocount=file($filename);
	$totallines=count($tocount);	
	$line=0;
	$error=0;
	$old_string=array();
	$tab=array();
	$old=array();
	$log="";
	
	
$log .="The file ".$filename." exists /<br/>";
$log .="The file contains ".$totallines." lines.<br />";	
	
while (!feof($fisopen))// loop each line
{
	$line++;
	$current_line = fgets($fisopen,1024); // lecture ligne
	$array_result = explode(";",trim($current_line));
	$totalfields = count($array_result);
	$log .="The <b>line ".$line."</b> contains  ".$totalfields." fields.<br />";
	$totalfields--;
	
	switch ($line)
	{
	//----------------------------- HEADER --------------------------------
	case 1:// control header : line 1 two last positions (and the others in a loop)
	//echo $array_result[$totalfields];
	if (strpos($array_result[$totalfields],'expected')===0){
	$log .="expected is present on the right position <br />";
	}
	else{
		$error++;
		}
	if (strpos($array_result[$totalfields-1],'action')===0){
	$log .="action is present on the right position <br />";
	}
	else{
		$error++;
		}
	$begin=$totalfields-2;
	//echo $begin."<br />";
	for ($here=$begin;$here>=0;$here--){// DESC
	//echo $here;
		if (strpos($array_result[$here],'category')===0){
		$log .="category level ".$here." is present on the right position <br />";
		}
		else{
			$error++;
			}
	//echo $here." : ".$array_result[$here]."<br />";
	}
		if ($error!=0){
		echo "There are ".$error." errors. <br />";
		}
	break;
	//---------------------------- CONTENT -------------------------------
	default:
	// test if category is numeric or alphabetic or null
	// put last_id : id number / or last insert
	$last_id=0;// to reset : but ...
		for ($here=0;$here<=$begin;$here++){
if ($here===0){// for the first loop : equals to : $parent_id
$last_id=$parent_id;
}
		
			if (ctype_digit($array_result[$here])){// ASC	
			$the_last_id=$array_result[$here];
			$log .=$array_result[$here].", field ".$here." is digit.<br />";// rely
			$log .="his parent id is ".$last_id.".<br />";
			}
			elseif ($array_result[$here]==NULL){
			$log .=$array_result[$here].", field ".$here." is null.<br />";
			}
			else{
			$log .=$array_result[$here].", field ".$here." is string<br />";
				$tab[0]=$array_result[$here];
			isset($old_string[$here])?$old=$old_string[$here]:$old=array();// use $old=array() VS non array in intersect
				//$old=$old_string[$here];
			//if (isset($old_string[$here])){	
			
			//}
			//echo $here." - ";
				//$result=array_intersect($tab,$old_string);// _assoc with key ; NULL without key
			$result=array_intersect($tab,$old);// ---------------------- $tab = now / $old = before
				//$log.="old means : ".$old."<br />";
				if ($result!=NULL){// same name for same level
				// and about same name for level superior
				$log .="<u> and yet exists</u><br />";				
				$key=array_search($array_result[$here],$old_string);
				$log .=" result is the key ".$key."<br />";
				$log .=" so, existant id is ".$old_id[$key]."<br />";
				$last_id=$old_id[$key];// retrieve
				}
				else{
			$the_last_id=$array_result[$here];// last insert id to retrieve
			//$old_string[]=$array_result[$here];// create : add also the id : $old_id with the same key !
		$old_string[$here][]=$array_result[$here];// an array by field ---------------------
		
		// detect : last place = begin
				if($here==$begin){
				$log .="last place !<br />";
				$log .="so parent is field behind nammed : ".$array_result[$here-1]."<br />";
				$log .="and, existant id of parent	 is ".$old_id[$here-1]."<br />";
				}
		
			// required : parent_id (from action is wanted) : $category_order, $orderby
			$array_result[$here]=input($array_result[$here]);
			$query="INSERT INTO $category_table ($category_parent_id, $category_label)VALUES ($last_id, '$array_result[$here]')";
			$query = mysql_query($query)or die(mysql_error());	
			$the_last_id=mysql_insert_id();// just for autoincrement : for scenario steps*/
			//$old_id[]=$the_last_id;// $old_id with the same key !
		$old_id[$here][]=$the_last_id;// an array by field --------------------- 
		echo "<br />";
				}
			//$log .=".<br />";// create then retrieve lastinsertid  for next field	
			$log .="his parent id is ".$last_id.".<br />";			
			}
		$last_id=$the_last_id;// to stock
		}
		$log .="action content is : ".$array_result[$totalfields-1].".<br />";
		$log .="expected content is : ".$array_result[$totalfields].".<br />";	// $scenario_step_order ,'$order'
// required : scenario id (created or retrieved) : $last_id	
$action=$array_result[$totalfields-1];	
$query = "INSERT INTO $scenario_table ($scenario_step_action,$scenario_step_expected, $scenario_step_scenario_id) 
VALUES ('$action','$array_result[$totalfields]','$last_id')";
$query = mysql_query($query)or die(mysql_error());
		
	break;	
	}
}
	if ($scenario_debug==0)
	{	
/*echo "<pre>";
echo "string for same level<br />";
print_r($old_string);
echo "id for level<br />";
print_r($old_id);
echo "<pre />";*/
	echo $log."<br />";	
	}
}
else {
echo "No file ".$filename." found.";
}
?>