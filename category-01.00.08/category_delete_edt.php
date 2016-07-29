<?php
// UPDATE 12-08-01
session_start();
require_once("category_inc.php");
head($title_category_order_edt,$category_design,'../public/'.$general_js.'',$category_favico);
include('../public/_header.php');
isset($_REQUEST["cat_id"])?$cat_id=$_REQUEST["cat_id"]:$cat_id="";

//echo "Delete ".$cat_id."<br />";
$result2=retrieveChild($cat_id, $conn);// $result : yet path

//print_r($result2);

$all=traitment($result2,$cat_id);

if ($category_debug==1)
{
	echo "<pre>";
	print_r($all);
	echo "</pre>";
}

$_SESSION['todo'] =$all;
// header("Location:category_list_edt.php");//mode automatic
include('../public/_footer.php');
?>
</body>
</html>