<?php
// UPDATE 12-08-01
// For the same level, view of items by order, with display of the order.
// The input is the parent category. The query retrieve all child of this parent.
// Each item has input box. This is a form with a submit button to go to "act" page.
// It is recommended to use decimal to insert value in interval.
require_once("category_inc.php");
head($title_category_order_edt,$category_design,'../public/'.$general_js.'',$category_favico);
include('../public/_header.php');
isset($_REQUEST["parent_id"])?$parent_id=$_REQUEST["parent_id"]:$parent_id="";

//$query = mysql_query("SELECT * FROM $category_table WHERE $category_parent_id=$parent_id ORDER BY $category_parent_id, $category_order");
$query=query_retrieve("SELECT * FROM $category_table WHERE $category_parent_id=$parent_id ORDER BY $category_parent_id, $category_order");
$result=output_query_category($query,$category_id);

if ($category_debug==1)
{
	echo "<pre>";
	print_r($result);
	echo "</pre>";
}

display_order_level($result);

include('../public/_footer.php');
?>
</body>
</html>