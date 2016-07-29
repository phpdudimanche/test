<?php
/* UPDATE 12-10-10
   For a scenario id, an array list of all steps and of fields.
   Verify if there is value in an array
   If there is already id, put the row in an array, a "update_array".
   - The modify array will be put by session in the "scenario_steps_update_act.php".
   If there is no existent id, but values in one of the other field, put the row in an a array, a "create_array".
   - The create array will be put by session in the "scenario_steps_create_act.php".
   If there is no value : no id, no value in any field ot the row: do nothing.
   In every case, use header redirection :
	   first "scenario_steps_update_act.php",
	   then "scenario_steps_create_act.php",
	   and at least "scenario_step_list_edt.php".

*/
session_start();
require_once("scenario_inc.php");
//error_reporting(0);
isset($_REQUEST["steps"])?$steps=$_REQUEST["steps"]:$steps="";
isset($_SESSION['increment'])?$increment=$_SESSION['increment']:$increment==0;
isset($_SESSION['scenario'])?$scenario=$_SESSION['scenario']:$scenario=='';
$scenario_id=$scenario['id'];
$scenario_name=$scenario['name'];
if ($scenario_id==''){
	$scenario_name="test";
	$scenario_id=0;
}
	$scenario_total=$scenario['total'];
	$referer = $_SERVER["HTTP_REFERER"];
	//echo $referer;
	//exit();
/*
print_r($increment);
echo $increment;
echo "here";
*/
if ($scenario_debug==1)
{
	echo "steps to trait in this script";
	echo "<pre>";
	print_r($steps);
	echo "</pre>";
}

// here, was the order
$result=array();// ANO-104
$ia=1;
$a=0;
foreach ($steps as $key=>$value){// null values may be everywhere

	if (empty($steps[$ia]['step_id'])AND empty($steps[$ia]['step_action']) AND empty($steps[$ia]['step_expected'])) {

	$a++;// just ignore this nothing

		// echo "nothing<br />";
		$result['nothing'][$ia]['step_id']=$steps[$ia]['step_id'];// ANO-104
		$result['nothing'][$ia]['step_order']=$steps[$ia]['step_order'];
		$result['nothing'][$ia]['step_action']=$steps[$ia]['step_action'];
		$result['nothing'][$ia]['step_expected']=$steps[$ia]['step_expected'];

		unset($steps[$ia]);// delete null array

	//	$i++;
	}
	elseif ($steps[$ia]['step_order']==NULL)
	{
	//echo "array".$i." has no order <br />";
		$steps_1[$ia]=$steps[$ia];// assign to other array
		unset($steps[$ia]);// delete of this old array
	}
	else{

	}

	 $ia++;
}

//$size=$total-$a;//not used anymore

//$steps_2=array_slice($steps, 0, $size);// select only array with values $a-1 // $a forget the last value and add a null value first
$steps_2=$steps;
if ($scenario_debug==1)// do nothing
{
$total=count($steps_2);
//echo "There are ".$a." null values to ignore<br />";
//echo "There are ".$size." values to get<br />";
//echo "The second array with values is beginning at this number ".$a."<br />";
echo "There are ".$total." array in the array with values and order <br />";// if null is first
	echo "<pre>";
	print_r($steps_2);
	echo "</pre>";
}

// here, is now the order, obligatory the order is not null (vs bug of order)
usort($steps_2, "compare");//
$total=count($steps_2);

if ($scenario_debug==1)
{
	echo "steps by order";
	echo "<pre>";
	print_r($steps_2);
	echo "</pre>";

	echo "There are ".$total." array in the order array with value <br />";
}

if (isset($steps_1)){
$steps_2=array_merge($steps_2,$steps_1);

	if ($scenario_debug==1)
	{
		echo "steps without order to join";
		echo "<pre>";
		print_r($steps_1);
		echo "</pre>";

		echo "the 2 array steps joined in the good order";
		echo "<pre>";
		print_r($steps_2);
		echo "</pre>";
	}


}


/* if ($scenario_debug==1)
{
	echo "steps without order to join";
	echo "<pre>";
	print_r($steps_1);
	echo "</pre>";

	echo "the 2 array steps joined in the good order";
	echo "<pre>";
	print_r($steps_2);
	echo "</pre>";
}*/

$i=0;
$a=$increment;// to begin by limit of the query
$a++;
foreach ($steps_2 as $key => $value) {// ignore if step_order is null replace with increment
		$steps_2[$i]['step_order']=str_replace($steps_2[$i]['step_order'],$a,$steps_2[$i]['step_order']);// replace decimals or old order_id by integer increment : the beginning is different by page

	if ($steps_2[$i]['step_order']==NULL)
	{

		if ($scenario_debug==1)
		{
		echo "action of every order wich is null : ".$steps_2[$i]['step_action']."<br />";
		}

	$a--;// do not count this step
	$steps_null[$i]='null';// not possible
	}

		if ($scenario_debug==1)
		{
		echo $steps_2[$i]['step_order']." | ";
		}

$i++;
$a++;// last increment
}


if ($scenario_debug==1 & isset($steps_null))// & isset($steps_null)  CHANGE
{
	echo "id wich orders are null";
	echo "<pre>";
	print_r($steps_null);
	echo "</pre>";
}

