<?php
// UPDATE  12-11-21

$lg_submit="créer";
$lg_excution_label="désignation de l'exécution du scenario";
$lg_execution_create_title="exécuter le scénario";
$lg_execution_pause="marquer une pause";
$lg_execution_close="clôturer l'exécution";
$lg_obtained="obtenu";
$lg_status="statut";
$lg_back="retour";
$lg_close="terminé";
$lg_inprogress="en cours";

// other
$lg_execution_sc="scénario";
$lg_execution_ex="exécution";
// titles
$lg_execution_steps_create="exécuter la procédure de test";
$lg_execution_title_01="exécution des procédure de cas de test";
$lg_execution_title_02="liste des exécutions terminées pour un scenario donné";
$lg_execution_title_03="rapport d'exécution pour un scenario donné";
$lg_execution_report_label="rapport";
// text
$lg_execution_report_presentation="rapport de l'exécution <i>%s</i> n° %s pour le scenario <i>%s</i> n° %s";

// array
$execution_steps_labels=array('original_id' =>"id",'action' =>"action",'expected' =>"attendu",$execution_step_obtained=>"obtenu",
$execution_step_status=>"statut");// add compare to scenario :: order => "ordre",
$execution_report_labels=array('status'=>"statut",'number'=>"volume",'percent'=>"pourcentage");
// tables fields=>lang label
$lg_execution_status=array(1=>"NT",2=>"KO",3=>"OK");

// links in other applications
$lg_execution_link="exécuter le scénario ";
$lg_execution_scenario_select="choisissez un scénario à exécuter";
$lg_execution_in_progress="reprendre l'exécution";
$lg_execution_yet_closed="exécution(s) terminée(s)";
$lg_execution_list_closed='%s pour le scénario <i>%s</i>';
$lg_execution_begin="début";
$lg_execution_end="fin";

$lg_execution_link_label=$lg_execution_link;// for title hover icons
$lg_execution_in_progress_label=$lg_execution_in_progress;
$lg_execution_yet_closed_label=$lg_execution_yet_closed;

?>