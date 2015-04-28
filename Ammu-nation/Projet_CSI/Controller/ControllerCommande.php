<?php


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
				
				
					$_SESSION['id_com'] = $db->lastInsertId();
				
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
	
	public static function validerCommande($id_com)
	{
	    include_once('../base.php');
	    $query = "UPDATE COMMANDE SET VALIDE=1 WHERE ID_COMMANDE=?";
		
		try {
			$db = Base::getConnection();
			$pp = $db->prepare($query);
			
			$id_com = intval($id_com);
			$pp->bindParam(1, $id_com, PDO::PARAM_INT);
			
			$res = $pp->execute();
            
            
		} catch (PDOException $e) {
            echo $query . "<br>";
            $res = false;
            throw new Exception($e->getMessage());
		}
		
		return $res;
	}
	
	public static function creerNouveauPanier($id_cli, $id_mag)
	{
	    include_once('../Model/Commande.php');
	    include_once('../base.php');
	    $id_cli = intval($id_cli);
	    $id_mag = intval($id_mag);
	    
	    Commande::CreateCommande($id_cli, $id_mag);
				
		$db = Base::getConnection();
		$id_panier = $db->lastInsertId(); 
				
		$_SESSION['id_com'] = $id_panier;
				
		
		//return $res;
	}

}
?>