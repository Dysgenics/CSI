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
	<link rel="stylesheet" href="../css/styles.css">
	
	<script type="text/javascript" src="../js/script.js"></script>
	
	<?php include("../../base.php"); ?>
	<?php include("../../Controller/ControllerCategorie.php"); ?>
	<?php include("../../Controller/ControllerProduit.php"); ?>
	<?php include("../../Controller/ControllerContient.php"); ?>
	<?php include("../../Model/Client.php"); ?>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

	<title> Ammu-nation.fr </title>
</head>

<body>
<div class="Entete">
	<h1> Ammu-nation </h1>
</div>

<div class ="Infos_user">
<?php
// Si l'utilisateur est connecté
if (isset($_SESSION['email'])) {
	echo "test2";
    // On affiche un message, son nom d'utilisateur et un bouton pour se déconnecter
    echo "<div class=\"connexion\">\n";
    echo "Vous êtes connectés en tant que " . $_SESSION['email'];
    echo "<form action=\"connection.php\" method=\"GET\">\n";
    echo "<input class=\"bouton\" type=\"submit\" value=\"Se déconnecter\"/>\n";
    echo "</form>\n";
    echo "</div>\n";
	 echo $_SESSION['id_cli'];
    
} else {
	echo "test";
    // Sinon, on affiche des champs et un bouton pour qu'il puisse se connecter
    echo "<div class=\"connexion\">\n";
    echo "<div class=\"input\">\n";
    echo "<form action=\"connection.php\" method=\"POST\">\n";
    echo "<input class=\"champ\" type=\"text\" name=\"email\" value=\"email\" size=\"20\"/>\n";
    echo "<input class=\"champ\" type=\"password\" name=\"mdp\" value=\"mdp\"/>\n";
    echo "<input class=\"bouton\" type=\"submit\" value=\"Se connecter\"/>\n";
    echo "</form>\n";
    echo "</div>\n";
    echo "</div>\n";
    
}	?>
</div>

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



</body>

</html>