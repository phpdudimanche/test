<?php
require_once("category_inc.php");

isset($_REQUEST["category_name"])?$category_name=input($_REQUEST["category_name"]):$category_name="";
isset($_REQUEST["orderby"])?$orderby=input($_REQUEST["orderby"]):$orderby="";
isset($_REQUEST["parent_id"])?$parent_id=input($_REQUEST["parent_id"]):$parent_id="";
isset($_REQUEST["cat_id"])?$cat_id=input($_REQUEST["cat_id"]):$cat_id="";

/*echo $category_name;
exit();*/

/*$upadteCategory=mysql_query("UPDATE $category_table SET $category_parent_id = '$parent_id', $category_order = '$orderby', $category_label = '$category_name'
 WHERE $category_id = '$cat_id'") or die(mysql_error());*/
$upadteCategory=query_record("UPDATE $category_table SET $category_parent_id = '$parent_id', $category_order = '$orderby', $category_label = '$category_name'
 WHERE $category_id = '$cat_id'");

header("Location:category_list_edt.php");
?>