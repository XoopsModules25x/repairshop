<?php
//  ------------------------------------------------------------------------ //
// ------------------- GESTION DE LA TABLE CLIENT -------------------------- //
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
	case "creatclient":
	global $xoopsDB, $myts;
	
	$compte    = $_POST["compte"];
	$rs		   	 = $_POST["rs"];
	$nom		   = $_POST["nom"];
	$prenom	   = $_POST["prenom"];
	$adresse   = $_POST["adresse"];
	$cp	 		   = $_POST["cp"];
	$ville 	   = $_POST["ville"];
	$teldom	 	 = $_POST["teldom"];
	$telport   = $_POST["telport"];
	$telbureau = $_POST["telbureau"];
	$fax			 = $_POST["fax"];
	$civilite  = $_POST["civilite"];
	$email 		 = $_POST["email"];
	$part_prof = $_POST["part_prof"];
	$permis 	 = $_POST["permis"];
	$remise 	 = $_POST["remise"];

     
	$sql = sprintf ("INSERT INTO %s (compte, rs, nom, prenom, adresse, cp, ville, teldom, telport, telbureau, telecopie, civilite, email, particulier_prof, permis, remise) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", $xoopsDB->prefix('garage_clients'),$compte, $rs, $nom, $prenom, $adresse, $cp, $ville, $teldom, $telport, $telbureau, $fax, $civilite, $email, $part_prof, $permis, $remise);

  $xoopsDB->queryF($sql) or die ('Erreur requete : '.$sql.'<br />');
		
	redirect_header("client.php", 2, _AM_CLIENT_CREATED);
	break;
	
//  ------------------------------------------------------------------------ //
//-- SUPPRESSION 	
//  ------------------------------------------------------------------------ //

  case "suprclient":
  global $xoopsDB;

	$sql = "DELETE FROM ".$xoopsDB->prefix('garage_clients')." WHERE id='".$id."'";
	$xoopsDB->queryF($sql) or die("Erreur requete : ".$sql.'<br />');

	redirect_header("client.php", 2, _AM_CLIENT_SUPR);
	break;

//  ------------------------------------------------------------------------ //
//-- MODIFICATION 	
//  ------------------------------------------------------------------------ //
  case "modifclient":
  global $xoopsDB;

	$sql=sprintf("SELECT * FROM ".$xoopsDB->prefix("garage_clients")." WHERE id='%s'",$id);
	$res = $xoopsDB->query($sql)  or die ('Erreur requete :'.$sql.'<br />');

	if ( $res )  {
		while (($row = $xoopsDB->fetchArray($res)) != false) {
			$id 			 = $row['id'];
			$compte    = $row['compte'];
			$rs			   = $row['rs'];
			$nom		   = $row['nom'];
			$prenom	   = $row['prenom'];
			$adresse   = $row['adresse'];
			$cp	 		   = $row['cp'];
			$ville 	   = $row['ville'];
			$teldom	 	 = $row['teldom'];
			$telport   = $row['telport'];
			$telbureau = $row['telbureau'];
			$fax			 = $row['telecopie'];
			$civilite  = $row['civilite'];
			$email 		 = $row['email'];
			$part_prof = $row['particulier_prof'];
			$permis 	 = $row['permis'];
			$remise 	 = $row['remise'];
		}
			}


Xoops_Cp_Header();

garage_tabsAdminMenu("client.php");

	$form = new XoopsThemeForm(_AM_CLIENT_MODIFICATION,'mclient',"client.php?op=update&id='".$id."'",'post');
	$form -> addElement(new XoopsFormText(_AM_CLIENT_COMPTE,'compte',50,255, $compte));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_RS,'rs',100,255, $rs));	

	$civ = new XoopsFormSelect(_AM_CLIENT_CIVILITE,'civilite',$civilite);	
  $civ -> addOption(_AM_CIVILITE_MR,_AM_CIVILITE_MR);
  $civ -> addOption(_AM_CIVILITE_MME,_AM_CIVILITE_MME);
  $civ -> addOption(_AM_CIVILITE_MELLE,_AM_CIVILITE_MELLE);
  $form -> addElement($civ);

	$form -> addElement(new XoopsFormText(_AM_CLIENT_NOM,'nom',50,255, $nom));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_PRENOM,'prenom',50,255, $prenom));	
	$form -> addElement(new XoopsFormTextArea(_AM_CLIENT_ADRESSE,'adresse', $adresse, 3, 80));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_CP,'cp',20,25, $cp));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_VILLE,'ville',50,255, $ville));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_TELDOM,'teldom',20,25, $teldom));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_TELPORT,'telport',20,25, $telport));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_TELBUREAU,'telbureau',20,25, $telbureau));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_FAX,'fax',20,25, $fax));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_EMAIL,'email',25,50, $email));	

  $ppro = new XoopsformRadio(_AM_CLIENT_PART_PROF, 'part_prof', $part_prof);
  $options = array('1' => _AM_CLIENT_PARTICULIER, '2' => _AM_CLIENT_PRO);
  $ppro -> addoptionArray($options);
  $form -> addElement($ppro);

//	$form -> addElement(new XoopsFormText(_AM_CLIENT_PART_PROF,'part_prof',2,2, $part_prof));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_PERMIS,'permis',20,25, $permis));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_REMISE,'remise',10,15, $remise));	

	$form -> addElement(new XoopsFormHidden('id',$id));

  /*ajout de bouton sur le formulaire*/		
	$form -> addElement(new XoopsFormButton('', 'submit', _AM_CREATING, 'submit'));
	/*affichage du formulaire*/
	$form -> display();

