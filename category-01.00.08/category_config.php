<?php
// UPDATE 12-11-15
$env=ENV;// 0 1 2 ... multiple environments
// connection : see config general : to put here for the module alone

// fields
$category_table=PREFIX."category";
$category_id="category_id";
$category_parent_id="parent_id";
$category_order="orderby";
$category_label="category_label";

// option
$type=0;// 0 basic, 5 full ajax
$istqb=ISTQB;// display istqb level 0 NO / 1 YES
$language=LANG;//$language="fr";// fr french, uk english
$category_design=$general_css;//"category_design_01.css";
$category_favico=$general_favico;
require_once("category_lang_".$language.".php");
$category_delete_warning=0;// O none, 1 warning : warning when user delete category
$category_debug=DEBUG;//0 none, 1 inline, 2 textlog
$target_link="../".SCENARIO."/";//link to other module which uses category scenario-00.01
$category_icons=CATEGORY_ICONS;
$opt_category_media=LINKS_UPLOAD;//link for upload, link media : 0 no, 1 yes
$opt_category_appli=LINKS_SCENARIO;//link to other application : scenario,
$opt_category_execution=LINKS_EXECUTION;

// sub opt ions
$opt_display_upload=1;// display all attachments in menu YES:0 NO:1
$opt_display_level_upload=0;// display documents type by level : $opt_upload_level[$currLevel] : YES:0 NO:1
?>