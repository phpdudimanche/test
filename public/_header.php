<?php
// UPDATE 12-11-11
// menu on all visible pages
$here=$_SERVER['SCRIPT_NAME'];

if(file_exists('config.php')){// script root
	//echo "website root";// only for index.php

//	include('config.php');// due to root (not this matter if in root and not directory)
	require_once('config.php');
	// config include in other files : not used here
	$language=LANG;//$language="fr";// fr french, uk english
	//echo $language;
	include("public/lang_".$language.".php");// "".$to_lang.

}
else{

//include('../config.php');// due to root (not this matter if in root and not directory)
require_once('../config.php');
// config include in other files : not used here
$language=LANG;//$language="fr";// fr french, uk english
//echo $language;
include("lang_".$language.".php");// "".$to_lang.

}


$pos_cat = strpos($here, CATEGORY);//http://www.php.net/manual/fr/function.strpos.php
$pos_sce = strpos($here, SCENARIO);
$pos_exe = strpos($here, EXECUTION);
$pos_upl = strpos($here, UPLOAD);
$pos_conf = strpos($here, CONFIG);
// module on position ON, current

$before="<span class=\"here\">";//"<b>";
$after="</span>";//"</b>";


if ($pos_cat !== false) {
$lg_menu_category='%s '.$lg_menu_category.' %s';
$localization='module';
}
else if ($pos_sce !== false) {
$lg_menu_scenario='%s '.$lg_menu_scenario.' %s';
$localization='module';
}
else if ($pos_exe !== false) {
$lg_menu_execution='%s '.$lg_menu_execution.' %s';
$localization='module';
}
else if ($pos_upl !== false) {
$lg_menu_upload='%s '.$lg_menu_upload.' %s';
$localization='module';
}
else if ($pos_conf !== false) {
$lg_menu_settings='%s '.$lg_menu_settings.' %s';
$localization='module';
}
else {// this is the last else if
$lg_menu_total='%s '.$lg_menu_total.' %s';
$localization='root';
//$lg_menu_category='%s '.$lg_menu_category.' %s';
	//echo "La chaine 'CATEGORY' ne se trouve pas dans la chaine '$here'";
}

if ($localization=='root'){
$to_directory='./';
$to_root='./public/';
$to_lang='';
}
else{
$to_directory='../';
$to_root='../public/';
$to_lang='../root/';
}



$lg_menu='<span class="menu"><a href="'.$to_directory.'" class="home">'.$lg_menu_total.'</a> | <a href="'.$to_directory.''.CATEGORY.'" class="category">'.$lg_menu_category.
	'</a> | <a href="'.$to_directory.''.SCENARIO.'" class="scenario">'.$lg_menu_scenario.'</a> | <a href="'.$to_directory.''.EXECUTION.'" class="execution">'.$lg_menu_execution.
	'</a> | <a href="'.$to_directory.''.UPLOAD.'" class="upload">'.$lg_menu_upload.'</a> | 
	<a href="javascript:open_win(\''.$to_root.'help_'.$language.'.htm\')" class="help">'.$lg_menu_help.'</a> | 
	<a href="'.$to_directory.''.CONFIG.'" class="settings">'.$lg_menu_settings.'</a></span>';
printf($lg_menu, $before, $after);
echo "<br />";
// <a href="'.$to_root.'help_'.$language.'.htm" target="_blank">
// without js wich doesn't work with chrome

?>