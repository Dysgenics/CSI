<?php
include_once '..\..\base.php';
	echo("allo");

$query = "SELECT email, mdp, id_cli FROM CLIENT WHERE login = '$_POST[login]' AND pass = '$_POST[pass]'";
    
try {   
	$db = Base::getConnection();
	$pp = $db->prepare($query);
	$pp->execute();
	
	//retourne un tableau d'objets produit
    $rep = $pp->fetchAll(PDO::FETCH_OBJ);

	 foreach ($rep as $row) {
		//if(($_POST[login]==$membre[login])&&($_POST[pass]==$membre[pass])) {
		if(($_POST[login]=="test")&&($_POST[pass]=="test")) {
			echo "1"; // on 'retourne' la valeur 1 au javascript si la connexion est bonne
		} else {
			echo "1";
		}
	}
} catch (PDOException $e) {
	echo $query . "<br>";
	throw new Exception($e->getMessage());
}	
	
