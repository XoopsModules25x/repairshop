<?php

include '../../../include/cp_header.php';
include_once XOOPS_ROOT_PATH .'/class/xoopsform/grouppermform.php';
include_once 'config.inc.php';

$perm_name = 'XORGACHART';
$module_id = $xoopsModule->getVar('mid');

$cat[CREATION] 	= array('name' => 'XXXXX', 'parent' => 0);

$title_of_form = "Droits d'acc&egrave;s"; 
$perm_desc = 'S&eacute;lectionner les acc&egrave;s pour chaque groupe';

$form = new XoopsGroupPermForm($title_of_form, $module_id, $perm_name, $perm_desc);
foreach ($cat as $cat_id => $cat_data) {
	$form->addItem($cat_id, $cat_data['name'], $cat_data['parent']);
}

//xoops_cp_header();
$xoopsTpl->assign('content',$form->render());
//xoops_cp_footer();

?>