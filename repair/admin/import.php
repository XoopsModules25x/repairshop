<?php
include_once("admin_header.php");
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once(XOOPS_ROOT_PATH . "/class/uploader.php");

define('_OKIMG',"<img src='../images/yes.gif' width='6' height='12' border='0' alt='' /> ");
define('_NOKIMG',"<img src='../images/no.gif' width='6' height='12' border='0' alt='' /> ");


if(!isset($_POST['op'])){
	$op = isset ($_GET['op']) ? $_GET['op'] : '';
}
else {
	$op = $_POST['op'];
}
$myts = MyTextSanitizer::getInstance();
if(!isset($op)){
	$op=" ";
}

if($op == "import_user"){
	global $xoopsDB, $myts;
	Xoops_Cp_Header();

	echo "<table width='100%'><tr><td align='center'><img src='../images/logo.jpg' alt='' title=''></td><td align='right' width='55'><a href='../help/help.php'><img src='../images/help.gif' alt='aide' title='aide'></a></td></tr></table><br />\n";

	xorgachart_tabsAdminMenu(__FILE__);

	$table_src = (isset($_POST["table_src"]) ? $myts->makeTboxData4Save($_POST["table_src"]) : '');
	if (empty($table_src)) { redirect_header("import.php", 2, _AM_ERROR_IDSERVREQ);}
 
	$delete_table = (isset($_POST["delete_table"]) ? $_POST["delete_table"] : '0');
	
	if($delete_table == 1){
		$sql = "DELETE FROM ".$xoopsDB->prefix('employe');
		$xoopsDB->queryF($sql) or die("Suppression Error ".$sql);
	}

	echo "<table class='outer' width='100%'>\n"
			."<tr><FONT color=red><center>Cr&eacute;ation employ&eacute;s</center></FONT></tr>\n"
			."<th><center>"._AM_ORGA_EMPL_CID."</center></th>\n"
			."<th><center>"._AM_ORGA_EMPL_NAME."</center></th>\n"
			."<th><center>"._AM_ORGA_EMPL_PREN."</center></th>\n"
			."<th><center>"._AM_ORGA_EMPL_PHOTO."</center></th>\n"
			."<th><center>"._AM_ORGA_EMPL_TEL."</center></th>\n"
			."<th><center>"._AM_ORGA_EMPL_LOCA."</center></th>\n";


	$sql = "select name FROM ".$table_src;
	$result = $xoopsDB->query($sql);

	while ((list($name) = $xoopsDB->fetchRow($result)) != false){	
		//d&eacute;coupage du champ name de la table users
		$arr = split(" ", $name);
		$prenom = $arr[0];
		$nom = $arr[1];
		//chaque caractere est mis dans un tableau
		$res = preg_split('//',$prenom,-1,PREG_SPLIT_NO_EMPTY);
		$res2 = preg_split('//',$nom,-1,PREG_SPLIT_NO_EMPTY);
		//constitution de l'identifiant (1ere lettre du prenom + 1ere lettre du nom + derniere lettre du nom)
		$id = $res[0].$res2[0].$res2[count($res2)-1];
		 
		//v&eacute;rification si l'identifiant existe d&eacute;j&agrave; 
		foreach($tab as $key => $value){
			if($value == $id){
				//$id = $res[0].$res2[0].$res2[count($res2)-1]."2";
				$id = $id."2";
			}		 
		}	   
		$tab[] .= $id;

		if(file_exists('../images/portrait/'.$id.'.jpg')){
			$img=$id;
		}
		else{
			$img = "portrait";
		}
			
		$photo = XOOPS_URL."/modules/xorgachart/images/portrait/".$img.".jpg";

		$sql = sprintf("INSERT INTO ".$xoopsDB->prefix("employe")."(id_empl, nom_empl, pre_empl, photo,tel, localisation) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", $id, $nom, $prenom, $photo, $tel, $localisation);
		$xoopsDB->queryF($sql) or die (redirect_header("import.php", 5, _NOKIMG._IMPORT_NOK.$sql)); 
		   
		echo '<tr>';
		echo '<td class="odd" ALIGN="center">'.$id.'</td>';
		echo '<td class="odd" ALIGN="center">'.$nom.'</td>';
		echo '<td class="odd" ALIGN="center">'.$prenom.'</td>';
		echo '<td class="odd" ALIGN="center"><img src="'.$photo.'"></td>';
		echo '<td class="odd" ALIGN="center">'.$tel.'</td>';
		echo '<td class="odd" ALIGN="center">'.$localisation.'</td></tr>';
	}		   
	echo "</table>";
	
    $content .=  _OKIMG._IMPORT_OK;                 
    	
	echo $content;
	
	xoops_cp_footer();	
}
	
//---------------------------------//
//Formulaire d'import
//--------------------------------//
	
if (empty($op)){
	Xoops_Cp_Header();
	echo "<table width='100%'><tr><td align='center'><img src='../images/logo.jpg' alt='' title=''></td><td align='right' width='55'><a href='../help/help.php'><img src='../images/help.gif' alt='aide' title='aide'></a></td></tr></table><br />\n";

	xorgachart_tabsAdminMenu(__FILE__);


	$form = new XoopsThemeForm(_AM_ORGA_IMPORT_CREATION,'iuser','import.php?op=import_user','post');
		
	$form -> addElement(new XoopsFormText(_AM_ORGA_IMPORT_NAME,'table_src',20,255, $xoopsDB->prefix("users")));
		
	$delete_table = new XoopsFormCheckBox(_AM_ORGA_IMPORT_DROP,'delete_table', '');
	$delete_table -> addOption(1,  " ");
	$form -> addElement($delete_table);
		
	$form -> addElement(new XoopsFormButton('', 'submit', _AM_CREATING, 'submit'));
	$form -> display();
		
	xoops_cp_footer();
}
?>