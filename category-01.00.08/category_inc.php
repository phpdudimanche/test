<?php
// UPDATE 12-12-27
//include("../config.php");// include is easier  /03_PROD/prod/ F:/USB/SITES/03_PROD/prod
require_once("../config.php");
require_once("category_config.php");
//require_once(ROOT."/".CORE."/lib_Mysql.php");// F:\USB\SITES/prod/core-00.00/lib_Mysql.php : $core_server.
	$result = str_replace('/'.CATEGORY.'/','', ROOT);//in root, sustract current category : /CATEGORY/
	$result = str_replace('/'.SCENARIO.'/','', $result);// due to scenario_steps_list_edt.php line 51
	$result = str_replace('/'.EXECUTION.'/','', $result);// due to execution_steps_export_xls.php  // NEW
	require_once($result."/".CORE."/lib_Mysql.php");
	require_once($result."/".CORE."/lib_Common.php");// head
	require_once($result."/".UPLOAD."/upload_config.php");// upload
	require_once($result."/".EXECUTION."/execution_config.php");// uploadrequire_once($result."/".UPLOAD."/upload_config.php");// upload
	require_once($result."/".SCENARIO."/scenario_config.php");
	//echo $result;
//$conn="";
//$conn = mysql_connect($host, $user, $pass) or die(mysql_error());
//mysql_select_db($database) or die(mysql_error());
$conn = mysqli_connect($host, $user, $pass, $database);

function output_query_category($query,$field){// no use to have old array, no entry if non media in query !
	global $category_parent_id, $category_label, $category_order,$opt_category_media,$opt_category_appli,$opt_category_execution;
	$array = array();
	$array_doc = array ();
	$old='';
			//$i=0;
	while($row = retrieve_assoc($query)){// assoc = // mysqli_fetch_assoc($query)  CORE_LIB
		// retrieve all fields and name them automatically (if the query returns them) // to display data 0 NO / 1 YES
		
if (!isset($row['upload_id']))// vs undefined index in category_add_edt.php
{
$row['upload_id']='';
}	
if (!isset($row['scenario']))
{
$row['scenario']='';
}
if (!isset($row['pause']))
{
$row['pause']='';
}
if (!isset($row['close']))
{
$row['close']='';
}		
		
$opt_category_media==0?$row['upload_id']='':$row['upload_id']=$row['upload_id'];
$opt_category_appli==0?$row['scenario']='':$row['scenario']=$row['scenario'];
$opt_category_execution==0?$row['pause']='':$row['pause']=$row['pause'];
$opt_category_execution==0?$row['close']='':$row['close']=$row['close'];
// NEW : as tree : "category_id"=>$row[$field],
			if($row['upload_id']==NULL){// no doc
				$array[$row[$field]] =
				array( "category_id"=>$row[$field],
				$category_parent_id => output($row[$category_parent_id]),
				"name" => output($row[$category_label]),
				"scenario" => output($row['scenario']),// SCENARIO exists or not
				"pause"=>output($row['pause']),
				"close"=>output($row['close']),// EXECUTION
				$category_order => output($row[$category_order]));
				}/**/
			elseif($row[$field]==$old)// yet another doc
				{
				$arr[output($row['upload_id'])]=array(output($row['upload_id'])=>output($row['upload_name']).':'.output($row['upload_label']).':'.output($row['upload_extension']) );

				$array[$row[$field]]['doc'][output($row['upload_id'])]=output($row['upload_name']).':'.output($row['upload_label']).':'.output($row['upload_extension']);// OK add .':'.output($row['upload_label']).':'.output($row['upload_extension'])
				// in a same array, fields to explode
				}
			else{// first time doc
				$array_doc[output($row['upload_id'])]=array( "id"=>output($row['upload_id']),"label"=>output($row['upload_label']),"extension"=>output($row['upload_extension']) );
				$tab=$array_doc[output($row['upload_id'])];
// NEW : as tree : "category_id"=>$row[$field],
				$array[$row[$field]] =
				array("category_id"=>$row[$field],
				$category_parent_id => output($row[$category_parent_id]),
				"name" => output($row[$category_label]),// .':test:'.output($row['upload_extension'])
				"doc"=>array(output($row['upload_id'])=>output($row['upload_name']).':'.output($row['upload_label']).':'.output($row['upload_extension']) ),// option : add an array with : label, extension
				"pause"=>output($row['pause']),"close"=>output($row['close']), // EXECUTION
				"scenario" => output($row['scenario']),// SCENARIO exists or not
				$category_order => output($row[$category_order]));
				$old=$row[$field];// means already done, now
				}
	}
	return ($array);
}

