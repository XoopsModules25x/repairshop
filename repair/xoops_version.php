<?php


global $xoopsDB, $xoopsUser, $xoopsConfig, $myts, $xoopsModule, $xoopsModuleConfig;

$modversion['name'] = "R&eacute;paration";
$modversion['version'] = 1.5;
$modversion['description'] = "Gestion des r&eacute;parations";
$modversion['author'] = "P.Masson (aka philou from frxoops)";
$modversion['credits'] = "P.Masson (aka philou from frxoops)";

$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/logo.jpg";
$modversion['dirname'] = "repair";

// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!) 
// creation des tables
$i=0;
$i++;
$modversion['tables'][$i] = 'garage_clients';
$i++;
$modversion['tables'][$i] = 'garage_vehicule';
$i++;
$modversion['tables'][$i] = 'garage_intervention';
$i++;
$modversion['tables'][$i] = 'garage_inter_pieces';
$i++;
$modversion['tables'][$i] = 'garage_inter_temp';
$i++;
$modversion['tables'][$i] = 'garage_inter_forfait';
$i++;
$modversion['tables'][$i] = 'garage_forfait';
$i++;
$modversion['tables'][$i] = 'garage_nomenc_forfait';
$i++;
$modversion['tables'][$i] = 'garage_pieces';
$i++;
$modversion['tables'][$i] = 'garage_cat_piece';
$i++;
$modversion['tables'][$i] = 'garage_fournisseur';
$i++;
$modversion['tables'][$i] = 'garage_marque';
$i++;
$modversion['tables'][$i] = 'garage_employe';
$i++;
$modversion['tables'][$i] = 'garage_num_doc';
$i++;
$modversion['tables'][$i] = 'garage_doc';


// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/intervention.php";
$modversion['adminmenu'] = "admin/menu.php";

// Blocks
$modversion['blocks'][1]['file'] = "garage_ec.php";
$modversion['blocks'][1]['name'] = _MI_GARAGE_INTER_EC;
$modversion['blocks'][1]['show_func'] = "garage_ec_list";

// Menu
$modversion['hasMain'] = 1;
$i=1;
$modversion['sub'][$i]['name'] = "R&eacute;parations en cours";
$modversion['sub'][$i]['url'] = "index.php?solde=0";
$i++;
$modversion['sub'][$i]['name'] = "R&eacute;parations sold&eacute;es";
$modversion['sub'][$i]['url'] = "index.php?solde=1";
$i++;
$modversion['sub'][$i]['name'] = "R&eacute;parations archiv&eacute;es";
$modversion['sub'][$i]['url'] = "index.php?solde=2";
/*
$i++;
$modversion['sub'][$i]['name'] = "Cr&eacute;ation dossier";
$modversion['sub'][$i]['url'] = "intervention.php";
*/
// Templates
$modversion['templates'][1]['file'] = 'devis_print.html';
$modversion['templates'][1]['description'] = 'Impression des devis';
$modversion['templates'][2]['file'] = 'facture_print.html';
$modversion['templates'][2]['description'] = 'Impression des factures';

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "repair_search";


// preferences
$cpto = 0;

$cpto++;
$modversion['config'][$cpto]['name'] = 'meca_t1';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_MECAT1';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_MECAT1';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'float';
$modversion['config'][$cpto]['default'] = 38.64;

$cpto++;
$modversion['config'][$cpto]['name'] = 'meca_t2';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_MECAT2';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_MECAT2';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'float';
$modversion['config'][$cpto]['default'] = 41.85;

$cpto++;
$modversion['config'][$cpto]['name'] = 'meca_t3';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_MECAT3';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_MECAT3';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'float';
$modversion['config'][$cpto]['default'] = 49.00;

$cpto++;
$modversion['config'][$cpto]['name'] = 'carro_t1';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_CARROT1';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_CARROT1';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'float';
$modversion['config'][$cpto]['default'] = 38.64;

$cpto++;
$modversion['config'][$cpto]['name'] = 'carro_t2';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_CARROT2';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_CARROT2';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'float';
$modversion['config'][$cpto]['default'] = 44.50;

$cpto++;
$modversion['config'][$cpto]['name'] = 'carro_t3';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_CARROT3';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_CARROT3';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'float';
$modversion['config'][$cpto]['default'] = 53.00;

$cpto++;
$modversion['config'][$cpto]['name'] = 'documentation';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_SHOW_DOC';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_SHOW_DOC';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;


$cpto++;
$modversion['config'][$cpto]['name'] = 'money';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_MONNAIE';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['default'] = '&euro;';

$cpto++;
$modversion['config'][$cpto]['name'] = 'tva';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_TX_TVA';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'float';
$modversion['config'][$cpto]['default'] = '19.6';

$cpto++;
$modversion['config'][$cpto]['name'] = 'modif_inter_mod';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_MODIF_MOD_ALLOW';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_MODIF_MOD_ALLOW';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

$cpto++;
$modversion['config'][$cpto]['name'] = 'modif_inter_pce';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_MODIF_PCE_ALLOW';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_MODIF_PCE_ALLOW';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

$cpto++;
$modversion['config'][$cpto]['name'] = 'modif_inter_for';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_MODIF_FOR_ALLOW';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_MODIF_FOR_ALLOW';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

$cpto++;
$modversion['config'][$cpto]['name'] = 'raison_sociale';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_RAISON_SOCIALE';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_RS';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'text';
//$modversion['config'][$cpto]['default'] = 'XXXXX';
$modversion['config'][$cpto]['default'] = '';

$cpto++;
$modversion['config'][$cpto]['name'] = 'rcs';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_RCS';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_RCS';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'text';
//$modversion['config'][$cpto]['default'] = 'XXX-XXX-XXX RCS XXXXXX';
$modversion['config'][$cpto]['default'] = '';

$cpto++;
$modversion['config'][$cpto]['name'] = 'societe';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_SOCIETE';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_SOCIETE';
$modversion['config'][$cpto]['formtype'] = 'textarea';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['default'] = '';

$cpto++;
$modversion['config'][$cpto]['name'] = 'impression_directe';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_IMPRESSION';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_IMPRESSION';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

$cpto++;
$modversion['config'][$cpto]['name'] = 'fonction_facture';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_FCT_FACTURE';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_FCT_FACTURE';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 1;

$cpto++;
$modversion['config'][$cpto]['name'] = 'impression_facture_non_admin';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_IMP_FACTURE';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_IMP_FACTURE';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

$cpto++;
$modversion['config'][$cpto]['name'] = 'autoriser_solde';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_AUT_SOLDE';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_AUT_SOLDE';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

$cpto++;
$modversion['config'][$cpto]['name'] = 'autoriser_archive';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_AUT_ARCHIVE';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_AUT_ARCHIVE';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;

$cpto++;
$modversion['config'][$cpto]['name'] = 'documentation';
$modversion['config'][$cpto]['title'] = '_MI_GARAGE_AFF_ONGLET_DOC';
$modversion['config'][$cpto]['description'] = '_MI_GARAGE_DESC_AFF_ONGLET_DOC';
$modversion['config'][$cpto]['formtype'] = 'yesno';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 0;
?>