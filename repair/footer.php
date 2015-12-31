<?php
$xoopsTpl->assign("mod_dirname", $xoopsModule->getVar('dirname'));
$xoopsTpl->assign("mod_dir_image", XOOPS_URL . '/modules/'.$xoopsModule->getVar('dirname').'/images');
if ($xoopsUser) {	
	if ($xoopsUser->getVar('name')=='') 
		$xoopsTpl->assign("xoops_name", $xoopsUser->getVar('uname'));
	else $xoopsTpl->assign("xoops_name", $xoopsUser->getVar('name'));
}
else $xoopsTpl->assign("xoops_name", 'Anonyme');
include_once XOOPS_ROOT_PATH .'/footer.php';

?>