/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  18/04/2015 13:14:07                      */
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
   ID_BILAN             int not null,
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
   ID_CATEGORIE         int not null,
   LIBELLE_CATEG        text,
   primary key (ID_CATEGORIE)
);

/*==============================================================*/
/* Table : CLIENT                                               */
/*==============================================================*/
create table CLIENT
(
   ID_CLI               int not null,
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
   ID_COMMANDE          int not null,
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
   ID_MAGASIN           int not null,
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
   ID_PRODUIT           int not null,
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
   ID_QUAI              int not null,
   ID_MAGASIN           int not null,
   NUMQUAI              int not null,
   primary key (ID_QUAI)
);

/*==============================================================*/
/* Table : REDUCTION                                            */
/*==============================================================*/
create table REDUCTION
(
   ID_REDUCTION         int not null,
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
   ID_RETRAIT           int not null,
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

