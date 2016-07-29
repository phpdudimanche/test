<?php
// UPDATE 12-12-05
$env=ENV;//0 usb 1 olympe 2 free julien
// connection : see config general : to put here for the module alone

$directory="../data/";// last level
$extensions_authorised = array('.png', '.bmp', '.jpg', '.jpeg','.JPG', '.gif', '.GIF',  '.doc', '.xls');// '.jpg', '.jpeg','.JPG',
$size_authorised=5240000;
$extensions_authorised_csv = array('.csv');
$size_authorised_csv=1240000;


// fields
$upload_table=PREFIX."upload";
$upload_id="upload_id";// increment
$upload_number="upload_number";// reference to id of category, scenario...
$upload_label="upload_label";// description
$upload_name="upload_name";
$upload_extension="upload_extension";
$upload_size="upload_size";
$upload_dimensions="upload_dimensions";
$upload_object="upload_object";// name of the application wich uses this media

// option
$language=LANG;//$language="fr";// fr french, uk english
require_once("upload_lang_".$language.".php");
$upload_design=$general_css;//"upload_design_01.css";
$upload_favico=$general_favico;
$upload_debug=DEBUG;//0 none, 1 inline, 2 textlog
$upload_list_number=NUMBER_UPLOAD;
?>