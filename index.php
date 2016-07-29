<?php
// PAGE : index.php / UPDATE 12-12-01
// SUBJECT : lists directories and reads index.txt
//include('config.php');
require_once('config.php');

$chemin_complet= $_SERVER['SCRIPT_NAME'];//chemin complet
$nom_fichier = basename($chemin_complet);//nom du fichier
$fin =str_replace($nom_fichier,"",$_SERVER['SCRIPT_NAME']);//nom du fichier enlevé : envoyé à la fonction !
$repertoire= str_replace("//","/",$_SERVER['DOCUMENT_ROOT'].$fin);// double [//] géré
include ($repertoire.''.CORE.'/lib_Common.php');

$language=LANG;//$language="fr";// fr french, uk english
include("public/lang_".$language.".php");// /root/
/* only PHP 5.3.0 : http://www.php.net/manual/fr/language.constants.predefined.php
$root = str_replace("\\","/",__DIR__.'/'.CORE);
include ($root.'/lib_Common.php');
*/
//echo directory_header();
include(CONFIG."/config_lang_".$language.".php");

// all this to do : repeat functions, include script : because path from config module to config file

function add($buffer,$replacement){
  // replace
  return (ereg_replace("</head>","<link rel=\"stylesheet\" type=\"text/css\" href= \"".CONFIG."/config.css\">\n<script language=\"Javascript\" src=\"".CONFIG."/config.js\"></script>\n</head>", $buffer));
}

ob_start("add");
head($lg_root_title,'public/01/'.$lg_root_css,'public/01/'.$lg_root_js,$favico);// 01/ to variabilize
include('public/_header.php');// /root/
ob_end_flush();

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

isset($_REQUEST["chap"])?$chap=$_REQUEST["chap"]:$chap="0";

echo "<div id=\"container\">";

display_config_menu($menu_home,$chap);
$nothing='';
$i=0;
if($i==$chap){
	$class="on";
	}
	else{
	$class="off";
	}
echo"\n\n<div id=\"menu_".$i."\" class=\"".$class." content\">";
//echo $lg_index_modules;
echo "<br />";
$result=display_directory($nothing);
echo $result;
echo "</div>";

$i=1;
if($i==$chap){
	$class="on";
	}
	else{
	$class="off";
	}
echo"\n\n<div id=\"menu_".$i."\" class=\"".$class." content\">";
echo "<br />";
echo "<pre>";
include('public/features_'.$language.'.txt');
echo "</pre>";
echo "</div>";

echo "</div>";
include('public/_footer.php');
echo directory_footer();
?>