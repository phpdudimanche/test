<?php
// UPDATE 12-11-0117
require_once("category_inc.php");

head($title_category_add_edt,$category_design,'../public/'.$general_js.'',$category_favico);
include('../public/_header.php');
isset($_REQUEST["parent_id"])?$parent_id=input($_REQUEST["parent_id"]):$parent_id="";
isset($_REQUEST["cat_id"])?$cat_id=input($_REQUEST["cat_id"]):$cat_id="";
//echo $parent_id;

//$rsMaxOrder = mysql_query("SELECT MAX(orderby) FROM $category_table WHERE parent_id = $parent_id ") or die(mysql_error());
//$results = mysql_fetch_array($rsMaxOrder);

$query="SELECT MAX(orderby) FROM $category_table WHERE parent_id = $parent_id ";
$send=mysqli_query($conn, $query);
$results = mysqli_fetch_array($send, MYSQLI_NUM);// http://php.net/manual/fr/mysqli-result.fetch-array.php   CGT

$last=$results[0];
$maxOrderby=$last+1;

if ($category_debug==1)
{
	echo "<pre>";
	echo "next order in creation mode : ".$maxOrderby;
	echo "</pre>";
}

echo '<br /><a href="'.$_SERVER['HTTP_REFERER'].'">'.$lg_back.'</a><br /><br />';

$label="";
$action="add";
display_form_edit($maxOrderby,$parent_id,$cat_id,$action,$label);


//$query = mysql_query("SELECT * FROM $category_table WHERE $category_parent_id=$parent_id ORDER BY $category_parent_id, $category_order");
	$query="SELECT * FROM $category_table WHERE $category_parent_id=$parent_id ORDER BY $category_parent_id, $category_order";
	//$send=mysqli_query($conn, $query);
	$send=query_retrieve($query); // CORE_LIB
//$result=output_query_category($query,$category_id);
$result=output_query_category($send,$category_id);// RESOLU donc list_edt reutilisable ?   // CORE_LIB



if ($category_debug==1)
{
	echo "<pre>";
	print_r($result);
	echo "</pre>";
}

display_same_level($result);
include('../public/_footer.php');
?>
</body></html>