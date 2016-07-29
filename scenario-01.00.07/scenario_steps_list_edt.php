<?php
/* UPDATE 12-11-17
	For a scenario id, list of all steps.
	If there are too much steps, the display uses a paging (fonction in core's module).
	The number of steps by page is a variable in config.
	All steps are editable : the user has writer wright. / there is a non editable page for user with lector wright
	   Fields visible :
	id (not editable), order, action, expected
	It is possible to modify and to add.
	All fields are modified (no js)
	By default, ther are lots of steps, even empty.
 */
require_once("scenario_inc.php");

	session_start();
	isset($_SESSION['scenario'])?$scenario=$_SESSION['scenario']:$scenario=='';
	$scenario_id=$scenario['id'];
	$scenario_name=$scenario['name'];

isset($_REQUEST["begin"])?$begin=$_REQUEST["begin"]:$begin=0;// for pagination
$_SESSION['increment']=$begin;// increment for listing act due by pagination
head($title_001,$scenario_css,'../public/'.$general_js.'',$scenario_favico);

include('../public/_header.php');
	if ($scenario_id==''){
	//$scenario_name="test";
	//$scenario_id=0;
require_once("../".CATEGORY."/category_config.php");// in order to retrieve parent of cat id, for breadcrumb
echo "<a href='../".CATEGORY."'>".$lg_category_select."</a>";
		include('../public/_footer.php');
		foot();
exit();
	}


if ($scenario_debug==1)
{
	echo "<pre>";
	print_r($scenario);
	echo "</pre>";
}

// for pagination
//$query = mysql_query("SELECT COUNT($scenario_step_id) FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id");
$query=query_retrieve("SELECT COUNT($scenario_step_id) FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id");
//$result_compt=mysql_fetch_row($query);
$result_compt=mysqli_fetch_row($query);
$total=$result_compt[0];
	$result = str_replace('/'.SCENARIO.'/','', ROOT);//in root, sustract current directory
	require_once($result."/".CORE."/lib_Pagination.php");
//include(ROOT."/".CORE."/lib_Pagination.php");
$link='scenario_steps_list_edt.php?';
$_SESSION['scenario']['total']=$total;
// for pagination

/* to export the current scenario (all pages)

*/
echo '<div id="breadcrumb_and">';
//echo $scenario_id;
echo $total.' '.$scenario_table_label.' <i>'.$scenario_name.'</i> | ';
echo "<a href='../".CATEGORY."'>".$lg_category_label."</a>";// .$category. $category_label was used in category_config.php
	$result = str_replace('/'.SCENARIO.'/','', ROOT);//in root, sustract current directory
	require_once($result."/".CATEGORY."/category_inc.php");// utile also for breadcrumb
//include (ROOT."/".CATEGORY."/category_inc.php");
$same="./";
category_next($category_next_label,$same,$scenario_id);
link_scenario_export_xls($scenario_id,$scenario_name);
	// TODO : verify if scenario steps exist
	include ("../".EXECUTION."/execution_config.php");	
	echo " | <a href='../".EXECUTION."/execution_scenario_edt.php?cat_id=".$scenario_id."&cat_name=".$scenario_name."'>".$lg_execution_link."".$scenario_name."</a>";
echo '<br />';

//echo "N sc $scenario_id ";// cat id
$query= "SELECT $category_parent_id FROM $category_table WHERE $category_id=$scenario_id";
$query=query_retrieve($query);
$query=mysqli_fetch_assoc($query);
$parent=$query[$category_parent_id];
echo "father $parent ";
echo display_breadcrumb($parent,CATEGORY);
echo "<br /><br />";
//--------------

echo '</div>';

// display scenario name
// if there is no scenario, invitation to create scenario
// to do : add limit as global $steps_by_page in query / add paginate
//$query = mysql_query("SELECT * FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id ORDER BY $scenario_step_order");
//$query = mysql_query("SELECT * FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id ORDER BY $scenario_step_order LIMIT $begin,$steps_by_page");
$query=query_retrieve("SELECT * FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id ORDER BY $scenario_step_order LIMIT $begin,$steps_by_page");
//$query="SELECT * FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id ORDER BY $scenario_step_order LIMIT $begin,$steps_by_page";
$result=output_query_scenario($query, $scenario_step_id);

// pagination
echo "<div id='pagination'>";
pagination($total, $steps_by_page, $begin, $link);
echo "</div>";
// pagination

if ($scenario_debug==1)
{
	echo "steps to display in this page";
	echo "<pre>";
	print_r($result);
	echo "</pre>";
}

display_scenario_steps_list_edit($result);

// pagination
echo "<div id='pagination'>";
pagination($total, $steps_by_page, $begin, $link);
echo "</div>";
// pagination
include('../public/_footer.php');
foot();
?>