<?php
define("_MI_GARAGE_VEHICULE", "V&eacute;hicules");
define("_MI_GARAGE_CLIENTS", "Clients");
define("_MI_GARAGE_FOURNISSEURS", "Fournisseurs");
define("_MI_GARAGE_PIECES", "Pi&egrave;ces");
define("_MI_GARAGE_MARQUES", "Marques");
define("_MI_GARAGE_EMPLOYES", "Employ&eacute;s");
define("_MI_GARAGE_CAT_PIECES", "Cat&eacute;gories pi&egrave;ces");
define("_MI_GARAGE_INTER", "Interventions");

//blocks
define("_MI_GARAGE_INTER_EC","R&eacute;parations en cours");

//preferences config
define("_MI_GARAGE_MECAT1", "Taux horaire T1 M&eacute;canique");
define("_MI_GARAGE_DESC_MECAT1", "<b>Op&eacute;rations courantes</b><br>Op&eacute;rations de d&eacute;pose, pose et remplacement d'organes m&eacute;caniques, &eacute;lectriques en &eacute;change standard.");
define("_MI_GARAGE_MECAT2", "Taux horaire T2 M&eacute;canique");
define("_MI_GARAGE_DESC_MECAT2", "<b>Op&eacute;rations complexes</b><br>Op&eacute;rations de r&eacute;vision, r&eacute;fection et r&eacute;glages m&eacute;caniques,&eacute;lectrique et hydraulique, remplacement de pare-brise coll&eacute;s.");
define("_MI_GARAGE_MECAT3", "Taux horaire T3 M&eacute;canique");
define("_MI_GARAGE_DESC_MECAT3", "<b>Op&eacute;rations haute technologie</b><br>Diagnostics,r&eacute;vision, r&eacute;fection et r&eacute;glage de syst&egrave;mes relatifs &agrave; l'&eacute;lectronique, turbo, climatisation, compresseur, ABS, BV automatique, pompe hydraulique ,et de contr&ocirc;le et r&eacute;glage d'injection de diesel ou essence effectu&eacute;es au banc, de m&ecirc;me que les controles et r&eacute;glages de trains avant et arri&egrave;re.");
define("_MI_GARAGE_CARROT1", "Taux horaire T1 Carrosserie");
define("_MI_GARAGE_DESC_CARROT1", "<b>Op&eacute;rations courantes</b><br>Op&eacute;rations de d&eacute;pose, pose et remplacement de carrosserie en &eacute;change standard.");
define("_MI_GARAGE_CARROT2", "Taux horaire T2 Carrosserie");
define("_MI_GARAGE_DESC_CARROT2", "<b>Op&eacute;rations complexes</b><br>Op&eacute;rations de r&eacute;vision, redressage d'&eacute;lement de carrosserie effectu&eacute; au sol; travaux de peinture.");
define("_MI_GARAGE_CARROT3", "Taux horaire T3 Carrosserie");
define("_MI_GARAGE_DESC_CARROT3", "<b>Op&eacute;rations haute technologie</b><br>Controles et r&eacute;glages de trains avant et arri&egrave;re.");

define("_MI_GARAGE_SHOW_DOC", "Afficher la documentation zone admin");
define("_MI_GARAGE_DESC_SHOW_DOC", "Cette option permet d'afficher ou non des informations d'aide dans les diff&eacute;rents onglets de l'administration du module");

define("_MI_GARAGE_MONNAIE", "Symbole pour la monnaie");
define("_MI_GARAGE_TX_TVA", "Taux de TVA applicable");

define("_MI_GARAGE_MODIF_MOD_ALLOW", "Interdire les modifications / suppressions de temps et constat cote utilisateur");
define("_MI_GARAGE_DESC_MODIF_MOD_ALLOW", "masque les zones 'action' du d&eacute;tail de la main d'oeuvre de la r&eacute;paration cote utilisateur");
define("_MI_GARAGE_MODIF_PCE_ALLOW", "Interdire les modifications / suppressions de pieces cote utilisateur");
define("_MI_GARAGE_DESC_MODIF_PCE_ALLOW", "masque les zones 'action' du d&eacute;tail des pi&egravesces utilis&eacute;es dans la r&eacute;paration cote utilisateur");
define("_MI_GARAGE_MODIF_FOR_ALLOW", "Interdire les modifications / suppressions de forfait cote utilisateur");
define("_MI_GARAGE_DESC_MODIF_FOR_ALLOW", "masque les zones 'action' du d&eacute;tail des forfaits de la r&eacute;paration cote utilisateur");

define("_MI_GARAGE_RAISON_SOCIALE", "Raison sociale");
define("_MI_GARAGE_DESC_RS", "Raison Sociale (pour impression en bas de page des devis)");
define("_MI_GARAGE_RCS", "Registre du Commerce et des Soci&eacute;t&eacute;s");
define("_MI_GARAGE_DESC_RCS", "Numero RCS (pour impression en bas de page des devis)");
define("_MI_GARAGE_SOCIETE", "Nom, adresse, tel. Fax....");
define("_MI_GARAGE_DESC_SOCIETE", "Ces informations seront utilis&eacute;es pour l'impression des devis et factures <br>(en tete des impressions, a cote du logo)");
define("_MI_GARAGE_IMPRESSION", "Impression directe");
define("_MI_GARAGE_DESC_IMPRESSION", "Ouvre la fen&ecirc;tre de s&eacute;lection de l'imprimante lors de l'appel du devis et de la facture");

define("_MI_GARAGE_FCT_FACTURE", "Fonction Facturation");
define("_MI_GARAGE_DESC_FCT_FACTURE", "Activation de la fonction de facturation, permet l'&eacute;dition de la facture apr&egrave;s celle des devis");

define("_MI_GARAGE_IMP_FACTURE", "Impression facture");
define("_MI_GARAGE_DESC_IMP_FACTURE", "Autorise l'&eacute;dition des factures aux non administrateurs du module");

define("_MI_GARAGE_AUT_SOLDE", "Autorisation de solder");
define("_MI_GARAGE_DESC_AUT_SOLDE", "Autorise le solde de la r&eacute;paration aux non administrateurs du module");

define("_MI_GARAGE_AUT_ARCHIVE", "Autorisation d'archiver");
define("_MI_GARAGE_DESC_AUT_ARCHIVE", "Autorise l'archivage de la r&eacute;paration aux non administrateurs du module");

define("_MI_GARAGE_AFF_ONGLET_DOC", "Afficher l'onglet documentation");
define("_MI_GARAGE_DESC_AFF_ONGLET_DOC", "Affiche l'onglet dans la zone administration.<br>Cela ne masque pas le syst&egrave;me de documentation dans les diff&eacute;rents onglets mais juste la possibilit&eacute; de modifier les textes d'aide.");



?>