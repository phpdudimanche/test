<?php
// UPDATE 12-12-05
// title of page
$title_001="liste des pas de test du scenario";
$title_002="importer catégories et pas de test";// NEW

// buttons
$submit="envoyer";

// labels of fields table
$scenario_table_label="pas du scenario :";
$scenario_step_id_label="id";
$scenario_step_action_label="action";
$scenario_step_expected_label="attendu";
$scenario_step_order_label="ordre";
$scenario_step_delete="suppr.";

// cracks to be more easy (http://php.net/manual/fr/function.list.php)
$scenario_steps_labels=array($scenario_step_id =>$scenario_step_id_label,$scenario_step_order => $scenario_step_order_label,$scenario_step_action =>$scenario_step_action_label,$scenario_step_expected =>$scenario_step_expected_label,$scenario_step_delete=>$scenario_step_delete);

// link to other application
$lg_category_label="tous les scenarios";// application category : same word as category_config
$category_next_label="scenario suivant";
$link_export_xls="export XLS";
$lg_category_select="choisissez un scénario à afficher";
?>