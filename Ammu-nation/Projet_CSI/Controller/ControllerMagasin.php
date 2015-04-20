<?php

include_once '..\..\Model\Magasin.php';

/*
* Controleur d'un magasin
* Appelle les fonctions liées à un Magasin
*/
 
class ControllerMagasin {
	
	/**
    * Recherche tous les magasins
    * Renvoit une liste de magasin
    */
	public static function ChoixMagasin() {
		//on recherche tous les Magasins 
        $r = Magasin::findAll();
		$output = '<ul>';
        foreach ($r as $row) {
			$output .= '<li><a href="notreDrive.php/?mag='. $row['id_magasin'] .'">' . $row['nom_magasin'] . '</a></li>';
		}
		$output .= '</ul>';
		
		echo $output;
	}
			
}

?>