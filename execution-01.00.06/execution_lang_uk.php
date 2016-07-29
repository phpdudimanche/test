)<?php
// UPDATE  12-11-21

$lg_submit="create";
$lg_excution_label="label scenario's execution";
$lg_execution_create_title="create an execution name";
$lg_execution_pause="pause";
$lg_execution_close="close";
$lg_obtained="obtained";
$lg_status="status";
$lg_back="back";
$lg_close="close";
$lg_inprogress="in progress";

// other
$lg_execution_sc="scenario";
$lg_execution_ex="run test";
// titles
$lg_execution_steps_create="run test";
$lg_execution_title_01="test execution";
$lg_execution_title_02="terminated execution scenario";
$lg_execution_title_03="execution scenario report";
$lg_execution_report_label="report";
// text
$lg_execution_report_presentation="execution report <i>%s</i> n° %s for the scenario <i>%s</i> n° %s";

// array
$execution_steps_labels=array('original_id' =>"id",'action' =>"action",'expected' =>"expected",$execution_step_obtained=>"obtained",
$execution_step_status=>"status");
$execution_report_labels=array('status'=>"status",'number'=>"quantity",'percent'=>"percentage");
// tables fields=>lang label
$lg_execution_status=array(1=>"NT",2=>"KO",3=>"OK");
// links in other applications
$lg_execution_link="run scenario ";
$lg_execution_scenario_select="select a scenario to run";
$lg_execution_in_progress="finish run test in progress";
$lg_execution_yet_closed="run test finished";
$lg_execution_list_closed='%s for the scenario<i>%s</i>';
$lg_execution_begin="start";
$lg_execution_end="stop";

$lg_execution_link_label=$lg_execution_link;// for title hover icons
$lg_execution_in_progress_label=$lg_execution_in_progress;
$lg_execution_yet_closed_label=$lg_execution_yet_closed;
?>