/* NOT USED ANY MORE : see display_breadcrumb
function output_query_breadcrumb($query){
global $category_parent_id, $conn;
$array = array();
$i=1;
//$result = mysqli_query($conn, $query);// PROCEDURAL
//if ($result = mysqli_query($conn, $query)) {// a imbriquer
if ($result=query_retrieve($query)){
//$query=$conn->query($query);
	//while($row = mysql_fetch_assoc($query)){
		while($row = mysqli_fetch_assoc($result)){// from prepared statements !!!  $query->fetch_assoc()
	/*while($row = mysql_fetch_row($query)){
$array[$i] =array('parent' => output($row[0]));*/
/*$array[$i] =array('level' => output($row['lvl']),'category' =>output($row['_id']),'parent' => output($row['parent']),'label' => output($row['label']));
$i++;	
	}
		}
	
return ($array);
}*/

function display_breadcrumb($cat,$rep='') // in order to be use from an other directory
	{
		global $category_table,$category_id;
	$path="";
	$div=" &gt; ";
	while ($cat!=0)
		{
		//$query="SELECT * FROM 001_category WHERE category_id = $cat";
		$query="SELECT * FROM $category_table WHERE $category_id = $cat";
		$rs=query_retrieve($query);
		$row=mysqli_fetch_row($rs);
		if ($row)
			{
				if($rep!=''){$rep="../$rep/";}
			$path=$div . '<a href="'.$rep.'category_list_edt.php?parent='.$row[1].'">' . $row[3]  . '</a>' . $path;
			$cat=$row[1];
			}
		}	
	if ($path!="")
		{ $path=substr($path,strlen($div)); }		
	return $path;
	}

function display_media($data){
global $directory, $opt_upload_scenario;// from upload_config.php
			//echo $category['doc'];
			foreach($data as $key=>$value){
			$sub_value=explode (":",$value);
echo "<a href=".$directory;// open in a new window
			//echo "id".$key."-";// .$value;."<br />";
			//echo "name ".$sub_value[0]."-";
			echo $sub_value[0];
echo " target=_blank>";
				$sub_value[1]!=""?$sub_value[1]=$sub_value[1]:$sub_value[1]=$opt_upload_scenario;// $opt_upload_scenario or other : TODO : detect appli
						//echo "label ".$sub_value[1];// ."-"
						echo $sub_value[1];
echo "</a>";
			//echo "extension ".$sub_value[2];
			//echo "<br />";
			echo " - ";
			}
}

function printTree($array, $currentParent, $currLevel, $prevLevel){// print all, with first options, and not recursively : $currLevel = 0, $prevLevel = -1
global $type, $down, $add, $move, $target_link,$target_label,$category_scenario_duplicate_label,$category_upload_label,$opt_category_media,$opt_category_appli,$add_label,$move_label,$import,$import_label;
if (CATEGORY_ICONS==1){
$add='<img src="../public/01/plus.gif"/>';$move='<img src="../public/01/split.gif" />';$import='<img src="../public/01/drop_box.gif"/>';
}
if (RIGHTS==5) {
	echo '<a href="category_add_edt.php?parent_id=';// LEVEL for action or not
	echo $currentParent;
	echo '" title="'.$add_label.'"> '.$add.'</a> ';
	echo '<a href="category_move_edt.php';
	echo '" title="'.$move_label.'"> '.$move.'</a> ';
	/*echo '<a href="../'.SCENARIO.'/scenario_import_csv_edt.php?parent=';
	echo $currentParent;
	echo '" title="'.$import_label.'"> '.$import.'</a> ';// IMPORT_CSV */
}
isset($a)?$a=$a:$a=0;// modulo
	displayTree($array, $currentParent, $currLevel, $prevLevel,$a);// $currLevel = 0, $prevLevel = -1 modulo $a
}

