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
include_once("admin_header.php");
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

if(!isset($_POST['op'])){
	$op = isset ($_GET['op']) ? $_GET['op'] : '';
}else {
	$op = $_POST['op'];
}

if(!isset($_POST['id'])){
	$id = isset ($_GET['id']) ? $_GET['id'] : '';
}else {
	$id = $_POST['id'];
}
$id = intval($id);

if(!isset($_POST['id_inter'])){
	$id_inter = isset ($_GET['id_inter']) ? $_GET['id_inter'] : '';
}else {
	$id_inter = $_POST['id_inter'];
}
$id_inter = intval($id_inter);

if ($id_inter == 0){	redirect_header("index.php", 2, _NOPERM);}

if(!isset($npce)){$npce = 0;};
if(!isset($quantite)){$quantite = 1;};
if(!isset($quantite1)){$quantite1 = 1;};
if(!isset($tarif_client)){$tarif_client = 0;};
if(!isset($tarif_client1)){$tarif_client1 = 0;};

$myts = MyTextSanitizer::getInstance();

if(!isset($op)){$op=" ";}
switch ($op) {

//  ------------------------------------------------------------------------ //
//--CREATION
//  ------------------------------------------------------------------------ //
	case "create":

	global $xoopsDB, $myts, $xoopsModule, $xoopsModuleConfig;
	
	$id_forfait				 = $_POST["id_forfait"];
	$id_piece 				 = $_POST["id_pieces"];
	$designation 			 = $_POST["designation"];
	$tx_real 			 		 = $_POST["tx_real"];
	$quantite 				 = $_POST["quantite"];
	$quantite1 				 = $_POST["quantite1"];
	$tarif_client			 = $_POST["tarif_client"];
	$tarif_client1		 = $_POST["tarif_client1"];
	$montant_net_repar = $_POST["montant_net_repar"];

	$id_empl		 				= $_POST["id_employe"];
	$hmeca_t1	 					= $_POST["hmeca_t1"];
	$hmeca_t2	 					= $_POST["hmeca_t2"];
	$hmeca_t3	 					= $_POST["hmeca_t3"];
	$hcarro_t1	 				= $_POST["hcarro_t1"];
	$hcarro_t2	 				= $_POST["hcarro_t2"];
	$hcarro_t3	 				= $_POST["hcarro_t3"];

	$taf				 				= $_POST["taf"];
	$delai			 				= $_POST["delai"];

	$solde		 					= $_POST["solde"];
	$archive	 					= $_POST["archive"];
  if ($archive == 1){$solde =2;};

	$remise_meca		 = $_POST["remise_meca"];
	$remise_caro		 = $_POST["remise_caro"];
	$remise_forfait	 = $_POST["remise_forfait"];

	if($hmeca_t1 ==""){$hmeca_t1 = 0;};
	if($hmeca_t2 ==""){$hmeca_t2 = 0;};
	if($hmeca_t3 ==""){$hmeca_t3 = 0;};
	if($hcarro_t1 ==""){$hcarro_t1 = 0;};
	if($hcarro_t2 ==""){$hcarro_t2 = 0;};
	if($hcarro_t3 ==""){$hcarro_t3 = 0;};

// traitement des heures et commentaires des employés a modifier
	$idconst = 0;
	while (isset($_POST["idkey_".$idconst]))
			{
        $key = $_POST["idkey_".$idconst];
        $observation		 = $_POST["constat_".$idconst];
        $maj_hmeca_t1    = $_POST["hmeca_t1_".$idconst];
        $maj_hmeca_t2    = $_POST["hmeca_t2_".$idconst];
        $maj_hmeca_t3    = $_POST["hmeca_t3_".$idconst];
        $maj_hcarro_t1   = $_POST["hcarro_t1_".$idconst];
        $maj_hcarro_t2   = $_POST["hcarro_t2_".$idconst];
        $maj_hcarro_t3   = $_POST["hcarro_t3_".$idconst];
        
				$sqli = "UPDATE ".$xoopsDB->prefix('garage_inter_temp')." SET observation='".$observation."', hmeca_t1='".$maj_hmeca_t1."', hmeca_t2='".$maj_hmeca_t2."', hmeca_t3='".$maj_hmeca_t3."', hcarro_t1='".$maj_hcarro_t1."', hcarro_t2='".$maj_hcarro_t2."', hcarro_t3='".$maj_hcarro_t3."' WHERE id=".$key;
  			$xoopsDB->queryF($sqli) or die ('Erreur requete : '.$sqli.'<br />');
        $idconst++;
			}
											  

// update de l'etat, du délai, des remises et montant net en cas de modif. on RAZ les num de devis et facture eventuels
	$sql = "UPDATE ".$xoopsDB->prefix('garage_intervention')." SET solde=$solde, delai='$delai', description='$taf' , remise_meca='$remise_meca', remise_caro='$remise_caro', remise_forfait='$remise_forfait', montant='$montant_net_repar', numero_devis =0, numero_facture=0 WHERE id=$id_inter";
  $xoopsDB->queryF($sql) or die ('Erreur requete : '.$sql.'<br />');

// creation dans la table des heures
if (($hmeca_t1 + $hmeca_t2 + $hmeca_t3 + $hcarro_t1 + $hcarro_t2 + $hcarro_t3) !=0){
	$sqlh = "INSERT INTO ".$xoopsDB->prefix('garage_inter_temp')." (id_inter, id_empl, observation, hmeca_t1, hmeca_t2, hmeca_t3, hcarro_t1, hcarro_t2, hcarro_t3) VALUES ($id_inter, $id_empl, '$tx_real', $hmeca_t1, $hmeca_t2, $hmeca_t3, $hcarro_t1, $hcarro_t2, $hcarro_t3)";
  $xoopsDB->queryF($sqlh) or die ('Erreur requete : '.$sqlh.'<br />');
}
// insertion des pieces selectionnees (pieces magasin)
if ($id_piece !=0){
   if ($tarif_client ==0){
	  $reqpx = $xoopsDB->query("SELECT tarif_client FROM ".$xoopsDB->prefix("garage_pieces")." WHERE id=".$id_piece);
    while ((list($tarif) = $xoopsDB->fetchRow($reqpx)) != false ) { $tarif_client = $tarif;}
  }

	$sql2 = sprintf ("INSERT INTO %s (id_inter , id_piece, quantite, tarif_client) VALUES ('%s', '%s', '%s', '%s')", $xoopsDB->prefix('garage_inter_pieces'),$id_inter, $id_piece, $quantite, $tarif_client);
  $xoopsDB->queryF($sql2) or die ('Erreur requete : '.$sql2.'<br />');
}
// insertion des pieces selectionnees (pieces hors magasin)
if ($designation !=""){
	$sql3 = sprintf ("INSERT INTO %s (id_inter , designation, quantite, tarif_client, id_fournisseur) VALUES ('%s', '%s', '%s', '%s', '%s')", $xoopsDB->prefix('garage_inter_pieces'),$id_inter, $designation, $quantite1, $tarif_client1, $id_fournisseur);
  $xoopsDB->queryF($sql3) or die ('Erreur requete : '.$sql3.'<br />');
  }

// update de la remise eventuelle des pieces detachees
	$idp = 1;
	while (isset($_POST["remise_pieces_".$idp]))
			{
        $key 					 = $_POST["idkeyp_".$idp];
        $remise_pieces = $_POST["remise_pieces_".$idp];
				$sqli = "UPDATE ".$xoopsDB->prefix('garage_inter_pieces')." SET remise_pieces='".$remise_pieces."' WHERE id=".$key;
  			$xoopsDB->queryF($sqli) or die ('Erreur requete : '.$sqli.'<br />');
        $idp++;
			}


// insertion des forfaits selectionnees
if ($id_forfait !=0){
	  $reqff = $xoopsDB->query("SELECT description, tarif FROM ".$xoopsDB->prefix("garage_forfait")." WHERE id=".$id_forfait);
    while ((list($description_forfait, $tarif_forfait) = $xoopsDB->fetchRow($reqff)) != false ) 
    { 
    	$designation = $description_forfait;
    	$tarif = $tarif_forfait;
    	}
  
  $quantite1 = 1;
  
	$sql3 = sprintf ("INSERT INTO %s (id_inter , id_forfait, designation, quantite, tarif_client) VALUES ('%s', '%s', '%s', '%s', '%s')", $xoopsDB->prefix('garage_inter_forfait'),$id_inter, $id_forfait, $designation, $quantite1, $tarif);
  $xoopsDB->queryF($sql3) or die ('Erreur requete : '.$sql3.'<br />');
  }
  
  
	redirect_header("inter_pces.php?id_inter=$id_inter", 1, _AM_INTER_MODIF_OK);
	break;
	
//  ------------------------------------------------------------------------ //
//-- SUPPRESSION PIECE
//  ------------------------------------------------------------------------ //

  case "delete":

	$sql = "DELETE FROM ".$xoopsDB->prefix('garage_inter_pieces')." WHERE id=".$id;
  $xoopsDB->queryF($sql) or die ('Erreur requete : '.$sql.'<br />');

	redirect_header("inter_pces.php?id_inter=$id_inter", 1, _AM_INTER_PCE_SUPR);
	break;
	
//  ------------------------------------------------------------------------ //
//-- SUPPRESSION 	MOD
//  ------------------------------------------------------------------------ //

  case "delete_mod":

	$sql = "DELETE FROM ".$xoopsDB->prefix('garage_inter_temp')." WHERE id=".$id;
  $xoopsDB->queryF($sql) or die ('Erreur requete : '.$sql.'<br />');

	redirect_header("inter_pces.php?id_inter=$id_inter", 1, _AM_INTER_MOD_SUPR);
	break;


//  ------------------------------------------------------------------------ //
//-- SUPPRESSION 	FORFAIT
//  ------------------------------------------------------------------------ //

  case "delete_forf":

	$sql = "DELETE FROM ".$xoopsDB->prefix('garage_inter_forfait')." WHERE id=".$id." AND id_inter=".$id_inter;
  $xoopsDB->queryF($sql) or die ('Erreur requete : '.$sql.'<br />');

	redirect_header("inter_pces.php?id_inter=$id_inter", 1, _AM_INTER_FORFAIT_SUPR);
	break;

}
//  ------------------------------------------------------------------------ //
//-- CAS GENERAL - FORMULAIRE DE CREATION / MODIFICATION
//  ------------------------------------------------------------------------ //
	if (empty($op)) {

Xoops_Cp_Header();

garage_tabsAdminMenu(__FILE__);

  global $xoopsDB, $id, $xoopsModule, $xoopsModuleConfig;
  $myts = MyTextSanitizer::getInstance();

  $montant_pieces = 0;

  $requete = $xoopsDB->query("SELECT i.*, v.id, v.immat, v.id_marque, v.gamme, v.modele_version, v.id_proprietaire, c.civilite, c.nom, c.prenom, c.teldom, c.telport, m.nom FROM ".$xoopsDB->prefix("garage_intervention")." i INNER JOIN ".$xoopsDB->prefix("garage_vehicule")." v ON i.id_voiture = v.id INNER JOIN ".$xoopsDB->prefix("garage_clients")." c ON v.id_proprietaire = c.id INNER JOIN ".$xoopsDB->prefix("garage_marque")." m ON m.id = v.id_marque WHERE i.id=".$id_inter); 

  while ((list($id2, $id_vehic, $kilometrage, $date_debut, $date_fin, $delai, $id_inter_recurrente, $description, $observation, $date_devis, $date_acceptation, $montant, $acompte_verse, $solde, $hmeca_t1, $hmeca_t2, $hmeca_t3, $hcarro_t1, $hcarro_t2, $hcarro_t3, $tmeca_t1, $tmeca_t2, $tmeca_t3, $tcarro_t1, $tcarro_t2, $tcarro_t3 ,$remise_meca, $remise_caro, $remise_forfait,$numero_devis, $numero_facture, $id_vehicule, $immat, $id_marque, $gamme, $modele_version, $id_proprietaire, $civilite, $nom, $prenom, $teldom, $telport, $marque) = $xoopsDB->fetchRow($requete)) != false ) {
   
  echo "<a href='index.php'><img src='../images/fleche.gif' alt='"._AM_BACKTOLISTE."' title='"._AM_BACKTOLISTE."'><br>"._AM_BACKTOLISTE."</a>";


  $form = new XoopsThemeForm(_AM_CREATE." "._AM_INTER_VEHICULE,'cinter',"inter_pces.php?op=create&id_inter=".$id_inter,'post');
  $form->setExtra("enctype='multipart/form-data'") ; // imperatif !

	$etrep  = "<table border=1>";
	$etrep .= "<tr><td align=left width=300px>"._AM_VEHICULE_IMMAT."</td>";
	$etrep .= "<td align=left>".$immat."</td>";
	$etrep .= "<td align=left>"._AM_INTER_RECEP."</td>";
	$etrep .= "<td>".date("d/m/Y", strtotime($date_debut))."</td></tr>";
	$etrep .= "<tr><td align=left>"._AM_VEHICULE_MARQUE."</td>";
	$etrep .= "<td align=left>".$marque."</td>";
	$etrep .= "<td align=left>"._AM_INTER_DELAI."</td>";
  $etrep .= "<td><input type='text' name='delai' size='10' maxlength='15' value='".$delai."'></td>";

	$etrep .= "<tr><td align=left>"._AM_VEHICULE_MODELE."</td>";
	$etrep .= "<td align=left>".$modele_version."</td>";
	$etrep .= "<td align=left>"._AM_INTER_KM."</td>";
	$etrep .= "<td>".$kilometrage." Kms</td></tr>";
	$etrep .= "<tr><td colspan=4>&nbsp;</td></tr>";
	$etrep .= "<tr><td align=left>"._AM_VEHICULE_PROPRIETAIRE."</td>";
	$etrep .= "<td align=left>".$civilite." ".$nom." ".$prenom."</td>";
	$etrep .= "<td align=left>"._AM_CLIENT_TEL."</td>";
	$etrep .= "<td>".$teldom." / ".$telport."</td></tr>";
	$etrep .= "<tr><td align=left>"._AM_INTER_TAF."</td>";
	$etrep .= "<td align=left colspan=3><TEXTAREA style='border: 1px solid #0078F0 ' rows='2' cols='70' name='taf'>".$description."</TEXTAREA><br><input type='submit' class='formButton' name='submit' id='submit' value='Mettre &agrave jour' title='MAJ'  /></td></tr>";
	$etrep .= "</table>";
						 
  $form->insertBreak(_AM_VEHICULE_INTERVENTION.'<center><br>'.$etrep.'</center>','head');

	$mod_dec  = "<table border=1>";
	$mod_dec .= "<tr><td></td>";
	$mod_dec .= "<th colspan=3>"._AM_INTER_MOD_MECA."</th>";
	$mod_dec .= "<th colspan=3>"._AM_INTER_MOD_CARRO."</th>";
	$mod_dec .= "<td></td></tr>";
	$mod_dec .= "<tr><th align=left width=200px>"._AM_INTER_EMPL."</th>";
	$mod_dec .= "<th width=100px>"._AM_INTER_MOD_T1."</th>";
	$mod_dec .= "<th width=100px>"._AM_INTER_MOD_T2."</th>";
	$mod_dec .= "<th width=100px>"._AM_INTER_MOD_T3."</th>";
	$mod_dec .= "<th width=100px>"._AM_INTER_MOD_T1."</th>";
	$mod_dec .= "<th width=100px>"._AM_INTER_MOD_T2."</th>";
	$mod_dec .= "<th width=100px>"._AM_INTER_MOD_T3."</th>";
	$mod_dec .= "<th width=100px>"._AM_ACTION."</th></tr>";

//heures deja declarées

// init des variables de cumul de la MOD
	$modct1 = 0;
	$modct2 = 0;
	$modct3 = 0;
	$modcat1 = 0;
	$modcat2 = 0;
	$modcat3 = 0;
	$commentaire = "";
  $montant_modmeca = 0;
  $montant_modcaro = 0;
  
  //compteur pour la zone 'travaux effectues' par employé
 $idconstat = 0;
 
 	$nbmo = 0; 
  $reqe = $xoopsDB->query("SELECT t.*, e.*  FROM ".$xoopsDB->prefix("garage_inter_temp")." t INNER JOIN ".$xoopsDB->prefix("garage_employe")." e ON t.id_empl = e.id_empl WHERE t.id_inter=".$id_inter);
  while ((list($idkeyempl, $idinter, $id_empl, $observation, $hmeca_t1, $hmeca_t2, $hmeca_t3, $hcarro_t1, $hcarro_t2, $hcarro_t3, $tmeca_t1, $tmeca_t2, $tmeca_t3, $tcarro_t1, $tcarro_t2, $tcarro_t3, $idkeyempl2, $nom_empl, $pre_empl ) = $xoopsDB->fetchRow($reqe)) != false )  {
  $nbmo = 1; // test pour affichage
  $mod_dec .= "<tr><td align=left>".$pre_empl.' '.$nom_empl."</td>";
  $mod_dec .= "<td align=center><input type='text' name='hmeca_t1_$idconstat' size='5' maxlength='10' value='".$hmeca_t1."' /></td>";
  $mod_dec .= "<td align=center><input type='text' name='hmeca_t2_$idconstat' size='5' maxlength='10' value='".$hmeca_t2."' /></td>";
  $mod_dec .= "<td align=center><input type='text' name='hmeca_t3_$idconstat' size='5' maxlength='10' value='".$hmeca_t3."' /></td>";
  $mod_dec .= "<td align=center><input type='text' name='hcarro_t1_$idconstat' size='5' maxlength='10' value='".$hcarro_t1."' /></td>";
  $mod_dec .= "<td align=center><input type='text' name='hcarro_t2_$idconstat' size='5' maxlength='10' value='".$hcarro_t2."' /></td>";
  $mod_dec .= "<td align=center><input type='text' name='hcarro_t3_$idconstat' size='5' maxlength='10' value='".$hcarro_t3."' /></td>";
  $mod_dec .= "<td align=center><a href='inter_pces.php?op=delete_mod&id=".$idkeyempl."&id_inter=".$id_inter."'><img src='../images/cancel.png' alt='Supprimer' title='Supprimer'></a></td></tr>";
  
  if ($observation !=""){
												  $mod_dec .= "<tr><td align=right>"._AM_INTER_TRAVAUX_REAL."&nbsp;</td>";
												  $mod_dec .= "<td colspan=6>";
													$mod_dec .= "<TEXTAREA style='border: 1px solid #0078F0' rows='2' cols='80' name='constat_$idconstat'>".$observation."</TEXTAREA>";
													$mod_dec .= "</td>";
												  $mod_dec .= "<td></td></tr>";
												  $mod_dec .= "<input type='hidden' name='idkey_$idconstat' value='$idkeyempl' />";
												  $idconstat ++;
  											}
  											
  $modct1 = $modct1 + $hmeca_t1;
  $modct2 = $modct2 + $hmeca_t2;
  $modct3 = $modct3 + $hmeca_t3;
  $modcat1 = $modcat1 + $hcarro_t1;
  $modcat2 = $modcat2 + $hcarro_t2;
  $modcat3 = $modcat3 + $hcarro_t3;
  
  $montant_modmeca = ($modct1 * $xoopsModuleConfig['meca_t1']) + ($modct2 * $xoopsModuleConfig['meca_t2']) + ($modct3 * $xoopsModuleConfig['meca_t3']);
  $montant_modcaro = ($modcat1 * $xoopsModuleConfig['carro_t1']) + ($modcat2 * $xoopsModuleConfig['carro_t2']) + ($modcat3 * $xoopsModuleConfig['carro_t3']);
  }

	$mod_dec .= "<tr><td></td>";
	$mod_dec .= "<td style='border: 1px solid #D2A901;' align=center>".$modct1."</td>";
	$mod_dec .= "<td style='border: 1px solid #D2A901;' align=center>".$modct2."</td>";
	$mod_dec .= "<td style='border: 1px solid #D2A901;' align=center>".$modct3."</td>";
	$mod_dec .= "<td style='border: 1px solid #D2A901;' align=center>".$modcat1."</td>";
	$mod_dec .= "<td style='border: 1px solid #D2A901;' align=center>".$modcat2."</td>";
	$mod_dec .= "<td style='border: 1px solid #D2A901;' align=center>".$modcat3."</td>";
	$mod_dec .= "<td></td></tr>";
	
	$mod_dec .= "<tr><td colspan=3 align=right>"._AM_INTER_MOD_MECA."&nbsp;:&nbsp;</td>";
	$mod_dec .= "<td style='border: 1px solid #D2A901;' align=right>".$montant_modmeca." ".$xoopsModuleConfig['money']."</td>";
	$mod_dec .= "<td colspan=2 align=right>"._AM_INTER_MOD_CARRO."&nbsp;:&nbsp;</td>";
	$mod_dec .= "<td style='border: 1px solid #D2A901;' align=right>".$montant_modcaro." ".$xoopsModuleConfig['money']."</td>";
	$mod_dec .= "<td></td></tr>";
	
	$mod_dec .= "<tr><td colspan=3 align=right>"._AM_PCE_REMISE."&nbsp;:&nbsp;</td>";
	$mod_dec .= "<td style='border: 1px solid #D2A901;' align=right><input type='text' name='remise_meca' size='10' maxlength='15' value='".$remise_meca."'> ".$xoopsModuleConfig['money']."</td>";
	$mod_dec .= "<td colspan=2 align=right>"._AM_PCE_REMISE."&nbsp;:&nbsp;</td>";
	$mod_dec .= "<td style='border: 1px solid #D2A901;' align=right><input type='text' name='remise_caro' size='10' maxlength='15' value='".$remise_caro."'> ".$xoopsModuleConfig['money']."</td>";
	$mod_dec .= "<td></td></tr>";
	
	$montant_brut_mod = $montant_modmeca + $montant_modcaro;
	$remise_mod 			= $remise_meca + $remise_caro;
	$montant_net_mod 	= $montant_brut_mod - $remise_mod ;
	$mod_dec .= "<tr><td colspan=6 align=right>"._AM_INTER_MOD."<br>"._AM_PCE_REMISE."<br>"._AM_PCE_NET."</td>";
	$mod_dec .= "<td style='border: 1px solid #D2A901;' align=right>".$montant_brut_mod." ".$xoopsModuleConfig['money']."<br>".$remise_mod." ".$xoopsModuleConfig['money']."<br>".$montant_net_mod." ".$xoopsModuleConfig['money']."</td>";
	$mod_dec .= "<td></td></tr>";
	$mod_dec .= "</table>";

  if ($nbmo != 0){
  $form->insertBreak('<h3><center>'._AM_INTER_MOD.'</center></h3><br>'.$mod_dec,'head');
  }
	$reqemp = $xoopsDB->query("SELECT id_empl, nom_empl, pre_empl  FROM ".$xoopsDB->prefix("garage_employe")." order by nom_empl");
	while (($row = $xoopsDB->fetchArray($reqemp)) != false ){
		$employes[$row['id_empl']]=$row['pre_empl'].' '.$row['nom_empl'];
	}
	
  $mod	= new XoopsFormElementTray('');
  $empl = new XoopsFormSelect('', 'id_employe');
	$empl -> addOptionArray ($employes);
//	$empl -> setValue($id_fournisseur);
  $mod -> addElement($empl);
  
  $mod 	-> addElement(new XoopsFormText("<b>"._AM_INTER_MOD_MECA."</b> -> "._AM_INTER_MOD_T1,'hmeca_t1',5,10));
  $mod 	-> addElement(new XoopsFormText('&nbsp;'._AM_INTER_MOD_T2,'hmeca_t2',5,10));
  $mod 	-> addElement(new XoopsFormText('&nbsp;'._AM_INTER_MOD_T3,'hmeca_t3',5,10));
  $mod 	-> addElement(new XoopsFormText("&nbsp;<b>"._AM_INTER_MOD_CARRO."</b> -> "._AM_INTER_MOD_T1,'hcarro_t1',5,10));
  $mod 	-> addElement(new XoopsFormText('&nbsp;'._AM_INTER_MOD_T2,'hcarro_t2',5,10));
  $mod 	-> addElement(new XoopsFormText('&nbsp;'._AM_INTER_MOD_T3,'hcarro_t3',5,10));
  $form -> addElement($mod);
  
  $form -> addElement(new XoopsFormTextArea(_AM_INTER_TRAVAUX_REAL,'tx_real',$observation,5,80));
  $form -> addElement(new XoopsFormButton('', 'submit', _AM_CREATE, 'submit'));

  
  $form->insertBreak('<h3><center>'._AM_INTER_PIECES.'</center></h3>','head');
  
	$pieces_det  = "<table border=1>";
	$pieces_det .= "<tr><th align=left>"._AM_PCE_DESIG."</th>";
	$pieces_det .= "<th align=left width=200px>"._AM_PCE_FSEUR."</th>";
	$pieces_det .= "<th align=center width=100px>"._AM_PCE_QTE."</th>";
	$pieces_det .= "<th align=center width=100px>"._AM_PCE_PX."</th>";
	$pieces_det .= "<th align=center width=100px>"._AM_PCE_REMISE."</th>";
	$pieces_det .= "<th align=center width=100px>"._AM_ACTION."</th></tr>";

  //liste des pieces deja renseignées
  $nbp = 0;
  $reqp = $xoopsDB->query("SELECT id, id_piece, designation, id_fournisseur, quantite, tarif_client, remise_pieces FROM ".$xoopsDB->prefix("garage_inter_pieces")." WHERE id_inter=".$id_inter);
  while ((list($idkey, $id_piece, $designation, $id_fournisseur, $quantite, $tarif_client, $remise_pieces) = $xoopsDB->fetchRow($reqp)) != false ) 
  {
 	$nbp ++; 
	//piece magasin
  if (!is_null($id_piece)) {
	    $reqpce = $xoopsDB->query("SELECT p.designation, p.tarif_client, f.nom FROM ".$xoopsDB->prefix("garage_pieces")." p INNER JOIN ".$xoopsDB->prefix("garage_fournisseur")." f ON p.id_fournisseur=f.id where p.id=".$id_piece);
		  while ((list ($designation, $tarif_client_std, $nom_fournisseur ) = $xoopsDB->fetchrow($reqpce)) != false )
		  {	
		  	if (is_null($tarif_client)) { $tarif_client = $tarif_client_std;}	  	 
				$pieces_det .= "<tr><td align=left>".$designation."</td>";
				$pieces_det .= "<td align=left>".$nom_fournisseur."</td>";
				$pieces_det .= "<td align=center>".$quantite."</td>";
				$pieces_det .= "<td ALIGN='right'>".$tarif_client." ".$xoopsModuleConfig['money']."</td>";
				$pieces_det .= "<td align ='right'><input type='text' name='remise_pieces_$nbp' size='12' maxlength='10' value='".$remise_pieces."' /></td>";
			  $pieces_det .= "<input type='hidden' name='idkeyp_$nbp' value='$idkey' />";

				$pieces_det .= "<td><a href='inter_pces.php?op=delete&id=".$idkey."&id_inter=".$id_inter."'><img src='../images/cancel.png' alt='"._AM_DELETE."' title='"._AM_DELETE."'></a></td></tr>";
	  	}
  		}
	//piece libre
  if (is_null($id_piece)) {
		  $reqf2 = $xoopsDB->query("SELECT id, nom  FROM ".$xoopsDB->prefix("garage_fournisseur")." where id=".$id_fournisseur);
			while (($row = $xoopsDB->fetchArray($reqf2)) != false ){	$nom_fournisseur=$row['nom']; } 
		  $pieces_det .= "<tr><td align=left>".$designation."</td>";
		  $pieces_det .= "<td align=left>".$nom_fournisseur."</td>";
		  $pieces_det .= "<td align=center>".$quantite."</td>";
		  $pieces_det .= "<td ALIGN='right'>".$tarif_client." ".$xoopsModuleConfig['money']."</td>";
			$pieces_det .= "<td><input type='text' name='remise_pieces_$nbp' size='12' maxlength='10' value='".$remise_pieces."' /></td>";
			$pieces_det .= "<input type='hidden' name='idkeyp_$nbp' value='$idkey' />";
		  $pieces_det .= "<td><a href='inter_pces.php?op=delete&id=".$idkey."&id_inter=".$id_inter."'><img src='../images/cancel.png' alt='"._AM_DELETE."' title='"._AM_DELETE."'></a></td></tr>";
			}
	$montant_pieces = $montant_pieces + ($quantite * $tarif_client);
  $remise_pce = $remise_pce + $remise_pieces;
	$montant_pieces_net = $montant_pieces - $remise;
	}

	$pieces_det .= "<tr><td colspan=3 align=right>"._AM_INTER_FOURNITURES."<br>"._AM_PCE_REMISE."<br>"._AM_PCE_NET."</td>";
	$pieces_det .= "<td style='border: 1px solid #D2A901;' ALIGN='right'>".$montant_pieces." ".$xoopsModuleConfig['money']."<br>".$remise_pce." ".$xoopsModuleConfig['money']."<br>".$montant_pieces_net." ".$xoopsModuleConfig['money']."</td>";
//	$pieces_det .= "<td style='border: 1px solid #D2A901;'>".$remise." ".$xoopsModuleConfig['money']."</td>";
//	$pieces_det .= "<td style='border: 1px solid #D2A901;'>".$montant_pieces_net." ".$xoopsModuleConfig['money']."</td>";
	$pieces_det .= "</tr>";
	$pieces_det .= "</table>";

  if ($nbp != 0){
  $form->insertBreak(_AM_INTER_PIECES_UTILISEES.'<center><br>'.$pieces_det.'</center>','head');
  }
// ajout de pieces  
  $req1 = $xoopsDB->query("SELECT p.id, p.ref, p.designation, f.nom FROM ".$xoopsDB->prefix("garage_pieces")." p INNER JOIN ".$xoopsDB->prefix("garage_fournisseur")." f ON f.id = p.id_fournisseur ORDER BY designation ASC");
  $list_id_pieces = array();
  $list_id_pieces[0] = _AM_PCE_MAG;
  while ((list($id_piece, $ref, $designation, $nom_fournisseur) = $xoopsDB->fetchRow($req1)) != false ) { 
  $list_id_pieces[$id_piece]=$designation.' - '.$nom_fournisseur;
  }

// Piece magasin
  $npce++;  
  if ($quantite ==0) {$quantite =1;};
  
  $pce	= new XoopsFormElementTray('');
  $pcec = new XoopsFormSelect('',"id_pieces");
  $pcec	-> addOptionArray ($list_id_pieces);
  $pce	-> addElement($pcec);
  $pce 	-> addElement(new XoopsFormText('&nbsp;&nbsp;&nbsp;'._AM_PCE_QTE,'quantite',3,5,$quantite));
  $pce 	-> addElement(new XoopsFormText('&nbsp;&nbsp;&nbsp;'._AM_PCE_PXE,'tarif_client',10,10,$tarif_client));
  $form -> addElement($pce);
    
	$req4 = $xoopsDB->query("SELECT id, nom  FROM ".$xoopsDB->prefix("garage_fournisseur")." order by nom");
	while (($row = $xoopsDB->fetchArray($req4)) != false ){
		$fournisseurs[$row['id']]=$row['nom'];
	}
	
// Piece hors magasin
  $npce++;
  if ($quantite1 ==0) {$quantite1 =1;};
  
  $fourn = new XoopsFormSelect('', 'id_fournisseur');
	$fourn -> addOptionArray ($fournisseurs);
	$fourn -> setValue($id_fournisseur);
  $pcel	= new XoopsFormElementTray('&nbsp;&nbsp;'._AM_PCE_FSEUR);
  $pcel -> addElement($fourn);
	$pcel -> addElement(new XoopsFormText(_AM_PCE_DESIG,'designation',40,50));
  $pcel -> addElement(new XoopsFormText('&nbsp;&nbsp;&nbsp;'._AM_PCE_QTE,'quantite1',3,5,$quantite1));
  $pcel -> addElement(new XoopsFormText('&nbsp;&nbsp;&nbsp;'._AM_PCE_PX,'tarif_client1',10,10));
  $form -> addElement($pcel);

	$forfait  = "<table border=1>";
	$forfait .= "<tr><th align=left>"._AM_PCE_DESIG."</th>";
	$forfait .= "<th align=center width=100px>"._AM_PCE_QTE."</th>";
	$forfait .= "<th align=center width=100px>"._AM_PCE_PX."</th>";
	$forfait .= "<th align=center width=100px>"._AM_ACTION."</th></tr>";

  //liste des forfaits deja affectés
  $reqf = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("garage_inter_forfait")." WHERE id_inter=".$id_inter);
  while ((list($idkey, $idinter, $id_forfait, $designation_ff, $ref_fournisseur, $quantite_ff, $tarif_client) = $xoopsDB->fetchRow($reqf)) != false ) 
  {
      $nbf =1; // compteur pour affichage
	    $forfait .= "<tr><td align=left>".nl2br($designation_ff)."</td>";
		  $forfait .= "<td align=center>".$quantite_ff."</td>";
		  $forfait .= "<td>".$tarif_client."</td>";
		  $forfait .= "<td><a href='inter_pces.php?op=delete_forf&id=".$idkey."&id_inter=".$id_inter."'><img src='../images/cancel.png' alt='"._AM_DELETE."' title='"._AM_DELETE."'></a></td></tr>";	

$montant_forfait_brut = $montant_brut_forfait + $tarif_client;
$remise_forf 		  		= $remise_forf + $remise_forfait; 
$montant_forfait_net = $montant_forfait_brut - $remise_forf;
}
	$forfait .= "<td colspan=2 align=right>"._AM_FORFAITS."<br>"._AM_PCE_REMISE."<br>"._AM_PCE_NET."</td>";
	$forfait .= "<td style='border: 1px solid #D2A901;' align=right>".$montant_forfait_brut." ".$xoopsModuleConfig['money']."<br><input type='text' name='remise_forfait' size='10' maxlength='15' value='".$remise_forfait."' > ".$xoopsModuleConfig['money']."<br>".$montant_forfait_net." ".$xoopsModuleConfig['money']."</td>";

  $forfait .="</table>";

  $nbfd = 0;
	$list_forfait=array();
	$reqfor = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("garage_forfait")." order by description");
	while (($row = $xoopsDB->fetchArray($reqfor)) != false ){
		$nbfd = 1;
		$list_forfait[$row['id']]=$row['nom'].' - '.$row['description'].' - Prix : '.$row['tarif'];
}

  if ($nbfd != 0){
  $form->insertBreak('<h3><center>'._AM_FORFAIT.'</center></h3><br>','head');
  }

  if ($nbf != 0){
    $form->insertBreak(_AM_FORFAIT_UTILISE.'<center><br>'.$forfait.'</center>','head');
  }

  if ($nbfd != 0){
  $forf	= new XoopsFormElementTray('');
  $forf = new XoopsFormSelect(_AM_FORFAIT,"id_forfait",'',3);
  $forf	-> addOptionArray ($list_forfait);
  $form	-> addElement($forf);
  }

