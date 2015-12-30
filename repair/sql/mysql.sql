CREATE TABLE garage_clients (
  id int(5) NOT NULL auto_increment,
  compte varchar(25) NULL,
  rs varchar(100) NULL,
  nom varchar(50) NULL,
  prenom varchar(25) NULL,
  adresse text NULL,
  cp varchar(15) NULL,
  ville varchar(25) NULL,
  teldom varchar(15) NULL,
  telport varchar(15) NULL,
  telbureau varchar(15) NULL,
  civilite varchar(15) NULL,
  telecopie varchar(15) NULL,
  email varchar(50) NULL,
  particulier_prof int(2) NULL,
  permis varchar(25) NULL,
  remise float(4.5) NULL,
  derniere_facture varchar(10) NULL,  
  PRIMARY KEY(id)
);

  CREATE TABLE garage_vehicule (
  id int(5) NOT NULL auto_increment,
  immat varchar(15) NOT NULL,
  id_proprietaire int(5) NOT NULL default '0',
  date_mec varchar(10)  NULL,
  kilometrage int(10) NULL,
  dernier_ct varchar(10) NULL,
  prochain_ct varchar(10) NULL,
  id_marque int(5) NOT NULL default '0',
  gamme varchar(25) NULL,
  modele_version varchar(25) NULL,
  energie varchar(20) NULL,
  genre varchar(10) NULL,
  vin varchar(25) NULL,
  date_garantie varchar(10) NULL,
  date_distribution varchar(10) NULL,
  km_distribution int(10) NULL,
  date_vidange varchar(10) NULL,
  km_vidange int(10) NULL,
  date_cg varchar(10) NULL,
  observation text NULL, 
  PRIMARY KEY(id)
);

  CREATE TABLE garage_intervention (
  id int(5) NOT NULL auto_increment,
  id_voiture int(5) NOT NULL,
  kilometrage int(10) NULL,
  date_debut varchar(10)  NULL,
  date_fin varchar(10)  NULL,
  delai varchar(10)  NULL,
  id_inter_recurrente int(5) NULL,
  description text NULL,
  observation text NULL,
  date_devis varchar(10)  NULL,
  date_acceptation varchar(10)  NULL,
  montant float(10.5) NULL,
  acompte_verse float(10.5) NULL,
  solde int(3) NULL,
  hmeca_t1 float(10.5) NULL,
  hmeca_t2 float(10.5) NULL,
  hmeca_t3 float(10.5) NULL,
  hcarro_t1 float(10.5) NULL,
  hcarro_t2 float(10.5) NULL,
  hcarro_t3 float(10.5) NULL,
  tmeca_t1 float(10.5) NULL,
  tmeca_t2 float(10.5) NULL,
  tmeca_t3 float(10.5) NULL,
  tcarro_t1 float(10.5) NULL,
  tcarro_t2 float(10.5) NULL,
  tcarro_t3 float(10.5) NULL,
  remise_meca float(10.5) NULL,
  remise_caro float(10.5) NULL,
  remise_forfait float(10.5) NULL,
  numero_devis int(10) NULL,
  numero_facture int(10) NULL,  
  PRIMARY KEY(id)
);  

CREATE TABLE garage_inter_forfait (
  id int(5) NOT NULL auto_increment,
  id_inter int(5) NOT NULL,
  id_forfait int(5) NULL,
  designation text NULL,
  ref_fournisseur varchar(25) NULL,
  quantite int(10) NULL default 1,
  tarif_client float(10.2) NULL,
	remise_forfait float(10.2) NULL,
  PRIMARY KEY(id, id_inter)
);

CREATE TABLE garage_inter_pieces (
  id int(5) NOT NULL auto_increment,
  id_inter int(5) NOT NULL,
  id_piece int(5) NULL,
  designation text NULL,
  id_fournisseur int(5) NULL,
  ref_fournisseur varchar(25) NULL,
  quantite int(10) NULL default 1,
  tarif_ha float(10.5) NULL,
  tarif_client float(10.5) NULL,
  id_cat_piece int(5) NULL,
	remise_pieces float(10.2) NULL,
  PRIMARY KEY(id, id_inter)
);

CREATE TABLE garage_inter_temp (
  id int(5) NOT NULL auto_increment,
  id_inter int(5) NOT NULL,
  id_empl int(5) NULL,
  observation text NULL,
  hmeca_t1 float(10.5) NULL,
  hmeca_t2 float(10.5) NULL,
  hmeca_t3 float(10.5) NULL,
  hcarro_t1 float(10.5) NULL,
  hcarro_t2 float(10.5) NULL,
  hcarro_t3 float(10.5) NULL,
  tmeca_t1 float(10.5) NULL,
  tmeca_t2 float(10.5) NULL,
  tmeca_t3 float(10.5) NULL,
  tcarro_t1 float(10.5) NULL,
  tcarro_t2 float(10.5) NULL,
  tcarro_t3 float(10.5) NULL,
	remise_mod float(10.2) NULL,
  PRIMARY KEY(id, id_inter)
);

  CREATE TABLE garage_forfait (
  id int(5) NOT NULL auto_increment,
  nom varchar(50) NULL,
  description text NULL,
  tarif float(10.5) NULL,
  PRIMARY KEY(id)
);  

  CREATE TABLE garage_nomenc_forfait (
  id int(5) NOT NULL auto_increment,
  id_forfait int(5) NOT NULL,
  designation text NULL,
  quantite int(10) default '1',
  tarif float(10.5) NULL,
  PRIMARY KEY(id)
);