function displayTree($array, $currentParent, $currLevel, $prevLevel,$a) {// act recursevely, display tree $currLevel = 0, $prevLevel = -1, and stop at $level
global $type, $down, $add, $update, $delete, $order, $depth, $size, $istqb,$lg_category_level_label,$import,$import_label,
	$target_link,$target_label,$category_scenario_duplicate_label,$category_upload_label,$lg_execution_link,$lg_execution_in_progress,$lg_execution_yet_closed,
	$opt_category_media,$opt_category_appli,$opt_upload_update,$opt_category_execution,
	$opt_upload_update_pl_1,$opt_upload_update_pl_2,$opt_upload_update_sg,$opt_display_upload,$opt_upload_level,$opt_display_level_upload,
	$down_label,$add_label,$update_label,$delete_label,$order_label,$scenario_label,$duplicate_label,$upload_the_label,$upload_admin,$lg_execution_link_label,$lg_execution_in_progress_label,$lg_execution_yet_closed_label;
$spacer_begin="<span class=\"spacer option\">&nbsp;";// <span class=\"spacer option\">&nbsp;
$spacer_end="</span>";// </span>


isset($a)?$a=$a:$a=0;// modulo
	//print_r($array);echo "array avant";//----------------------------- PB
if (!empty($array)){// SECU debut	if not WARNING error    CGT
foreach ($array as $categoryId => $category) {

		if ($currentParent == $category['parent_id'] and $currLevel<$depth+1) {
			if ($currLevel > $prevLevel) echo " <ul> \n";
			$level="parent";
			//if ($currLevel == $prevLevel) echo " </li> \n";// NEVER WRITTEN
			$level="child";
$a++;
if ($a%2 == 1) {$type="odd";}else{$type="even";}	// modulo	pair/even/2-impair/odd/1		

			echo '<li id="'.$categoryId.'" class="'.$type.'">';			
				if($istqb==1){
					if(isset($lg_category_level_label[$currLevel])){
					echo '<i>'.$lg_category_level_label[$currLevel].'</i> ';
					}
				}			
			echo '<span>'.$category['name'].'</span> ';// modulo
switch($type){// to use later
				case 0:
if (CATEGORY_ICONS==1){ // TODO variabilize module css : 01 AND fix icons name : 23 icons (problem with extension)
$add='<img src="../public/01/plus.gif" />';$delete='<img src="../public/01/trash.gif" />';$order='<img src="../public/01/list_ordered.gif" />';$category_scenario_duplicate_label='<img src="../public/01/copy.gif" />';$category_upload_label='<img src="../public/01/arrow_fat_down.gif" />';
$import='<img src="../public/01/drop_box.gif" />';
$down='<img src="../public/01/arrow_expand.gif" />';$update='<img src="../public/01/document.gif" />';$lg_execution_link='<img src="../public/01/Play.png" />';$lg_execution_in_progress='<img src="../public/01/Pause.png" />';$lg_execution_yet_closed='<img src="../public/01/Pie-Chart.png" />';								
$opt_upload_update_sg='<img src="../public/01/arrow_fat_right.gif" />';$opt_upload_update_pl_1='';$opt_upload_update_pl_2='<img src="../public/01/arrow_fat_right.gif" />';
$target_label='<img src="../public/01/plugin.gif" />';	$spacer_link=" ";$spacer_module="";
$scenario_title="SCENARIO ";$upload_title=" DOCUMENT ";$execution_title=" EXECUTION ";
$pos_01="pos_01";$pos_02="pos_02";$pos_03="pos_03";$pos_04="pos_04";
}
else{$scenario_title="";$upload_title="";$execution_title="";$spacer_link=" - ";$spacer_module=" | ";$pos_01="";$pos_02="";$pos_03="";$pos_04="";}								
									if (RIGHTS==5) {// RIGHTS
									// definitiv level
						$definitivlevel=$size+$currLevel;
						//echo ' - level '.$currLevel.' - depth '.$depth.' '.$size.' '.$type.' '.$a.' ';//  $size is the level of breadcrumb : add $currLevel compare $currLevel and $level
									echo $spacer_link.'<span class="'.$pos_01.'"><a href="category_list_edt.php?parent=';// NEW with level
									echo $categoryId;
									$nextlevel=$currLevel+1;
									echo '&level='.$nextlevel;
									echo '" title="'.$down_label.'">'.$down.'</a> ';									
							echo $spacer_link.'<a href="category_add_edt.php?parent_id=';
							echo $categoryId; 
							echo '" title="'.$add_label.'">'.$add.'</a>';
							echo $spacer_link.'<a href="category_update_edt.php?parent_id='.$category['parent_id'].'&cat_id='.$categoryId.'" title="'.$update_label.'">'.$update.'</a>';
							echo $spacer_link.'<a href="category_delete_edt.php?cat_id='.$categoryId.'" title="'.$delete_label.'">'.$delete.'</a>';
							echo $spacer_link.'<a href="category_order_edt.php?parent_id='.$category['parent_id'].'" title="'.$order_label.'">'.$order.'</a>';
							
							/*echo $spacer_link;
							echo '<a href="../'.SCENARIO.'/scenario_import_csv_edt.php?parent=';
							echo $categoryId;
							echo '" title="'.$import_label.'">'.$import.'</a>';	// IMPORT_CSV */					
							echo '</span>'.$spacer_begin;
													}// RIGHTS
if($opt_category_media==1){
							echo $spacer_module.'<span class="'.$pos_02.'">'.$upload_title.'<a href="../'.UPLOAD.'/upload_form_edt.php?object_id='.$categoryId.'&object_type=category&object_name='.$category['name'].'" title="'.$upload_the_label.'">'.$category_upload_label.'</a>';// option
									if(isset ($category['doc'])){
											//print_r($category['doc']);//Array ( [11] => category_1.gif::.gif [10] => category_1.gif::.gif )
											$total=count($category['doc']);
											//echo $total;
											//$pre_array=explode (":",$category['doc']);
											//print_r($pre_array);
										if($opt_display_upload==0){
										//display_media($category['doc']);
										}
											if($total==1 && $opt_display_upload==1){	// new : display only for one file
									//display_media($category['doc']);// option
												// echo $opt_display_upload;
											}
									echo $spacer_link.'<a href="../'.UPLOAD.'/upload_list_edt.php?object_id='.$categoryId.'&object_type=category&object_name='.$category['name'].'" title="'.$upload_admin.'">';

									if($total>1){
									echo $opt_upload_update_pl_1;
									echo " ".$total." ";
									echo $opt_upload_update_pl_2;
									}
									if($total==1){
									echo $opt_upload_update_sg." ";
									}
									//echo $opt_upload_update;
									echo '</a>';// option
									}
									if($opt_display_level_upload!=0){
									echo $opt_upload_level[$currLevel];// echo 'TYPE '.$currLevel;//
									}
									else {
									}
echo '</span>';
}													
if ($istqb==1 and $definitivlevel!=5){ // istqb, display scenario and execution only on case test
}
else
{
if($opt_category_appli==1){// $opt_category_appli=="scenario"
							echo $spacer_module.' <span class="'.$pos_03.'">'.$scenario_title.'<a href="'.$target_link.'?cat_id='.$categoryId.'&cat_name='.$category['name'].'" title="'.$scenario_label.'">'.$target_label.'</a>';// NEW option strtoupper()
								if (RIGHTS==5) {// RIGHTS
									echo $spacer_link.'<a href="category_duplicate_act.php?cat_id='.$categoryId.'&cat_name='.$category['name'].'" title="'.$duplicate_label.'">'.$category_scenario_duplicate_label.'</a>';// option
												}// RIGHTS
												echo '</span>';
}
// category media was here
if($opt_category_execution==1){
								//echo  ' | ';
								echo $spacer_module.'<span class="'.$pos_04.'">'.$execution_title;
	if($category['pause']==0 AND $category['scenario']!=0){// was in third position
						//echo $category['pause'];
						//echo $category['close'];
					echo '<a href="../'.EXECUTION.'/execution_scenario_edt.php?cat_id='.$categoryId.'&cat_name='.$category['name'].'" title="'.$lg_execution_link_label.'">'.$lg_execution_link.'</a>';// TODO verify if steps exist
						}
	if($category['pause']!=0){
                         echo  $spacer_link.'<a href="../'.EXECUTION.'/execution_scenario_edt.php?cat_id='.$categoryId.'&cat_name='.$category['name'].'" title="'.$lg_execution_in_progress_label.'" class="in_progress">'.$lg_execution_in_progress.'</a>';
						 }
	if($category['close']!=0){
						echo  $spacer_link.'  <a href="../'.EXECUTION.'/execution_scenario_list.php?cat_id='.$categoryId.'&cat_name='.$category['name'].'" title="'.$lg_execution_yet_closed_label.'">'.$category['close'].' '.$lg_execution_yet_closed.'</a>';// TODO the landing page
						//echo ' <a href="../'.EXECUTION.'/execution_scenario_edt.php?cat_id='.$categoryId.'&cat_name='.$category['name'].'"> '.$lg_execution_link.'</a> ';// TODO verify if steps exist
						 }
					echo '</span>';
}
}//end of istqb else							
echo $spacer_end;
							//}// END
				break;
			}// end of switch
echo "\n </li>\n\n";// END LINE HERE NEW
			if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }
			$currLevel++;
			displayTree ($array, $categoryId, $currLevel, $prevLevel,$a);// modulo
			$currLevel--;			
		}		
	}// end of foreach
	
}	// SECU fin	
	
	
	
	
	
	
	
		if ($currLevel == $prevLevel) echo "\n </ul> \n";// ".$prevLevel." other hierarchy   \n </li>  NEW
}



