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

global $xoopsConfig;

$adminmenu[0]['title'] = "Administration";
$adminmenu[0]['link'] = "admin/vehicule.php";

$adminmenu[3]['title']  = _MI_GARAGE_INTER;
$adminmenu[3]['link']   = "admin/intervention.php";

$adminmenu[4]['title']  = _MI_GARAGE_VEHICULE;
$adminmenu[4]['link']   = "admin/vehicule.php";

$adminmenu[5]['title']  = _MI_GARAGE_CLIENTS;
$adminmenu[5]['link']   = "admin/client.php";

$adminmenu[6]['title']  = _MI_GARAGE_FOURNISSEURS;
$adminmenu[6]['link']   = "admin/fournisseur.php";

$adminmenu[7]['title']  = _MI_GARAGE_PIECES;
$adminmenu[7]['link']   = "admin/piece.php";

$adminmenu[8]['title']  = _MI_GARAGE_CAT_PIECES;
$adminmenu[8]['link']   = "admin/cat_piece.php";

$adminmenu[9]['title']  = _MI_GARAGE_MARQUES;
$adminmenu[9]['link']   = "admin/marque.php";

$adminmenu[10]['title']  = _MI_GARAGE_EMPLOYES;
$adminmenu[10]['link']   = "admin/employe.php";
?>