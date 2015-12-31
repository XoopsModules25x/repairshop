<?php
// $Id: admin_header.php,v 1.1 2005/05/04 08:41:03 pemen Exp $
//  ------------------------------------------------------------------------ //
//  ------------------------------------------------------------------------ //
require('../../../mainfile.php'); 
include(XOOPS_ROOT_PATH."/include/cp_header.php");

include_once(XOOPS_ROOT_PATH."/class/xoopsmodule.php");
//include(XOOPS_ROOT_PATH."/include/cp_functions.php");
include_once("../include/functions.php");

$mod_path = XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname();
define('MOD_PATH', XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname());
define('MOD_DIR', $xoopsModule->dirname());

include(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
include('tabs.php');

define('TAB_INDEX', 1);
define('TAB_PERMISSION', 10);

if ( $xoopsUser ) {
	$xoopsModule = XoopsModule::getByDirname("repair");
	if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) { 
		redirect_header($xoopsConfig['xoops_url']." / ",3,_NOPERM);
		exit();
	}
} else {
	redirect_header($xoopsConfig['xoops_url']." / ",3,_NOPERM);
	exit();
}
if ( file_exists("../language/".$xoopsConfig['language']."/admin.php") ) {
	include_once("../language/".$xoopsConfig['language']."/admin.php");
} else {
	include_once("../language/english/admin.php");
}

?>