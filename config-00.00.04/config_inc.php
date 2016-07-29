<?php // update 12-12-01
require_once("../config.php");// done like this in each module : so impossible to get from general index
$language=LANG;//$language="fr";// fr french, uk english usualy in config file
require_once("config_lang_".$language.".php");

if (stripos(ROOT, EXECUTION)!==FALSE) { // used by execution_steps_create.php
	$result = str_replace('/'.EXECUTION.'/','', ROOT);
}
/*else if (stripos(ROOT, EXECUTION)!==FALSE)&&(stripos(ROOT,SCENARIO)!==FALSE)&&(stripos(ROOT,CATEGORY)!==FALSE)&&
(stripos(ROOT, UPLOAD)!==FALSE){// NEW
}*/
else{
	$result = str_replace('/'.CONFIG.'/','', ROOT);//in root, sustract current directory ORIGINAL
}
require_once($result."/".CORE."/lib_Common.php");

function display_config_menu($menu_config,$chap){
echo"<ul id=\"menu\">";
$i=0;
foreach($menu_config as $key=>$value){
if($i==$chap){
$class="current";
}
else{
$class="ghost";
}
		echo"<li class=\"menu".$i."\">";
			echo"<a href=\"#\" id=\"_".$i."\" class=\"".$class."\" onclick=\"multiClass(this.id)\" alt=\"menu".$i."\">".$value."</a>";
		echo"</li>";
$i++;
}
echo"</ul>\n\n";
}

function display_config_content($menu_config,$thechap,$cfg,$title_label,$label){// common_tag and label,menu on,config array,translation title,translation label
$i=0;
foreach($menu_config as $key=>$value){
	if($i==$thechap){
	$class="on";
	}
	else{
	$class="off";
	}
//echo " i ".$i." chap ".$thechap." class ".$class."<br />";
$group=$key;
$chap=$i;
		echo"\n\n<div id=\"menu_".$i."\" class=\"".$class." content\">";
			display_config_group($cfg,$title_label,$label,$group,$chap);
		echo "</div>\n\n";
$i++;
}
}

function display_config_group($cfg,$title_label,$label,$group,$chap){
$sep_line="";// "<br />";
$sep_value=" : ";
$sep_code="\n";
global $lg_submit;

echo "<br /><table>";
echo "<form method=\"POST\" action=\"config_act.php?chap=".$chap."\" name=\"".$group."\" id=\"".$group."\">";// cfg_act
		//echo 'category'.$sep_code;
foreach($cfg as $key=>$value){
		if (strstr($key,$group)!=FALSE){// retriev only the group with commun letters		'category_'
//echo $sep_line.$key.$sep_value.$value.$sep_line;
echo "<tr width=300><td>";
			if (isset ($title_label[$key])){
			echo $sep_line.$title_label[$key].$sep_value;// explanation title		
			}
			if (isset ($label[$key])){		
				if (is_array($label[$key])==FALSE){
				echo $label[$key];// text value : display a text form
				echo "<input type=\"text\" value=\"".$value."\" name=\"cfg['".$key."']\" size=\"1\" id=\"cfg['".$key."']\" />".$sep_code;
				}
				else{
				//echo "ARRAY ! cfg['".$key."']";
				//print_r($label[$key]);			
				select_list($label[$key],"cfg['".$key."']",$value);// lov
				echo $sep_code;	
				}
			}
echo "</td></tr>";			
		}
		
}
echo  "<tr><td><input type=\"submit\" value=\"$lg_submit\"></td></tr>";
echo "</table></form>";
}

/* NOT USED */
function display_array_group($array,$group,$label){
global $sep_line,$sep_value;// need to put here : too more ! 
			echo $group.$sep_line;
	foreach($array as $key=>$value){
			if (strstr($key,$group)!=FALSE){
				  if (is_array($label[$key][$value])==FALSE){
				//echo $$key.$sep_value;// for text value of a variable with this name	
					echo $label[$key];// cfg label when text niveau de profondeur à afficher
			echo $key.$sep_value.$value.$sep_line;// cfg data	
													}
													else{
													echo $label[$key];
													}
													
			}
	}
}

/* YET in CORE 
function select_list($array,$name,$selected){

	echo '<select name="'.$name.'" size="1">';
	echo '<option value="null"></option>';// null first
	foreach($array as $key=>$value){
		echo '<option value="'.$key.'"';
		if ($selected==$key) {
			echo 'selected="selected"';
		}
		echo '>';
		echo $value;
		echo '</option>';
	}
	echo '</select>';
}*/


function Edit_ini_file($file , $array){ 

$msg="";

echo "<pre>";
print_r($array);// imput array : values to write
echo "</pre>";

/*
Array
(
    [number] => UPDATE
    [level] => MAJ
    [test] => OK
)
*/	

 // file is here ?
  if(!file_exists($file)): 
  echo "File does not exist "; 
  return false; 
  endif; 
  // read rights
  $fp = fopen ($file, "r"); 
  if(!$fp): 
  echo "Unable to open file"; 
  return false; 
  endif; 
  
  $output=''; 
  
  // read line by line
  while (!feof ($fp)): 
  //read one line, 4k max 
  $tmpline = fgets($fp, 4096); 
  // parse to verify
  $posbegin = strpos($tmpline, "$"); 
  if (!($posbegin === false)): 
  // verify "=" is after "$" 
  $posmiddle = strpos($tmpline, "="); 
  if(($posmiddle) and ($posmiddle > $posbegin)):   
  // verify ";" is after "=" 
  $posend = strpos($tmpline, ";"); 
  if(($posend) and ($posend > $posmiddle)): 
  // everything is OK
  $varname = substr($tmpline, $posbegin+1, $posmiddle - $posbegin-1); 
  $varvalue = substr($tmpline, $posmiddle + 1, $posend - $posmiddle -1); 
  
  // blank space to delete
  $varname = trim($varname); 
  $varvalue = trim($varvalue); 
  
echo "target var in file : ".$varname."<br />";// param['test']
    
  $todelete=array("cfg['","']");// NEW to variabilize : param cfg  numeric with quotes 3->"3"
  $toadd=array("","");  
  $cleanvar = str_replace($todelete, $toadd, $varname);// no more param['...'] TODO preg_replace() with regex
  
echo "var clean yet in file : ".$cleanvar."<br />";
  
   if ($varvalue=='""'){
echo "null value ".$varvalue."<br />";// NULL value has characters
//$varvalue=NULL;
$test="KO";
}
else{
  // delete les " 
  $varvalue = str_replace("\"", "", $varvalue); 
echo "yet value in file : ".$varvalue."<br />";
$test="OK";
}
  
  if (isset($array[$cleanvar])){// NEW
$msg="index array exists in input :";// value to update exists in input
echo $msg."<br />";
echo "value to put in : ".$array[$cleanvar]."<br />";
}// NEW
if ($test=="OK"){
  $tmpline=str_replace($varvalue,$array[$cleanvar], $tmpline);//becareful : doesn't work with NULL value
 }
else{
$tmpline=str_replace($varvalue,'"'.$array[$cleanvar].'"', $tmpline);// ADD " " which have been deleted for NULL value
} 
      
   endif; 
  endif; 
  endif; 
  $output .= $tmpline; 
  endwhile; 
  // close readable file
  fclose($fp); 
  
  // open to write
  $fp = fopen ($file, "w"); 
  if(!$fp): 
  echo "Unable to open file in write mode"; 
  return false; 
  endif; 
  // write
  fwrite($fp, $output); 
   // close witabel file
  fclose($fp); 
  
  //return true; 
}
?>