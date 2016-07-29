<?php
// UPDATE 12-12-05
// general
$down="sous familles";
$add="ajouter";
$update="modifier";
$delete="supprimer";
$order="réordonner";
$move="déplacer";
$validate="valider";
$same_level="les catégories de même niveau";
$order_crack="Pour éviter de tout renuméroter, utiliser des décimales pour vous placer dans les intervalles.";
$process_move="sélectionner à aguche l'élememnt à déplacer à droite vers son nouveau parent <br />ou retourner à la <a href='category_list_edt.php'>page de gestion</a><br /><br />";
$import="importer";

$down_label=$down;// for title hover icons
$add_label=$add;
$update_label=$update;
$delete_label=$delete;
$order_label=$order;
$move_label=$move;
$import_label=$import;

$before_delete_with_childs=<<<EOF

Vous allez supprimer la catégorie et toutes ses catégories filles.<br />
Est-ce que <a href='category_delete_act.php'>vous confirmez</a> ou <a href='category_list_edt.php'>vous annulez</a> ?<br />
EOF;
$before_delete_without_child=<<<EOF

Vous allez supprimer la catégorie choisie, qui est sans catégorie fille.<br />
Est-ce que <a href='category_delete_act.php'>vous confirmez</a> ou <a href='category_list_edt.php'>vous annulez</a> ?<br />
EOF;

$lg_category_level="le nombre de sous familles à afficher";
$lg_category_level_label=array(1=>"objet de test",2=>"article de test",3=>"condition de test",4=>"cas de test",5=>"procédure de test");// ISTQB norm
$lg_back="retour";

// to other module
$target_label="scenario";
$category_scenario_duplicate_label="copier";// le scenario
$category_upload_label="télécharger un document";
$opt_upload_scenario="exigence";
$opt_upload_update="gérer les pièces jointes";// not used any more
$opt_upload_update_sg="pièce jointe";//gerer la
$opt_upload_update_pl_1="";//gerer les
$opt_upload_update_pl_2="pièces jointes";
$cat_error="merci de vérifier que l'installation s'est bien effectuée";
$opt_upload_level=array(1=>'stratégie de test',2=>'plan de test',3=>'liste de scénarios',4=>'test');//

$scenario_label=$target_label;// for title hover icons
$duplicate_label=$category_scenario_duplicate_label;
$upload_the_label=$category_upload_label;
$upload_admin=$opt_upload_update;

// head
$title_category_list_edt="lister les catégories";
$title_category_add_edt="ajouter une catégorie";
$title_category_move_edt="déplacer une catégorie";
$title_category_update_edt="modifier une catégorie";
$title_category_order_edt="changer l'ordre d'une catégorie";
?>