break;

//  ------------------------------------------------------------------------ //
//-- UPDATE APRES MODIF 
//  ------------------------------------------------------------------------ //
  case "update":
	global $xoopsDB, $myts;
	
	$compte    = $_POST["compte"];
	$rs			   = $_POST["rs"];
	$nom		   = $_POST["nom"];
	$prenom	   = $_POST["prenom"];
	$adresse   = $_POST["adresse"];
	$cp	 		   = $_POST["cp"];
	$ville 	   = $_POST["ville"];
	$teldom	 	 = $_POST["teldom"];
	$telport   = $_POST["telport"];
	$telbureau = $_POST["telbureau"];
  $fax			 = $_POST["fax"];
	$civilite  = $_POST["civilite"];
	$email 		 = $_POST["email"];
	$part_prof = $_POST["part_prof"];
	$permis 	 = $_POST["permis"];
	$remise 	 = $_POST["remise"];
	
	$sql = sprintf("UPDATE ".$xoopsDB->prefix("garage_clients")." SET compte='$compte', rs='$rs', nom='$nom', prenom='$prenom', adresse='$adresse', cp='$cp', ville='$ville', teldom='$teldom', telport='$telport', telbureau='$telbureau', telecopie='$fax', civilite='$civilite', email='$email', particulier_prof='$part_prof', permis='$permis', remise='$remise'  WHERE id=$id");

	$xoopsDB->queryF($sql)  or die ('Erreur requete : '.$sql.'<br />');
	
	redirect_header("client.php",2, _AM_CLIENT_MODIF);

}
//  ------------------------------------------------------------------------ //
//-- CAS GENERAL - ON LISTE LES ENREGISTREMENTS + FORMULAIRE DE CREATION
//  ------------------------------------------------------------------------ //
	if (empty($op)) {

Xoops_Cp_Header();

garage_tabsAdminMenu("client.php");

    doc_info('Client');

		$result = $xoopsDB->query("SELECT id, nom, prenom, cp, ville FROM ".$xoopsDB->prefix("garage_clients")." ORDER BY id");

 		echo "<table class=\"outer\" width=\"100%\">\n"
		."<th><center>"._AM_CLIENT_NOM.' / '._AM_CLIENT_PRENOM."</center></th>\n"
		."<th><center>"._AM_CLIENT_CP.' - '._AM_CLIENT_VILLE."</center></th>\n"
		."<th colspan=\"2\"><center>"._AM_ACTION."</center></th>\n";
//		."<th><center>"._AM_ACTION."</center></th>\n";
		
	 	while ((list($id, $nom, $prenom, $cp, $ville) = $xoopsDB->fetchRow($result)) != false ) {
   			echo '<tr>';
				echo '<td class="odd" ALIGN="left">'.$nom.' - '.$prenom.'</td>';
				echo '<td class="odd" ALIGN="left">'.$cp.' - '.$ville.'</td>';
				echo '<td class="odd" align="center"><A HREF="client.php?op=modifclient&id='.$id.'"><img src="../images/modif.png"></a> </td>';
				echo '<td class="odd" align="center"><A HREF="client.php?op=suprclient&id='.$id.'"><img src="../images/sup.png"></a></td>';
		    }
		echo '</tr></table><br />';

	$form = new XoopsThemeForm(_AM_CLIENT_CREATION,'cclient','client.php?op=creatclient','post');
	$form -> addElement(new XoopsFormText(_AM_CLIENT_COMPTE,'compte',50,255, ''));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_RS,'rs',100,255, ''));	

	$civ = new XoopsFormSelect(_AM_CLIENT_CIVILITE,'civilite');	
  $civ -> addOption(_AM_CIVILITE_MR,_AM_CIVILITE_MR);
  $civ -> addOption(_AM_CIVILITE_MME,_AM_CIVILITE_MME);
  $civ -> addOption(_AM_CIVILITE_MELLE,_AM_CIVILITE_MELLE);
  $form -> addElement($civ);

	$form -> addElement(new XoopsFormText(_AM_CLIENT_NOM,'nom',50,255, ''));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_PRENOM,'prenom',50,255, ''));	
	$form -> addElement(new XoopsFormTextArea(_AM_CLIENT_ADRESSE,'adresse', '', 3, 80));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_CP,'cp',15,15, ''));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_VILLE,'ville',50,255, ''));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_TELDOM,'teldom',15,15, ''));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_TELPORT,'telport',15,15, ''));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_TELBUREAU,'telbureau',15,15, ''));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_FAX,'fax',15,15, ''));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_EMAIL,'email',25,50, ''));	

  $ppro = new XoopsformRadio(_AM_CLIENT_PART_PROF, 'part_prof','');
  $options = array('1' => _AM_CLIENT_PARTICULIER, '2' => _AM_CLIENT_PRO);
  $ppro -> addoptionArray($options);
  $form -> addElement($ppro);

//	$form -> addElement(new XoopsFormText(_AM_CLIENT_PART_PROF,'part_prof',2,2, ''));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_PERMIS,'permis',20,25, ''));	
	$form -> addElement(new XoopsFormText(_AM_CLIENT_REMISE,'remise',10,15, ''));	

	$form -> addElement(new XoopsFormButton('', 'submit', _AM_CREATING, 'submit'));
	$form -> display();
}
xoops_cp_footer();
?>