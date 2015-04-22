<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

if(isset($_GET['mag'])) {
	$_SESSION['num_mag'] = $_GET['mag'];
}
if(isset($_GET['categ'])) {
	$_SESSION['num_categ'] = $_GET['categ'];
}
?>

<!DOCTYPE html>
<html>
<head>	
	<meta charset="UTF-8"/>
	<link rel="stylesheet" href="../../css/styles.css">
	
	<script type="text/javascript" src="../js/script.js"></script>
	
	<?php include("../../base.php"); ?>
	<?php include("../../Controller/ControllerCategorie.php"); ?>
	<?php include("../../Controller/ControllerProduit.php"); ?>
	<?php include("../../Controller/ControllerContient.php"); ?>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

	<title> Ammu-nation.fr </title>
</head>

<body>
<header>
<div class ="Infos_user">
	<p> Connexion -> AJAX et inscription </p>
	<p> A la connexion du client, créer automatiquement une commande, ou récupérer l'ancienne </p>
</div>

<div class="Entete">
	<h1> Ammu-nation </h1>
</div>


</header>
<div id="contenu">
<div class="Colonne_categ">
<?php
	ControllerCategorie::ChoixCategorie();
	//ControllerContient::Ajouterproduit(1, 2, 3, 0, 20); OK BABY 
?>	
</div>

<div class="Zone_produits">
<?php
	if(isset($_GET['prod'])) {
		ControllerProduit::DetailProduit($_GET['prod']);	
	} else {
		if(isset($_SESSION['num_categ'])) {
			ControllerProduit::AfficherProduitCateg($_SESSION['num_mag'], $_SESSION['num_categ']);
		} else {
			ControllerProduit::AfficherProduit($_SESSION['num_mag']);
		}
	}
?>

</div>


</div>



</body>

</html>