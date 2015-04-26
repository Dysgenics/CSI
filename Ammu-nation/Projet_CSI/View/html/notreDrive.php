<?php
// On démarre la session AVANT d'écrire du code HTML

session_start();
if(isset($_GET['mag'])) {
	$_SESSION['num_mag'] = intval($_GET['mag']);
	
}
if(isset($_GET['categ'])) {
	$_SESSION['num_categ'] = $_GET['categ'];
}

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
	<script type="text/javascript" src="../js/script.js"></script>
	
	<?//php include("../../base.php"); ?>
	<?//php include("../../Controller/ControllerCategorie.php"); ?>
	<?//php include("../../Controller/ControllerProduit.php"); ?>
	<?//php include("../../Controller/ControllerContient.php"); ?>
	<?//php include("../../Model/Client.php"); ?>
	<?//php include("../../Model/Magasin.php"); ?>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

	<title> Ammu-nation.fr </title>
</head>

<body>
<header>
<div class="Entete">
	<h1> Ammu-nation </h1>
	<?php 
$mag = Magasin::findById($_SESSION['num_mag']);
	$_SESSION['mag'] = array();
	
	$_SESSION['mag'] = $mag;
	echo '<h4>' . $_SESSION['mag']['nom_magasin'] . '</h4>';
	?>

	
</div>

<div class ="Infos_user">
<?php
// Si l'utilisateur est connecté
if (isset($_SESSION['email'])) {
	//echo "test2";
    // On affiche un message, son nom d'utilisateur et un bouton pour se déconnecter
    echo "<div class=\"connexion\">\n";
    echo  $_SESSION['prenom_cli'] . " " . $_SESSION['nom_cli'];
    echo "<form action=\"connection.php\" method=\"GET\">\n";
    echo "<input id=\"connectBtn\" class=\"bouton\" type=\"submit\" value=\"Se déconnecter\"/>\n";
    echo "</form>\n";
    ControllerContient::AfficherPanierReduit($_SESSION['id_com']);
    echo "</div>\n";
	
    
} else {
	//echo "test";
    // Sinon, on affiche des champs et un bouton pour qu'il puisse se connecter
    echo "<div class=\"connexion\">\n";
    echo "<div class=\"input\">\n";
    echo "<form action=\"connection.php\" method=\"POST\">\n";
    echo "<input class=\"champ\" type=\"text\" name=\"email\" value=\"email\" size=\"20\"/>\n";
    echo "<input class=\"champ\" type=\"password\" name=\"mdp\" value=\"mdp\"/>\n";
    echo "<input id=\"connectBtn\" class=\"bouton\" type=\"submit\" value=\"Se connecter\"/>\n";
    echo "</form>\n";
    
    if(isset($_GET['auth']))
    {
        if($_GET['auth'] == 0)
        {
            echo "<p id=\"authError\">Email ou mot de passe incorrect</p>";
        }
    }
    
    echo "</div>\n";
    echo "</div>\n";
    
}	?>
</div>
</header>

<div id="contenu">
<div class="Colonne_categ">
<h2>Catégories</h2>
<?php
	ControllerCategorie::ChoixCategorie();
	//ControllerContient::Ajouterproduit(1, 2, 3, 0, 20); OK BABY 
?>	
</div>

<div class="Zone_produits">
<?php
    var_dump($_SESSION);
    if(isset($_GET['panier']))
    {
        ControllerContient::AfficherPanier($_SESSION['id_com']);
    }
	else if(isset($_GET['prod'])) {
		ControllerProduit::DetailProduit($_GET['prod']);	
	} else {
		if(isset($_SESSION['num_categ']) && $_SESSION['num_categ'] != -1) {
			ControllerProduit::AfficherProduitCateg($_SESSION['num_mag'], $_SESSION['num_categ']);
		} else {
			ControllerProduit::AfficherProduit($_SESSION['num_mag']);
		}
	}
	// ControllerContient::AfficherPanier($_SESSION['id_com']); Il faut afficher les noms des produits
?>
</div>

</div>

<script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/notify.min.js"></script>

</body>

</html>