<?php // UPDATE 12-12-27
$file="config_data.php";

if (get_magic_quotes_gpc()) {// hack if the host used magic quotes
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}
   
isset($_REQUEST["cfg"])?$cfg=$_REQUEST["cfg"]:$cfg="";
isset($_REQUEST["chap"])?$chap=$_REQUEST["chap"]:$chap="0";

config_write($file,$cfg);
header ("Location:index.php?chap=".$chap."");

function config_write($file,$array){
$posbegin="";
$posmiddle="";
$posend="";
$i=0;

if(!file_exists($file)){
  echo "File does not exist "; 
  return false; 
  
 }
else{ 
	 $fp = fopen ($file, "r"); // read
	  if(!$fp){
	  echo "Unable to open file"; 
	  return false; 
	  }
	else{
$final='';	
  // read line by line
  while (!feof ($fp)){  
			  //read one line, 4k max 
			  $tmpline = fgets($fp, 4096); 
			  $i++;
//echo "line ".$i." ";// DEBUG
			  // parse to verify
				  $posbegin = strpos($tmpline, "$"); 
				  if (!($posbegin === false)){ 
				  // verify "=" is after "$" 
				  $posmiddle = strpos($tmpline, "="); 
				  }
				  if(($posmiddle) and ($posmiddle > $posbegin)){  
				  // verify ";" is after "=" 
				  $posend = strpos($tmpline, ";"); 
				  }
			  if(($posend) and ($posend > $posmiddle)){ 
			  // everything is OK
			  $varname = substr($tmpline, $posbegin+1, $posmiddle - $posbegin-1); 
			  $varvalue = substr($tmpline, $posmiddle + 1, $posend - $posmiddle -1);
			$varname=str_replace("cfg[","",$varname);// to replace with preg_replace
			$varname=str_replace("]","",$varname);

					if (isset($array[$varname])){ // file equals input
//echo " matches ".$cfg[$varname]." / ";// DEBUG
					$tmpline =str_replace($varvalue,$array[$varname], $tmpline);//becareful : doesn't work with NULL value
//echo " ->write : ".$tmpline." | ";// DEBUG
						}  
					else{					
//echo "not the good variable : put the same ";	// DEBUG				
					}  
			  //$varvalue = str_replace("\"","",$varvalue);//delete double quote
//echo $varname." - ".$varvalue."<br />";// DEBUG
			    } 		  
			  else{
//echo "no variable here : put the same ";// DEBUG
			  	  }
$final .= $tmpline;	// get all the content	: no variable, no variable choosen, and upadte	  
			   }// end of loop
  }// readable file   
  fclose($fp); 
 }// file exists 
 //echo "<br /> | ".$final;// impossible to write on screen 
 $fp = fopen ($file, "w"); // write now
  if(!$fp){ 
  echo "Unable to open file in write mode";
  return false; 
  }
else{  
  // write
  fwrite($fp, $final);    
  fclose($fp); 
  }

}  

?>