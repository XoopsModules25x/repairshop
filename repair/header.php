<?php
include '../../mainfile.php';


//include_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/config.inc.php';

// Permission associ&eacute;e au module
/*
$perm_name = 'XORGACHART';
if ($xoopsUser)  $groups = $xoopsUser->getGroups();
else $groups = XOOPS_GROUP_ANONYMOUS;
$module_id = $xoopsModule->getVar("mid");
$gperm_handler = & xoops_gethandler('groupperm');
*/
$myts = MyTextSanitizer::getInstance();
foreach ($_POST as $k => $v) {
	if (is_string($v))
	     $$k = $myts->stripSlashesGPC($v);
	else $$k = $v;
}
foreach ($_GET as $k => $v) {
	if (is_string($v)) 
	     $$k = $myts->stripSlashesGPC($v);
	else $$k = $v;
}

?>