<?php


/*
* Controleur de contient
* Appelle les fonctions liées au contenu d'une commande
*/
 
class ControllerContient {
	
	/* Ajoute une ligne dans la table contient
	 * A utiliser au clic sur le bouton "Ajouter au panier"
	 * @param $id_com : Id commande stocké dans une variable de session
	 */
	
	public static function Ajouterproduit($id_prod, $id_com, $q, $red, $pu) {
	    include_once("../base.php");
		
		$contientDeja = ControllerContient::rechercherProduit($id_prod, $id_com);
		
		//si la commande ne contient pas deja ce produit
		if($contientDeja == false)
		{
		    $query = "INSERT INTO CONTIENT 
			VALUES (?,?,?,?,?);";
			
			try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
            
			$id_prod = intval($id_prod);
			$id_com = intval($id_com);
			$q = intval($q);
			
			//définition des paramètres
			$pp->bindParam(1, $id_prod, PDO::PARAM_INT);
            $pp->bindParam(2, $id_com, PDO::PARAM_INT);
			$pp->bindParam(3, $q, PDO::PARAM_INT);
            $pp->bindParam(4, $red, PDO::PARAM_STR);
			$pp->bindParam(5, $pu, PDO::PARAM_STR);		
            $res = $pp->execute();
            
            } catch (PDOException $e) {
                $res = false;
                echo $query . "<br>";
                throw new Exception($e->getMessage());
            }
		}
		else
		{
		    //sinon, il existe deja et on modifie juste la quantite, et la reduction s'il y a
		    $query = "update CONTIENT set QUANTITE=? where ID_PRODUIT=? and ID_COMMANDE=?;";
			
			try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
            
			$id_prod = intval($id_prod);
			$id_com = intval($id_com);
			$q = intval($q) + $contientDeja['quantite'];
			
			//définition des paramètres
			$pp->bindParam(1, $q, PDO::PARAM_INT);
            $pp->bindParam(2, $id_prod, PDO::PARAM_INT);
			$pp->bindParam(3, $id_com, PDO::PARAM_INT);
           	
            $res = $pp->execute();
            
            } catch (PDOException $e) {
                $res = false;
                echo $query . "<br>";
                throw new Exception($e->getMessage());
            }
		}
		
        
        
        return $res;
    }
    
    public static function rechercherProduit($id_prod, $id_com) {
	    $query = "SELECT * FROM CONTIENT where ID_PRODUIT=? and ID_COMMANDE=?;";
		include_once("../base.php");
        try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
            
			$id_prod = intval($id_prod);
			$id_com = intval($id_com);
			
			//définition des paramètres
			$pp->bindParam(1, $id_prod, PDO::PARAM_INT);
            $pp->bindParam(2, $id_com, PDO::PARAM_INT);
		
            $res = $pp->execute();
            $res = $pp->fetch(PDO::FETCH_OBJ);
            
            if($res != false)
            {
                $contient = array();
                $contient['id_produit'] = intval($res->ID_PRODUIT);
                $contient['id_commande'] = intval($res->ID_COMMANDE);
                $contient['quantite'] = intval($res->QUANTITE);
                $contient['reduction'] = doubleval($res->REDUCTION);
                $contient['prix_unitaire'] = doubleval($res->PRIX_UNITAIRE);
                
                return $contient;
            }
            
            
        } catch (PDOException $e) {
            $res = false;
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }
        
        return $res;
    }
    
	
	/* 
	 * 
	*/
	public static function AfficherPanier($id_com) {
	    	
		//on recherche toutes les catégories
        $r = Contient::findAll($id_com);
		$output = '<ul>';
        foreach ($r as $row) {
		$query = "SELECT NOM_PRODUIT FROM PRODUIT where ID_PRODUIT=?;";
		include_once("../base.php");
			try{
			
				$db = Base::getConnection();

				$pp = $db->prepare($query);
				
				$id_prod = intval($id_prod);
				$pp->bindParam(1, $id_prod, PDO::PARAM_INT);			
				
				$output .= '<li>' . $row['id_produit'] . '<p> '.$res->NOM_PRODUIT .'</p>' .'</li>';
				
				
			}   catch (PDOException $e) {
				$res = false;
				echo $query . "<br>";
				throw new Exception($e->getMessage());
			}
		}
		$output .= '</ul>';
		
		echo $output;
		var_dump($output);
	}
}

?>