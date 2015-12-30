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

Xoops_Header();

$myts =& MyTextSanitizer::getInstance();

if(!isset($op)){$op=" ";}
switch ($op) {

//  ------------------------------------------------------------------------ //
//--CREATION
//  ------------------------------------------------------------------------ //
	case "create":

	global $xoopsDB, $myts, $xoopsModule, $xoopsModuleConfig;
	
	$id_piece 				 = $_POST["id_pieces"];
	$designation 			 = $_POST["designation"];
	$tx_real 			 		 = $_POST["tx_real"];
//	$observation 			 = $_POST["observation"];
	$quantite 				 = $_POST["quantite"];
	$quantite1 				 = $_POST["quantite1"];
	$tarif_client			 = $_POST["tarif_client"];
	$tarif_client1		 = $_POST["tarif_client1"];
	$montant_pieces		 = $_POST["montant_pieces"];

	$id_empl		 				= $_POST["id_employe"];
	$hmeca_t1	 					= $_POST["hmeca_t1"];
	$hmeca_t2	 					= $_POST["hmeca_t2"];
	$hmeca_t3	 					= $_POST["hmeca_t3"];
	$hcarro_t1	 				= $_POST["hcarro_t1"];
	$hcarro_t2	 				= $_POST["hcarro_t2"];
	$hcarro_t3	 				= $_POST["hcarro_t3"];

	$solde		 					= $_POST["solde"];
	$archive	 					= $_POST["archive"];

if ($archive == 1){$solde =2;};

	if($hmeca_t1 ==""){$hmeca_t1 = 0;};
	if($hmeca_t2 ==""){$hmeca_t2 = 0;};
	if($hmeca_t3 ==""){$hmeca_t3 = 0;};
	if($hcarro_t1 ==""){$hcarro_t1 = 0;};
	if($hcarro_t2 ==""){$hcarro_t2 = 0;};
	if($hcarro_t3 ==""){$hcarro_t3 = 0;};

  
// update de l'etat
	$sql = "UPDATE ".$xoopsDB->prefix('garage_intervention')." SET solde=$solde, numero_devis=0, numero_facture=0  WHERE id=$id_inter";
  $xoopsDB->queryF($sql) or die ('Erreur requete : '.$sql.'<br />');

// creation dans la table des heures
if (($hmeca_t1 + $hmeca_t2 + $hmeca_t3 + $hcarro_t1 + $hcarro_t2 + $hcarro_t3) !=0){
	$sqlh = "INSERT INTO ".$xoopsDB->prefix('garage_inter_temp')." (id_inter, id_empl, observation, hmeca_t1, hmeca_t2, hmeca_t3, hcarro_t1, hcarro_t2, hcarro_t3) VALUES ($id_inter, $id_empl, '$observation', $hmeca_t1, $hmeca_t2, $hmeca_t3, $hcarro_t1, $hcarro_t2, $hcarro_t3)";
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
  
  
	redirect_header("inter_pces.php?id_inter=$id_inter", 1, _MD_INTER_MODIF_OK);
	break;
	
//  ------------------------------------------------------------------------ //
//-- SUPPRESSION PIECE
//  ------------------------------------------------------------------------ //

  case "delete":

	$sql = "DELETE FROM ".$xoopsDB->prefix('garage_inter_pieces')." WHERE id=".$id;
  $xoopsDB->queryF($sql) or die ('Erreur requete : '.$sql.'<br />');

	redirect_header("inter_pces.php?id_inter=$id_inter", 1, _MD_INTER_PCE_SUPR);
	break;
	
//  ------------------------------------------------------------------------ //
//-- SUPPRESSION 	MOD
//  ------------------------------------------------------------------------ //

  case "delete_mod":

	$sql = "DELETE FROM ".$xoopsDB->prefix('garage_inter_temp')." WHERE id=".$id;
  $xoopsDB->queryF($sql) or die ('Erreur requete : '.$sql.'<br />');

	redirect_header("inter_pces.php?id_inter=$id_inter", 1, _MD_INTER_MOD_SUPR);
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
//-- CAS GENERAL - ON LISTE LES ENREGISTREMENTS + FORMULAIRE DE CREATION
//  ------------------------------------------------------------------------ //
	if (empty($op)) {

//  ------------------------------------------------------------------------ //
//-- CAS GENERAL - FORMULAIRE DE CREATION DU DETAIL
//  ------------------------------------------------------------------------ //
  global $xoopsDB, $id, $xoopsModule, $xoopsModuleConfig;
  $myts =& MyTextSanitizer::getInstance();

  $montant_pieces = 0;

  $requete = $xoopsDB->query("SELECT i.*, v.id, v.immat, v.id_marque, v.gamme, v.modele_version, v.id_proprietaire, c.civilite, c.nom, c.prenom, c.teldom, c.telport, m.nom FROM ".$xoopsDB->prefix("garage_intervention")." i INNER JOIN ".$xoopsDB->prefix("garage_vehicule")." v ON i.id_voiture = v.id INNER JOIN ".$xoopsDB->prefix("garage_clients")." c ON v.id_proprietaire = c.id INNER JOIN ".$xoopsDB->prefix("garage_marque")." m ON m.id = v.id_marque WHERE i.id=".$id_inter); 


  while ((list($id2, $id_vehic, $kilometrage, $date_debut, $date_fin, $delai, $id_inter_recurrente, $description, $observation, $date_devis, $date_acceptation, $montant, $acompte_verse, $solde, $hmeca_t1, $hmeca_t2, $hmeca_t3, $hcarro_t1, $hcarro_t2, $hcarro_t3, $tmeca_t1, $tmeca_t2, $tmeca_t3, $tcarro_t1, $tcarro_t2, $tcarro_t3 ,$remise_meca, $remise_caro, $remise_forfait, $numero_devis, $numero_facture, $id_vehicule, $immat, $id_marque, $gamme, $modele_version, $id_proprietaire, $civilite, $nom, $prenom, $teldom, $telport, $marque) = $xoopsDB->fetchRow($requete)) != false ) {
  	
   
  echo "<table width='100%'><tr><td align='center'><img src='images/logo.jpg' alt='' title=''></td></tr></table><br />\n";	
    
  echo "<a href='index.php'><img src='images/fleche.gif' alt='"._MD_BACKTOLISTE."' title='"._MD_BACKTOLISTE."'><br>"._MD_BACKTOLISTE."</a>";


  $form = new XoopsThemeForm(_MD_CREATE." "._MD_INTER_VEHICULE,'cinter','inter_pces.php?op=create','post');
  $form->setExtra("enctype='multipart/form-data'") ; // imperatif !

	$etrep  = "<table border=1>";
	$etrep .= "<tr><td align=left width=300px>"._MD_VEHICULE_IMMAT."</td>";
	$etrep .= "<td align=left>".$immat."</td>";
	$etrep .= "<td align=left>"._MD_INTER_RECEP."</td>";
	$etrep .= "<td>".date("d/m/Y", strtotime($date_debut))."</td></tr>";
	$etrep .= "<tr><td align=left>"._MD_VEHICULE_MARQUE."</td>";
	$etrep .= "<td align=left>".$marque."</td>";
	$etrep .= "<td align=left>"._MD_INTER_DELAI."</td>";
	$etrep .= "<td>".date("d/m/Y", strtotime($delai))."</td></tr>";
	$etrep .= "<tr><td align=left>"._MD_VEHICULE_MODELE."</td>";
	$etrep .= "<td align=left>".$modele_version."</td>";
	$etrep .= "<td align=left>"._MD_INTER_KM."</td>";
	$etrep .= "<td>".$kilometrage." Kms</td></tr>";
	$etrep .= "<tr><td align=left>"._MD_VEHICULE_GAMME."</td>";
	$etrep .= "<td align=left colspan=4>".$gamme."</td></tr>";
	$etrep .= "<tr><td align=left>"._MD_VEHICULE_PROPRIETAIRE."</td>";
	$etrep .= "<td align=left>".$civilite." ".$nom." ".$prenom."</td>";
	$etrep .= "<td align=left>"._MD_CLIENT_TEL."</td>";
	$etrep .= "<td>".$teldom." / ".$telport."</td></tr>";
	$etrep .= "<tr><td align=left>"._MD_INTER_TAF."</td>";
	$etrep .= "<td align=left colspan=3>".nl2br($description)."</td></tr>";
	$etrep .= "</table>";
						 
  $form->insertBreak(_MD_VEHICULE_INTERVENTION.'<center><br>'.$etrep.'</center>','head');

	$mod_dec  = "<table border=1>";
	$mod_dec .= "<tr><td></td>";
	$mod_dec .= "<th align='center' colspan=3>"._MD_INTER_MOD_MECA."</th>";
	$mod_dec .= "<th align='center' colspan=3>"._MD_INTER_MOD_CARRO."</th>";
	$mod_dec .= "<td></td></tr>";
	$mod_dec .= "<tr><th align=left width=200px>"._MD_INTER_EMPL."</th>";
	$mod_dec .= "<th align='center' width=100px>"._MD_INTER_MOD_T1."</th>";
	$mod_dec .= "<th align='center' width=100px>"._MD_INTER_MOD_T2."</th>";
	$mod_dec .= "<th align='center' width=100px>"._MD_INTER_MOD_T3."</th>";
	$mod_dec .= "<th align='center' width=100px>"._MD_INTER_MOD_T1."</th>";
	$mod_dec .= "<th align='center' width=100px>"._MD_INTER_MOD_T2."</th>";
	$mod_dec .= "<th align='center' width=100px>"._MD_INTER_MOD_T3."</th>";

if ($xoopsModuleConfig['modif_inter_mod']==0){
		$mod_dec .= "<th align='center' width=100px>"._MD_ACTION."</th>";
}
	$mod_dec .= "</tr>";
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
  
 
 	$nbmo = 0; 
  $sql = "SELECT t.*, e.*  FROM ".$xoopsDB->prefix("garage_inter_temp")." t INNER JOIN ".$xoopsDB->prefix("garage_employe")." e ON t.id_empl = e.id_empl WHERE t.id_inter=".$id_inter;
  $reqe = $xoopsDB->query($sql);
  while ((list($idkeyempl, $idinter, $id_empl, $observation, $hmeca_t1, $hmeca_t2, $hmeca_t3, $hcarro_t1, $hcarro_t2, $hcarro_t3, $tmeca_t1, $tmeca_t2, $tmeca_t3, $tcarro_t1, $tcarro_t2, $tcarro_t3, $idkeyempl2, $nom_empl, $pre_empl ) = $xoopsDB->fetchRow($reqe)) != false ) 
  {
  $nbmo = 1; // test pour affichage
  $mod_dec .= "<tr><td align=left>".$pre_empl.' '.$nom_empl."</td>";
  $mod_dec .= "<td align=center>".$hmeca_t1."</td>";
  $mod_dec .= "<td align=center>".$hmeca_t2."</td>";
  $mod_dec .= "<td align=center>".$hmeca_t3."</td>";
  $mod_dec .= "<td align=center>".$hcarro_t1."</td>";
  $mod_dec .= "<td align=center>".$hcarro_t2."</td>";
  $mod_dec .= "<td align=center>".$hcarro_t3."</td>";
  if ($xoopsModuleConfig['modif_inter_mod']==0){
		$mod_dec .= "<td align=center><a href='inter_pces.php?op=delete_mod&id=".$idkeyempl."&id_inter=".$id_inter."'><img src='images/cancel.png' alt='Supprimer' title='Supprimer'></a></td>";
  }
  
  $mod_dec .="</tr>";

  if ($observation !=""){
												  $mod_dec .= "<tr><td align=right>"._MD_INTER_TRAVAUX_REAL."&nbsp;</td>";
												  $mod_dec .= "<td colspan=6>";
													if ($xoopsModuleConfig['modif_inter_mod']==0){
														$mod_dec .= "<TEXTAREA style='border: 1px solid #0078F0' rows='2' cols='80' name='constat_".$idkeyempl."'>".$observation."</TEXTAREA>";
													} else {
														$mod_dec .= "<TEXTAREA DISABLED style='border: 1px solid #0078F0' rows='2' cols='80' name='constat_".$idkeyempl."'>".$observation."</TEXTAREA>";
														}
													$mod_dec .= "</td>";
												  $mod_dec .= "<td></td></tr>";
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
	$mod_dec .= "<tr><td colspan=3 align=right>"._MD_INTER_MOD_MECA."&nbsp;:&nbsp;</td>";
	$mod_dec .= "<td style='border: 1px solid #D2A901;' align=right>".$montant_modmeca." ".$xoopsModuleConfig['money']."</td>";
	$mod_dec .= "<td colspan=2 align=right>"._MD_INTER_MOD_CARRO."&nbsp;:&nbsp;</td>";
	$mod_dec .= "<td style='border: 1px solid #D2A901;' align=right>".$montant_modcaro." ".$xoopsModuleConfig['money']."</td>";
	$mod_dec .= "<td></td></tr>";
	$mod_dec .= "</table>";

  if ($nbmo != 0){
  $form->insertBreak('<h3><center>'._MD_INTER_MOD.'</center></h3><br>'.$mod_dec,'head');
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
  
  $mod 	-> addElement(new XoopsFormText("<b>"._MD_INTER_MOD_MECA."</b> -> "._MD_INTER_MOD_T1,'hmeca_t1',5,10));
  $mod 	-> addElement(new XoopsFormText('&nbsp;&nbsp;&nbsp;'._MD_INTER_MOD_T2,'hmeca_t2',5,10));
  $mod 	-> addElement(new XoopsFormText('&nbsp;&nbsp;&nbsp;'._MD_INTER_MOD_T3,'hmeca_t3',5,10));
  $mod 	-> addElement(new XoopsFormText("&nbsp;&nbsp;&nbsp;<b>"._MD_INTER_MOD_CARRO."</b> -> "._MD_INTER_MOD_T1,'hcarro_t1',5,10));
  $mod 	-> addElement(new XoopsFormText('&nbsp;&nbsp;&nbsp;'._MD_INTER_MOD_T2,'hcarro_t2',5,10));
  $mod 	-> addElement(new XoopsFormText('&nbsp;&nbsp;&nbsp;'._MD_INTER_MOD_T3,'hcarro_t3',5,10));
  $form -> addElement($mod);
  
  $form -> addElement(new XoopsFormTextArea(_MD_INTER_TRAVAUX_REAL,'observation',$observation,5,80));
  $form -> addElement(new XoopsFormButton('', 'submit', _MD_CREATE, 'submit'));

  
  $form->insertBreak('<h3><center>'._MD_INTER_PIECES.'</center></h3>','head');
  
	$pieces_det  = "<table border=1>";
	$pieces_det .= "<tr><th align=left>"._MD_PCE_DESIG."</th>";
	$pieces_det .= "<th align=left width=200px>"._MD_PCE_FSEUR."</th>";
	$pieces_det .= "<th align=center width=100px>"._MD_PCE_QTE."</th>";
	$pieces_det .= "<th align=center width=100px>"._MD_PCE_PX."</th>";
  if ($xoopsModuleConfig['modif_inter_pce']==0){
	$pieces_det .= "<th align='center' width=100px>"._MD_ACTION."</th>";
  }
  $pieces_det .="</tr>";

  $nbp = 0;
  //liste des pieces deja renseignées
  $reqp = $xoopsDB->query("SELECT id, id_piece, designation, id_fournisseur, quantite, tarif_client FROM ".$xoopsDB->prefix("garage_inter_pieces")." WHERE id_inter=".$id_inter);
  while ((list($idkey, $id_piece, $designation, $id_fournisseur, $quantite, $tarif_client) = $xoopsDB->fetchRow($reqp)) != false ) 
  {
  	$nbp = 1; // test pour affichage
	//piece magasin
  if (!is_null($id_piece)) {
													    $reqpce = $xoopsDB->query("SELECT p.designation, p.tarif_client, f.nom FROM ".$xoopsDB->prefix("garage_pieces")." p INNER JOIN  ".$xoopsDB->prefix("garage_fournisseur")." f ON p.id_fournisseur=f.id where p.id=".$id_piece);
														  while ((list ($designation, $tarif_client_std, $nom_fournisseur ) = $xoopsDB->fetchrow($reqpce)) != false )
														  {	
														  	if (is_null($tarif_client)) { $tarif_client = $tarif_client_std;}	  	 
																$pieces_det .= "<tr><td align=left>".$designation."</td>";
																$pieces_det .= "<td align=left>".$nom_fournisseur."</td>";
																$pieces_det .= "<td align=center>".$quantite."</td>";
																$pieces_det .= "<td>".$tarif_client."</td>";
                                if ($xoopsModuleConfig['modif_inter_pce']==0){
																$pieces_det .= "<td align='center'><a href='inter_pces.php?op=delete&id=".$idkey."&id_inter=".$id_inter."'><img src='images/cancel.png' alt='"._MD_DELETE."' title='"._MD_DELETE."'></a></td>";
																}
																$pieces_det .="</tr>";
													  	}
  													}
	//piece libre
  if (is_null($id_piece)) {
													  $reqf2 = $xoopsDB->query("SELECT id, nom  FROM ".$xoopsDB->prefix("garage_fournisseur")." where id=".$id_fournisseur);
														while (($row = $xoopsDB->fetchArray($reqf2)) != false ){	$nom_fournisseur=$row['nom']; } 
													  $pieces_det .= "<tr><td align=left>".$designation."</td>";
													  $pieces_det .= "<td align=left>".$nom_fournisseur."</td>";
													  $pieces_det .= "<td align=center>".$quantite."</td>";
													  $pieces_det .= "<td align='right'>".$tarif_client."</td>";
                            if ($xoopsModuleConfig['modif_inter_pce']==0){
														  $pieces_det .= "<td align='center'><a href='inter_pces.php?op=delete&id=".$idkey."&id_inter=".$id_inter."'><img src='images/cancel.png' alt='"._MD_DELETE."' title='"._MD_DELETE."'></a></td>";
														 }
															$pieces_det .="</tr>";
														  
													}
	$montant_pieces = $montant_pieces + ($quantite * $tarif_client);
	}

	$pieces_det .= "<tr><td colspan=3 align='right'>"._MD_INTER_FOURNITURES."&nbsp;:&nbsp;</td>";
	$pieces_det .= "<td align='right' style='border: 1px solid #D2A901;'>".$montant_pieces." ".$xoopsModuleConfig['money']."</td>";
	$pieces_det .= "<td></td></tr>";
	$pieces_det .= "</table>";

  if ($nbp != 0){
  $form->insertBreak(_MD_INTER_PIECES_UTILISEES.'<center><br>'.$pieces_det.'</center>','head');
	}
// ajout de pieces  
  $req1 = $xoopsDB->query("SELECT p.id, p.ref, p.designation, f.nom FROM ".$xoopsDB->prefix("garage_pieces")." p INNER JOIN ".$xoopsDB->prefix("garage_fournisseur")." f ON f.id = p.id_fournisseur ORDER BY designation ASC");
  $list_id_pieces = array();
  $list_id_pieces[0] = _MD_PCE_MAG;
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
  $pce 	-> addElement(new XoopsFormText('&nbsp;&nbsp;&nbsp;'._MD_PCE_QTE,'quantite',3,5,$quantite));
  $pce 	-> addElement(new XoopsFormText('&nbsp;&nbsp;&nbsp;'._MD_PCE_PXE,'tarif_client',10,10,$tarif_client));
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
  $pcel	= new XoopsFormElementTray('&nbsp;&nbsp;'._MD_PCE_FSEUR);
  $pcel -> addElement($fourn);
	$pcel -> addElement(new XoopsFormText(_MD_PCE_DESIG,'designation',40,50));
  $pcel -> addElement(new XoopsFormText('&nbsp;&nbsp;&nbsp;'._MD_PCE_QTE,'quantite1',3,5,$quantite1));
  $pcel -> addElement(new XoopsFormText('&nbsp;&nbsp;&nbsp;'._MD_PCE_PX,'tarif_client1',10,10));
  $form -> addElement($pcel);


	$forfait  = "<table border=1>";
	$forfait .= "<tr><th align=left>"._MD_PCE_DESIG."</th>";
	$forfait .= "<th align=center width=100px>"._MD_PCE_QTE."</th>";
	$forfait .= "<th align=center width=100px>"._MD_PCE_PX."</th>";
if ($xoopsModuleConfig['modif_inter_for']==0){
	$forfait .= "<th align='center' width=100px>"._MD_ACTION."</th>";
}
  $forfait .="</tr>";
  
  $nbf = 0;
  //liste des forfaits deja affectés
  $reqf = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("garage_inter_forfait")." WHERE id_inter=".$id_inter);
  while ((list($idkey, $id_interv, $id_forfait, $designation_ff, $ref_fournisseur, $quantite_ff, $tarif_client) = $xoopsDB->fetchRow($reqf)) != false ) 
  {
      $nbf =1; // compteur pour affichage
 	    $forfait .= "<tr><td align=left>".nl2br($designation_ff)."</td>";
		  $forfait .= "<td align=center>".$quantite_ff."</td>";
		  $forfait .= "<td>".$tarif_client."</td>";
      if ($xoopsModuleConfig['modif_inter_for']==0){
		$forfait .= "<td align='center'><a href='inter_pces.php?op=delete_forf&id=".$idkey."&id_inter=".$id_inter."'><img src='images/cancel.png' alt='Supprimer' title='Supprimer'></a></td>";}
			$forfait .="</tr>";
}
  $forfait .="</table>";
  
  $nbfd = 0;
	$list_forfait=array();
	$reqfor = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("garage_forfait")." order by description");
	while (($row = $xoopsDB->fetchArray($reqfor)) != false ){
		$nbfd = 1;
		$list_forfait[$row['id']]=$row['nom'].' - '.$row['description'].' - Prix : '.$row['tarif'];
}


  if ($nbfd != 0){
  $form->insertBreak('<h3><center>'._MD_FORFAIT.'</center></h3><br>','head');
  }

  if ($nbf != 0){
    $form->insertBreak(_MD_FORFAIT_UTILISE.'<center><br>'.$forfait.'</center>','head');
  }

  if ($nbfd != 0){
  $forf	= new XoopsFormElementTray('');
  $forf = new XoopsFormSelect(_MD_FORFAIT_ADD,"id_forfait",'',3);
  $forf	-> addOptionArray ($list_forfait);
  $form	-> addElement($forf);
}

// traitement du solde et archive
	if ($solde == 2 || $solde == 1 ) {$etatsolde = 1; } else {$etatsolde = 0; } ; 
	if ($xoopsModuleConfig['autoriser_solde'] == 1 || $xoopsUser->isAdmin($xoopsModule->mid()) )
	{
		$form -> addElement (new XoopsFormRadioYN(_MD_INTER_SOLDE, 'solde', $etatsolde));
	}	

// si la reparation n'est pas soldée on ne propose pas l'archivage	
	if ($solde != 0) {
	if ($solde == 2) {$archive = 1; } else {$archive = 0; }; 
	if ($xoopsModuleConfig['autoriser_archive'] == 1 || $xoopsUser->isAdmin($xoopsModule->mid()) )
	{
		$form -> addElement (new XoopsFormRadioYN(_MD_INTER_ARCHIVE, 'archive', $archive));
	}
}
// element caches
  if ($id_inter ==0){  
	$form -> addElement(new xoopsFormHidden ('id_inter', $id));
} else {
  $form -> addElement(new xoopsFormHidden ('id_inter', $id_inter));
}
  $form -> addElement(new xoopsFormHidden ('montant_pieces', $montant_pieces));  
  $form -> addElement(new XoopsFormButton('', 'submit', _MD_CREATE, 'submit'));
  $form -> display();
}
}
	include_once XOOPS_ROOT_PATH.'/footer.php';
?>