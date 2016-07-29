<?php
/*
   step 1/4
   click on a link since category in order to duplicate category and steps' scenario

   step 2/4
   create a scenario (first of all : category) by duplication
   take the id and the name
   insert the name with COPY in front
   redirect to script of steps'scenario copy

   step 3/4
   select all data of the steps which have this id as father
   insert as father the new father id
   redirect to category list

   step 4/4
   manually rename and remove
*/
require_once("category_inc.php");

isset($_REQUEST["cat_id"])?$cat_id=input($_REQUEST["cat_id"]):$cat_id="";
$directory=SCENARIO;

	if ($category_debug==1)
	{
	echo "duplicate category id ".$cat_id."<br />";
	}
// INSERT INTO category SELECT '', parent_id, orderby, CONCAT("COPY ", category_label)as label  FROM category WHERE category_id=1
//$query="INSERT INTO $category_table SELECT $category_parent_id, $category_order, CONCAT('COPY ', $category_label)as label FROM $category_table WHERE $category_id=$cat_id";
$query="INSERT INTO $category_table ($category_parent_id, $category_order, $category_label) SELECT $category_parent_id, $category_order, CONCAT('COPY ', $category_label)as label FROM $category_table WHERE $category_id=$cat_id";
// category_id must be null, this field is an auto increment -> mysqli remove after SELECT   '',
	if ($category_debug==1)
	{
		echo $query;
	}

//$query = mysql_query($query) or die(mysql_error());
$query=query_record($query);
//$last_increment=mysql_insert_id();
$last_increment=mysqli_insert_id($conn);
	if ($category_debug==1)
	{
		echo "new scenario id is $last_increment - ";
	echo "<a href='../$directory/scenario_steps_duplicate_act.php?scenario=$last_increment&old_scenario=$cat_id'>go to scenario</a>";
	exit();
	}

header("location:../$directory/scenario_steps_duplicate_act.php?scenario=$last_increment&old_scenario=$cat_id");
?>