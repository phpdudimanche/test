<?php
// UPDATE 2012-03-23
session_start();
isset($_REQUEST["cat_id"])?$cat_id=$_REQUEST["cat_id"]:$cat_id="";
isset($_REQUEST["cat_name"])?$cat_name=$_REQUEST["cat_name"]:$cat_name="";
$cat['id']=$cat_id;
$cat['name']=$cat_name;
$_SESSION['scenario']=$cat;
//print_r($cat);

/*
if there is no query in url
exist some categories whithout scenario steps ?
YES list theses categories here as workflow
NO : redirect
*/
header('location:scenario_steps_list_edt.php');
?>