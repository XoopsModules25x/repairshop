<?php
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

if(!isset($_POST['id_supp'])){
	$id_supp = isset ($_GET['id_supp']) ? $_GET['id_supp'] : '';
}else {
	$id_supp = $_POST['id_supp'];
}

$myts = MyTextSanitizer::getInstance();

if(!isset($op)){$op=" ";}
switch ($op) {

//  ------------------------------------------------------------------------ //
//--CREATION
//  ------------------------------------------------------------------------ //
	case "create":
	global $xoopsDB, $myts;
	
// forfait
	$nom_forfait 					= $_POST["nom_forfait"];
	$description_forfait 	= $_POST["description_forfait"];
	$tarif_forfait 				= $_POST["tarif_forfait"];

// lignes du forfait
	$id_pieces 		= $_POST["id_pieces"];
	$id_forfait 	= $_POST["id"];
	$designation 	= $_POST["designation"];
	$quantite			= $_POST["quantite"];
	$tarif 				= $_POST["tarif"];

// creation / mise a jour du forfait	
if ( $id == '') {    
										$sql = sprintf("INSERT INTO %s (nom, description, tarif) VALUES ('%s', '%s', '%s')",
  									$xoopsDB->prefix("garage_forfait"), $nom_forfait, $description_forfait, $tarif_forfait);										
  								} else {
										$sql = "UPDATE ".$xoopsDB->prefix('garage_forfait')." SET nom='".$nom_forfait."', description='".$description_forfait."', tarif='".$tarif_forfait."' WHERE id=".$id;
  									$xoopsDB->queryF($sql) or die ('Erreur requete : '.$sql.'<br />');
   								}

  $xoopsDB->queryF($sql) or die ('erreur requete :'.$sql.'<br />');

// on recupere la valeur de l'increment
if ( $id == '') {    
  $sql = $xoopsDB->queryF("SELECT max(id) as maxid FROM ".$xoopsDB->prefix("garage_forfait"));
    while ((list($maxid) = $xoopsDB->fetchRow($sql)) != false ) { $id = $maxid;}
}


// insertion des pieces selectionnees
if ($id_pieces !=0){
   if ($tarif ==0){
	  $reqpx = $xoopsDB->query("SELECT tarif_client FROM ".$xoopsDB->prefix("garage_pieces")." WHERE id=".$id_pieces);
    while ((list($tarif_pce) = $xoopsDB->fetchRow($reqpx)) != false ) { $tarif = $tarif_pce;}
  }

if ($designation ==""){
	  $reqdes = $xoopsDB->query("SELECT designation FROM ".$xoopsDB->prefix("garage_pieces")." WHERE id=".$id_pieces);
    while ((list($des_piece) = $xoopsDB->fetchRow($reqdes)) != false ) { $designation = $des_piece;}
	}
}else{

	$sql2 = sprintf ("INSERT INTO %s (id_forfait , designation, quantite, tarif) VALUES ('%s', '%s', '%s', '%s')", $xoopsDB->prefix('garage_nomenc_forfait'),$id_forfait, $designation, $quantite, $tarif);
  $xoopsDB->queryF($sql2) or die ('Erreur requete : '.$sql2.'<br />');
}
		
	redirect_header("forfait.php?op=modif&id=".$id, 2, _AM_FORFAIT_UPDATED);
	break;
	
//  ------------------------------------------------------------------------ //
//-- SUPPRESSION 	
//  ------------------------------------------------------------------------ //

  case "suppr":
  global $xoopsDB;

	$sql = "DELETE FROM ".$xoopsDB->prefix('garage_forfait')." WHERE id='".$id."'";
	$xoopsDB->queryF($sql) or die("Suppression Error ".$sql);
	
	redirect_header("forfait.php",2, _AM_FORFAIT_SUPR);
	
	break;

//  ------------------------------------------------------------------------ //
//-- SUPPRESSION LIGNE	
//  ------------------------------------------------------------------------ //

  case "suppr_lig":
  global $xoopsDB;

	$sql = "DELETE FROM ".$xoopsDB->prefix('garage_nomenc_forfait')." WHERE id='".$id_supp."'";
	$xoopsDB->queryF($sql) or die("Suppression Error ".$sql);
	
	redirect_header("forfait.php?op=modif&id=".$id,2, _AM_FORFAIT_SUPR);
	
	break;

//  ------------------------------------------------------------------------ //
//-- MODIFICATION 	
//  ------------------------------------------------------------------------ //
  case "modif":
  global $xoopsDB;

	$sql=sprintf("SELECT * FROM ".$xoopsDB->prefix("garage_forfait")." WHERE id='%s'",$id);
	$res = $xoopsDB->query($sql)  or die ('erreur requete :'.$sql.'<br />');

	if ( $res )  {
		while (($row = $xoopsDB->fetchArray($res)) != false) {
			$id 			        = $row['id'];
			$nom 			        = $row['nom'];
			$description      = $row['description'];
			$tarif		        = $row['tarif'];
			
		}
	}


Xoops_Cp_Header();

garage_tabsAdminMenu("forfait.php");

    doc_info('forfait');


	$form = new XoopsThemeForm(_AM_FORFAIT_MODIFICATION,'mforfait',"forfait.php?op=create&id=".$id,'post');
	$form -> addElement(new XoopsFormText(_AM_FORFAIT_NOM,'nom_forfait',50,255, $nom));	
	$form -> addElement(new XoopsFormTextArea(_AM_FORFAIT_DESCRIPTION,'description_forfait',$description,5,60));	
  $form -> addElement(new XoopsFormText(_AM_FORFAIT_TARIF,'tarif_forfait',10,10, $tarif));	

  $form->insertBreak('<h3><center>'._AM_FORFAIT_PIECES.'</center></h3><br>','head');
//pieces

// ajout de pieces  
  $req1 = $xoopsDB->query("SELECT p.id, p.ref, p.designation, f.nom FROM ".$xoopsDB->prefix("garage_pieces")." p INNER JOIN ".$xoopsDB->prefix("garage_fournisseur")." f ON f.id = p.id_fournisseur ORDER BY designation ASC");
  $list_id_pieces = array();
  $list_id_pieces[0] = _AM_PCE_MAG;
  while ((list($id_piece, $ref, $designation, $nom_fournisseur) = $xoopsDB->fetchRow($req1)) != false ) { 
  $list_id_pieces[$id_piece]=$designation.' - '.$nom_fournisseur;
  }

  //liste des pieces deja renseignées
  $reqp = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("garage_nomenc_forfait")." WHERE id_forfait=".$id);
	
	$pieces_det  = "<table border=1>";
	$pieces_det .= "<tr><th align=left>"._AM_PCE_DESIG."</th>";
	$pieces_det .= "<th align=center width=100px>"._AM_PCE_QTE."</th>";
	$pieces_det .= "<th align=center width=100px>"._AM_PCE_PX."</th>";
	$pieces_det .= "<th align=center width=100px>"._AM_ACTION."</th></tr>";
	
	  while ((list($idkey, $id_forfait, $designation, $quantite, $tarif) = $xoopsDB->fetchRow($reqp)) != false ) 
  {
		  $pieces_det .= "<tr>";
		  $pieces_det .= "<td align=left>".$designation."</td>";
		  $pieces_det .= "<td align=center>".$quantite."</td>";
		  $pieces_det .= "<td>".$tarif."</td>";
		  $pieces_det .= "<td><a href='forfait.php?op=suppr_lig&id_supp=".$idkey."&id=".$id."'><img src='../images/cancel.png' alt='"._AM_DELETE."' title='"._AM_DELETE."'></a></td></tr>";
	}

