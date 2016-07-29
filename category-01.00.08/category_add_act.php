<?php
require_once("category_inc.php");

isset($_REQUEST["category_name"])?$category_name=input($_REQUEST["category_name"]):$category_name="";
isset($_REQUEST["orderby"])?$orderby=input($_REQUEST["orderby"]):$orderby="";
isset($_REQUEST["parent_id"])?$parent_id=input($_REQUEST["parent_id"]):$parent_id="";

//echo $category_name;

/*$newCategory = mysql_query("INSERT INTO $category_table ($category_parent_id, $category_label, $category_order)
VALUES ($parent_id, '$category_name', $orderby)") or die(mysql_error());// DEPRECATED*/
$query="INSERT INTO $category_table ($category_parent_id, $category_label, $category_order)
VALUES ($parent_id, '$category_name', $orderby)";
//$result=mysqli_query($conn, $query);
$result=query_record($query);

header ("Location:category_list_edt.php");
?>