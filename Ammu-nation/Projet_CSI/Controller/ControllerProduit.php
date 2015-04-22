<?php

include_once '..\..\Model\Produit.php';

/*
* Controleur d'un produit
* Appelle les fonctions liées à un produit
*/
 
class ControllerProduit {

	/**
    * Recherche toutes les produits vendus par le magasin
    * Renvoit une liste de produit
    */
	public static function AfficherProduit($mag) {
			$r = Produit::findAll($mag);
			$output = '<ul>';
			foreach ($r as $row) {
				$output .= '<li><a href="?prod='. $row['id_produit'] .'">' . $row['nom_produit'] . '</a></li>';
			}
			$output .= '</ul>';
			
			echo $output;
	}
	
	
	/**
    * Recherche toutes les produits vendus par le magasin
    * Renvoit une liste de produit
    */
	public static function AfficherProduitCateg($mag, $cat) {
		$r = Produit::findByCateg($mag, $cat);
		$output = '<ul>';
		foreach ($r as $row) {
			$output .= '<li><a href="?prod='. $row['id_produit'] .'">' . $row['nom_produit'] . '</a></li>';
		}
		$output .= '</ul>';
		echo $output;
	}
	
	public static function DetailProduit($id_prod) {
		$r = Produit::findById($id_prod);
		$output = '<div class="test">';
		foreach ($r as $row) {
			$output .= '<p> Libellé:'. $row['libelle'] .'</p><p> Afficher le reste </p>';
		}
		$output .= '</div>';
		echo $output;
	}
}
?>