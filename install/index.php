<?php
// update 2012/07/16
$filename_sql="install.sql";
$filename_php="install.php";
include('../config.php');
include ("install_lang_".LANG.".php");
$prefix=PREFIX;// see constant

$firstdir=__DIR__. "/../";
$subdir=array();
$dir =array_diff(scandir($firstdir),array('..','.'));
foreach ($dir as $result) {
	if (is_dir($firstdir.$result)){
		$subdir[]=$result;
		    $result2=scandir($firstdir.$result);
			foreach ($result2 as $subresult) {
				if(preg_match('`.sql$`', $subresult)){
					$files[]=$result.'/'.$subresult;
				}
			}
		
	}
}
//print_r($dir);print_r($subdir);
//print_r($files);//---- outputt as [0] => category-00.05.03/category_data.sql [1] => category-00.05.03/category_structure.sql
//--- FILES LIST end

// TEST EXISTENCE of prefix tables begin
//--- CONNECTION : SCRIPT SERVer
/*$dbhandle = mysql_connect($host, $user, $pass) 
	or die("Unable to connect to MySQL"); */ //  MYSQL
	$conn = mysqli_connect($host, $user, $pass, $database);
//--- CONNECTION : SCRIPT database
/*$selected = mysql_select_db($database, $dbhandle)
	or die("Could not select examples");*/ //  MYSQL
//--- VIEW : TABLES
//$result_tbl = mysql_query( "SHOW TABLES FROM ".$database, $dbhandle ); //  MYSQL
$result_tbl = $conn->query("SHOW TABLES FROM ".$database);
//--- LIST TABLE
$tables = array();
//while ($row = mysql_fetch_row($result_tbl)) { // MYSQL
while ($row = mysqli_fetch_row($result_tbl)) {
	if(preg_match('`^'.$prefix.'`', $row[0])){// '`^001_`'
		$tables[] = $row[0];
	}
}
//print_r($tables);
if(!empty($tables)){
	echo $in_yet_datables_01;
foreach ( $tables as $result )
{
	echo $result."<br>";
}
	echo $in_yet_datables_02;
	exit();
}
// TEST EXISTENCE of prefix tables end


if (file_exists($filename_sql)){
echo $in_yet_file;
}
else {
	printf($in_to_create,$prefix);

// CREATE COLLATE SCRIPT SQL begin
	$fp = fopen($filename_sql,"w");// create new file and delete existent file
	for($i=0;$i<sizeof($files);$i++)// for each file
	{
		//$handle = fopen($path_final.''.$files[$i], 'r');// read
		$handle = fopen(__DIR__.'/../'.$files[$i], 'r');
		if ($handle) {
			while (!feof($handle))	{
				$buffer = fgets($handle);// get
				$buffer =	str_replace("PRE_",$prefix,$buffer);
				//echo $buffer;// output screen
				fputs($fp, $buffer);// write content
			}
			$buffer=PHP_EOL;// if there is no space beetween scripts
			fputs($fp, $buffer);
			fclose($handle);// finish
		}
	}
	fclose($fp);// close file
// CREATE COLLATE SCRIPT SQL end

// CREATE INSTALLATION QUERY begin
	$fp = fopen($filename_php,"w");// final document of installation php
	$buffer="<?php".PHP_EOL;
	fputs($fp, $buffer);

	/*$buffer="$"."host="."\"localhost\";".PHP_EOL;// already done in crud
	$buffer.="$"."database="."\"dev\";".PHP_EOL;// already done in crud
	$buffer.="$"."user="."\"root\";".PHP_EOL;// already done in crud
	$buffer.="$"."pass="."\"\";".PHP_EOL;// already done in crud */
	$buffer="$"."host="."\"$host\";".PHP_EOL;// already done in crud
	$buffer.="$"."database="."\"$database\";".PHP_EOL;// already done in crud
	$buffer.="$"."user="."\"$user\";".PHP_EOL;// already done in crud
	$buffer.="$"."pass="."\"$pass\";".PHP_EOL;// already done in crud
	//$buffer.="$"."conn = mysql_connect($"."host, $"."user, $"."pass) or die(mysql_error());".PHP_EOL;
	//$buffer.="mysql_select_db($"."database) or die(mysql_error());".PHP_EOL;
	$buffer.="$"."conn = mysqli_connect($"."host,$"."user, $"."pass, $"."database);".PHP_EOL; //  MYSQL
	fputs($fp, $buffer.PHP_EOL);


	$handle = @fopen($filename_sql, "r");// to_clean.txt
if ($handle) {
	$i=0;$number=0;
while (!feof($handle)) {
	$query= fgets($handle, 4096);// read each line
	$i++;// increment, order of line
	$query=rtrim($query);// escape blank and space without to say nothing

	$search=";";
	$pos=strpos($query,$search);

	if ($pos !== false)

	{
		$number=$i;// at this end, put
	}

	if (empty($query)) {
		//echo "nothing line ".$i;//do not write this
		$i--;
	}
	else
	{
		if ($i==1 OR $i==$number+1) {//real beginning, or next step
			//echo $i." begin : ";
			$buffer="$"."query=\"";// begin :
			fputs($fp, $buffer);
		}
		$queries="$"."query";
		//$query=str_replace(";","\";".PHP_EOL."mysql_query(".$queries.") or die(mysql_error());".PHP_EOL,$query);// END     MYSQL
		$query=str_replace(";","\";".PHP_EOL."$"."conn->query(".$queries.");".PHP_EOL,$query);
		$buffer=$query.PHP_EOL;
		fputs($fp, $buffer);
	}


}
	fclose($handle);
}

	//$buffer="header('Location: ./');";// becareful to timeout : stay to confirm creation
	$buffer="echo \"<a href='../'>Acces au site</a>\";";

	$buffer.=PHP_EOL."?>";
	fputs($fp, $buffer);
	fclose($fp);//close final document
}
// CREATE INSTALLATION QUERY end

?>