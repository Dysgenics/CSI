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
    
    public static function AfficherPanierReduit($id_com) {
	    	
		//on recherche toutes les catégories
		include_once("../../base.php");
		$id_com = intval($id_com);
        $r = Contient::findAll($id_com);
        //var_dump($r);
		
		$tot = 0;
		$nb_prod = 0;
        foreach ($r as $row) {
		$query = "SELECT * FROM PRODUIT where ID_PRODUIT=?;";
		
			try{
			
				$db = Base::getConnection();

				$pp = $db->prepare($query);
				
				$id_prod = intval($row['id_produit']);
				$pp->bindParam(1, $id_prod, PDO::PARAM_INT);
				$pp->execute();
				$res = $pp->fetch(PDO::FETCH_OBJ);
				$ligne_tot = (intval($row["quantite"]) * doubleval($row['prix_unitaire']) );
			    $nb_prod = $nb_prod + intval($row['quantite']);
				$tot = $tot + $ligne_tot;
				
			}   catch (PDOException $e) {
				$res = false;
				echo $query . "<br>";
				throw new Exception($e->getMessage());
			}
		}
		$output = '<p><a id="showPanierBtn" href="notreDrive.php?panier">Panier : ' . $nb_prod . ' produits. TOTAL : ' . $tot . '</a></p>';
		
		echo $output;
		//var_dump($output);
	}
    
	
	/* 
	 * 
	*/
	public static function AfficherPanier($id_com) {
	    	
		//on recherche toutes les catégories
		include_once("../../base.php");
		$id_com = intval($id_com);
        $r = Contient::findAll($id_com);
        //var_dump($r);
		$output = '<table><tr><td> PRODUIT </td><td> QUANTITE </td><td> PRIX UNITAIRE </td><td> PRIX TOTAL </td></tr>';
		$tot = 0;
        foreach ($r as $row) {
		$query = "SELECT * FROM PRODUIT where ID_PRODUIT=?;";
		
			try{
			
				$db = Base::getConnection();

				$pp = $db->prepare($query);
				
				$id_prod = intval($row['id_produit']);
				$pp->bindParam(1, $id_prod, PDO::PARAM_INT);
				$pp->execute();
				$res = $pp->fetch(PDO::FETCH_OBJ);
				$ligne_tot = (intval($row["quantite"]) * doubleval($row['prix_unitaire']) );
				$output .= '<tr><td>'.$res->NOM_PRODUIT .'</td><td> ' . $row["quantite"] . ' </td><td> ' . $row['prix_unitaire'] . ' </td><td> ' . $ligne_tot  . ' </td><td> (bouton pour retirer un ou plusieurs produits) </td></tr>';
				$tot = $tot + $ligne_tot;
				
			}   catch (PDOException $e) {
				$res = false;
				echo $query . "<br>";
				throw new Exception($e->getMessage());
			}
		}
		$output .= '<tr><td>TOTAL</td><td></td><td></td><td>' . $tot .'</td></tr></table>';
		
		echo $output;
		//var_dump($output);
	}
}

?>