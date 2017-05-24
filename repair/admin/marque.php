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

$myts = MyTextSanitizer::getInstance();

if(!isset($op)){$op=" ";}
switch ($op) {

//  ------------------------------------------------------------------------ //
//--CREATION
//  ------------------------------------------------------------------------ //
	case "creatmarque":
	global $xoopsDB, $myts;
	
	$nom 	= $_POST["nom"];
	
     
	$sql = sprintf("INSERT INTO %s (nom) VALUES ('%s')",
  $xoopsDB->prefix("garage_marque"), $nom);

  $xoopsDB->queryF($sql) or die ('erreur requete :'.$sql.'<br />');
		
	redirect_header("marque.php", 2, _AM_MARQUE_CREATED);
	break;
	
//  ------------------------------------------------------------------------ //
//-- SUPPRESSION 	
//  ------------------------------------------------------------------------ //

  case "suprmarque":
  global $xoopsDB;


	$sql = "DELETE FROM ".$xoopsDB->prefix('garage_marque')." WHERE id='".$id."'";
	$xoopsDB->queryF($sql) or die("Suppression Error ".$sql);
	
	redirect_header("marque.php",2, _AM_MARQUE_SUPR);
	
	break;

//  ------------------------------------------------------------------------ //
//-- MODIFICATION 	
//  ------------------------------------------------------------------------ //
  case "modifmarque":
  global $xoopsDB;

	$sql=sprintf("SELECT * FROM ".$xoopsDB->prefix("garage_marque")." WHERE id='%s'",$id);
	$res = $xoopsDB->query($sql)  or die ('erreur requete :'.$sql.'<br />');

	if ( $res )  {
		while (($row = $xoopsDB->fetchArray($res)) != false) {
			$id 			        = $row['id'];
			$nom 			        = $row['nom'];
			
		}
	}


Xoops_Cp_Header();

garage_tabsAdminMenu("marque.php");

    doc_info('marque');


	$form = new XoopsThemeForm(_AM_MARQUE_MODIFICATION,'mmarque',"marque.php?op=update&id='".$id."'",'post');
	$form -> addElement(new XoopsFormText(_AM_MARQUE_NOM,'nom',50,255, $nom));	
	
	$form -> addElement(new XoopsFormHidden('id',$id));

	$form -> addElement(new XoopsFormButton('', 'submit', _AM_CREATING, 'submit'));
	
	$form -> display();

break;

//  ------------------------------------------------------------------------ //
//-- UPDATE APRES MODIF 
//  ------------------------------------------------------------------------ //
  case "update":
	global $xoopsDB, $myts;
	
	$nom = $_POST["nom"];
	
  
	$sql = sprintf("UPDATE ".$xoopsDB->prefix("garage_marque")." SET nom='$nom' WHERE id=$id");

	$xoopsDB->queryF($sql)  or die ('erreur requete :'.$sql.'<br />');
	
	redirect_header("marque.php",2, _AM_MARQUE_MODIF);

}
//  ------------------------------------------------------------------------ //
//-- CAS GENERAL - ON LISTE LES ENREGISTREMENTS + FORMULAIRE DE CREATION
//  ------------------------------------------------------------------------ //
	if (empty($op)) {

Xoops_Cp_Header();

garage_tabsAdminMenu("marque.php");

    doc_info('marque');

		$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("garage_marque")." ORDER BY id");
    $marque = array();

 		echo "<table class=\"outer\" width=\"100%\">\n"
		."<th><align='left'>"._AM_MARQUE_NOM."</center></th>\n"
		."<th colspan=\"2\"><center>"._AM_ACTION."</center></th>\n";
		
	 	while ((list($id, $nom) = $xoopsDB->fetchRow($result)) != false ) {
  			$marque[$id] = $id;
        
   			echo '<tr>';
				//echo '<td class="odd" ALIGN="left">'.$id.'</td>';
				echo '<td class="odd" ALIGN="left">'.$nom.'</td>';
				echo '<td class="odd" align="center"><A HREF="marque.php?op=modifmarque&id='.$id.'"><img src="../images/modif.png"></a></td>';
				echo '<td class="odd" align="center"><A HREF="marque.php?op=suprmarque&id='.$id.'"><img src="../images/sup.png"></a></td>';
		    }
		echo '</tr></table><br />';

	$form = new XoopsThemeForm(_AM_MARQUE_CREATION,'cmarque','marque.php?op=creatmarque','post');
	$form -> addElement(new XoopsFormText(_AM_MARQUE_NOM,'nom',50,255, ''));	
	$form -> addElement(new XoopsFormButton('', 'submit', _AM_CREATING, 'submit'));
	$form -> display();
}
xoops_cp_footer();
?>