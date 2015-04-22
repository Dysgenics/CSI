<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>	
	<meta charset="UTF-8"/>
	<link rel="stylesheet" href="../css/xyz.css">
	
	<script type="text/javascript" src="../js/xyz.js"></script>

	<?php include("../../base.php"); ?>
	<?php include("../../Controller/ControllerMagasin.php"); ?>

	<title> Ammu-nation.fr </title>
</head>

<body>
<h1> Ammu-nation </h1>

<h2> Choisir votre magasin : </h2>

<?php
	ControllerMagasin::ChoixMagasin();
?>	
</body>