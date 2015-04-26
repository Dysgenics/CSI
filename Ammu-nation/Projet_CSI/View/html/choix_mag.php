<?php
session_start();


include_once("../../base.php");

include_once("../../Controller/AJAXController.php");
include_once("../../Controller/ControllerCategorie.php");
include_once("../../Controller/ControllerCommande.php");
include_once("../../Controller/ControllerContient.php");
include_once("../../Controller/ControllerProduit.php");
include_once("../../Controller/ControllerMagasin.php");

include_once("../../Model/Categorie.php");
include_once("../../Model/Client.php");
include_once("../../Model/Commande.php");
include_once("../../Model/Contient.php");
include_once("../../Model/Magasin.php");
include_once("../../Model/Produit.php");

?>

<!DOCTYPE html>
<html>
<head>	
	<meta charset="UTF-8"/>
	<link rel="stylesheet" href="../css/styles.css">
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Allerta+Stencil" />
	
	<script type="text/javascript" src="../js/xyz.js"></script>

	<?//php include("../../base.php"); ?>
	<?//php include("../../Controller/ControllerMagasin.php"); ?>

	<title> Ammu-nation.fr </title>
</head>

<body>
<div id="choixMagContainer">
<div id="choixMagBanner">
<div id="choixMagCenter">
<h1> Ammu-nation </h1>

<h2> Choisir votre magasin : </h2>

<?php
	ControllerMagasin::ChoixMagasin();
?>	
</div>
</div>
</div>
</body>