function display_menu($parent, $level, $depth, $real_depth, $array) {// $depth 
$html = ""; 
foreach ($array AS $tree) { 
//print_r($tree);
/*if ( !(isset($tree['parent_id'])) )
{
}*/
	if (isset($tree['parent_id'])&& $parent==$tree['parent_id'])	{ 
 //$real_depth=1; 
		for ($i = 0; $i < $level; $i++) 
		{// equals to
		}// equals to
if ($real_depth <= $depth){/* CHANGED */ 
		for ($a=0;$a<$real_depth; $a++)// identation loop in the test
		{
		$html .= " - ";
		}
	$html .='level nammed : '.$level;// just write level (but first level is given by function), but write level many times if not behind { }
	$html .='real depth '.$real_depth;
	$html .=' cat id '.$tree['category_id'];

	$html .= sprintf(" <a href='?parent=%s'>%s</a>",$tree['category_id'],$tree['name']);// sprintf returns, printf displays
	$html .="<br />";	
}		 
		$html .= display_menu($tree['category_id'], ($level+ 1),$depth,$real_depth+1, $array);	 
		}
	}
return $html; 
}

function printTreeMove($array, $currentParent, $currLevel = 0, $prevLevel = -1, $side){// print all, with first options, and not recursively
	displayTreeMove($array, $currentParent, $currLevel = 0, $prevLevel = -1, $side);
}

