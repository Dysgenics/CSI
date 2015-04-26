/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  18/04/2015 13:14:07                      */
/* AJOUT de 4 clients après la création de la BDD		*/
/* AJOUT de 2 magasins après la création de la BDD		*/
/*==============================================================*/


drop table if exists APPLIQUEE_A;

drop table if exists BENEFICIE;

drop table if exists BILAN;

drop table if exists CATEGORIE;

drop table if exists CLIENT;

drop table if exists COMMANDE;

drop table if exists CONTIENT;

drop table if exists EST_PROPOSEE;

drop table if exists HORAIRE;

drop table if exists MAGASIN;

drop table if exists OFFRE_PROMO;

drop table if exists PRODUIT;

drop table if exists PROPOSE;

drop table if exists QUAI;

drop table if exists REDUCTION;

drop table if exists RETRAIT;

/*==============================================================*/
/* Table : APPLIQUEE_A                                          */
/*==============================================================*/
create table APPLIQUEE_A
(
   ID_REDUCTION         int not null,
   ID_PRODUIT           int not null,
   primary key (ID_REDUCTION, ID_PRODUIT)
);

/*==============================================================*/
/* Table : BENEFICIE                                            */
/*==============================================================*/
create table BENEFICIE
(
   ID_CLI               int not null,
   ID_REDUCTION         int not null,
   primary key (ID_CLI, ID_REDUCTION)
);

/*==============================================================*/
/* Table : BILAN                                                */
/*==============================================================*/
create table BILAN
(
   ID_BILAN             int not null AUTO_INCREMENT,
   ID_MAGASIN           int not null,
   DEBUTPERIODE         date not null,
   FINPERIODE           date not null,
   NBPRODUITSVENDUS     int,
   CA_TOTAL             decimal,
   primary key (ID_BILAN)
);

/*==============================================================*/
/* Table : CATEGORIE                                            */
/*==============================================================*/
create table CATEGORIE
(
   ID_CATEGORIE         int not null AUTO_INCREMENT,
   LIBELLE_CATEG        text,
   primary key (ID_CATEGORIE)
);

/*==============================================================*/
/* Table : CLIENT                                               */
/*==============================================================*/
create table CLIENT
(
   ID_CLI               int not null AUTO_INCREMENT,
   NOM_CLI              text,
   PRENOM_CLI           text,
   ADRESSE_CLI          text,
   MDP                  text,
   EMAIL                text,
   TELEPHONE            int,
   primary key (ID_CLI)
);

/*==============================================================*/
/* Table : COMMANDE                                             */
/*==============================================================*/
create table COMMANDE
(
   ID_COMMANDE          int not null AUTO_INCREMENT,
   ID_CLI               int not null,
   ID_RETRAIT           int,
   ID_MAGASIN           int not null,
   VALIDE               bool,
   TOTAL                decimal,
   DATEACHAT            datetime,
   primary key (ID_COMMANDE)
);

/*==============================================================*/
/* Table : CONTIENT                                             */
/*==============================================================*/
create table CONTIENT
(
   ID_PRODUIT           int not null,
   ID_COMMANDE          int not null,
   QUANTITE             int not null,
   REDUCTION            int,
   PRIX_UNITAIRE        decimal,
   primary key (ID_PRODUIT, ID_COMMANDE)
);

/*==============================================================*/
/* Table : EST_PROPOSEE                                         */
/*==============================================================*/
create table EST_PROPOSEE
(
   ID_PRODUIT           int not null,
   ID_OFFRE             int not null,
   primary key (ID_PRODUIT, ID_OFFRE)
);

/*==============================================================*/
/* Table : HORAIRE                                              */
/*==============================================================*/
create table HORAIRE
(
   DATE                 date not null,
   HEURE                time not null,
   primary key (HEURE, DATE)
);

/*==============================================================*/
/* Table : MAGASIN                                              */
/*==============================================================*/
create table MAGASIN
(
   ID_MAGASIN           int not null AUTO_INCREMENT,
   NOM_MAGASIN          text,
   NUM_RUE              text,
   NOM_RUE              text,
   VILLE                text,
   CP                   int,
   primary key (ID_MAGASIN)
);

/*==============================================================*/
/* Table : OFFRE_PROMO                                          */
/*==============================================================*/
create table OFFRE_PROMO
(
   ID_OFFRE             int not null,
   DATEDEBOFFRE         datetime,
   DATEFINOFFRE         datetime,
   QUANTITEMINO         int,
   MONTANTOFFRE         int,
   primary key (ID_OFFRE)
);

