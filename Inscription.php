<?php

/*
 * Classe gère les inscriptions du site
 */


if(!isset($_SESSION)) 
{ 
session_start(); 
}

include_once('Base.php');
include_once('Users.php');
include_once('PasswordLib/PasswordLib.php');

	$c = Base::getConnection();
	
if (isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['nom'])
	&& isset($_POST['prenom']) && isset($_POST['societe']) && isset($_POST['email']) && isset($_POST['adresse']) && isset($_POST['numtel'])) {
	
	// Requête EMAIL
		$query = $c->prepare("SELECT COUNT(id) AS nbr FROM users WHERE email =?");
		$query->bindParam(1, $_POST['email'], PDO::PARAM_STR);
		$query->execute();
		
  	 	$result = $query->fetch(PDO::FETCH_BOTH);
	
		
		if($result['nbr'] > 0){
			 // email existant
			$_SESSION['tmpi'] = 'email';
			header("location:".  $_SERVER['HTTP_REFERER']);
		}else{
			if($_POST['password'] != $_POST['password2']) {
				// Mot de passe ne corresponde pas
				$_SESSION['tmpi'] = 'mdp';
				 header("location:".  $_SERVER['HTTP_REFERER']);
			}else{
					// Inscription / Cryptage
						session_unset();
					$lib = new PasswordLib\PasswordLib();	
					$hash=$lib->createPasswordHash($_POST['password'],'$2a$',array('cost'=> 12));
					
						$user = new users();

						$user->email = $_POST['email'];
						$user->prenom = $_POST['prenom'];
						$user->nom = $_POST['nom'];		
						$user->societe = $_POST['societe'];
						$user->passwd = $hash;
						$user->numtel = $_POST['numtel'];
						$user->adresse = $_POST['adresse'];
			
					$user->insert();
					header("location:".  $_SERVER['HTTP_REFERER']);
				}
			
		}
}
	