function displayTreeMove($array, $currentParent, $currLevel = 0, $prevLevel = -1, $side) {// act recursevely, display tree
	global $type, $add, $update, $delete, $order;

	foreach ($array as $categoryId => $category) {

		if ($currentParent == $category['parent_id']) {

			if ($currLevel > $prevLevel) echo " <ul> \n";
			$level="parent";

			if ($currLevel == $prevLevel) echo " </li> \n";
			$level="child";

			echo '<li id="'.$categoryId.'">';
			//.'</span><img src="16-circle-blue-add.png" alt="add subcategory" width="16" height="16" class="add_category"/> <img src="16-circle-red-remove.png" alt="remove" width="16" height="16" class="delete_category"/>'
			//echo $type;
switch($type){
	case 0:

		if ($level=="parent") {// no used!
			echo "<input type=\"radio\" name=\"group[".$categoryId."]\" value=\"". $categoryId."\">";
			echo $category['parent_id'];

		}
		else{
			echo "<input type=\"radio\" name=\"".$side."\"  id=\"".$side."[".$categoryId."]\" value=\"". $categoryId."\">";
			echo "<label for=\"".$side."[".$categoryId."]\">".$category['name']."</label>";
			//echo "<label for=\"".$side."\">".$category['name']."</label>";
			echo  " (".$categoryId.")";
		}
		break;
	default:
	;
}

			if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }

			$currLevel++;

			displayTreeMove ($array, $categoryId, $currLevel, $prevLevel, $side);

			$currLevel--;

		}

	}

	if ($currLevel == $prevLevel) echo "\n </li> \n </ul> \n";

}