/*==============================================================*/
/* Table : PRODUIT                                              */
/*==============================================================*/
create table PRODUIT
(
   ID_PRODUIT           int not null AUTO_INCREMENT,
   ID_CATEGORIE         int not null,
   NOM_PRODUIT          text,
   PRIX                 decimal,
   LIBELLE              text,
   IMG_URL              text,
   primary key (ID_PRODUIT)
);

/*==============================================================*/
/* Table : PROPOSE                                              */
/*==============================================================*/
create table PROPOSE
(
   ID_PRODUIT           int not null,
   ID_MAGASIN           int not null,
   primary key (ID_PRODUIT, ID_MAGASIN)
);

/*==============================================================*/
/* Table : QUAI                                                 */
/*==============================================================*/
create table QUAI
(
   ID_QUAI              int not null AUTO_INCREMENT,
   ID_MAGASIN           int not null,
   NUMQUAI              int not null,
   primary key (ID_QUAI)
);

/*==============================================================*/
/* Table : REDUCTION                                            */
/*==============================================================*/
create table REDUCTION
(
   ID_REDUCTION         int not null AUTO_INCREMENT,
   DATEDEBREDUC         datetime,
   DATEFINREDUC         datetime,
   QUANTITEMINR         int,
   MONTANTREDUC         int,
   primary key (ID_REDUCTION)
);

/*==============================================================*/
/* Table : RETRAIT                                              */
/*==============================================================*/
create table RETRAIT
(
   ID_RETRAIT           int not null AUTO_INCREMENT,
   ID_QUAI              int not null,
   ID_COMMANDE          int not null,
   HEURE                time not null,
   DATE                 date not null,
   primary key (ID_RETRAIT)
);

alter table APPLIQUEE_A add constraint FK_APPLIQUEE_A foreign key (ID_REDUCTION)
      references REDUCTION (ID_REDUCTION) on delete restrict on update restrict;

alter table APPLIQUEE_A add constraint FK_APPLIQUEE_A2 foreign key (ID_PRODUIT)
      references PRODUIT (ID_PRODUIT) on delete restrict on update restrict;

alter table BENEFICIE add constraint FK_BENEFICIE foreign key (ID_CLI)
      references CLIENT (ID_CLI) on delete restrict on update restrict;

alter table BENEFICIE add constraint FK_BENEFICIE2 foreign key (ID_REDUCTION)
      references REDUCTION (ID_REDUCTION) on delete restrict on update restrict;

alter table BILAN add constraint FK_LIE_A foreign key (ID_MAGASIN)
      references MAGASIN (ID_MAGASIN) on delete restrict on update restrict;

alter table COMMANDE add constraint FK_CONCERNE foreign key (ID_MAGASIN)
      references MAGASIN (ID_MAGASIN) on delete restrict on update restrict;

alter table COMMANDE add constraint FK_PASSE foreign key (ID_CLI)
      references CLIENT (ID_CLI) on delete restrict on update restrict;

alter table COMMANDE add constraint FK_RETRAIT_DE_COMMANDE2 foreign key (ID_RETRAIT)
      references RETRAIT (ID_RETRAIT) on delete restrict on update restrict;

alter table CONTIENT add constraint FK_CONTIENT foreign key (ID_PRODUIT)
      references PRODUIT (ID_PRODUIT) on delete restrict on update restrict;

alter table CONTIENT add constraint FK_CONTIENT2 foreign key (ID_COMMANDE)
      references COMMANDE (ID_COMMANDE) on delete restrict on update restrict;

alter table EST_PROPOSEE add constraint FK_EST_PROPOSEE foreign key (ID_PRODUIT)
      references PRODUIT (ID_PRODUIT) on delete restrict on update restrict;

alter table EST_PROPOSEE add constraint FK_EST_PROPOSEE2 foreign key (ID_OFFRE)
      references OFFRE_PROMO (ID_OFFRE) on delete restrict on update restrict;

alter table PRODUIT add constraint FK_APPARTIENT foreign key (ID_CATEGORIE)
      references CATEGORIE (ID_CATEGORIE) on delete restrict on update restrict;

alter table PROPOSE add constraint FK_PROPOSE foreign key (ID_PRODUIT)
      references PRODUIT (ID_PRODUIT) on delete restrict on update restrict;

alter table PROPOSE add constraint FK_PROPOSE2 foreign key (ID_MAGASIN)
      references MAGASIN (ID_MAGASIN) on delete restrict on update restrict;

