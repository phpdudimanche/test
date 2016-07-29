<?php
// UPDATE 12-12-05
// general
$down="see only sub-categories";
$add="add";
$update="modify";
$delete="delete";
$order="order";
$move="move";
$validate="validate";
$same_level="same level categories";
$order_crack="Use decimals is very simple to go to an interval without too much changes.";
$process_move="select on the right the element to move to its new parent <br />or return to the <a href='category_list_edt.php'>listing page</a><br /><br />";
$import="import";

$down_label=$down;// for title hover icons
$add_label=$add;
$update_label=$update;
$delete_label=$delete;
$order_label=$order;
$move_label=$move;
$import_label=$import;

$before_delete_with_childs=<<<EOF
In the way to delete the category choosen and all this child.<br />
Do <a href='category_delete_act.php'>you confirm</a> or <a href='category_list_edt.php'>you abort</a> ?<br />
EOF;
$before_delete_without_child=<<<EOF
You want to delete the category choosen without child.<br />
Do <a href='category_delete_act.php'>you confirm</a> or <a href='category_list_edt.php'>you abort</a> ?<br />
EOF;

$lg_category_level="subcategories number to display";
$lg_category_level_label=array(1=>"objet de test",2=>"article de test",3=>"condition de test",34=>"cas de test",5=>"procedure de test");// ISTQB norm


// to other module
$target_label="scenario";
$category_scenario_duplicate_label="duplicate";// scenario
$category_upload_label="upload media";
$opt_upload_scenario="requirement";
$opt_upload_update="update attachments";// not used any more
$opt_upload_update_sg="attachment";// update the unique
$opt_upload_update_pl_1="";// update the
$opt_upload_update_pl_2="attachments";
$opt_upload_level=array(1=>'strategy',2=>'plan test',3=>'scenarios',4=>'test');//

$scenario_label=$target_label;// for title hover icons
$duplicate_label=$category_scenario_duplicate_label;
$upload_the_label=$category_upload_label;
$upload_admin=$opt_upload_update;

// head
$title_category_list_edt="categories' list";
$title_category_add_edt="add category";
$title_category_move_edt="move category";
?>