// traitement du solde et archive
	if ($solde == 2 || $solde == 1 ) {$etatsolde = 1; } else {$etatsolde = 0; } ; 
	if ($xoopsModuleConfig['autoriser_solde'] == 1 || $xoopsUser->isAdmin($xoopsModule->mid()) )
	{
		$form -> addElement (new XoopsFormRadioYN(_AM_INTER_SOLDE, 'solde', $etatsolde));
	}	

// si la reparation n'est pas soldée on ne propose pas l'archivage	
	if ($solde != 0) {
	if ($solde == 2) {$archive = 1; } else {$archive = 0; }; 
	if ($xoopsModuleConfig['autoriser_archive'] == 1 || $xoopsUser->isAdmin($xoopsModule->mid()) )
	{
		$form -> addElement (new XoopsFormRadioYN(_AM_INTER_ARCHIVE, 'archive', $archive));
	}
}

// element caches
  if ($id_inter ==0){  
	$form -> addElement(new xoopsFormHidden ('id_inter', $id));
} else {
  $form -> addElement(new xoopsFormHidden ('id_inter', $id_inter));
}
 

  $remise_repar      = $remise_mod + $remise_pce + $remise_forf;
  $montant_net_repar = $montant_pieces_net + $montant_mod_net + $montant_forfait_net;

  $montant_brut_repar = $montant_net_repar + $remise_repar ;

  $pct = round((100 - ($montant_net_repar * 100) / $montant_brut_repar),0);
  
  if ($montant_net_repar != 0){
  $form->insertBreak(_AM_PIED_REPAR,'head');
  $form -> addElement(new xoopsFormLabel (_AM_PCE_BRUT, $montant_brut_repar." ".$xoopsModuleConfig['money']));
  $form -> addElement(new xoopsFormLabel (_AM_PCE_REMISE, $remise_repar." ".$xoopsModuleConfig['money']." (soit ".$pct."% de remise)"));
  $form -> addElement(new xoopsFormLabel (_AM_PCE_NET, $montant_net_repar." ".$xoopsModuleConfig['money']));
}

  $form -> addElement(new xoopsFormHidden ('montant_net_repar', $montant_net_repar));
  
  $form -> addElement(new XoopsFormButton('', 'submit', _AM_CREATE, 'submit'));

  $form -> display();
}
}
xoops_cp_footer();
?>