alter table QUAI add constraint FK_SE_TROUVE foreign key (ID_MAGASIN)
      references MAGASIN (ID_MAGASIN) on delete restrict on update restrict;

alter table RETRAIT add constraint FK_RETRAIT_AU_QUAI foreign key (ID_QUAI)
      references QUAI (ID_QUAI) on delete restrict on update restrict;

alter table RETRAIT add constraint FK_RETRAIT_A_L_HORAIRE foreign key (HEURE, DATE)
      references HORAIRE (HEURE, DATE) on delete restrict on update restrict;

alter table RETRAIT add constraint FK_RETRAIT_DE_COMMANDE foreign key (ID_COMMANDE)
      references COMMANDE (ID_COMMANDE) on delete restrict on update restrict;

/*==============================================================*/
/* Ajout des clients	                                        */
/*==============================================================*/

INSERT INTO CLIENT 
    VALUES (0,'Papelier', 'Romain', '16 rue du Sapin', '598f195ab155f4279de2ee4e4c3edcd8a4ea69383ab2454591301b7672aa4d369adaf45d0563c3ec4df82f006653440415dd5b3d72989299628bc25c9099a3c0', 'romain.papelier@gmail.com', 0657890876),
    (0,'Chaboissier', 'Maxime', '12 rue MC circulaire', '9c357f1841ff6c7a65011d75efa517bfd212f183d08cf898b73b044578dd71f6aa8b0a07eb01ca59b36516f82d1346d01d198c8d1642d8996acdd0d72cff7616', 'maxime.chaboissier@yahoo.fr', 0698906754),
    (0,'Besson', 'Leonard', '256 boulevard du jambon', '4f59fc06506f22f06ce4d2d9a163fcd0009bf5d0e830cac441d88bbcaef4e821cb17bd0c4f6ac780cc1f68d929cb6765fbe2745ec5d1aca29d5d74415942c2c6', 'leonard@hotmail.fr', NULL),
   (0,'Burteaux', 'Pierre', '46 avenue de la meuse', 'ecf37bff40e6d1de59c03382590c24ac32592561b2a77474c9cb20045a229a5fb5604ceb60808194a6d188f1b36e38ccc804ad616a4c4532af2fe5da3cf45439','pierre.burteaux@gmail.com', 0657899765);

/*==============================================================*/
/* Ajout des magasins	                                        */
/*==============================================================*/

INSERT INTO MAGASIN
VALUES (0, 'Chez Marco', '12', 'Rue du jardiland', 'Nancy', 54000),
(0, 'Chez Jenko', '21', 'Jump Street', 'Vancouver', NULL),
(0, 'Chez Schmit', '22', 'Jump Street', 'Vancouver', NULL);

/*==============================================================*/
/* Ajout des catégories	                                        */
/*==============================================================*/

INSERT INTO CATEGORIE
VALUES (0,'Arme blanche'),
(0,'Arme de poing'),
(0,'Fusil d\'assaut');

/*==============================================================*/
/* Ajout des produits		                                    */
/*==============================================================*/

INSERT INTO PRODUIT
VALUES (0, 1, 'Couteau', 20, 'Un beau couteau', '../../View/img/img_prod/couteau.jpeg'), /* !! Chemin ne fonctionne pas */
(0, 1,'Club de golf', 89, 'Pour jouer au golf', '../../View/img/img_prod/club_golf.jpg'),
(0, 2, 'Revolver Colt', 189, 'Pistolet de Cow Boy', '../../View/img/img_prod/revolver_colt.png'),
(0, 3, 'FN FNC', 1600, 'Le fusil d\'Al Pacino dans Heat, la classe !', '../../View/img/img_prod/fn_fnc.png'),
(0, 2, 'Pistolet Luger', 159, 'Meilleur vente', '../../View/img/img_prod/luger_p08.png');

INSERT INTO PRODUIT
VALUES (0, 2, "Beretta PX4 Storm", 989, "Px4 Storm avec chargeur de réserve. Calibre : 9 para Capacité chargeur : 17 coups", "../../View/img/img_prod/beretta.jpg");

/*==============================================================*/
/* Ajout dans propose	                                    */
/*==============================================================*/

INSERT INTO PROPOSE
VALUES (1, 1),
(1, 2),
(2, 1),
(3, 2),
(4, 2),
(6, 2),
(5, 2);

/*
CREATE EVENT CREATE_BILAN
ON SCHEDULE EVERAY 1 DAY STARTS '2015-04-19 21:45:00'
DO INSERT INTO projet_CSI.BILAN
VALUES (0, 1, DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY), CURRENT_DATE, */