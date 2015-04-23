<?php

include_once '../../Model/Commande.php';
include_once 'ControllerContient.php';

class ControllerCommande {
	
	public static function GestionCommande ($id_cl, $id_mag) {
		$query = "SELECT * FROM COMMANDE WHERE id_cli=? and id_magasin=? and valide=0";
		
		try {
			$db = Base::getConnection();
			$pp = $db->prepare($query);
			
			$pp->bindParam(1, $id_cl, PDO::PARAM_INT);
			$pp->bindParam(2, $id_mag, PDO::PARAM_INT);
			$res = $pp->execute();
            
            $res = $pp->fetchAll();
            
            
			if (count($res) == 0) {
				Commande::CreateCommande($id_cl, $id_mag);
				
				$r = Commande::findByIdClient($id_cl);
				foreach ($r as $row) {
					$_SESSION['id_com'] = $row['id_commande'];
				}
			} else {
				//Commande::CreateCommande($id_cl, $id_mag);
				$r = $res[0];
				
				$_SESSION['id_com'] = intval($r['ID_COMMANDE']);
				
			}
		} catch (PDOException $e) {
            echo $query . "<br>";
            throw new Exception($e->getMessage());
		}
	}

}
?>