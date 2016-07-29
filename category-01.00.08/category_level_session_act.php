<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
}
isset($_POST['depth'])?$depth=$_POST['depth']:$depth=9;
$_SESSION['depth']=$depth;
//echo $depth;
$togo=$_SERVER['HTTP_REFERER'];// retrieve url with query
header('location:'.$togo.'');
//echo $_SERVER['HTTP_REFERER'];// retrieve url with query

?>