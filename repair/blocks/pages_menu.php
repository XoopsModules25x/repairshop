<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
function b_pages_list() {
	global $xoopsDB, $xoopsModule, $myts;
	$myts = MyTextSanitizer::getInstance();
	$block['content'] =" ";
        $result2 = $xoopsDB->query("SELECT CID FROM " . $xoopsDB->prefix("pages") . "");
        $numrows = $xoopsDB->getRowsNum($result2);

        if ($numrows > 0)
        {
            $sql = "SELECT CID, pagetitle, pageheadline, weight, publishdate FROM " . $xoopsDB->prefix("pages") . " WHERE mainpage <>0 OR defaultpage =1 ORDER BY weight, pagetitle ASC";
            $result = $xoopsDB->query($sql) ;
            while (list($CID, $pagetitle, $pageheadline, $publishdate) = $xoopsDB->fetchrow($result))
            {
             $pagetitle = $myts->htmlSpecialChars($pagetitle);
  					 $block['content'] .= "<li><a href='" . XOOPS_URL . "/modules/pages/index.php?pagenum=$CID'>" . $pagetitle . "</a></li>";
            } 
        } else {$block['content'] = _MD_NOPAGE;}
	return $block;
}
?>