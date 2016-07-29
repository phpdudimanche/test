<?php
/* update 12-08-01
  normaly there's no update (just if there's a mistake), only create
  the execution is unique
  repeat list of steps of the scenario
  add specific fields : obtained, status, date (of the day)
  button : pause / close
   */
require_once("execution_inc.php");
//echo ROOT;//complete path with this directory
$result = str_replace('/'.EXECUTION.'/','', ROOT);
//echo "<br />".$result;//without this directory
//echo "<br />".$result."/".SCENARIO."/scenario_config.php";
require_once($result."/".SCENARIO."/scenario_inc.php");
require_once($result."/".CATEGORY."/category_config.php");
isset($_REQUEST["execution_id"])?$execution_id=input($_REQUEST["execution_id"]):$execution_id="";
isset($_REQUEST["scenario_id"])?$scenario_id=input($_REQUEST["scenario_id"]):$scenario_id="";
isset($_REQUEST["begin"])?$begin=$_REQUEST["begin"]:$begin=0;// for pagination

head($lg_execution_steps_create,$execution_css,'../public/'.$general_js.'',$execution_favico);
include('../public/_header.php');

if ($execution_debug==1)
{
print_r($lg_execution_status);
}

//select_list($lg_execution_status,'');
//$query="SELECT * FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id ORDER BY $scenario_step_order LIMIT $begin,$steps_by_page";
$query="SELECT * FROM  $scenario_table, $execution_step_table WHERE $execution_step_fk_id=$scenario_step_id AND
$execution_fk_id=$execution_id ORDER BY $scenario_step_order LIMIT $begin,$steps_by_page";// to transmit : $execution_id
// with excecution fields (create and update) TODO sjoin with execution_steps_table
	if ($execution_debug==1)
	{
	echo $query;
	}
//$query = mysql_query($query);
$query=query_retrieve($query);
$result1=output_query_execution_step($query, $scenario_step_id);// TODO put the id of each execution step
	if ($execution_debug==1)
	{
	echo "<pre> Steps";
	print_r($result1);
	echo "</pre>";
	}
// for label explanation
$query="SELECT $execution_scenario_label, (SELECT $category_label FROM $category_table WHERE $category_id=$scenario_id) as $category_label FROM $execution_scenario_table WHERE $execution_scenario_id=$execution_id";
// OK SELECT exs_label FROM execution_scenario WHERE exs_id=6 // SELECT $execution_scenario_label FROM $execution_scenario_table WHERE $execution_scenario_id=$execution_id
// SELECT category_label FROM category WHERE category_id=3
// OK : SELECT category_label, (SELECT exs_label FROM execution_scenario WHERE exs_id=6) as scenario_label FROM category WHERE category_id=3
// KO :    SELECT e.exs_label, c.category_label FROM execution_scenario e JOIN category c ON c.category_id=e.exs_category_id
//echo $query;//exit();
//$query = mysql_query($query);
$query=query_retrieve($query);
$answer=output_query_explanation_label($query,$execution_id);
//print_r($answer);
	/*$label_cat=$answer[$execution_id][$category_label];
	$label_exe=$answer[$execution_id][$execution_scenario_label];
	echo $lg_execution_sc.' : '.$label_cat.' | '.$lg_execution_ex.' : '.$label_exe. ' | ';*/
// for pagination
//$query = mysql_query("SELECT COUNT($scenario_step_id) FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id");
$query=query_retrieve("SELECT COUNT($scenario_step_id) FROM $scenario_table WHERE $scenario_step_scenario_id=$scenario_id");
//$result_compt=mysql_fetch_row($query);
$result_compt=mysqli_fetch_row($query);
$total=$result_compt[0];

require_once($result."/".CORE."/lib_Pagination.php");
$link='execution_steps_create.php?execution_id='.$execution_id.'&scenario_id='.$scenario_id.'';//?execution_id=17&scenario_id=19

// action link about general execution
echo '<a href="execution_scenario_pause.php?execution_id='.$execution_id.'">'.$lg_execution_pause.'</a> | <a href="execution_scenario_close.php?execution_id='.$execution_id.'">'.$lg_execution_close.'</a>';
// pagination
echo "<div id='pagination'>";
pagination($total, $steps_by_page, $begin, $link);
echo "</div>";
// pagination
//display_scenario_steps_list_edit($result);// see : display_scenario_steps_list_edit($result);
display_execution_steps_create($result1);
// pagination
echo "<div id='pagination'>";
pagination($total, $steps_by_page, $begin, $link);
echo "</div>";
// pagination
include('../public/_footer.php');
?>
</body></html>