<?php
/* UPDATE 12-11-17
for a scenario execution : how many results by status in quantities and purcents
statut -  nombre - %
 OK			2     20
 KO			5	  70
 NT			1     10
 total      8  - 100
*/
require_once("execution_inc.php");
isset($_REQUEST["cat_id"])?$execution_id=$_REQUEST["cat_id"]:$execution_id=0;
isset($_REQUEST["cat_name"])?$execution_name=$_REQUEST["cat_name"]:$execution_name="test";
isset($_REQUEST["category_id"])?$id=$_REQUEST["category_id"]:$id=0;
isset($_REQUEST["category_name"])?$name=$_REQUEST["category_name"]:$name="";
head($lg_execution_title_03,$execution_css,'../public/'.$general_js.'',$execution_favico);
include('../public/_header.php');

printf($lg_execution_report_presentation,$execution_name,$execution_id,$name,$id);

echo '<br /><a href="'.$_SERVER['HTTP_REFERER'].'">'.$lg_back.'</a><br />';

$query="select count(*) as number, $execution_step_status from $execution_step_table WHERE 
$execution_fk_id=$execution_id GROUP BY $execution_step_status ORDER BY $execution_step_status ASC";
if ($execution_debug==1)
{
echo "<pre>";
echo $query;
echo "</pre>";
}
//$query = mysql_query($query);
$query = query_retrieve($query);
// OUTPUT display even null values : display all the status !
$array = array();
$i=0;
//while($row = mysql_fetch_assoc($query)){
while($row = mysqli_fetch_assoc($query)){
if (output($row[$execution_step_status])==NULL){ // TODO correct behind : create with 0 if no status
$array[0]=array('number' => output($row['number']),'status'=>0);;
}
else
{
$array[output($row[$execution_step_status])]=array('number' => output($row['number']),'status'=>output($row[$execution_step_status]));
}
// ID = output($row[$execution_step_status])
// LABEL = $lg_execution_status[output($row[$execution_step_status])]
// NOT $array[$i], but
$i++;
}
//return($array);
//$total=sizeof($array);// for the loop (finally not used)

if ($execution_debug==1)
{
echo "<pre>";
echo "Output of database with id status :";
print_r($array);
//echo "size : ".$total;
echo "</pre>";
} 
 
// DISPLAY like $lg_execution_status=array(1=>"NT",2=>"KO",3=>"OK");
$lg_execution_status=array(0=>"EMPTY",1=>"NT",2=>"KO",3=>"OK");// ,4=>"test",5=>"non plus"  FOR the test 0=>"NULL",
$count=sizeof($lg_execution_status);
for($a=0; $a<$count; $a++) {// logic : satus is principle, result is slave 
/* echo ' for status '.$array[$a]['status'].
' named '.$lg_execution_status[$array[$a]['status']].
' number '.$array[$a]['number']; */
	if (array_key_exists($a,$array))
	{
	/*echo ' for status '.$array[$a]['status'].
	' named '.$lg_execution_status[$array[$a]['status']].
	' number '.$array[$a]['number'].'<br />';*/

/*if (!isset($lg_execution_status[$a])){
$array[$a]['status']="EMPTY";
echo "mistake";
}
else{*/
//echo "good";
$array[$a]['status']=$lg_execution_status[$a];// do this here and not in the output query is better
//}
	}
	else
	{
	//echo "no key ".$a. " - ";
$array[$a]=array('number' =>0,'status'=>$lg_execution_status[$a]);// ad array and join array -- for null value
// ID = 'status'=>$a 
// LABEL =$lg_execution_status[$a] : bug, retrieve database value
	}
}

ksort($array);// sort final array

if ($execution_debug==1)
{
echo "<pre>";
echo "Final array with label and status without data :";
print_r($array);//to use with graphic stat
echo "</pre>";
} 

$total = 0;
$i=0;// status 0 is the no-status nammed empty
foreach ($array AS $key=>$value) {
//echo $array[$i]['number'].' - ';
$total += $array[$i]['number'];
$i++;
}
//echo $total;

function percentage($quantity, $total) { // bad round
	//$resultat = ($Nombre / $total) * 100;
	//return round($resultat);
	//return $quantity * 100 / $total;// round()
	$result = $quantity * 100 / $total;
	return number_format($result,2);// 2 chiffres après virgule
}
$i=0;// status 0 is the no-status nammed empty
foreach ($array AS $key=>$value) {
$array[$i]['percent'] = percentage($array[$i]['number'], $total);
$i++;
}
if ($execution_debug==1)
{
echo "<pre>";
echo "Definitiv array with percentage for the total ".$total.":";
print_r($array);//to use with graphic stat
echo "</pre>";
} 

echo "<table id='report'>";
echo "<thead>";//header
foreach ($execution_report_labels AS $key=>$value) {
echo "<th>";
echo $value;
echo "</th>";
}
echo "</thead>";
echo "<tfoot>";//footer
echo "<tr><th>total</th><th>".$total."</th><th></th></tr>";
echo "</tfoot>";
$i=0;// status 0 is the no-status nammed empty
foreach ($array AS $key=>$value) {//content
echo "<tr class='".$array[$i]['status']."'>";
echo "<td width='100'>";
	echo $array[$i]['status'];
echo "</td>";
echo "<td width='100'>";
	echo $array[$i]['number'];
echo "</td>";	
echo "<td width='100'>";
	echo $array[$i]['percent']." %";  
echo "</td>";
echo "</tr>";
$i++;
}
echo "</table>";

include('../public/_footer.php');
?>