CREATE TABLE garage_pieces (
  id int(5) NOT NULL auto_increment,
  ref text NULL,
  designation text NULL,
  id_fournisseur int(5) NULL,
  ref_fournisseur varchar(25) NULL,
  tarif_ha float(10.5) NULL,
  tarif_client float(10.5) NULL,
  id_cat_piece int(5) NULL,
  PRIMARY KEY(id)
);

CREATE TABLE garage_cat_piece (
  id int(5) NOT NULL auto_increment,
  nom text NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE garage_fournisseur (
  id int(5) NOT NULL auto_increment,
  nom text NULL,
  adresse text NULL,
  tel varchar(25) NULL,
  fax varchar(25) NULL,
  email varchar(50) NULL,
  PRIMARY KEY(id)
);

CREATE TABLE garage_marque (
  id int(5) NOT NULL auto_increment,
  nom text NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE garage_employe (
  id_empl int(5) NOT NULL auto_increment,
  nom_empl varchar(20) NULL,
  pre_empl varchar(20) NULL,
  PRIMARY KEY  (id_empl)
);

CREATE TABLE garage_num_doc (
  type_doc varchar(10) NULL,
  num_doc int(10) NULL
);

CREATE TABLE garage_doc (
  id_doc varchar(25) NULL,
  doc_fr  text  NOT NULL,
  PRIMARY KEY(id_doc)
);


#
# Dumping data
#
INSERT INTO `garage_num_doc` VALUES ('DEVIS',1);
INSERT INTO `garage_num_doc` VALUES ('FACTURE',1);

INSERT INTO `garage_doc` VALUES('Client', 'Attention : La suppression de client est d&eacute;finitive<br><i>Be careful, the customer deletion is permanent</i>');
INSERT INTO `garage_doc` VALUES('Vehicule', 'Parc des v&eacute;hicules du garage<br><i>Cars already repaired in the garage</i>');
INSERT INTO `garage_doc` VALUES('Piece', 'Liste des pi&eacute;ces d&eacute;tach&eacute;es disponibles dans les r&eacute;parations<br><i>Spare parts available in repair<i>');
INSERT INTO `garage_doc` VALUES('Cat_Piece', 'Les cat&eacute;gories permettent de trier les pi&egrave;ces<br><i>The categories allow to sort the spare parts</i>');
INSERT INTO `garage_doc` VALUES('Employe', 'Nom des ouvriers du garage<br><i>The workers of the garage</i>');
INSERT INTO `garage_doc` VALUES('Fournisseur', 'Fournisseurs de pi&egrave;ces d&eacute;tach&eacute;es<br><i>Suppliers of the spare parts</i>');
INSERT INTO `garage_doc` VALUES('Marque', 'Attention &agrave; ne pas supprimer une marque utilis&eacute;e dans les v&eacute;hicules existants !<br><i>Be careful : do not delete a make used in the car table</i>');
INSERT INTO `garage_doc` VALUES('forfait', 'si aucun forfait n''existe la fonctionnalit&eacute; sera masqu&eacute;e dans la partie utilisateur.<br><i>If no package exist the function is hide in user side</i>');

INSERT INTO `garage_marque` VALUES (1,'Renault');
INSERT INTO `garage_marque` VALUES (2,'Peugeot');
INSERT INTO `garage_marque` VALUES (3,'Citroen');
INSERT INTO `garage_marque` VALUES (4,'Volvo');
INSERT INTO `garage_marque` VALUES (5,'Fiat');
INSERT INTO `garage_marque` VALUES (6,'Audi');
INSERT INTO `garage_marque` VALUES (7,'Volkswagen');
INSERT INTO `garage_marque` VALUES (8,'Rover');
INSERT INTO `garage_marque` VALUES (9,'Mercedes');
INSERT INTO `garage_marque` VALUES (10,'BMW');
INSERT INTO `garage_marque` VALUES (0,'- Divers -');

INSERT INTO `garage_cat_piece` VALUES (1,'Carrosserie');
INSERT INTO `garage_cat_piece` VALUES (2,'Electricit&eacute;');
INSERT INTO `garage_cat_piece` VALUES (3,'Mecanique');
INSERT INTO `garage_cat_piece` VALUES (4,'Freinage');

INSERT INTO `garage_clients` VALUES (1, '123456', '', 'DUPOND', 'Jean', '1 rue Xoops', '41000', 'BLOIS', '0254545454', '066006600', '', 'M.', '', '', 1, '123456879', 0, NULL);
INSERT INTO `garage_clients` VALUES (2, '456789', 'Charpente DUCLOU', 'DUCLOU', 'Christophe', '1 rue GPL', '41020', 'DANZE LES BLOSI', '', '', '', 'M.', '', '', 1, '123456879', 0, NULL);
INSERT INTO `garage_clients` VALUES (0,'', '','- Divers -', '', '', '', '', '', '', '', '', '', '', 1, '', 0, NULL);

INSERT INTO `garage_employe` VALUES (1, 'LABOSSE', 'Carl');
INSERT INTO `garage_employe` VALUES (2, 'DUMOULIN', 'Kevin');

INSERT INTO `garage_fournisseur` VALUES (2, 'Capail', '11 bis rue joseph cugnot\r\n37300 TOURS', '02 47 75 30 30', '02 47 75 30 31', 'capail@orange.fr');
INSERT INTO `garage_fournisseur` VALUES (4, 'autre', '', '', '', '');

INSERT INTO `garage_vehicule` VALUES (1, 'AA 12345 AA', 1, '2010-08-04', 32111, '2010-08-04', '2010-08-04', 6, '', '', 'Essence', '', '', '2010-08-04', '2010-08-04', 0, '2010-08-04', 0, '2010-08-04', '');