$pieces_det .= "</table>";
  $form->insertBreak(_AM_INTER_PIECES_UTILISEES.'<center><br>'.$pieces_det.'</center>','head');

// Piece magasin

  $pce	= new XoopsFormElementTray('');
  $pcec = new XoopsFormSelect('',"id_pieces");
  $pcec	-> addOptionArray ($list_id_pieces);
  $pce	-> addElement($pcec);
  $pce 	-> addElement(new XoopsFormText('&nbsp;&nbsp;&nbsp;'._AM_PCE_QTE,'quantite',3,5,''));
  $pce 	-> addElement(new XoopsFormText('&nbsp;&nbsp;&nbsp;'._AM_PCE_PXE,'tarif',10,10,''));
  $form -> addElement($pce);
			
  $refman	= new XoopsFormElementTray(_AM_PIECES_REF);
	$refman -> addElement(new XoopsFormText('','ref',15,255, ''));	
	$refman -> addElement(new XoopsFormText(_AM_PIECES_DESIGNATION,'designation',40,255, ''));	
  $refman	-> addElement(new XoopsFormText('&nbsp;&nbsp;&nbsp;'._AM_PCE_QTE,'quantite',3,5,''));
	$refman -> addElement(new XoopsFormText(_AM_PCE_PX,'tarif',10,25, ''));	
  $form -> addElement($refman);
	
	$form -> addElement(new XoopsFormHidden('id',$id));
	$form -> addElement(new XoopsFormHidden('id_forfait',$id_forfait));

	$form -> addElement(new XoopsFormButton('', 'submit', _AM_CREATING, 'submit'));
	
	$form -> display();

