<?php
// general config UPDATE 12-11-25
define("ENV",1);//0 usb 1 olympe 2 free julien
$env=ENV;
// connection
switch ($env){
case 0:
	$host="localhost";
	$database="test";
	$user="root";
	$pass="root";
	break;
case 1:
	$host="localhost";
	$database="test";
	$user="root";
	$pass="root";
	break;
case 2:
	$host="localhost";
	$database="test";
	$user="root";
	$pass="root";
	break;
}
define("CORE","core-02.00.04");
define("CATEGORY","category-01.00.08");// new
define("SCENARIO","scenario-01.00.07");
define("UPLOAD","upload-01.00.06");
define("EXECUTION","execution-01.00.06");
define("CONFIG","config-00.00.04");// new

require_once(CONFIG.'/config_data.php');

define("LANG",$cfg['general_lang']);//fr french, uk english
//define("ROOT",str_replace("\\","/",__DIR__.'/'));// OK php 5.3
define("DEBUG",$cfg['general_debug']);//0 none, 1 inline, 2 textlog
define("PREFIX","001_");// one prefix by project 005_
define("ISTQB",$cfg['scenario_istqb']);// display istqb level 0 NO / 1 YES
define("CATEGORY_LEVEL",$cfg['category_level']);// number to display by default
define("CATEGORY_ICONS",$cfg['category_icons']);
define("LINKS_CATEGORY",1);// not used yet : utile for other application of the module : like in requirements
define("LINKS_SCENARIO",$cfg['category_link_scenario']);
define("LINKS_UPLOAD",$cfg['category_link_upload']);
define("LINKS_EXECUTION",$cfg['category_link_execution']);
define("STEPS_FULL",$cfg['scenario_steps_bypage']);
define("STEPS_EMPTY",$cfg['scenario_steps_empty']);
define("NUMBER_UPLOAD",$cfg['upload_list_number']);

$chemin_complet= $_SERVER['SCRIPT_NAME'];//complete path
$nom_fichier = basename($chemin_complet);//file name
$fin =str_replace($nom_fichier,"",$_SERVER['SCRIPT_NAME']);//no more filename
$repertoire= str_replace("//","/",$_SERVER['DOCUMENT_ROOT'].$fin);// double [//] 
define("ROOT",$repertoire);


//-------- options
$general_js="01/root_01.js";
$general_css="../public/01/root_design_01.css";
$general_favico="../public/01/file_13.png";
$favico="public/01/file_13.png";// just for index of apply
$version="version 02.02.05";
//-- links beetween application : 0 no, 1 yes

//-- rights 1 visitor (navigate),2 test executant(no CRUD about category and cenario, can create and upade execution),5 administrator (all rights)
define ("RIGHTS",5);
?>