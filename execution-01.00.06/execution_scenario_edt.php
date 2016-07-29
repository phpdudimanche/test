<?php
/* UPDATE 12-11-17
form for create (update delete) : scenario
create 	create title as unique display field
   		get scenario_id from scenario
   		(put date now ? or after in the script)
		go to execution_scenario_create_act.php
   		can not create scenario without steps (verify or before)
   used by :scenario_steps_list_edt.php, category_list_edt.php
*/
require_once("execution_inc.php");
isset($_REQUEST["cat_id"])?$cat_id=input($_REQUEST["cat_id"]):$cat_id="";
isset($_REQUEST["cat_name"])?$cat_name=input($_REQUEST["cat_name"]):$cat_name="";



$form_goto="execution_scenario_create_act.php";
$form_name="scenario_create";
$form_submit=$lg_submit;
$number_submit=1;
$get_id=$cat_id;
$get_name=$cat_name;

// verify_execution : if exists yet an execution which is not finished whith this scenario id in relation, go to execution_scenario_step
//$query = mysql_query("SELECT $execution_scenario_id FROM $execution_scenario_table WHERE $execution_scenario_parent_id=$get_id AND $execution_scenario_end=2010-10-10");
$query=query_retrieve("SELECT $execution_scenario_id FROM $execution_scenario_table WHERE $execution_scenario_parent_id=$get_id AND $execution_scenario_end='2010-10-10'");
$result=output_query_execution_id_in_process($query);// TODO
//echo $result;
	if ($result=="") {// to create : first one or the others

	head($lg_execution_title_02,$execution_css,'../public/'.$general_js.'',$execution_favico);
	include('../public/_header.php');
	
	echo '<br /><a href="'.$_SERVER['HTTP_REFERER'].'">'.$lg_back.'</a><br /><br />';
	
	display_form_scenario($form_goto,$form_name,$form_submit,$number_submit,$get_id,$get_name);
	include('../public/_footer.php');

	}
else{// it's already exists and is not finished
header('location:execution_steps_create.php?execution_id='.$result.'&scenario_id='.$cat_id.'');
}


?>
