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
include_once("admin_header.php");
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

$myts = MyTextSanitizer::getInstance();

if(!isset($_POST['op'])){
	$op = isset ($_GET['op']) ? $_GET['op'] : '0';
}else {
	$op = $_POST['op'];
}
if(!isset($_POST['id_inter'])){
	$id_inter = isset ($_GET['id_inter']) ? $_GET['id_inter'] : '0';
}else {
	$id_inter = $_POST['id_inter'];
}

if(!isset($op)){$op=" ";}
switch ($op) {

//  ------------------------------------------------------------------------ //
//--MISE DANS LA CORBEILLE (ETAT 9)
//  ------------------------------------------------------------------------ //
	case "trash":

  global $xoopsDB;

// changement de l'état de l'intervention
	$sql = "UPDATE ".$xoopsDB->prefix('garage_intervention')." SET solde='9'  WHERE id=$id_inter";
  $xoopsDB->queryF($sql) or die ('Erreur requete : '.$sql.'<br />');
	redirect_header("intervention.php", 2, _AM_INTER_DELETED);

//  ------------------------------------------------------------------------ //
//--SUPPRESSION
//  ------------------------------------------------------------------------ //
	case "delete":

  global $xoopsDB;

// suppression de l'intervention
	$sql = "DELETE FROM ".$xoopsDB->prefix('garage_intervention')." WHERE id='".$id_inter."'";
	$xoopsDB->queryF($sql) or die("Erreur requete : ".$sql.'<br />');

// suppression des heures saisies
	$sql = "DELETE FROM ".$xoopsDB->prefix('garage_inter_temp')." WHERE id_inter='".$id_inter."'";
	$xoopsDB->queryF($sql) or die("Erreur requete : ".$sql.'<br />');

// suppression des pieces saisies
	$sql = "DELETE FROM ".$xoopsDB->prefix('garage_inter_pieces')." WHERE id_inter='".$id_inter."'";
	$xoopsDB->queryF($sql) or die("Erreur requete : ".$sql.'<br />');

	redirect_header("intervention.php", 2, _AM_INTER_DELETED);
	break;

} // fin du switch

	if (empty($op)) {

Xoops_Cp_Header();

garage_tabsAdminMenu("intervention.php");
  
    doc_info('Suppression_inter');

		echo "<style> 
					.encours {background-color: #E6FFE6; padding: 5px;}
					.solde {background-color: #CAFAFF; padding: 5px;}
					.archive {background-color: #CAE2FF; padding: 5px;}
					</style>";
		$etat_des = _AM_INTER_ENCOURS ;
		$style = 'encours';
						
    echo "<table width='100%'><tr><td align='center'><img src='images/logo.jpg' alt='' title=''></td></tr></table><br />\n";	
		echo "<h1>".$etat_des."</h1>";

// on affiche uniquement les interventions en cours (etat a 0)
		$result = $xoopsDB->query("SELECT id, id_voiture, date_debut, date_fin, delai, solde  FROM ".$xoopsDB->prefix("garage_intervention")." WHERE solde =0");

 		echo "<table class=\"outer\" width=\"100%\">\n"
		."<th><center>"._AM_INTER_DELAI."</center></th>\n"
		."<th><center>"._AM_VEHICULE."</center></th>\n"
		."<th><center>"._AM_VEHICULE_PROPRIETAIRE."</center></th>\n"
		."<th colspan=\"2\"><center>"._AM_ACTION."</center></th>\n";
	 
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
   	echo '<tr>';
		echo '<td class="'.$style.'" ALIGN="left">'.$delai.'</td>';
		echo '<td class="'.$style.'" ALIGN="left"><b>'.$mark.'</b> '.$gamme.' '.$modele_version.' -<b> '.$immat.'</b></td>';
		echo '<td class="'.$style.'" ALIGN="left">'.$civilite.' '.$nom.' '.$prenom.'</td>';
		echo '<td class="'.$style.'" align="center"><A HREF="inter_pces.php?id_inter='.$id_inter.'" ><img src="../images/modif.png" alt="'._AM_MODIFY.'" title="'._AM_MODIFY.'"></a>&nbsp;<A HREF="../devis.php?id_inter='.$id_inter.'" target="blank"><img src="../images/print.gif" alt="'._AM_PRINT_DEVIS.'" title="'._AM_PRINT_DEVIS.'"></a>&nbsp;<A HREF="../facture.php?id_inter='.$id_inter.'" target="blank"><img src="../images/invoice.png" alt="'._AM_PRINT_FACTURE.'" title="'._AM_PRINT_FACTURE.'"></a>&nbsp;<A HREF="intervention.php?id_inter='.$id_inter.'&op=trash"><img src="../images/sup.png" alt="'._AM_INTER_SUPPR.'" title="'._AM_INTER_SUPPR.'"></a></td>';
}}
		echo '</tr></table><br />';

	echo '<a href="../intervention.php"><img src="../images/ajouter.png"></a>';

}
xoops_cp_footer();
?>