function display_same_level($array){// to view the other items of the same level
global $type, $same_level;

	echo $same_level;
	foreach ($array as $categoryId => $category) {
		echo '<li id="'.$categoryId.'"><span>'.$category['name'].'</span>';
					echo '</li>';
	}

}

function display_order_level($array){// to see and to change the order
	global $type, $same_level, $order, $order_crack;
	$redirection="category_order_act.php";
echo $order.' '.$same_level. ' '.$order_crack;
echo "\r\n";
echo "<form method=\"POST\" action=\"$redirection\" name=\"order_new\" id=\"order_new\">";
echo "\r\n";
	foreach ($array as $categoryId => $category) {
?>
	<input type="text" size="3" value="<?php echo $category['orderby'] ?>" name="cat_order<?php echo '['.$categoryId.']';?>" id="cat_order" />
	<?php echo $category['name'] ?>
	<br />

<?php
	}
echo "<input type=\"submit\" value=\"$order\" id=\"form_submit\" />";
echo "</form>";
}

function display_form_edit($maxOrderby,$parent_id,$cat_id,$action,$label){// becareful to $maxOrderby : in update mod : get existent order
	global $add, $update;

	if ($action=="add") {
		$redirection="category_add_act.php?submitted=true";
		$act=$add;
	}
	else
	{
		$redirection="category_update_act.php?submitted=true";
		$act=$update;
	}
?>
	<form method="POST" action="<?php echo $redirection ?>" name="add_new" id="add_new">
	<label for="category_name"></label>
	<input type="text" value="<?php echo $label ?>" style="width:250px;" name="category_name" id="category_name" />
	<input type="hidden" value="<?php echo $cat_id ?>" name="cat_id" id="cat_id" />
	<input type="hidden" value="<?php echo $parent_id ?>" name="parent_id" id="parent_id" />
	<input type="hidden" value="<?php echo $maxOrderby;	?>" name="orderby" id="orderby" />
	<input type="submit" value="<?php echo $act ?>" id="form_submit" />
	</form>
<?php
}

