<?php

/**
 * Ce fichier gère de façon séparé à l'affichage la connection
 * des utilisateurs au site
 */
 
if(!isset($_SESSION)) 
{ 
session_start(); 
}

include_once('Base.php');
include_once('PasswordLib/PasswordLib.php');

	
	/* 
	 * Connection au site
	 * - Vérifie que les champs sont remplis
	 * - Vérifie après la requête qu'un utilisateur est bien trouvé
	 * - Vérifie que les mots de passe correspondent
	 * Dans ce cas la connection s'effectue 
	 * Sinon une variable temporaire renseignera l'erreur à l'affichage
	 * -> Redirigé vers la page précedente dans tous les cas
	*/
	$c = Base::getConnection();
	
	if (isset($_POST['login_signin']) && isset($_POST['password_signin'])) {
	
		$query = $c->prepare("SELECT COUNT(id) AS nbr, id, email, passwd FROM users WHERE email =? GROUP BY id");
		$query->bindParam(1, $_POST['login_signin'], PDO::PARAM_STR);
		$query->execute();
		
  	 	$result = $query->fetch(PDO::FETCH_BOTH);
	
		if($result['nbr'] == 1){
			$crypt = new PasswordLib\PasswordLib;
			if ($crypt->verifyPasswordHash($_POST['password_signin'], $result['passwd'])) {
				
				$_SESSION['id'] = $result['id'];
				$_SESSION['email'] = $result['email'];
				$_SESSION['passwd'] = $result['passwd'];
				header("location:".  $_SERVER['HTTP_REFERER']); 
				
			}else{
				$_SESSION['tmp'] = 'mdp';
				$_SESSION['email'] =  $result['email'];
				header("location:".  $_SERVER['HTTP_REFERER']); 
			}
				
		}else{ if($result['nbr'] < 1){
				$_SESSION['tmp'] = 'login';
				header("location:".  $_SERVER['HTTP_REFERER']); 
			}
		}
	}
