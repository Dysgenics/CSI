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

$authSucess = false;

// Si l'utilisateur est déjà connecté
if(isset($_SESSION['email'])) {
    // Déconnexion de l'utlisateur
    unset($_SESSION['email']);
	unset($_SESSION['id_cli']);
}

if(isset($_POST['email'], $_POST['mdp'])) {

    $em = $_POST['email'];
    $pw = hash("sha512", $_POST['mdp']);
    
    // On récupère l'utilisateur
    $client = Client::findByEmail($em);
	$val = $client->mdp_cli;
    // Si le mot de passe indiqué est le bon
    if($pw == $val) {
        //$a = session_start();
        // On enregistre en tant que variables de sessions, son email et son id
        $_SESSION['email'] = $em;
        $_SESSION['id_cli'] = intval($client->id_cli);
        $_SESSION['prenom_cli'] = $client->prenom_cli;
        $_SESSION['nom_cli'] = $client->nom_cli;
		
		/* On recherche si une commande est en cours et on en crée une si il faut */
		ControllerCommande::GestionCommande($_SESSION['id_cli'], $_SESSION['mag']['id_magasin']);
		$authSucess = true;
    }
    
    
}

// Redirection vers la page d'accueil
if($authSucess)
    header("Location: notreDrive.php");
else
    header("Location: notreDrive.php?auth=0");