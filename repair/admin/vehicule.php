<?php
//  ------------------------------------------------------------------------ //
// ------------------- GESTION DE LA TABLE VEHICULE ------------------------ //
//  ------------------------------------------------------------------------ //

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

$myts =& MyTextSanitizer::getInstance();

if(!isset($op)){$op=" ";}
switch ($op) {

//  ------------------------------------------------------------------------ //
//--CREATION
//  ------------------------------------------------------------------------ //
	case "creatvehicule":
	global $xoopsDB, $myts;
	
	$immat    					= $_POST["immat"];
	$id_proprietaire		= $_POST["id_proprietaire"];
	$date_mec	 					= $_POST["date_mec"];
	$kilometrage		  	= $_POST["kilometrage"];
	$dernier_ct	   			= $_POST["dernier_ct"];
	$prochain_ct   			= $_POST["prochain_ct"];
	$id_marque	 		  	= $_POST["id_marque"];
	$gamme 	   					= $_POST["gamme"];
	$modele_version	  	= $_POST["modele_version"];
	$energie   					= $_POST["energie"];
	$genre 							= $_POST["genre"];
	$vin			 					= $_POST["vin"];
	$date_garantie  		= $_POST["date_garantie"];
	$date_distribution 	= $_POST["date_distribution"];
	$km_distribution 		= $_POST["km_distribution"];
	$date_vidange 			= $_POST["date_vidange"];
	$km_vidange			 		= $_POST["km_vidange"];
	$date_cg 	 					= $_POST["date_cg"];
	$observation 	 			= $_POST["observation"];

     
	$sql = sprintf ("INSERT INTO %s (immat, id_proprietaire, date_mec, kilometrage, dernier_ct, prochain_ct, id_marque, gamme, modele_version, energie, genre, vin, date_garantie, date_distribution, km_distribution, date_vidange, km_vidange, date_cg, observation) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", $xoopsDB->prefix('garage_vehicule'),$immat, $id_proprietaire, $date_mec, $kilometrage, $dernier_ct, $prochain_ct, $id_marque, $gamme, $modele_version, $energie, $genre, $vin, $date_garantie, $date_distribution, $km_distribution, $date_vidange, $km_vidange, $date_cg, $observation);

  $xoopsDB->queryF($sql) or die ('Erreur requete : '.$sql.'<br />');
		
	redirect_header("vehicule.php", 2, _AM_VEHICULE_CREATED);
	break;
	
//  ------------------------------------------------------------------------ //
//-- ARCHIVAGE 	
//  ------------------------------------------------------------------------ //

  case "archivevehicule":
  global $xoopsDB;

// faut-il avoir la possibilité de conserver un véhicule sur lequel des reparations ont ete effectuées ?

//	$sql = "DELETE FROM ".$xoopsDB->prefix('garage_vehicule')." WHERE id='".$id."'";
//	$xoopsDB->queryF($sql) or die("Erreur requete : ".$sql.'<br />');

	redirect_header("vehicule.php", 2, _AM_VEHICULE_ARCHIVED);
	break;

//  ------------------------------------------------------------------------ //
//-- SUPPRESSION 	
//  ------------------------------------------------------------------------ //

  case "suprvehicule":
  global $xoopsDB;

// interdiction de la suppression par mise en commentaire des liens dans la liste
// il faudrait alors mettre a jour les enregistrements connexes notamment dans la table client   

	$sql = "DELETE FROM ".$xoopsDB->prefix('garage_vehicule')." WHERE id='".$id."'";
	$xoopsDB->queryF($sql) or die("Erreur requete : ".$sql.'<br />');

	redirect_header("vehicule.php", 2, _AM_VEHICULE_DELETED);
	break;

//  ------------------------------------------------------------------------ //
//-- MODIFICATION 	
//  ------------------------------------------------------------------------ //
  case "modifvehicule":
  global $xoopsDB;

	$sql=sprintf("SELECT * FROM ".$xoopsDB->prefix("garage_vehicule")." WHERE id='%s'",$id);
	$res = $xoopsDB->query($sql)  or die ('Erreur requete :'.$sql.'<br />');

	if ( $res )  {
		while (($row = $xoopsDB->fetchArray($res)) != false) {

			$id 			 					= $row['id'];
			$immat    					= $row['immat'];
			$id_proprietaire		= $row['id_proprietaire'];
			$date_mec	 					= $row['date_mec'];
			$kilometrage		  	= $row['kilometrage'];
			$dernier_ct	   			= $row['dernier_ct'];
			$prochain_ct   			= $row['prochain_ct'];
			$id_marque	 		  	= $row['id_marque'];
			$gamme 	   					= $row['gamme'];
			$modele_version	  	= $row['modele_version'];
			$energie   					= $row['energie'];
			$genre 							= $row['genre'];
			$vin			 					= $row['vin'];
			$date_garantie  		= $row['date_garantie'];
			$date_distribution 	= $row['date_distribution'];
			$km_distribution 		= $row['km_distribution'];
			$date_vidange 			= $row['date_vidange'];
			$km_vidange 				= $row['km_vidange'];
			$date_cg 	 					= $row['date_cg'];
			$observation 	 			= $row['observation'];
		}
			}

Xoops_Cp_Header();

garage_tabsAdminMenu("vehicule.php");

	$form = new XoopsThemeForm(_AM_VEHICULE_MODIFICATION,'mvehicule',"vehicule.php?op=update&id='".$id."'",'post');

  $form->insertBreak('<h3><center>'._AM_VEHICULE_ADMINFO.'</center></h3>','head');
	$form -> addElement(new XoopsFormText(_AM_VEHICULE_IMMAT,'immat',20,25, $immat));	


	$req4 = $xoopsDB->query("SELECT id, nom, prenom, cp FROM ".$xoopsDB->prefix("garage_clients")." order by nom");
	while (($row = $xoopsDB->fetchArray($req4)) != false ){
		$clients[$row['id']]=$row['nom'].' - '.$row['prenom'].' - '.$row['cp'];
	}
		$cli = new XoopsFormSelect(_AM_VEHICULE_PROPRIETAIRE, 'id_proprietaire', null, 5, false);
		$cli -> addOptionArray($clients);
		$cli -> setValue($id_proprietaire);
		$form -> addElement($cli);

	$form -> addElement(new XoopsFormTextDateSelect(_AM_VEHICULE_DATE_MEC,'date_mec',15, strtotime($date_mec)));	
	$form -> addElement(new XoopsFormText(_AM_VEHICULE_KILOMETRAGE,'kilometrage',50,255, $kilometrage));	

  $form->insertBreak('<h3><center>'._AM_VEHICULE_TECHINFO.'</center></h3>','head');
  $ct =new XoopsFormElementTray(_AM_VEHICULE_CT);  
	$ct -> addElement(new XoopsFormTextDateSelect(_AM_VEHICULE_DERNIER_CT,'dernier_ct',15, strtotime($dernier_ct)));	
	$ct -> addElement(new XoopsFormTextDateSelect(_AM_VEHICULE_PROCHAIN_CT,'prochain_ct',15, strtotime($prochain_ct)));	
	$form -> addElement($ct);

	$info =new XoopsFormElementTray(' ');

	$req4 = $xoopsDB->query("SELECT id, nom FROM ".$xoopsDB->prefix("garage_marque")." order by nom");
	$marques[0]='---NA---';
	while (($row = $xoopsDB->fetchArray($req4)) != false ){
		$marques[$row['id']]=$row['nom'];
	}
		$marq = new XoopsFormSelect(_AM_VEHICULE_MARQUE, 'id_marque', null, 1, false);
		$marq -> addOptionArray($marques);
		$marq -> setValue($id_marque);
		$info -> addElement($marq);

	$info -> addElement(new XoopsFormText(_AM_VEHICULE_GAMME,'gamme',20,25, $gamme));	
	$info -> addElement(new XoopsFormText(_AM_VEHICULE_MODELE_VERSION,'modele_version',20,25, $modele_version));	
  $form -> addElement($info);

  $infocg =new XoopsFormElementTray(' ');  
	$ene = new XoopsFormSelect(_AM_VEHICULE_ENERGIE,'energie',$energie);	
  $ene -> addOption(_AM_VEHICULE_ENERGIE_ES,_AM_VEHICULE_ENERGIE_ES);
  $ene -> addOption(_AM_VEHICULE_ENERGIE_GO,_AM_VEHICULE_ENERGIE_GO);
  $ene -> addOption(_AM_VEHICULE_ENERGIE_GPL,_AM_VEHICULE_ENERGIE_GPL);
  $ene -> addOption(_AM_VEHICULE_ENERGIE_ELEC,_AM_VEHICULE_ENERGIE_ELEC);
  $infocg -> addElement($ene);

	$infocg -> addElement(new XoopsFormText(_AM_VEHICULE_GENRE,'genre',20,25, $genre));	
	$infocg -> addElement(new XoopsFormText(_AM_VEHICULE_VIN,'vin',25,50, $vin));	
  $form -> addElement($infocg);

  $form -> addElement(new XoopsformTextDateSelect(_AM_VEHICULE_DATE_CG, 'date_cg',15, strtotime($date_cg)));

  $form->insertBreak('<h3><center>'._AM_VEHICULE_ENTRETIEN.'</center></h3>','head');
  $distrib =new XoopsFormElementTray(_AM_VEHICULE_DISTRIBUTION);
  $distrib -> addElement(new XoopsformTextDateSelect(_AM_VEHICULE_DATE_DISTRIBUTION, 'date_distribution',15, strtotime($date_distribution)));
  $distrib -> addElement(new XoopsformText(_AM_VEHICULE_KM_DISTRIBUTION, 'km_distribution',10,25, $km_distribution));
  $form -> addElement($distrib);
  
  $vidange =new XoopsFormElementTray(_AM_VEHICULE_VIDANGE);
  $vidange -> addElement(new XoopsformTextDateSelect(_AM_VEHICULE_DATE_VIDANGE, 'date_vidange',15, strtotime($date_vidange)));
  $vidange -> addElement(new XoopsformText(_AM_VEHICULE_KM_VIDANGE, 'km_vidange',10,25, $km_vidange));
  $form -> addElement($vidange);

  $form -> addElement(new XoopsformTextDateSelect(_AM_VEHICULE_DATE_GARANTIE, 'date_garantie',15, strtotime($date_garantie)));
  $form -> addElement(new XoopsFormTextArea(_AM_VEHICULE_OBSERVATION, 'observation',$observation, 5 ));

	$form -> addElement(new XoopsFormHidden('id',$id));
	$form -> addElement(new XoopsFormButton('', 'submit', _AM_CREATING, 'submit'));
	$form -> display();

break;

//  ------------------------------------------------------------------------ //
//-- UPDATE APRES MODIF 
//  ------------------------------------------------------------------------ //
  case "update":
	global $xoopsDB, $myts;
	
	$immat    					= $_POST["immat"];
	$id_proprietaire		= $_POST["id_proprietaire"];
	$date_mec	 					= $_POST["date_mec"];
	$kilometrage		  	= $_POST["kilometrage"];
	$dernier_ct	   			= $_POST["dernier_ct"];
	$prochain_ct   			= $_POST["prochain_ct"];
	$id_marque	 		  	= $_POST["id_marque"];
	$gamme 	   					= $_POST["gamme"];
	$modele_version	  	= $_POST["modele_version"];
	$energie   					= $_POST["energie"];
	$genre 							= $_POST["genre"];
	$vin			 					= $_POST["vin"];
	$date_garantie  		= $_POST["date_garantie"];
	$date_distribution 	= $_POST["date_distribution"];
	$km_distribution 		= $_POST["km_distribution"];
	$date_vidange 			= $_POST["date_vidange"];
	$km_vidange			 		= $_POST["km_vidange"];
	$date_cg 	 					= $_POST["date_cg"];
	$observation 	 			= $_POST["observation"];
	
	$sql = sprintf("UPDATE ".$xoopsDB->prefix("garage_vehicule")." SET immat='$immat', id_proprietaire='$id_proprietaire', date_mec='$date_mec', kilometrage='$kilometrage', dernier_ct='$dernier_ct', prochain_ct='$prochain_ct', id_marque='$id_marque', gamme='$gamme', modele_version='$modele_version', energie='$energie', genre='$genre', vin='$vin', date_garantie='$date_garantie', date_distribution='$date_distribution', km_distribution='$km_distribution', date_vidange='$date_vidange', km_vidange='$km_vidange', date_cg='$date_cg', observation='$observation'  WHERE id=$id");

	$xoopsDB->queryF($sql)  or die ('Erreur requete : '.$sql.'<br />');
	
	redirect_header("vehicule.php",2, _AM_VEHICULE_MODIF);

break;
}
//  ------------------------------------------------------------------------ //
//-- CAS GENERAL - ON LISTE LES ENREGISTREMENTS + FORMULAIRE DE CREATION
//  ------------------------------------------------------------------------ //
	if (empty($op)) {

Xoops_Cp_Header();

garage_tabsAdminMenu("vehicule.php");

    doc_info('Vehicule');

		$result = $xoopsDB->query("SELECT id, immat, id_proprietaire, id_marque, gamme, modele_version FROM ".$xoopsDB->prefix("garage_vehicule")." ORDER BY id");

 		echo "<table class=\"outer\" width=\"100%\">\n"
		."<th><center>"._AM_VEHICULE_IMMAT.' / '._AM_VEHICULE_MARQUE."</center></th>\n"
		."<th><center>"._AM_VEHICULE_PROPRIETAIRE."</center></th>\n"
		."<th colspan=\"2\"><center>"._AM_ACTION."</center></th>\n";
//		."<th><center>"._AM_ACTION."</center></th>\n";
		
	 	while ((list($id, $immat, $id_proprietaire, $id_marque, $gamme, $modele_version) = $xoopsDB->fetchRow($result)) != false ) {

$marque ="";
if ($id_marque != 0){
// on recupere la marque du vehicule
	 $req = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("garage_marque"). " WHERE id='$id_marque'");
   if ($req) {
   	while (($row = $xoopsDB->fetchArray($req)) != false ) {
        $marque = $row['nom'];
        }
}
}

$proprietaire ="";
if ($id_proprietaire !=0){
	// on recupere le nom du proprietaire du vehicule
	 $req = $xoopsDB->query("SELECT id, civilite, nom, prenom FROM ".$xoopsDB->prefix("garage_clients"). " WHERE id='$id_proprietaire'");
   if ($req) {
   	while (($row = $xoopsDB->fetchArray($req)) != false ) {
        $proprietaire = $row['civilite'].' '.$row['prenom'].' '.$row['nom'];
        }
   }
}
   			echo '<tr>';
				echo '<td class="odd" ALIGN="left">'.$immat.' - '.$marque.'</td>';
				echo '<td class="odd" ALIGN="left">'.$proprietaire.'</td>';
				echo '<td class="odd" align="center"><A HREF="vehicule.php?op=modifvehicule&id='.$id.'"><img src="../images/modif.png"></a> </td>';
				echo '<td class="odd" align="center"><A HREF="vehicule.php?op=suprvehicule&id='.$id.'"><img src="../images/sup.png"></a></td>';
		    }
		echo '</tr></table><br />';


	$form = new XoopsThemeForm(_AM_VEHICULE_CREATION,'cvehicule','vehicule.php?op=creatvehicule','post');

  $form->insertBreak('<h3><center>'._AM_VEHICULE_ADMINFO.'</center></h3>','head');

	$form -> addElement(new XoopsFormText(_AM_VEHICULE_IMMAT,'immat',25,50));	

	$req4 = $xoopsDB->query("SELECT id, nom, prenom, cp FROM ".$xoopsDB->prefix("garage_clients")." order by nom");
	while (($row = $xoopsDB->fetchArray($req4)) != false ){
		$clients[$row['id']]=$row['nom'].' - '.$row['prenom'].' - '.$row['cp'];
	}
		$cli = new XoopsFormSelect(_AM_VEHICULE_PROPRIETAIRE, 'id_proprietaire', null, 5, false);
		$cli -> addOptionArray($clients);
		$form -> addElement($cli);

	$form -> addElement(new XoopsFormTextDateSelect(_AM_VEHICULE_DATE_MEC,'date_mec',15,date("YYYY-mm-dd")));	
	$form -> addElement(new XoopsFormText(_AM_VEHICULE_KILOMETRAGE,'kilometrage',15,25));	

  $form->insertBreak('<h3><center>'._AM_VEHICULE_TECHINFO.'</center></h3>','head');
  $ct = new XoopsFormElementTray(_AM_VEHICULE_CT);  
	$ct -> addElement(new XoopsFormTextDateSelect(_AM_VEHICULE_DERNIER_CT,'dernier_ct',15,date("YYYY-mm-dd")));	
	$ct -> addElement(new XoopsFormTextDateSelect(_AM_VEHICULE_PROCHAIN_CT,'prochain_ct',15,date("YYYY-mm-dd")));	
	$form -> addElement($ct);

	$info =new XoopsFormElementTray(' ');

	$req4 = $xoopsDB->query("SELECT id, nom FROM ".$xoopsDB->prefix("garage_marque")." order by nom");
	while (($row = $xoopsDB->fetchArray($req4)) != false ){
		$marques[$row['id']]=$row['nom'];
	}
		$marq = new XoopsFormSelect(_AM_VEHICULE_MARQUE, 'id_marque', null, 1, false);
		$marq -> addOptionArray($marques);
		$info -> addElement($marq);

	$info -> addElement(new XoopsFormText(_AM_VEHICULE_GAMME,'gamme',20,25));	
	$info -> addElement(new XoopsFormText(_AM_VEHICULE_MODELE_VERSION,'modele_version',20,25));	
  $form -> addElement($info);

  $infocg =new XoopsFormElementTray(' ');  
	$ene = new XoopsFormSelect(_AM_VEHICULE_ENERGIE,'energie');	
  $ene -> addOption(_AM_VEHICULE_ENERGIE_ES,_AM_VEHICULE_ENERGIE_ES);
  $ene -> addOption(_AM_VEHICULE_ENERGIE_GO,_AM_VEHICULE_ENERGIE_GO);
  $ene -> addOption(_AM_VEHICULE_ENERGIE_GPL,_AM_VEHICULE_ENERGIE_GPL);
  $ene -> addOption(_AM_VEHICULE_ENERGIE_ELEC,_AM_VEHICULE_ENERGIE_ELEC);
  $infocg -> addElement($ene);

	$infocg -> addElement(new XoopsFormText(_AM_VEHICULE_GENRE,'genre',20,25));	
	$infocg -> addElement(new XoopsFormText(_AM_VEHICULE_VIN,'vin',25,50));	
  $form -> addElement($infocg);

  $form -> addElement(new XoopsformTextDateSelect(_AM_VEHICULE_DATE_CG, 'date_cg',15,date("YYYY-mm-dd")));
  
  $form->insertBreak('<h3><center>'._AM_VEHICULE_ENTRETIEN.'</center></h3>','head');
  $distrib =new XoopsFormElementTray(_AM_VEHICULE_DISTRIBUTION);
  $distrib -> addElement(new XoopsformTextDateSelect(_AM_VEHICULE_DATE_DISTRIBUTION, 'date_distribution',15,date("YYYY-mm-dd")));
  $distrib -> addElement(new XoopsformText(_AM_VEHICULE_KM_DISTRIBUTION, 'km_distribution',15,20));
  $form -> addElement($distrib);
  
  $vidange =new XoopsFormElementTray(_AM_VEHICULE_VIDANGE);
  $vidange -> addElement(new XoopsformTextDateSelect(_AM_VEHICULE_DATE_VIDANGE, 'date_vidange',15,date("YYYY-mm-dd")));
  $vidange -> addElement(new XoopsformText(_AM_VEHICULE_KM_VIDANGE, 'km_vidange',15,20));
  $form -> addElement($vidange);
  
  $form -> addElement(new XoopsformTextDateSelect(_AM_VEHICULE_DATE_GARANTIE, 'date_garantie',15,date("YYYY-mm-dd")));  
  $form -> addElement(new XoopsFormTextArea(_AM_VEHICULE_OBSERVATION, 'observation', '',5));

	$form -> addElement(new XoopsFormHidden('id',$id));
	$form -> addElement(new XoopsFormButton('', 'submit', _AM_CREATING, 'submit'));

/*
	$civ = new XoopsFormSelect(_AM_VEHICULE_CIVILITE,'civilite');	
  $civ -> addOption(_AM_CIVILITE_MR,_AM_CIVILITE_MR);
  $civ -> addOption(_AM_CIVILITE_MME,_AM_CIVILITE_MME);
  $civ -> addOption(_AM_CIVILITE_MELLE,_AM_CIVILITE_MELLE);
  $form -> addElement($civ);

  $ppro = new XoopsformRadio(_AM_VEHICULE_PART_PROF, 'part_prof','');
  $options = array('1' => _AM_VEHICULE_PARTICULIER, '2' => _AM_VEHICULE_PRO);
  $ppro -> addoptionArray($options);
  $form -> addElement($ppro);
*/
	$form -> display();

}

xoops_cp_footer();
?>