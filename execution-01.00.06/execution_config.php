<?php
// UPDATE 12-11-18
$env=ENV;// 0 1 2 ... multiple environments
// connection : see config general : to put here for the module alone

// fields
$execution_scenario_table=PREFIX."execution_scenario";
$execution_scenario_id="exs_id";
$execution_scenario_parent_id="exs_category_id";
$execution_scenario_label="exs_label";
$execution_scenario_beginning="exs_create_date";
$execution_scenario_end="exs_close_date";

$execution_step_table=PREFIX."execution_steps";
$execution_step_id="exp_id";
$execution_step_fk_id="exp_step_id";
$execution_fk_id="exp_execution_id";
$execution_step_obtained="exp_obtained";
$execution_step_status="exp_status";
$execution_step_date="exp_date";

// option
$type=0;// 0 basic, 5 full ajax
$language=LANG;//$language="fr";// fr french, uk english
require_once("execution_lang_".$language.".php");// put automatically current directory $here.
$execution_css=$general_css;//"execution_design_01.css";
$execution_favico=$general_favico;
$execution_debug=DEBUG;//0 none, 1 inline, 2 textlog

// other application
?>