<?php

if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
{
function stripslashes_deep($value)
{
	return is_array($value) ?
		array_map('stripslashes_deep', $value) :
		stripslashes($value);
}
$_POST    = array_map('stripslashes_deep', $_POST);
$_GET     = array_map('stripslashes_deep', $_GET);
$_COOKIE  = array_map('stripslashes_deep', $_COOKIE);
$_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}

function input($string)// input
	{
	global $conn;
		if(ctype_digit($string))// integer yes
		{
			$string = intval($string);
		}
		else// integer no
		{
			//$string = mysql_real_escape_string($string);// DEPRECATED
			$string=mysqli_real_escape_string ($conn , $string);// http://php.net/manual/fr/mysqli.real-escape-string.php
			$string = addcslashes($string, '%_');
		}
		return $string;
	}

function output($string)// output
		{
			return htmlentities($string);
		}

// depends on confg : mysqli, pdo... object or procedural, row or array...
function connect(){
global $host,$user,$pass,$database;
return mysqli_connect($host, $user, $pass, $database);	
}
function query_retrieve($query){// select
global $conn;
return mysqli_query($conn, $query);
}
function query_record($query){// insert
global $conn;
return mysqli_query($conn, $query);
}
function retrieve_assoc($query){
return mysqli_fetch_assoc($query);	
}

?>