// no child : id as parent doesn't exist : just delete one without message
// child : id as parent exists : get all the ids and recurservely
function retrieveChild($cat_id, $conn){
global $category_table, $category_parent_id,$category_order, $category_id;

$i=0;
	global $i;
	//$result=array();
	global $result2;

	//$query = mysql_query("SELECT * FROM $category_table WHERE $category_parent_id=$cat_id ORDER BY $category_parent_id, $category_order");
	$query=query_retrieve("SELECT * FROM $category_table WHERE $category_parent_id=$cat_id ORDER BY $category_parent_id, $category_order");
	//$total = mysql_num_rows($query);
	$total = mysqli_num_rows($query);
	if ($total!=0) {
	//echo " trouve ";
	$i++;
		$result2[$i]=output_query_category($query,$category_id);
	/*	echo "<pre>";
		print_r($result[$i]);
		echo "</pre>"; */

		foreach ($result2[$i] as $cle=>$value ){
		retrieveChild($cle	, $conn);
		}

//
	}
return $result2;
/* output
   Array
   (
   [1] => Array          // number of array with the id as parent
   (
   [22] => Array		// id of the child
   (
   [parent_id] => 21	// element of the child
   [name] => label of 22
   )

   )

   )

   */

}

function traitment($result2,$cat_id){//before a recursively delete
global $before_delete_with_childs, $before_delete_without_child;
	//echo $result;
	if($result2!="")
	{
		$all[] = $cat_id;
		//echo "OK";

	/*	echo "<pre>";
		print_r($result);
		echo "</pre>";*/

		$total=count($result2);//number of array
		// echo $total." array<br />";

echo $before_delete_with_childs;

		// to prevent
		// after confirmation, post the form (submit by js)

for($compt=1;$compt<=$total;$compt++){
	//echo " - <br />";

	foreach ($result2[$compt] as $cle=>$value ){
		//echo "Delete ".$cle."<br />";
		//array_push()
		$all[] = $cle;// push in the array

	}


}
	/*	echo "<pre>";
		print_r($all);
		echo "</pre>";*/

	}
else{
	$all[] = $cat_id;
echo $before_delete_without_child;

}
return($all);
}

//------------- functions used by other applications

function category_next($category_next_label,$category_next_link,$cat_id){// go to the next category if it exists. Otherwise, no link is displayed : input=category_id
global $category_table,$category_id,$category_label,$category_parent_id,$category_order;// don't forget 18/12/11
// retrieve parent and order of the id, then in same parent take order after
	$array = array();
$query="SELECT $category_id,
$category_label FROM $category_table WHERE $category_parent_id=(SELECT $category_parent_id FROM $category_table WHERE $category_id=$cat_id)
AND orderby=(SELECT $category_order FROM $category_table WHERE $category_id=$cat_id)+1";
	//echo $query;
//$query = mysql_query($query);
$query=query_retrieve($query);
//$num_rows = mysql_num_rows($query);//   mysql_affected_rows  for insert
$num_rows=mysqli_num_rows($query);
// used by scenario

//echo $num_rows." response";
//while($row = mysql_fetch_assoc($query)){
while($row=mysqli_fetch_assoc($query)){
	$array=array($category_id => output($row[$category_id]),$category_label => output($row[$category_label]));
}
//print_r($array);
// variables to put on url : scenario/index.php :$cat_id $cat_name
	if ($num_rows>0){
	echo " | <a href='".$category_next_link."?cat_id=".$array['category_id']."&cat_name=".$array['category_label']."'>".$category_next_label."</a>";
	}
}

function category_children($id){// used by export steps test in xls
global $category_id,$category_label,$category_parent_id,$category_table,$category_order;
$query="SELECT $category_id, $category_label
FROM $category_table WHERE $category_parent_id=$id ORDER BY $category_order";
//$query = mysql_query($query);
$query =query_retrieve($query);
//$num_rows = mysql_num_rows($query);
$num_rows = mysqli_num_rows($query);
$result=array(); // vs notice
//echo $num_rows." response";

	$i=0;
	//while($row = mysql_fetch_assoc($query)){
	while($row = mysqli_fetch_assoc($query)){
	//$result[$i]=$row[$category_id];
		$result[$i]=array($row[$category_id],$row[$category_label]);
	$i++;
	}
//$result=output_query_category($query,$category_id);// , $category_order, $category_label, $category_parent_id
//print_r($result);// list of categories
return $result;
}



?>