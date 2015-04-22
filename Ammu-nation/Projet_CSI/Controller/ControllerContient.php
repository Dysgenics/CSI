<?php

include_once '..\..\Model\Contient.php';

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
	    $query = "INSERT INTO CONTIENT 
			VALUES (?,?,?,?,?);";
		
        try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
			
			//définition des paramètres
			$pp->bindParam(1, $id_prod, PDO::PARAM_INT);
            $pp->bindParam(2, $id_com, PDO::PARAM_INT);
			$pp->bindParam(3, $q, PDO::PARAM_INT);
            $pp->bindParam(4, $red, PDO::PARAM_INT);
			$pp->bindParam(5, $pu, PDO::PARAM_INT);		
            $pp->execute();
        } catch (PDOException $e) {
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }
    }
	
	/* 
	 * 
	*/
	public static function AfficherPanier($id_com) {
		//on recherche toutes les catégories
        $r = Contient::findAll($id_com);
		$output = '<ul>';
        foreach ($r as $row) {
			
			$output .= '<li>' . $row['id_produit'] . '<p> Afficher le nom </p>' .'</li>';
		}
		$output .= '</ul>';
		
		echo $output;
	}
}

?>