if (isset($steps_null)){// vs error if nothing is null

foreach ($steps_null as $key => $value){

	if ($scenario_debug==1)
	{
		echo "new order for each is :".$key."<br />";
	}
	$steps_2[$key]['step_order']=$a;//rename 0 with max order
	$a++;// continue increment

}
}


/* TODO
$a is the last order
if there are other data, other result pages (verify by a query) -> it is known with pagination script
reorder the rest since $a (use script and page scenario_steps_order.php)
execute this script before all
*/

if ($scenario_debug==2)
{
	echo "the last increment to use is this one : ".$a;
	echo "<br />order all the rest : get it by query and update";

$total=count($steps_2);
echo "<br />There are ".$total." array in the array with values and order renumbered<br />";// if null is first
	echo "<pre>";
	print_r($steps_2);
	echo "</pre>";




}




$i=-1;// bug, last number
foreach ($steps_2 as $key=>$value){
$i++;
	if (isset($steps_2[$i]['step_delete'])){// new    if ($steps_2[$i]['step_delete']=="true")
		//echo "delete<br />";	// can remove an order but not important : interval is correct
		$result['delete'][$i]['step_id']=$steps_2[$i]['step_id'];
		$result['delete'][$i]['step_order']=$steps_2[$i]['step_order'];
		$result['delete'][$i]['step_action']=$steps_2[$i]['step_action'];
		$result['delete'][$i]['step_expected']=$steps_2[$i]['step_expected'];
		$result['delete'][$i]['step_expected']=$steps_2[$i]['step_delete'];
	}
	elseif (empty($steps_2[$i]['step_id'])AND(!is_null($steps_2[$i]['step_action'])OR!is_null($steps_2[$i]['step_expected']))) {// create
		//echo "create<br />";
		$result['create'][$i]['step_id']=$steps_2[$i]['step_id'];
		$result['create'][$i]['step_order']=$steps_2[$i]['step_order'];
		$result['create'][$i]['step_action']=$steps_2[$i]['step_action'];
		$result['create'][$i]['step_expected']=$steps_2[$i]['step_expected'];
	}
	else{
		//echo "update<br />";
		$result['update'][$i]['step_id']=$steps_2[$i]['step_id'];
		$result['update'][$i]['step_order']=$steps_2[$i]['step_order'];
		$result['update'][$i]['step_action']=$steps_2[$i]['step_action'];
		$result['update'][$i]['step_expected']=$steps_2[$i]['step_expected'];
	}
}


// order the rest BEGIN : should be an order page
//$to_minus=count($result['create']);  CHANGE
if (isset($result['create'])){
$to_minus=count($result['create']);
}
else
{
$to_minus=0;
}

$b=$a-$to_minus;
$b--;// take the order just before, the beginning must be 0 and not 1
if (isset($result['update'])){// NEW
$passed=count($result['update']);
$c=$scenario_total-$passed;// total to display : total minus update paste
}
else{
$c=$scenario_total;
}

if ($scenario_debug==1){
echo "<br />array create counts ".$to_minus." elements<br />";
echo "take data since the number ".$a." minus ".$to_minus."<br />";// $last minus $steps_1 ou create
echo "This equals to ".$b;
echo "<br />there are ".$c." data to display";
}

//$query = mysql_query("SELECT $scenario_step_id,$scenario_step_order FROM $scenario_table WHERE $scenario_step_scenario_id='$scenario_id' ORDER BY $scenario_step_order LIMIT $b,$c");
$query=query_retrieve("SELECT $scenario_step_id,$scenario_step_order FROM $scenario_table WHERE $scenario_step_scenario_id='$scenario_id' ORDER BY $scenario_step_order LIMIT $b,$c");
//$number = mysql_num_rows($query);
$number = mysqli_num_rows($query);
//echo $number.' values to display<br/>';//$a.' - '.
//while($row = mysql_fetch_assoc($query)){
while($row = mysqli_fetch_assoc($query)){
$id=output($row['sc_step_id']);

//$update=mysql_query("UPDATE $scenario_table SET $scenario_step_order = '$a' WHERE $scenario_step_id = '$id'") or die(mysql_error());
$update=query_record("UPDATE $scenario_table SET $scenario_step_order = '$a' WHERE $scenario_step_id = '$id'");
		if ($scenario_debug==2)
		{
		echo "new order ".$a."for id ".$id." - ";
		}
$a++;
}
// order the rest END




$_SESSION['result']=$result;

if ($scenario_debug==1)
{
	echo "<pre>";
	echo "delete :";
		if (isset($result['delete'])){
	print_r($result['delete']);
	echo "<a href='scenario_steps_delete_act.php'>delete this before update</a>";
		}
	echo "</pre>";

	echo "<pre>";
	echo "nothing :";
		if (isset($result['nothing'])){
	print_r($result['nothing']);
		}
	echo "</pre>";

	echo "<pre>";
	echo "create :";
		if (isset($result['create'])){
	print_r($result['create']);
		}
	echo "</pre>";

	echo "<pre>";
	echo "update :";
	print_r($result['update']);
	echo "<a href='scenario_steps_update_act.php'>update first</a>";
	echo "</pre>";

	/*echo "<pre>";
	echo "totality in session :";
	print_r($_SESSION['result']);
	echo "</pre>";*/

}

header('location:scenario_steps_delete_act.php');//scenario_steps_update_act.php : order = order/delete/update/create
?>