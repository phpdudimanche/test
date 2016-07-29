<?php // UPDATE 12-11-12
//include('config_lang.php');
include('config_data.php');

require_once("config_inc.php");

function add($buffer,$replacement)
{
  // replace
  return (ereg_replace("</head>","<link rel=\"stylesheet\" type=\"text/css\" href= \"config.css\">\n<script language=\"Javascript\" src=\"config.js\"></script>\n</head>", $buffer));
}
ob_start("add");
head($lg_cfg_edit,$general_css,'../public/'.$general_js.'',$general_favico);
include('../public/_header.php');
ob_end_flush();

isset($_REQUEST["chap"])?$chap=$_REQUEST["chap"]:$chap="0";

/*
echo "<pre>";
print_r($cfg);// retrieve
echo "</pre>";

echo "<pre>";
print_r($label);// retrieve
echo "</pre>";
*/

echo "<div id=\"container\">";
display_config_menu($menu_config,$chap);
$thechap=$chap;// because chap is instanciate in the form
display_config_content($menu_config,$thechap,$cfg,$title_label,$label);
echo "</div>";

include('../public/_footer.php');
?>