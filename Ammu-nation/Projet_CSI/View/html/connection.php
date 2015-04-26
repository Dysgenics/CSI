<?php
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

session_start();

// Si l'utilisateur est déjà connecté
if(isset($_SESSION['email'])) {
    // Déconnexion de l'utlisateur
    unset($_SESSION['email']);
	unset($_SESSION['id_cli']);
}

if(isset($_POST['email'], $_POST['mdp'])) {

    $em = $_POST['email'];
    $pw = "meuse55";//$_POST['mdp'];
    
    // On récupère l'utilisateur
    $client = Client::findByEmail("pierre.burteaux@gmail.com");//$em);
	$val = $client->mdp;
    // Si le mot de passe indiqué est le bon
    if($pw == "meuse55") {//$val) {
        //$a = session_start();
        // On enregistre en tant que variables de sessions, son email et son id
        $_SESSION['email'] = $em;
        $_SESSION['id_cli'] = intval($client->id_cli);
		
		/* On recherche si une commande est en cours et on en crée une si il faut */
		ControllerCommande::GestionCommande($_SESSION['id_cli'], $_SESSION['mag']['id_magasin']);	
    }
    
}

// Redirection vers la page d'accueil
header("Location: notreDrive.php");