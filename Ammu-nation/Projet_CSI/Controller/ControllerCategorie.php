<?php

include_once '..\..\Model\Categorie.php';

/*
* Controleur d'une catégorie
* Appelle les fonctions liées à une catégorie
*/
 
class ControllerCategorie {

	/**
    * Recherche toutes les catégories
    * Renvoit une liste de catégorie
    */
	public static function ChoixCategorie() {
		//on recherche toutes les catégories
        $r = Categorie::findAll();
		$output = '<ul>';
        foreach ($r as $row) {
			$output .= '<li><a href="?categ='. $row['id_categorie'] .'">' . $row['libelle_categ'] . '</a></li>';
		}
		$output .= '</ul>';
		
		echo $output;
	}
			
}

?>