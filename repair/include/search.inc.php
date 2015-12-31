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

function repair_search($queryarray, $andor, $limit, $offset, $userid){
	global $xoopsDB, $xoopsModule, $xoopsModuleConfig;
	
	  $sql = "SELECT i.*, v.id, v.immat, v.id_marque, v.gamme, v.modele_version, v.id_proprietaire, c.civilite, c.nom, c.prenom, c.teldom, c.telport, m.nom FROM ".$xoopsDB->prefix("garage_intervention")." i INNER JOIN ".$xoopsDB->prefix("garage_vehicule")." v ON i.id_voiture = v.id INNER JOIN ".$xoopsDB->prefix("garage_clients")." c ON v.id_proprietaire = c.id INNER JOIN ".$xoopsDB->prefix("garage_marque")." m ON m.id = v.id_marque WHERE"; 
  		

	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	if ( is_array($queryarray) && $count = count($queryarray) ) {
		$sql .= " ((immat LIKE '%$queryarray[0]%' OR numero_devis LIKE '%$queryarray[0]%' OR numero_facture LIKE '%$queryarray[0]%')";
		for($i=1;$i<$count;$i++){
			$sql .= " $andor ";
			$sql .= "((immat LIKE '%$queryarray[0]%' OR numero_devis LIKE '%$queryarray[0]%' OR numero_facture LIKE '%$queryarray[0]%')";
		}
		$sql .= ") ";
	}
	$sql .= "ORDER BY date_devis DESC";
	$result = $xoopsDB->query($sql,$limit,$offset);
	$ret = array();
	$i = 0;
/*
    list($id2, $id_vehic, $kilometrage, $date_debut, $date_fin, $delai, $id_inter_recurrente, $description, $observation, $date_devis, $date_acceptation, $montant, $acompte_verse, $solde, $hmeca_t1, $hmeca_t2, $hmeca_t3, $hcarro_t1, $hcarro_t2, $hcarro_t3, $tmeca_t1, $tmeca_t2, $tmeca_t3, $tcarro_t1, $tcarro_t2, $tcarro_t3 ,$remise_meca, $remise_caro, $remise_forfait, $numero_devis, $numero_facture, $id_vehicule, $immat, $id_marque, $gamme, $modele_version, $id_proprietaire, $civilite, $nom, $prenom, $teldom, $telport, $marque) = $xoopsDB->fetchrow($sql);
*/    
   	while($myrow = $xoopsDB->fetchArray($result)){
		$ret[$i]['title'] = "R&eacute;paration du : ".date("d/m/Y", strtotime($myrow['date_debut']))." V&eacute;hicule  : ".$myrow['nom']." - ".$myrow['immat'];
		$ret[$i]['link'] = "inter_pces.php?id_inter=".$myrow['id']."";
		$ret[$i]['immat'] = $myrow['immat'];
//		$ret[$i]['time'] = $myrow['created'];
		$i++;
	}
	return $ret;
}
?>