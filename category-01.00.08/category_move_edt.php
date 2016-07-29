<?php
// UPDATE 12-10-15
// For different levels, move an item, change its parent.
// There are two sides, the source side and the target side.
// Each item has a radio button. There is only one choice by side.
// This is a form with a submit button to go to "act" page.
// Display  a back link to "category_list_edt.php".
require_once("category_inc.php");
head($title_category_move_edt,$category_design,'../public/'.$general_js.'',$category_favico);
include('../public/_header.php');
//error_reporting(E_ALL ^ E_NOTICE);// TODO Undefined index: upload_id, scenario, pause, close in category_inc.php line 29,30,31,32
//$query = mysql_query("SELECT * FROM $category_table ORDER BY $category_parent_id, $category_order");

// also maintain the same query in category_list_edt.php
if ($opt_category_media==1) { //
$query ="SELECT $category_id, $category_parent_id, $category_order,$category_label, $upload_label, $upload_object, $upload_extension, $upload_id, $upload_name,
/* detect if scenario exists  */(select COUNT(*)  as total_3 from $scenario_table WHERE $scenario_step_scenario_id=$category_id) as scenario,
(select COUNT(*) as total_1 from $execution_scenario_table WHERE $execution_scenario_parent_id=$category_id AND $execution_scenario_end='2010-10-10') as pause,
(select COUNT(*) as total_2 from $execution_scenario_table WHERE $execution_scenario_parent_id=$category_id AND $execution_scenario_end!='2010-10-10') as close
FROM $category_table
LEFT OUTER JOIN  $upload_table ON $category_id=$upload_number AND $upload_object='category'
ORDER BY $category_parent_id, $category_order";
	if ($category_debug==1)
	{
	echo $query;
	}
	//$query = mysql_query($query) or (FALSE);// CHANGE
	$query=query_retrieve($query);
}
else
{	// OLD
	//$query = mysql_query("SELECT * FROM $category_table ORDER BY $category_parent_id, $category_order") or (FALSE);
	$query=query_retrieve("SELECT * FROM $category_table ORDER BY $category_parent_id, $category_order");
}

$result=output_query_category($query,$category_id);

if ($category_debug==1)
{
	echo "<pre>";
	print_r($result);
	echo "</pre>";
}

$currentParent=0;
?>
<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
<title>style</title>
<meta name="description" content="seule page avec style">
<link rel="stylesheet" type="text/css" href="<?php echo $category_design;?>" />
</head>
<body> -->

<div id="double_side">
<?php echo $process_move; ?>
<form method="POST" action="category_move_act.php" name="move_new" id="move_new">
<div id="side_source">
<li id="0">Level 0</li>
<?php printTreeMove($result, $currentParent, $currLevel = 0, $prevLevel = -1, "source"); ?></div>
<div id="side_target">
<li id="0"><input type="radio" name="target"  id="target[0]" value="0"><label for="target[0]">Level 0</label></li>
<?php printTreeMove($result, $currentParent, $currLevel = 0, $prevLevel = -1, "target"); ?></div>
<hr />
<input type="submit" value="<?php echo $move;?>" id="move_submit" />
</form>
</div>
<hr />
<?php
include('../public/_footer.php');
?>
</body></html>