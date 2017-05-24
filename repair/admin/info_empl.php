<?php
include_once("admin_header.php");
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once(XOOPS_ROOT_PATH . "/class/uploader.php");

if(!isset($_POST['id_serv'])){
	$id_serv = isset ($_GET['id_serv']) ? $_GET['id_serv'] : '';
}else {
	$id_serv = $_POST['id_serv'];
}
$myts = MyTextSanitizer::getInstance();
global $xoopsDB, $myts, $id_service;
//Xoops_Cp_Header();
$id_service = $id_serv;

echo bonjour;


$result5 = $xoopsDB->query("select name FROM xoopsv2_users");




		echo "<table class=\"outer\" width=\"100%\">\n"
			."<th><center>"._AM_ORGA_SERV_CID."</center></th>\n"
			."<th><center>"._AM_ORGA_SERV_NAME."</center></th>\n"
			."<th><center>"._AM_ORGA_SERV_PERE."</center></th>\n"
			."<th><center>"._AM_ORGA_SERV_CHEF."</center></th>\n"
			."<th><center>"._AM_ORGA_SERV_SECR."</center></th>\n"
			."<th><center>"._AM_ORGA_SERV_ADJ."</center></th>\n"
			."<th colspan=\"3\"><center>"._AM_ACTION."</center></th>\n";

		$result = $xoopsDB->query("SELECT id_serv, nom_serv, pere, chef, secretaire, adjoint FROM ".$xoopsDB->prefix("service")." WHERE id_serv='".$id_service."'");
    $service = array();
    $service[0] = "---- NA ----";
		while ((list($id_serv, $nom_serv, $pere, $chef, $secretaire, $adjoint) = $xoopsDB->fetchRow($result)) != false ) {
		$id_chef=$chef;
		$id_adj=$adjoint;
		$id_sec=$secretaire;
  			$service[$id_serv] = $nom_serv;
  			echo '<tr>';
				echo '<td class="odd" ALIGN="left">'.$id_serv.'</td>';
				echo '<td class="odd" ALIGN="left">'.$nom_serv.'</td>';
				echo '<td class="odd" ALIGN="left">'.$pere.'</td>';
        if ($chef == "0") {$chef = "-- NA --";}
				echo '<td class="odd" ALIGN="left">'.$chef.'</td>';
        if ($secretaire == "0") {$secretaire = "-- NA --";}
				echo '<td class="odd" ALIGN="left">'.$secretaire.'</td>';
        if ($adjoint == "0") {$adjoint = "-- NA --";}
				echo '<td class="odd" ALIGN="left">'.$adjoint.'</td>';
				echo '<td class="odd" align="center"><A HREF="contact.php?op=addmem&id_serv='.$id_serv.'"><img src="../images/profil.gif"></a></td>';
				echo '<td class="odd" align="center"><A HREF="contact.php?op=modifser&id_serv='.$id_serv.'"><img src="../images/modif.png"></a></td>';
				echo '<td class="odd" align="center"><A HREF="contact.php?op=suprser&id_serv='.$id_serv.'"><img src="../images/sup.png"></a></td>';
		    }
    $i = 0;
	$test_chef = $id_chef;
$test_sec = $id_sec;
$test_adj = $id_adj;
		$result2 = $xoopsDB->query("SELECT id_empl, id_serv FROM ".$xoopsDB->prefix("affecte")." WHERE id_serv='".$id_service."'");
		while ((list($id_empl, $id_serv) = $xoopsDB->fetchRow($result2)) != false || $id_chef != "0" || $id_sec != "0" || $id_adj != "0") {
    $i++;
if ($i==1) {
	echo "<tr><th><center>"._AM_ORGA_EMPL_CID."</center></th>\n"
			."<th><center>"._AM_ORGA_EMPL_NAME."</center></th>\n"
			."<th><center>"._AM_ORGA_EMPL_PREN."</center></th>\n"
			."<th><center>"._AM_ORGA_EMPL_PHOTO."</center></th>\n"
			."<th><center>"._AM_ORGA_EMPL_TEL."</center></th>\n"
			."<th><center>"._AM_ORGA_EMPL_LOCA."</center></th>\n"
			."<th colspan=\"3\"><center>"._AM_ACTION."</center></th>\n";
}

$test = 0;

if ($id_chef != "0"){
	if($id_sec == "0" && $id_adj == "0"){
	$test = 1;
	}	
	info_empl($id_chef, $id_serv,"chef", $test);
	$id_chef="0";
}

if ($id_sec != "0"){
	if($id_adj == "0"){
		$test = 1;
	}
	info_empl($id_sec, $id_serv,"sec", $test);
	$id_sec="0";
}

if ($id_adj != "0"){
	info_empl($id_adj, $id_serv,"adj", 1);
	$id_adj="0";
}

if($id_empl != $test_chef && $id_empl != $test_sec && $id_empl != $test_adj){
info_empl($id_empl, $id_serv, "",0);
}
    }
		echo '</tr></table><br />';
?>