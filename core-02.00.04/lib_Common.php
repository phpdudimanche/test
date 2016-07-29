<?php
// UPDATE 12-10-15
//------------------------- DIRECTORY ---------------------------

function for_include($server,$script){// for general root
	$tab = explode("/", $script);
	$size=count($tab);
	$result="/";
	for ($i=0;$i<$size;$i++){
		if ($i!=0 AND $i!=$size-1) {
			$result.=$tab[$i]."/";
		}
	}
	return $server."".$result;
}

$to_ignorate = array ('.','..');// in order to ignorate false directory
$separator=";";
$handle=opendir(".");
$output2=array();
$output="";

function directory_header()// replace with head function NOT USED ANYMORE
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="fr-FR">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Application lists</title>
<link rel="stylesheet" type="text/css" href="root_design_01.css" />
</head>
<body>
<?php
}

function directory_footer()
{
?>
</body>
</html>
<?php
}

function display_directory($directory)// list all directories and ignorate those which have no index.txt ! : end the 17/03/2010 11:07
{
	global $to_ignorate,$separator,$handle,$output2,$output;// sont en global, pourraient être en define
	$mask="/index_".LANG.".txt";// "/index.txt"
	$i=0;

while ($file = readdir($handle))
{
	if (is_dir($file) && !in_array($file,$to_ignorate)) // directory and not yet known
	{
		if (!file_exists($directory.$file.$mask))// complet root
		{
			//echo "nothing in directory ". $directory.$file."/index.txt";
		}
		else
		{
			// the begining
			$fp=fopen($file.$mask,"r");// relativ path
			//echo "ok";
			$line = 0;
			$tab=array();
			while($tab=fgetcsv($fp,1024,$separator))//loop
			{
				$label=$tab[0];
				$summary=$tab[1];
				//print_r($tab);
				$line ++;// increment
			}
			fclose($fp);
			$data[$i] =array_push($output2,array('directory'=>$file,'label'=>$label,'summary'=>$summary));
			// the end
		}
	}
	$i++;
}
	closedir($handle);

	sort($output2);
	//print_r($output2);

	$output .="<ul>";// the beginning of the display : directory in directory
for($i=0;$i<sizeof($output2);$i++) // loop
{
	$output .="<li><a href='".$output2[$i]['directory']."'>";
	$output .= $output2[$i]['label']."</a> ";
	$output .=  $output2[$i]['summary']."</li>";
}
	$output .="</ul>";//the beginning of the display : directory in directory
	return $output;
}

//------------------------- UTILS SCRIPTS ---------------------------

function head($title,$css,$js,$ico){//
echo"<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\">
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\"/><head>
<title>$title</title>
<meta name=\"description\" content=\"$title\">
<link rel=\"stylesheet\" type=\"text/css\" href=\"".$css."\" />
<link rel=\"icon\" type=\"image/png\" href=\"$ico\" />
<script	type=\"text/javascript\" src=\"".$js."\"></script>
</head>
<body>";// ../public/file_13.png
}

function select_list($array,$name,$selected){
//global $mode_debug;
	if (DEBUG==1)//obsolete possible specific debug by module
	{
		foreach($array as $key=>$value){
			echo 'key '.$key.' | value '.$value.'<br />';
		}
	}

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
}

?>