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
include '../../mainfile.php';
include_once 'include/fonctions.php';
include_once 'header.php';
include_once XOOPS_ROOT_PATH.'/header.php';
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

Xoops_Header();

$myts = MyTextSanitizer::getInstance();

if(!isset($_POST['solde'])){
	$etat = isset ($_GET['solde']) ? $_GET['solde'] : '0';
}else {
	$etat = $_POST['solde'];
}
// on accede pas de maniere anonyme au module
if (! $xoopsUser){	redirect_header(XOOPS_URL, 2, _NOPERM);}
  
		echo "<style> 
					.encours {background-color: #E6FFE6; padding: 5px;}
					.solde {background-color: #CAFAFF; padding: 5px;}
					.archive {background-color: #CAE2FF; padding: 5px;}
					</style>";
		if ($etat == 0){ $etat_des = _MD_INTER_ENCOURS ; $style = 'encours';}
		if ($etat == 1){ $etat_des = _MD_INTER_SOLDEES ; $style = 'solde';}
		if ($etat == 2){ $etat_des = _MD_INTER_ARCHIVEES ;$style = 'archive';}
		
	$xoopsModule = XoopsModule::getByDirname("repair");

if ( $xoopsUser ) {
	if ( $xoopsUser->isAdmin($xoopsModule->mid()) ) { 
   echo "<table width='100%'><tr><td align='center'><img src='images/logo.jpg' alt='' title=''></td><a href='admin/index.php' target='_blanck'><img src='images/admin.gif' alt='Admin'></a></tr></table><br />\n";	
		} else {
	   echo "<table width='100%'><tr><td align='center'><img src='images/logo.jpg' alt='' title=''></td></tr></table><br />\n";	
	}
} else {
	   echo "<table width='100%'><tr><td align='center'><img src='images/logo.jpg' alt='' title=''></td></tr></table><br />\n";	
	}
				
 	echo "<h1>".$etat_des."</h1>";

// on affiche les interventions en cours
		$result = $xoopsDB->query("SELECT id, id_voiture, date_debut, date_fin, delai, solde  FROM ".$xoopsDB->prefix("garage_intervention")." WHERE solde =".$etat);

 		echo "<table class=\"outer\" width=\"100%\">\n"
		."<th><center>"._MD_INTER_DELAI."</center></th>\n"
		."<th><center>"._MD_VEHICULE."</center></th>\n"
		."<th><center>"._MD_VEHICULE_PROPRIETAIRE."</center></th>\n"
		."<th colspan=\"2\"><center>"._MD_ACTION."</center></th>\n";
	 
	 	while ((list($id_inter, $id_voiture, $date_debut, $date_fin, $delai, $solde) = $xoopsDB->fetchRow($result)) != false ) {

 // recup des infos du vehicule et proprio 
 $req3 = $xoopsDB->query("SELECT id, immat, id_marque, gamme, modele_version, id_proprietaire FROM ".$xoopsDB->prefix("garage_vehicule")." WHERE id=$id_voiture");
  while ((list($id_vehicule, $immat, $id_marque, $gamme, $modele_version, $id_proprietaire) = $xoopsDB->fetchRow($req3)) != false ) {
  	
  	$civilite = '';
  	$nom      = '';
  	$prenom   = '';
if ($id_proprietaire !=0){
			$sql = sprintf("SELECT * FROM ".$xoopsDB->prefix("garage_clients")." WHERE id='%s'",$id_proprietaire);
		  $res = $xoopsDB->query($sql)  or die ('erreur requete :'.$sql.'<br />');
		
		  if ( $res )  {
				$nb_champs = mysql_num_fields($res);
				$i=0;
				while($i<$nb_champs)
				  {
				  $nom_champs=mysql_field_name($res,$i);
				  $$nom_champs=mysql_result($res,0,$nom_champs);
				  $i++;
				  }
				}
		  
  }

$mark = "";
if ($id_marque !=0){
	  $sql2 = sprintf("SELECT * FROM ".$xoopsDB->prefix("garage_marque")." WHERE id='%s'",$id_marque);
    $res = $xoopsDB->query($sql2)  or die ('erreur requete :'.$sql.'<br />');

    while ((list($id_marque,$marque) = $xoopsDB->fetchRow($res)) != false ) {$mark = $marque;}
  }  	
	  if (date("d/m/Y", strtotime($delai)) > date("d/m/Y")){$retard ="<img src='images/flag_green.gif' alt='OK' title='OK'>";}
	  if (date("d/m/Y", strtotime($delai)) == date("d/m/Y")){$retard ="<img src='images/flag_orange.gif' alt='Livraison ce jour' title='Livraison ce jour'>";}
	  if (date("d/m/Y", strtotime($delai)) < date("d/m/Y")){$retard ="<img src='images/flag_red.gif' alt='EN RETARD' title='EN RETARD'>";}
   	echo '<tr>';
		echo '<td class="'.$style.'" ALIGN="left">'.$retard.'  '.date("d/m/Y", strtotime($delai)).'</td>';
		echo '<td class="'.$style.'" ALIGN="left"><b>'.$mark.'</b> '.$gamme.' '.$modele_version.' -<b> '.$immat.'</b></td>';
		echo '<td class="'.$style.'" ALIGN="left">'.$civilite.' '.$nom.' '.$prenom.'</td>';

// edition des factures active

     $facture = "";

     if ($xoopsModuleConfig['fonction_facture'] == 1) {
     		if ($xoopsModuleConfig['impression_facture_non_admin'] == 1 || $xoopsUser->isAdmin($xoopsModule->mid()) )
     		{
   			$facture = '<img src="images/invoice.png" alt="'._MD_PRINT_FACTURE.'" title="'._MD_PRINT_FACTURE.'"></a>';
   			}
	   }
       
     	echo '<td class="'.$style.'" align="center"><A HREF="inter_pces.php?id_inter='.$id_inter.'" ><img src="images/modif.png" alt="'._MD_MODIFY.'" title="'._MD_MODIFY.'"></a>&nbsp;<A HREF="devis.php?id_inter='.$id_inter.'" target="blank"><img src="images/print.gif" alt="'._MD_PRINT_DEVIS.'" title="'._MD_PRINT_DEVIS.'"></a>&nbsp;<A HREF="facture.php?id_inter='.$id_inter.'" target="blank">'.$facture.'</td>';
	}
}
		echo '</tr></table><br />';

	if ($etat == 0){
		include 'intervention.php';
	}


	include_once XOOPS_ROOT_PATH.'/footer.php';
?>