break;

//  ------------------------------------------------------------------------ //
//-- UPDATE APRES MODIF 
//  ------------------------------------------------------------------------ //
  case "update":
	global $xoopsDB, $myts;
	
	$nom 					= $_POST["nom_forfait"];
	$description 	= $_POST["description_forfait"];
	$tarif 				= $_POST["tarif_forfait"];
	
  
	$sql = sprintf("UPDATE ".$xoopsDB->prefix("garage_forfait")." SET nom='$nom', description='$description', tarif='$tarif' WHERE id=$id");

	$xoopsDB->queryF($sql)  or die ('erreur requete :'.$sql.'<br />');
	
	redirect_header("forfait.php?op=modif&id=".$id,2, _AM_FORFAIT_MODIF);

}
//  ------------------------------------------------------------------------ //
//-- CAS GENERAL - ON LISTE LES ENREGISTREMENTS + FORMULAIRE DE CREATION
//  ------------------------------------------------------------------------ //
	if (empty($op)) {

Xoops_Cp_Header();

garage_tabsAdminMenu("forfait.php");

    doc_info('forfait');

		$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("garage_forfait")." ORDER BY id");
    $cat = array();

 		echo "<table class=\"outer\" width=\"100%\">\n"
		."<th><align='left'>"._AM_FORFAIT_NOM."</center></th>\n"
		."<th><align='left'>"._AM_FORFAIT_DESCRIPTION."</center></th>\n"
		."<th><align='left'>"._AM_FORFAIT_TARIF."</center></th>\n"
		."<th colspan=\"2\"><center>"._AM_ACTION."</center></th>\n";
		
	 	while ((list($id, $nom, $description, $tarif) = $xoopsDB->fetchRow($result)) != false ) {
  			$cat[$id] = $id;
        
   			echo '<tr>';
				echo '<td class="odd" ALIGN="left">'.$nom.'</td>';
				echo '<td class="odd" ALIGN="left">'.nl2br($description).'</td>';
				echo '<td class="odd" ALIGN="right">'.$tarif.'</td>';
				echo '<td class="odd" align="center"><A HREF="forfait.php?op=modif&id='.$id.'"><img src="../images/modif.png"></a></td>';
				echo '<td class="odd" align="center"><A HREF="forfait.php?op=suppr&id='.$id.'"><img src="../images/sup.png"></a></td>';
		    }
		echo '</tr></table><br />';

	$form = new XoopsThemeForm(_AM_FORFAIT_CREATION,'cforfait','forfait.php?op=create','post');
	$form -> addElement(new XoopsFormText(_AM_FORFAIT_NOM,'nom_forfait',50,255, ''));	
	$form -> addElement(new XoopsFormTextArea(_AM_FORFAIT_DESCRIPTION,'description_forfait','',5,60));	
  $form -> addElement(new XoopsFormText(_AM_FORFAIT_TARIF,'tarif_forfait',10,10, ''));	
	$form -> addElement(new XoopsFormButton('', 'submit', _AM_CREATING, 'submit'));
	$form -> display();
}
xoops_cp_footer();
?>