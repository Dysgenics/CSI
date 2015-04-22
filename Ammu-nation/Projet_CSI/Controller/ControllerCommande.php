<?php

include_once '..\..\Model\Commande.php';
include_once 'ControllerContient.php';

class ControllerCommande {
	
	public static function GestionCommande ($id_cl, $id_mag) {
		$query = "SELECT COUNT(*) FROM COMMANDE WHERE id_cli=? and valide=0";
		
		try {
			$db = Base::getConnection();
			$pp = $db->prepare($query);
			
			$pp->bindParam(1, $id_cl, PDO::PARAM_INT);
			$pp->execute();

			if ($pp->fetchColumn() == 0) {
				Commande::CreateCommande($id_cl, $id_mag);
				
				$r = Commande::findByIdClient($id_cl);
				foreach ($r as $row) {
					$_SESSION['id_com'] = $row['id_commande'];
				}
			} else {
				//Commande::CreateCommande($id_cl, $id_mag);
				$r = Commande::findByIdClient($id_cl);
				foreach ($r as $row) {
					$_SESSION['id_com'] = $row['id_commande'];
				}
			}
		} catch (PDOException $e) {
            echo $query . "<br>";
            throw new Exception($e->getMessage());
		}
	}

}
?>