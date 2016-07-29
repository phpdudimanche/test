<?php
// UPDATE 12-11-0117
require_once("category_inc.php");
head($title_category_update_edt,$category_design,'../public/'.$general_js.'',$category_favico);
include('../public/_header.php');
isset($_REQUEST["parent_id"])?$parent_id=$_REQUEST["parent_id"]:$parent_id="";
isset($_REQUEST["cat_id"])?$cat_id=$_REQUEST["cat_id"]:$cat_id="";
//echo $cat_id;
/*$rsMaxOrder = mysql_query("SELECT MAX(orderby) FROM $category_table WHERE parent_id = $parent_id ") or die(mysql_error());// to use only in creation
$results = mysql_fetch_array($rsMaxOrder);
//$maxOrderby = $results[0];// see category_move_act.php
$last=$results[0];
$maxOrderby=$last+1;*/

if ($category_debug==1)
{
	echo "<pre>";
	echo "category ".$cat_id." and parent ".$parent_id;
	//echo "next order in creation mode : ".$maxOrderby;
	echo "</pre>";
}

echo '<br /><a href="'.$_SERVER['HTTP_REFERER'].'">'.$lg_back.'</a><br /><br />';

//$query = mysql_query("SELECT * FROM $category_table WHERE $category_id=$cat_id ORDER BY $category_parent_id, $category_order"); // DEVIENT 2 lignes suivantes
$query="SELECT * FROM $category_table WHERE $category_id=$cat_id ORDER BY $category_parent_id, $category_order";
$query=query_retrieve($query);

$result=output_query_category($query,$category_id);// inchange

$label=$result[$cat_id]['name'];// category name
$maxOrderby=$result[$cat_id]['orderby'];

if ($category_debug==1)
{
echo "<pre>";
print_r($result);
echo "<br />category name is ".$label;
echo " and category order is ".$maxOrderby;
echo "</pre>";
}


$action="update";
display_form_edit($maxOrderby,$parent_id,$cat_id,$action,$label);

//$query = mysql_query("SELECT * FROM $category_table WHERE $category_parent_id=$parent_id ORDER BY $category_parent_id, $category_order");// change
$query="SELECT * FROM $category_table WHERE $category_parent_id=$parent_id ORDER BY $category_parent_id, $category_order";
$query=query_retrieve($query);
$result=output_query_category($query,$category_id);// inchange

if ($category_debug==1)
{
	echo "<pre>";
	print_r($result);
	echo "</pre>";
}

display_same_level($result);

include('../public/_footer.php');
?>
</body>
</html>