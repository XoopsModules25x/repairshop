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

if(!isset($_POST['id_inter'])){
	$id_inter = isset ($_GET['id_inter']) ? $_GET['id_inter'] : '';
}else {
	$id_inter = $_POST['id_inter'];
}
$id_inter = intval($id_inter);

if ($id_inter == 0){	redirect_header("index.php", 2, _NOPERM);}

if(!isset($npce)){$npce = 0;};
if(!isset($tarif_client)){$tarif_client = 0;};
if(!isset($tarif_client1)){$tarif_client1 = 0;};

  global $xoopsDB, $id, $xoopsModule, $xoopsModuleConfig, $xoopsTpl;

  $xoopsTpl = new XoopsTpl();

  $montant_pieces = 0;


  $requete = $xoopsDB->query("SELECT i.*, v.id, v.immat, v.id_marque, v.gamme, v.modele_version, v.id_proprietaire, c.civilite, c.nom, c.prenom, c.teldom, c.telport, m.nom , c.compte, c.rs, c.adresse, c.cp, c.ville, c.remise FROM ".$xoopsDB->prefix("garage_intervention")." i INNER JOIN ".$xoopsDB->prefix("garage_vehicule")." v ON i.id_voiture = v.id INNER JOIN ".$xoopsDB->prefix("garage_clients")." c ON v.id_proprietaire = c.id INNER JOIN ".$xoopsDB->prefix("garage_marque")." m ON m.id = v.id_marque WHERE i.id=".$id_inter); 

  while ((list($id2, $id_vehic, $kilometrage, $date_debut, $date_fin, $delai, $id_inter_recurrente, $description, $observation, $date_devis, $date_acceptation, $montant, $acompte_verse, $solde, $hmeca_t1, $hmeca_t2, $hmeca_t3, $hcarro_t1, $hcarro_t2, $hcarro_t3, $tmeca_t1, $tmeca_t2, $tmeca_t3, $tcarro_t1, $tcarro_t2, $tcarro_t3 ,$remise_meca, $remise_caro, $remise_forfait, $numero_devis, $numero_facture, $id_vehicule, $immat, $id_marque, $gamme, $modele_version, $id_proprietaire, $civilite, $nom, $prenom, $teldom, $telport, $marque, $compte, $client_rs, $adresse, $cp, $ville, $remise) = $xoopsDB->fetchRow($requete)) != false ) {

   
// recup et update du numero de devis
if ($numero_facture ==0){
	  $reqnum = $xoopsDB->query("SELECT num_doc FROM ".$xoopsDB->prefix("garage_num_doc")." WHERE type_doc='FACTURE'");
  while ((list($n_doc) = $xoopsDB->fetchRow($reqnum)) != false ) 
  {
  $n_doc++;
  // mise a jour dans la table des numeros de documents
	$sql = "UPDATE ".$xoopsDB->prefix('garage_num_doc')." SET num_doc=$n_doc  WHERE type_doc='FACTURE'";
  $xoopsDB->queryF($sql) or die ('Erreur requete : '.$sql.'<br />');
  // mise a jour dans la table des nterventions
  $sqli = "UPDATE ".$xoopsDB->prefix('garage_intervention')." SET numero_facture=$n_doc  WHERE id=$id_inter";
  $xoopsDB->queryF($sqli) or die ('Erreur requete : '.$sqli.'<br />');
  $numero_facture = $n_doc;
}
}

// assignation des constantes
  
     $xoopsTpl -> assign ('facture_date',date("d-m-Y"));
		 $xoopsTpl -> assign ('facture_id',$numero_facture);
     $xoopsTpl -> assign ('facture_immat',$immat);
     $xoopsTpl -> assign ('facture_ddebut',date("d/m/Y", strtotime($date_debut)));
     $xoopsTpl -> assign ('facture_marque',$marque);
     $xoopsTpl -> assign ('facture_gamme',$gamme);
     $xoopsTpl -> assign ('facture_delai',date("d/m/Y", strtotime($delai)));
     $xoopsTpl -> assign ('facture_modele',$modele_version);
     $xoopsTpl -> assign ('facture_km',$kilometrage);
     $xoopsTpl -> assign ('facture_proprietaire',$civilite." ".$nom." ".$prenom);
     $xoopsTpl -> assign ('facture_teldom',$teldom);
     $xoopsTpl -> assign ('facture_telport',$telport);
     $xoopsTpl -> assign ('facture_compte',$compte);
     $xoopsTpl -> assign ('facture_client_rs',$client_rs);
     $xoopsTpl -> assign ('facture_adresse',nl2br($adresse));
     $xoopsTpl -> assign ('facture_cp',$cp);
     $xoopsTpl -> assign ('facture_ville',$ville);
     $xoopsTpl -> assign ('facture_remise',$remise);
     $xoopsTpl -> assign ('facture_taf',nl2br($description));
     $xoopsTpl -> assign ('facture_devise',$xoopsModuleConfig['money']);
     $xoopsTpl -> assign ('facture_rs',$xoopsModuleConfig['raison_sociale']);
     $xoopsTpl -> assign ('facture_societe',nl2br($xoopsModuleConfig['societe']));
     $xoopsTpl -> assign ('facture_rcs',$xoopsModuleConfig['rcs']);
     if ($xoopsModuleConfig['impression_directe'] == 1){
     $xoopsTpl -> assign ('facture_impression_directe',' onload="window.print()"');
   } else {
   	     $xoopsTpl -> assign ('facture_impression_directe','');
   }

     $xoopsTpl -> assign ('facture_remise_meca',$remise_meca);
     $xoopsTpl -> assign ('facture_remise_caro',$remise_caro);
     $xoopsTpl -> assign ('facture_remise_forfait',$remise_forfait);



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
  $remise_pces = 0;
  $montant_net_forfaits = 0;
  
  $facture_detail_mod = array();

  $i = 0;
  $facture_observation = "";
  $reqe = $xoopsDB->query("SELECT t.*, e.*  FROM ".$xoopsDB->prefix("garage_inter_temp")." t INNER JOIN ".$xoopsDB->prefix("garage_employe")." e ON t.id_empl = e.id_empl WHERE t.id_inter=".$id_inter);
  while ((list($idkeyempl, $idinter, $id_empl, $observation, $hmeca_t1, $hmeca_t2, $hmeca_t3, $hcarro_t1, $hcarro_t2, $hcarro_t3, $remise_mod, $idkeyempl2, $nom_empl, $pre_empl ) = $xoopsDB->fetchRow($reqe)) != false ) 
  {
  $i++;
  $facture_detail_mod[$i]['facture_nom_empl']= $pre_empl.' '.$nom_empl;
  $facture_observation = $facture_observation.nl2br($observation).'<br>';  
   										
  $modct1 = $modct1 + $hmeca_t1;
  $modct2 = $modct2 + $hmeca_t2;
  $modct3 = $modct3 + $hmeca_t3;
  $modcat1 = $modcat1 + $hcarro_t1;
  $modcat2 = $modcat2 + $hcarro_t2;
  $modcat3 = $modcat3 + $hcarro_t3;
 } 
  $xoopsTpl -> assign ('facture_nb_mod',$i);

  $xoopsTpl -> assign ('facture_observation',$facture_observation);

  $xoopsTpl -> assign ('facture_cumul_modc_t1',$modct1);
  $xoopsTpl -> assign ('facture_cumul_modc_t2',$modct2);
  $xoopsTpl -> assign ('facture_cumul_modc_t3',$modct3);
  $xoopsTpl -> assign ('facture_cumul_modca_t1',$modcat1);
  $xoopsTpl -> assign ('facture_cumul_modca_t2',$modcat2);
  $xoopsTpl -> assign ('facture_cumul_modca_t3',$modcat3);

  $montant_modmeca = ($modct1 * $xoopsModuleConfig['meca_t1']) + ($modct2 * $xoopsModuleConfig['meca_t2']) + ($modct3 * $xoopsModuleConfig['meca_t3']);
  $montant_modcaro = ($modcat1 * $xoopsModuleConfig['carro_t1']) + ($modcat2 * $xoopsModuleConfig['carro_t2']) + ($modcat3 * $xoopsModuleConfig['carro_t3']);
 
  $cumul_modmeca = $modct1  + $modct2 + $modct3 ;
  $cumul_modcaro = $modcat1 + $modcat2 + $modcat3 ;
 
  $xoopsTpl -> assign ('facture_detail_mod',$facture_detail_mod);
  $xoopsTpl -> assign ('facture_cumul_modmeca',$cumul_modmeca);
  $xoopsTpl -> assign ('facture_cumul_modcaro',$cumul_modcaro);
  $xoopsTpl -> assign ('facture_cumul_mod', $cumul_modcaro + $cumul_modmeca);
  $xoopsTpl -> assign ('facture_remise_mod',$remise_meca + $remise_caro);
  
  $xoopsTpl -> assign ('facture_val_mod_m_t1',$xoopsModuleConfig['meca_t1'] * $modct1);
  $xoopsTpl -> assign ('facture_val_mod_m_t2',$xoopsModuleConfig['meca_t2'] * $modct2);
  $xoopsTpl -> assign ('facture_val_mod_m_t3',$xoopsModuleConfig['meca_t3'] * $modct3);
  
  $xoopsTpl -> assign ('facture_val_mod_c_t1',$xoopsModuleConfig['carro_t1'] * $modcat1);
  $xoopsTpl -> assign ('facture_val_mod_c_t2',$xoopsModuleConfig['carro_t2'] * $modcat2);
  $xoopsTpl -> assign ('facture_val_mod_c_t3',$xoopsModuleConfig['carro_t3'] * $modcat3);
    
  $xoopsTpl -> assign ('facture_montant_modmeca',$montant_modmeca);
  $xoopsTpl -> assign ('facture_montant_modcaro',$montant_modcaro);
  $xoopsTpl -> assign ('facture_montant_mod',$montant_modmeca + $montant_modcaro);

  $xoopsTpl -> assign ('facture_montant_net_modmeca',$montant_modmeca - $remise_meca);
  $xoopsTpl -> assign ('facture_montant_net_modcaro',$montant_modcaro - $remise_caro);
  $xoopsTpl -> assign ('facture_montant_net_mod',($montant_modcaro - $remise_caro)+($montant_modmeca - $remise_meca));

	$montant_net_mod = ($montant_modcaro - $remise_caro)+($montant_modmeca - $remise_meca);

	$i=0;
  $facture_detail_pieces = array();
	$montant_pieces = 0;
  //liste des pieces
  $reqp = $xoopsDB->query("SELECT id, id_piece, designation, id_fournisseur, quantite, tarif_client, remise_pieces FROM ".$xoopsDB->prefix("garage_inter_pieces")." WHERE id_inter=".$id_inter);
  while ((list($idkey, $id_piece, $designation, $id_fournisseur, $quantite, $tarif_client, $remise_pieces) = $xoopsDB->fetchRow($reqp)) != false ) 
  {
   $i++;
	//piece magasin
  if (!is_null($id_piece)) {
													    $reqpce = $xoopsDB->query("SELECT p.designation, p.tarif_client, f.nom FROM ".$xoopsDB->prefix("garage_pieces")." p INNER JOIN  ".$xoopsDB->prefix("garage_fournisseur")." f ON p.id_fournisseur=f.id where p.id=".$id_piece);
														  while ((list ($designation, $tarif_client_std, $nom_fournisseur ) = $xoopsDB->fetchrow($reqpce)) != false )
														  {	
 													  	if (is_null($tarif_client)) {$tarif_client = $tarif_client_std;}	  	 
																$facture_detail_pieces[$i]['facture_dp_designation'] 	= $designation;
																$facture_detail_pieces[$i]['facture_dp_quantite'] 		= $quantite;
																$facture_detail_pieces[$i]['facture_dp_tarif_client'] = $tarif_client;
																$facture_detail_pieces[$i]['facture_dp_montant'] 			= $tarif_client * $quantite;
																$facture_detail_pieces[$i]['facture_dp_remise'] 			= $remise_pieces;
															  $facture_detail_pieces[$i]['facture_dp_net'] 					= ($tarif_client * $quantite) - $remise_pieces;
													  	}
  													}
	//piece libre
  if (is_null($id_piece)) {
													  $reqf2 = $xoopsDB->query("SELECT id, nom  FROM ".$xoopsDB->prefix("garage_fournisseur")." where id=".$id_fournisseur);
														while (($row = $xoopsDB->fetchArray($reqf2)) != false ){	$nom_fournisseur=$row['nom']; } 
																$facture_detail_pieces[$i]['facture_dp_designation'] 	= $designation;
																$facture_detail_pieces[$i]['facture_dp_quantite'] 		= $quantite;
																$facture_detail_pieces[$i]['facture_dp_tarif_client'] = $tarif_client;
																$facture_detail_pieces[$i]['facture_dp_montant'] 			= $tarif_client * $quantite;
															  $facture_detail_pieces[$i]['facture_dp_remise'] 			= $remise_pieces;
															  $facture_detail_pieces[$i]['facture_dp_net'] 					= ($tarif_client * $quantite) - $remise_pieces;
													  	}
	$montant_pieces = $montant_pieces + $facture_detail_pieces[$i]['facture_dp_montant'];
	$remise_pces = $remise_pces + $remise_pieces;
	}
  $montant_net_pieces = $montant_pieces - $remise_pces;
  
  $xoopsTpl -> assign ('facture_nb_pieces',$i);
  $xoopsTpl -> assign ('facture_dp_remise_tot',$remise_pces);


// forfaits

	$i=0;
  $facture_detail_forfaits = array();
	$montant_forfaits = 0;
  $reqf = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("garage_inter_forfait")." WHERE id_inter=".$id_inter);
  while ((list($idkey, $id_interv, $id_forfait, $designation_ff, $ref_fournisseur, $quantite_ff, $tarif_client, $remise_forfait) = $xoopsDB->fetchRow($reqf)) != false ) 
  {
     $i++;
     $nbf =1; // compteur pour affichage
 		 $facture_detail_forfaits[$i]['facture_forfait_designation'] 	= nl2br($designation_ff);
 		 $facture_detail_forfaits[$i]['facture_forfait_quantite'] 		= $quantite_ff;
 		 $facture_detail_forfaits[$i]['facture_forfait_prix'] 				= $tarif_client;
 		 $facture_detail_forfaits[$i]['facture_forfait_montant'] 			= $quantite_ff * $tarif_client;
 		 $facture_detail_forfaits[$i]['facture_forfait_remise'] 			= $remise_forfait;
 		 $facture_detail_forfaits[$i]['facture_forfait_net'] 					= ($quantite_ff * $tarif_client) - $remise_forfait;

	$montant_forfaits = $montant_forfaits + $facture_detail_forfaits[$i]['facture_forfait_montant'];
  $montant_net_forfaits = $montant_net_forfaits + $facture_detail_forfaits[$i]['facture_forfait_net'];
}
  $xoopsTpl -> assign ('facture_nb_forfait',$i);


  $tva = ((($montant_net_pieces + $montant_net_mod + $montant_net_forfaits) * $xoopsModuleConfig['tva']) / 100);
  $tva = round ($tva, 2);
  $ttc = $montant_net_pieces + $montant_net_mod + $montant_net_forfaits + $tva;
  
  $xoopsTpl -> assign ('facture_detail_pieces',$facture_detail_pieces);
  $xoopsTpl -> assign ('facture_detail_forfaits',$facture_detail_forfaits);
  $xoopsTpl -> assign ('facture_montant_pieces',$montant_pieces);
  $xoopsTpl -> assign ('facture_montant',$montant_net_pieces + $montant_net_mod + $montant_net_forfaits);
  $xoopsTpl -> assign ('facture_tx_tva',$xoopsModuleConfig['tva']);
  $xoopsTpl -> assign ('facture_tva',$tva);
  $xoopsTpl -> assign ('facture_ttc',$ttc);



	$xoopsTpl->display('db:facture_print.html');

}
?>