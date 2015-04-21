<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();
// On s'amuse à créer quelques variables de session dans $_SESSION
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
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a dignissim erat. Phasellus ac lacus convallis, aliquam sapien id, euismod lacus. Maecenas urna nulla, fringilla vitae massa vel, rhoncus dapibus lacus. Mauris consequat luctus ante. Aenean ac augue magna. Nam libero diam, laoreet sit amet lacus in, sodales viverra massa. Praesent sit amet justo magna. Mauris finibus ex a purus laoreet viverra. Sed eget eros nec est vehicula ornare auctor id lacus. Ut ut nibh et erat condimentum dictum ut et tortor. Integer fermentum arcu in facilisis faucibus. Quisque lorem metus, volutpat hendrerit ligula id, commodo feugiat lectus. Vivamus scelerisque cursus nisl, et varius odio placerat a. Quisque et lobortis justo. Nam laoreet, enim in vestibulum bibendum, arcu nulla finibus orci, in vestibulum lectus nunc blandit augue. Vestibulum ut neque vestibulum neque lacinia mollis.


Vestibulum sit amet libero sagittis metus sollicitudin finibus at nec magna. Donec auctor imperdiet mauris, aliquet imperdiet elit rhoncus eget. Cras non lorem id metus ultrices aliquam. Aenean elementum ipsum a neque convallis suscipit. Nullam aliquam mauris et lorem finibus suscipit. Integer et mattis dolor. Vivamus ligula ex, dignissim non scelerisque nec, rutrum eu nisi. Mauris dictum leo nunc. Maecenas eu tempus ligula, vestibulum elementum erat. Nullam maximus, augue ac condimentum maximus, lectus purus ultricies odio, malesuada dictum justo nisl at nisi. Pellentesque id dolor maximus, luctus sapien ut, vulputate ex. Duis ac augue condimentum, rutrum ante eget, accumsan eros. Aenean venenatis ultrices tincidunt. Etiam vitae diam non turpis condimentum suscipit. Donec volutpat nunc in lacinia semper.</p>
</div>


</div>



</body>

</html>