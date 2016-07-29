<?php
// This is the submit destination page of "edt" page.
// The input is an array ordered by order, perhaps with decimal.
// The script replaces order number by order id increment of the array.
// Then, the script insert queries in database.
// At least, redirection to category_list_edt.php.
require_once("category_inc.php");

isset($_REQUEST["cat_order"])?$cat_order=$_REQUEST["cat_order"]:$cat_order="";

if ($category_debug==1)
{
	echo "<pre>";
	print_r($cat_order);// get
	echo "</pre>";
}

asort($cat_order);// sort, order

if ($category_debug==1)
{
	echo "<pre>";
	print_r($cat_order);
	echo "</pre>";
}

$i=0;
foreach ($cat_order as $key => $value) {
$i++;
$array[$key]=str_replace($value,$i,$value);// replace decimals or old order_id by integer increment
}

if ($category_debug==1)
{
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

foreach ($array as $key=>$value ){// execute query
	//echo $key.'='.$value.' | ';
//$updateOrder=mysql_query("UPDATE $category_table SET $category_order ='$value' WHERE $category_id = '$key'") or die(mysql_error());
query_record("UPDATE $category_table SET $category_order ='$value' WHERE $category_id = '$key'");
}

if ($category_debug!=1)
{
header("Location:category_list_edt.php");
}

?>