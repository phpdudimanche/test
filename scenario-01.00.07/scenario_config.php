<?php
// UPDATE 12-11-13
$env=ENV;// 0 1 2 ... multiple environments
// connection : see config general : to put here for the module alone

// other application
if (stripos(ROOT, EXECUTION)!==FALSE) { // used by execution_steps_create.php
	$result = str_replace('/'.EXECUTION.'/','', ROOT);
}
elseif(stripos(ROOT, CATEGORY)!==FALSE) { // used by category_list_edt.php
	$result = str_replace('/'.CATEGORY.'/','', ROOT);
}
else{
		$result = str_replace('/'.SCENARIO.'/','', ROOT);//in root, sustract current directory ORIGINAL SCRIPT
}
require_once($result."/".CORE."/lib_Mysql.php");

// fields
$scenario_table=PREFIX."scenario_step";
$scenario_step_id="sc_step_id";
$scenario_step_action="sc_step_action";
$scenario_step_expected="sc_step_expected";
$scenario_step_order="sc_step_order";
$scenario_step_scenario_id="sc_step_scenario_id";

// option
$type=0;// 0 basic, 5 full ajax
$language=LANG;//$language="fr";// fr french, uk english
//$here=for_include($_SERVER['DOCUMENT_ROOT'],$_SERVER['SCRIPT_NAME']);
require_once("scenario_lang_".$language.".php");// put automatically current directory $here.
$scenario_css=$general_css;//"scenario_design_01.css";
$scenario_favico=$general_favico;
$scenario_debug=DEBUG;//0 none, 1 inline, 2 textlog
$steps_by_page=STEPS_FULL;// NEW 10
$steps_to_add=STEPS_EMPTY;// NEW 2
?>