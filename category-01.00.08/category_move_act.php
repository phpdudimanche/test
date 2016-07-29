<?php
// This is the submit destination page of "edt" page.
// The input is two variables : source id_child, target id_parent.
// The script changes the parent of the child.
// Then, the script inserts update query in database.
// At least, redirection to "edt" page
require_once("category_inc.php");

isset($_REQUEST["source"])?$source=$_REQUEST["source"]:$source="";
isset($_REQUEST["target"])?$target=$_REQUEST["target"]:$target="";

if ($category_debug==1)
{
	echo "<pre>";
	echo "source ".$source." and target ".$target;
	echo "</pre>";
}

// recuperate max orderby
//$query = mysql_query("SELECT MAX(orderby) FROM $category_table WHERE $category_parent_id=(SELECT $category_parent_id FROM $category_table WHERE $category_id=$target)");
	$query="SELECT MAX(orderby) FROM $category_table WHERE $category_parent_id=(SELECT $category_parent_id FROM $category_table WHERE $category_id=$target)";
	$query=query_retrieve("SELECT MAX(orderby) FROM $category_table WHERE $category_parent_id=(SELECT $category_parent_id FROM $category_table WHERE $category_id=$target)");
//$max=mysql_fetch_array($query); // curieux, besoin des 2 $query

if ($result=mysqli_query($conn, $query)) {// $result=mysqli_query($conn, $query)   --- KO : $result=$query  : 
    /* Récupération du tableau associatif */
    while ($max = mysqli_fetch_row($result)) {
        return $max[0];
    }
}

$last=$max[0];// max
$orderby=$last+1;
//echo "apres";
if ($category_debug==1)
{
	echo "<pre>";
	echo "numero le plus élevé : ".$last;
	echo " plus un égale ".$orderby;
	echo "</pre>";
}

//$query=mysql_query("UPDATE $category_table SET $category_parent_id = $target, $category_order = $orderby WHERE $category_id = $source") or die(mysql_error());
$query=query_record("UPDATE $category_table SET $category_parent_id = $target, $category_order = $orderby WHERE $category_id = $source");
header("Location:category_move_edt.php");
?>