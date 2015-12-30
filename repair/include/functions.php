<?php

/*
* Function to show the admin menu
*/

function garage_tabsAdminMenu($file) {

  global $xoopsModule;

  // Configuring different tables
  $url = XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/admin";
  $url2 = XOOPS_URL."/modules/".$xoopsModule->getVar('dirname');
  $tabs = array();
  $tabs[] = array(
        'title' => _AM_INTER,
        'url' => $url.'/intervention.php',
        'color' => ''
        );
  $tabs[] = array(
        'title' => _AM_VEHICULE,
        'url' => $url.'/vehicule.php',
        'color' => ''
        );
  $tabs[] = array(
        'title' => _AM_CLIENT,
        'url' => $url.'/client.php',
        'color' => ''
        );
  $tabs[] = array(
        'title' => _AM_FOURNISSEUR,
        'url' => $url.'/fournisseur.php',
        'color' => ''
        );
  $tabs[] = array(
        'title' => _AM_PIECES,
        'url' => $url.'/piece.php',
        'color' => ''
        );
  $tabs[] = array(
        'title' => _AM_CAT,
        'url' => $url.'/cat_piece.php',
        'color' => ''
        );
  $tabs[] = array(
        'title' => _AM_FORFAIT,
        'url' => $url.'/forfait.php',
        'color' => ''
        );
  $tabs[] = array(
        'title' => _AM_MARQUE,
        'url' => $url.'/marque.php',
        'color' => ''
        );
  $tabs[] = array(
        'title' => _AM_EMPLOYE,
        'url' => $url.'/employe.php',
        'color' => ''
        );

    $tabs[] = array(
        'title' => '&nbsp;<img src="'.$url2.'/images/tip.png" alt="'._AM_DOC.'" title="'._AM_DOC.'">&nbsp;',
        'url' => $url.'/gest_doc.php',
        'color' => ''
        );

    $tabs[] = array(
        'title' => '&nbsp;<img src="'.$url2.'/images/trash.jpeg" alt="'._AM_TRASH.'" title="'._AM_TRASH.'" height ="12px" width="12px">&nbsp;',
        'url' => $url.'/trash.php',
        'color' => ''
        );

  // Call generic function with correct params
  xoops_tabAdminMenu($xoopsModule, $file, $tabs);
}

/**
 * Create the header of the module (logo & help)
 */
 function header_mod_garage(){
	echo "<table width='100%'>\n
	       <tr>\n
	      	 <td align='center'><img src='../images/logo.jpg' alt='' title=''></td>\n
	       </tr>\n
	     	</table>\n
	     	<br />\n";
}

/**
 * Creates nice menu with tabs. This idea comes from smartSection and formulaire modules.
 */
function xoops_tabAdminMenu($module, $file, $tabs) {

header_mod_garage();

  // Nice buttons styles
  $imgUrl = XOOPS_URL."/modules/".$module->getVar('dirname').'/images/admin';
  echo "<style type='text/css'>\n"
    ."#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }\n"
    ."#buttonbar { float:left; width:100%; background: #e7e7e7 url('".$imgUrl."/bg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }\n"
    ."#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }\n"
    ."#buttonbar li { display:inline; margin:0; padding:0; }\n"
    ."#buttonbar a { float:left; background:url('".$imgUrl."/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }\n"
    ."#buttonbar a span { float:left; display:block; background:url('".$imgUrl."/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }\n"
    ."/* Commented Backslash Hack hides rule from IE5-Mac */\n"
    ."#buttonbar a span {float:none;}\n"
    ."/* End IE5-Mac hack */\n"
    ."#buttonbar a:hover span { color:#333; }\n"
    ."#buttonbar #current a { background-position:0 -150px; border-width:0; }\n"
    ."#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }\n"
    ."#buttonbar a:hover { background-position:0% -150px; }\n"
    ."#buttonbar a:hover span { background-position:100% -150px; }\n"
    ."</style>\n";

    // Current tab special settings
  $page = preg_replace("'^.*[\\/](.*?\.php).*$'", "\\1", $file);
  foreach ($tabs as $i => $tab) {
    if (strpos($tab['url'], $page)) {
      $tabs[$i]['color'] = 'current';
    }
  }

  // Displaying tabs
  echo "<div id='buttontop'>\n"
    ."<table style=\"width: 100%; padding: 0;\" cellspacing=\"0\">\n"
    ."<tr>\n"
    ."<td style='font-size: 10px; text-align: right; ' colspan='2'>&nbsp;</td>\n"
    ."</tr>\n"
    ."</table>\n"
    ."</div>"
    ."<div id='buttonbar'>\n"
    ."<ul>";
  foreach ($tabs as $tab) {
    echo "<li id='" . $tab['color'] . "'><a href=\"".$tab['url']."\"><span>".$tab['title']."</span></a></li>\n";
  }
  echo "</ul>\n"
    ."</div>&nbsp;\n";
}


 function doc_info($lieu) {
    global $xoopsDB;
    $req = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("garage_doc")." WHERE id_doc='".$lieu."'");
     while ((list($id_doc, $doc_fr) = $xoopsDB->fetchRow($req)) != false ) 
     {		
      if ($doc_fr <> "") {echo '<fieldset><legend>&nbsp;<img src="../images/tipanim.gif">&nbsp;<b>'._AM_DOC.'</b>&nbsp;</legend><br />'.nl2br($doc_fr).'</fieldset><br />';}
     	}
}
?>