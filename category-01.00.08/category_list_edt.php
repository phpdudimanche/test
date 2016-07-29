<?php
//UPDATE 12-10-31
require_once("category_inc.php");

isset($_REQUEST['level'])?$level=$_REQUEST['level']:$level='1';//$level=0;
isset($_REQUEST['parent'])?$parent=$_REQUEST['parent']:$parent='0';//$parent=85;
isset($_REQUEST['depth'])?$depth=$_REQUEST['depth']:$depth=CATEGORY_LEVEL;//$parent=85;

if(!isset($_SESSION)) 
{ 
session_start(); 
}
isset($_SESSION['depth'])?$depth=$_SESSION['depth']:$depth=CATEGORY_LEVEL;

head($title_category_list_edt,$category_design,'../public/'.$general_js.'',$category_favico);
include('../public/_header.php');

//--- level session edit BEGIN ---
	echo "<form method=\"POST\" action=\"category_level_session_act.php\" name=\"config_depth\" id=\"config_depth\">";
echo "<table>";
echo "<tr><td>";
	echo "<input type=\"submit\" value=\"$update\"> ".$lg_category_level."<input type=\"text\" value=\"".$depth."\" name=\"depth\" size=\"1\" id=\"1\" />";
echo "</td></tr>";
echo "</table></form>";
//--- level session edit END ---




// also maintain the same query in category_list_edt.php
//echo "media : ".$opt_category_media."<br />";
if ($opt_category_media==1) { //
	// NEW with media
	/*$query ="SELECT * FROM $category_table ";
	$query.="LEFT OUTER JOIN upload ON  $category_id=upload_number AND upload_object='category'";// OPTION
	$query.="ORDER BY $category_parent_id, $category_order";
	echo $query;
	$query = mysql_query($query);*/

	// NEW with also execution
 /*$query ="SELECT category_id, parent_id, orderby,category_label, upload_label, upload_object, upload_extension, upload_id,
(select COUNT(*) as total_1 from execution_scenario WHERE exs_category_id=category_id AND exs_close_date=2010-10-10) as pause,
(select COUNT(*) as total_2 from execution_scenario WHERE exs_category_id=category_id AND exs_close_date!=2010-10-10) as close
FROM category
LEFT OUTER JOIN  upload ON category_id=upload_number AND upload_object='category'
ORDER BY parent_id, orderby"; */

$query ="SELECT $category_id, $category_parent_id, $category_order,$category_label, $upload_label, $upload_object, $upload_extension, $upload_id, $upload_name,
/* detect if scenario exists  */(select COUNT(*)  as total_3 from $scenario_table WHERE $scenario_step_scenario_id=$category_id) as scenario,
(select COUNT(*) as total_1 from $execution_scenario_table WHERE $execution_scenario_parent_id=$category_id AND $execution_scenario_end='2010-10-10') as pause,
(select COUNT(*) as total_2 from $execution_scenario_table WHERE $execution_scenario_parent_id=$category_id AND $execution_scenario_end!='2010-10-10') as close
FROM $category_table
LEFT OUTER JOIN  $upload_table ON $category_id=$upload_number AND $upload_object='category'
ORDER BY $category_parent_id, $category_order";
//
	if ($category_debug==1)
	{
	echo $query;
	exit();
		//$query = mysql_query($query)or print($cat_error);
	}

	//$query = mysql_query($query) or (FALSE);
	$query = $conn->query($query);

}
else
{	// OLD
	//$query = mysql_query("SELECT * FROM $category_table ORDER BY $category_parent_id, $category_order") or (FALSE);/*or die(mysql_error())  (print($cat_error)) */;
	//$query = $conn->query("SELECT * FROM $category_table ORDER BY $category_parent_id, $category_order");// ne pas melanger objet er procedural
	$query=query_retrieve("SELECT * FROM $category_table ORDER BY $category_parent_id, $category_order");
}// $ko=1 PB!!!

//head($title_category_list_edt,$category_design,'../public/'.$general_js.'');
//include('../public/_header.php');
//echo $query;


if ($query!=FALSE) {
	// TO STOP if query is wrong
	//echo "query OK";
	$result=output_query_category($query,$category_id);
	if ($category_debug==1)
	{
		echo "<pre>";
		print_r($result);//----- ICI
		echo "</pre>";
	}
	$currentParent=$parent;// 0 id category where i retrieve childs
	$currLevel =$level;// if this a contextual tree : retrieve level by breadcrumb
	$real_depth=1;
	
	
	

	
echo display_breadcrumb($parent);
	//exit();
	

//output_query_breadcrumb($query); // existe : a changer						



							
echo "<br /><br />";
//echo display_menu($parent, $level, $depth, $real_depth, $result2);// $level=just the level of the beginning NEW
//-------------- ----------------------------
// if is before printTree : Notice: Undefined index: parent_id -> rename result as result2
echo "\n\n<div id='category_list'>\n";	
//print_r($result);	
	printTree($result, $currentParent, $currLevel, $prevLevel= -1);// $currLevel = 0, $prevLevel = -1
echo "</div>\n\n";	
	
// TODO : http://127.0.0.1/03_PROD/V.02.02.01/category-01.00.04/category_list_edt.php?parent=3&depth=2 affiche 3 profondeurs au lieu de 2
// display tree ajouter for avec arrêt à fin de depth
//echo display_menu($parent, $level, $depth, $real_depth, $result);// $level=just the level of the beginning
//echo $parent." ".$level." ".$depth." ".$real_depth;
}
else{
	print($cat_error);
}

include('../public/_footer.php');
?>
</body></html>