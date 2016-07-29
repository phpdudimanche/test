<?php // UPDATE 12-11-25
$lg_cfg_edit="Edition des paramètres de configuration";
$lg_submit=" modifier ";

$menu_home=array(0=>"Liste des modules",1=>"Liste des fonctions");// NEW
$menu_config=array('general_'=>"Tout module",'category_'=>"Module catégorie",'scenario_'=>"Module scénario",'upload_'=>"Module documents");
$title_label['general_lang']="Langue àafficher";
$title_label['general_debug']="Mode de débuggage";

$label['general_lang']=array("'fr'"=>"français","'uk'"=>"anglais"); 
$label['general_debug']=array(0=>"désactivé",1=>"affichage en ligne");

$title_label['category_level']="Niveau de profondeur maximum à afficher en catégorie";
$title_label['category_icons']="Afficher des icônes dans le menu";
$title_label['category_link_upload']="Lien de téléchargement";
$title_label['category_link_scenario']="Lien de scenario";
$title_label['category_link_execution']="Lien d'exécution";

$label['category_level']=" ";
$label['category_icons']=array(0=>"ne pas afficher",1=>"afficher");
$label['category_link_upload']=array(1=>"afficher",0=>"ne pas afficher");
$label['category_link_scenario']=array(1=>"afficher",0=>"ne pas afficher");
$label['category_link_execution']=array(1=>"afficher",0=>"ne pas afficher");

$title_label['scenario_istqb']="Norme CFTL Certification Française de Tests Logiciels";

$label['scenario_istqb']=array(0=>"non activée",1=>"activée");
$label['scenario_steps_bypage']="Pas affichés par page ";
$label['scenario_steps_empty']="Pas vides pour la création en fin de page ";

$title_label['upload_list_number']="Nombre maximum de documents à afficher par page";

$label['upload_list_number']=" ";

?>